<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 13/05/17
 * Time: 19:16
 */

namespace marqu3s\itam\controllers;

use consynki\yii\pushover\Pushover;
use marqu3s\itam\models\Monitoring;
use Pushbullet\Pushbullet;
use Yii;
use yii\helpers\Console;

/**
 * Class ConsoleController
 *
 * This is a child of a Console Controller.
 * This means that it must be used from a console or terminal.
 * The main action query-assets query each monitored asset to find out
 * if it's online (UP) or offline (DOWN).
 *
 * If an asset is found to be DOWN more than alert_after_x_consecutive_fails times,
 * then it will be reported by the alert system.
 *
 * An asset will also be reported by the alert system if it came UP. In this case,
 * all the other assets that are still DOWN will also be included in the report.
 *
 * @package marqu3s\itam\controllers
 */
class ConsoleController extends \yii\console\Controller
{
    public function actionQueryAssets()
    {
        # Get assets to check
        /** @var Monitoring[] $itemsToMonitor */
        $itemsToMonitor = Monitoring::find()->andWhere(['enabled' => 1])->all();

        # Check the assets
        $results = [];
        $assetsWentUp = [];
        $assetsWentDown = [];
        $assetsStillDown = [];
        foreach ($itemsToMonitor as $i => $item) {
            if ($item->check_type == 'ping') {
                $pingResult = exec("ping -c {$item->ping_count} -t {$item->ping_timeout} {$item->asset->ip_address}", $output, $return); // t = timeout, c = count
                if (strstr($pingResult, '100.0% packet loss') !== false) {
                    $results[$item->description] = 0;
                } else {
                    $results[$item->description] = 1;
                }
            } else {
                $fp = @ fsockopen($item->asset->ip_address, $item->socket_port, $numeroDoErro, $stringDoErro, $item->socket_timeout); // Este último é o timeout, em segundos
                if ($fp === false) {
                    $results[$item->description] = 0;
                } else {
                    fclose($fp);
                    $results[$item->description] = 1;
                }
            }

            # Decide if the asset came up, went down or are still down.
            if ((int) $item->up !== $results[$item->description]) {
                # If previous state was down, then the asset came up
                if ($item->up === 0) {
                    $item->fail_count = 0;
                    $assetsWentUp[] = $item;
                } else { // asset went down
                    $item->fail_count++;
                    if ($item->fail_count >= $item->alert_after_x_consecutive_fails) {
                        $assetsWentDown[] = $item;
                    }
                }
            } else {
                # Assets still down
                if ($results[$item->description] === 0) {
                    $assetsStillDown[] = $item;
                }
            }

            # Update monitoring info
            $item->up = $results[$item->description];
            $item->last_check = date('Y-m-d H:i:s');
            $item->save();
        }

        # Send alerts
        if (count($assetsWentUp) || count($assetsWentDown)) {
            $subject = 'ITAM: ';
            $body = "";
            if (count($assetsWentDown)) {
                $subject .= count($assetsWentDown) . ' went DOWN';
                $body .= "DOWN:\n";
                foreach ($assetsWentDown as $i => $item) {
                    $body .= $item->description . "\n";
                }
            }
            if (count($assetsWentUp)) {
                if (count($assetsWentDown)) $subject .= ' | ';
                $subject .= count($assetsWentUp) . ' came UP';
                if (count($assetsWentDown)) $body .= "\n";
                $body .= "UP:\n";
                foreach ($assetsWentUp as $i => $item) {
                    $body .= $item->description . "\n";
                }
            }
            if (count($assetsStillDown)) {
                if (count($assetsWentDown) || count($assetsWentUp)) $body .= "\n";
                $body .= "STILL DOWN:\n";
                foreach ($assetsStillDown as $i => $item) {
                    $body .= $item->description . "\n";
                }
            }
            if (count($assetsWentDown) == 0 && count($assetsStillDown) == 0) {
                $body .= "\nALL GOOD CAPTAIN!";
            }

            # Pushbullet alerts
            $this->sendPushbulletAlert($subject, $body);

            # Pushover alerts
            //$this->sendPushoverAlert($subject, $body);
        }

        # Print the results to the console
        echo $this->ansiFormat("\nQUERY RESULTS:\n", Console::FG_PURPLE);
        foreach ($results as $description => $status) {
            if ($status === 0) $color = Console::FG_RED;
            else $color = Console::FG_GREEN;
            echo $this->ansiFormat(str_pad($description . ' ', 30, '.', STR_PAD_RIGHT), Console::FG_CYAN);
            echo ' ' .  $this->ansiFormat($status === 0 ? 'DOWN' : 'UP', $color);
            echo "\n";
        }

        return 0;
    }

    public function actionPortscan($ip)
    {
        $result = exec("nmap {$ip}", $output, $return);
        \yii\helpers\VarDumper::dump($output, 10);
    }


    /**
     * Return a pushover component
     *
     * @return Pushover|null
     */
    public function getPushover()
    {
        if (!empty(Yii::$app->getModule('itam')->pushoverAPIKey) && !empty(Yii::$app->getModule('itam')->pushoverUserKey)) {
            $pushover = new Pushover();
            $pushover->api_key = Yii::$app->getModule('itam')->pushoverAPIKey;
            $pushover->user_key = Yii::$app->getModule('itam')->pushoverUserKey;

            return $pushover;
        }

        return null;
    }

    /**
     * Return a pushbullet component
     *
     * @return Pushbullet|null
     */
    public function getPushbullet()
    {
        if (!empty(Yii::$app->getModule('itam')->pushbulletAPIKey)) {
            return new Pushbullet(Yii::$app->getModule('itam')->pushbulletAPIKey);
        }

        return null;
    }

    /**
     * Sends an alert using Pushover service.
     *
     * @param string $title
     * @param string $body
     */
    public function sendPushoverAlert($title, $body)
    {
        $po = $this->getPushover();
        if (!empty($po)) {
            $po->send($body, $title);
        }
    }

    /**
     * Sends an alert using Pushbullet service.
     *
     * @param string $title
     * @param string $body
     */
    public function sendPushbulletAlert($title, $body)
    {
        $pb = $this->getPushbullet();
        if (!empty($pb)) {
            $pb->allDevices()->pushNote($title, $body);
        }
    }
}
