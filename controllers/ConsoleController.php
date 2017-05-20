<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 13/05/17
 * Time: 19:16
 */

namespace marqu3s\itam\controllers;

use consynki\yii\pushover\Pushover;
use marqu3s\itam\Module;
use marqu3s\itam\models\Monitoring;
use yesaulov\pushbullet\Pushbullet;
use Yii;

class ConsoleController extends \yii\console\Controller
{
    public function actionQueryAssets()
    {
        # Get assets to check
        /** @var Monitoring[] $itemsToMonitor */
        $itemsToMonitor = Monitoring::find()->all();

        # Check the assets
        $results = [];
        $assetsToAlert = [];
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

            $item->up = $results[$item->description];
            $item->fail_count = ($item->up === 1) ? 0 : $item->fail_count + 1;
            $item->last_check = date('Y-m-d H:i:s');
            $item->save();

            if ($item->up === 0 && $item->fail_count >= $item->alert_after_x_consecutive_fails) {
                $assetsToAlert[] = $item;
            }
        }

        # Send alerts
        if (count($assetsToAlert)) {
            $subject = 'ITAM: ' . Module::t('alert', 'You have') . ' ' . count($assetsToAlert) . ' ' . Module::t('alert', 'assets down!');
            $body = Module::t('alert', 'Assets not responding:<br>');
            foreach ($assetsToAlert as $i => $item) {
                $body .= $item->description . '<br>';
            }

            # Pushover alerts
            //$this->pushover()->send($body, $subject);

            # Pushbullet alerts
            $this->pushbullet()->pushNote('iPhone 6S P', $body, $subject);
        }

        \yii\helpers\VarDumper::dump($results, 10);

        return 0;
    }

    public function actionPortscan($ip)
    {
        $result = exec("nmap {$ip}", $output, $return);
        \yii\helpers\VarDumper::dump($output, 10);
    }


    /**
     * Return a pushover component
     */
    public function pushover()
    {
        $pushover = new Pushover();
        $pushover->api_key = Yii::$app->getModule('itam')->pushoverAPIKey;
        $pushover->user_key = Yii::$app->getModule('itam')->pushoverUserKey;

        return $pushover;
    }

    /**
     * Return a pushbullet component
     */
    public function pushbullet()
    {
        $pushover = new Pushbullet();
        $pushover->apiKey = Yii::$app->getModule('itam')->pushbulletAPIKey;

        return $pushover;
    }
}
