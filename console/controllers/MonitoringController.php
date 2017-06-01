<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 13/05/17
 * Time: 19:16
 */

namespace marqu3s\itam\console\controllers;

use consynki\yii\pushover\Pushover;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use marqu3s\itam\models\Config;
use marqu3s\itam\models\Monitoring;
use Pushbullet\Pushbullet;
use Yii;
use yii\helpers\Console;

/**
 * Provides asset survey methods.
 *
 * This is a child of a \yii\console\Controller Controller.
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
 * Installation: Add the following config to your main.php configuration of your
 * console application and adjust parameters accordingly.
 *
 * ```php
 * return [
 *     'controllerMap' => [
 *         'itam-monitoring' => [
 *             'class' => 'marqu3s\itam\console\controllers\MonitoringController',
 *             'nmapPath' => '/usr/bin/',
 *             'pushbulletAPIKey' => '',
 *             'pushbulletChannelTag' => '',
 *             'pushoverUserKey' => '',
 *             'pushoverAPIKey' => '',
 *         ],
 *     ],
 * ];
 * ```
 *
 * Reporting using Pushbullet requires the following attributes to be set:
 * - pushbulletAPIKey - The access token to the pushbullet account
 * - pushbulletChannelTag - The channel tag to where the notifications will be sent to
 *
 * Reporting using Pushover requires the following attributes to be set:
 * - pushoverAPIKey - The access token to the pushbullet application
 * - pushoverUserKey - The user/group key where the notifications will be sent to
 *
 * @package marqu3s\itam\console\controllers
 */
class MonitoringController extends \yii\console\Controller
{
    /**
     * The path to the nmap executable
     * @var string
     */
    public $nmapPath = '/usr/bin/';

    /** @var string  */
    public $pushbulletAPIKey = '';

    /** @var string  */
    public $pushbulletChannelTag = '';

    /** @var string  */
    public $telegramAPIKey = '';

    /** @var string  */
    public $telegramBotName = '';

    /** @var string  */
    public $telegramChannel = '';

    /** @var string  */
    public $pushoverUserKey = '';

    /** @var string  */
    public $pushoverAPIKey = '';



    ### ACTIONS ###
    
    /**
     * Query assets to find out if they are UP or DOWN
     *
     * @return int
     */
    public function actionQueryAssets()
    {
        /** @var Config $config */
        $config = Config::findOne(1);

        if ((int) $config->asset_query_running === 1 || (!empty($config->next_asset_query_time) && date('Y-m-d H:i:s') < $config->next_asset_query_time)) {
            echo $this->ansiFormat("Nothing to do here\n", Console::FG_PURPLE);
            return 0;
        }

        $config->asset_query_running = 1;
        $config->save();

        try {
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
                    if ((int) $return !== 0) {
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
                if ((int)$item->up !== $results[$item->description]) {
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
                        $item->fail_count++;
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

                # Telegram alert
                $this->sendTelegramAlert($subject, $body);

                # Pushover alerts
                //$this->sendPushoverAlert($subject, $body);
            }

            # Print the results to the console
            echo $this->ansiFormat("\nQUERY RESULTS:\n", Console::FG_PURPLE);
            foreach ($results as $description => $status) {
                if ($status === 0) $color = Console::FG_RED;
                else $color = Console::FG_GREEN;
                echo $this->ansiFormat(str_pad($description . ' ', 30, '.', STR_PAD_RIGHT), Console::FG_CYAN);
                echo ' ' . $this->ansiFormat($status === 0 ? 'DOWN' : 'UP', $color);
                echo "\n";
            }
        } catch (\Exception $e) {
            echo $this->ansiFormat($e->getMessage(), Console::FG_RED);
        }

        $config->asset_query_running = 0;
        $config->next_asset_query_time = date('Y-m-d H:i:s', ceil(time()/60)*60); // next full minute.
        $config->save();

        return 0;
    }

    /**
     * Executes an nmap fast scan.
     *
     * @param $ip
     *
     * @return int
     */
    public function actionPortscan($ip)
    {
        $result = exec($this->nmapPath . "nmap -F " . escapeshellarg($ip), $output, $return);
        \yii\helpers\VarDumper::dump($output, 10);

        return 0;
    }

    /**
     * Executes a ping to an IP.
     *
     * @param string $ip
     * @param int $count
     * @param int $timeout
     *
     * @return int
     */
    public function actionPing($ip, $count = 1, $timeout = 2)
    {
        $pingResult = exec("ping -c {$count} -t {$timeout} {$ip}", $output, $return); // t = timeout, c = count
        \yii\helpers\VarDumper::dump($pingResult, 10);
        \yii\helpers\VarDumper::dump($output, 10);
        \yii\helpers\VarDumper::dump($return, 10);

        return 0;
    }



    ### AUXILIARY ###

    /**
     * Return a pushover component
     *
     * @return Pushover|null
     */
    public function getPushover()
    {
        if (!empty($this->pushoverAPIKey) && !empty($this->pushoverUserKey)) {
            $pushover = new Pushover();
            $pushover->api_key = $this->pushoverAPIKey;
            $pushover->user_key = $this->pushoverUserKey;

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
        if (!empty($this->pushbulletAPIKey)) {
            return new Pushbullet($this->pushbulletAPIKey);
        }

        return null;
    }

    /**
     * Configures a Telegram module to use the Telegram API
     */
    public function getTelegram()
    {
        if (!empty($this->telegramAPIKey)) {
            $telegram = new Telegram($this->telegramAPIKey, $this->telegramBotName);

            return $telegram;
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
            $channel = $pb->channel($this->pushbulletChannelTag);
            $channel->pushNote($title, $body);
        }
    }

    /**
     * Sends an alert using the Telegram API.
     *
     * @param string $title
     * @param string $body
     */
    public function sendTelegramAlert($title, $body)
    {
        $telegram = $this->getTelegram();
        if ($telegram !== null) {
            $result = Request::sendMessage(['chat_id' => $this->telegramChannel, 'text' => $title . "\n" . $body]);
        }
    }
}
