<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 13/05/17
 * Time: 19:16
 */

namespace marqu3s\itam\controllers;

use marqu3s\itam\Module;
use marqu3s\itam\models\Monitoring;

class ConsoleController extends \yii\console\Controller
{
    public function actionQueryAssets()
    {
        # Get assets to check
        /** @var Monitoring[] $itemsToMonitor */
        $itemsToMonitor = Monitor::find()->all();

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
            $item->fail_count = $item->up === 1 ? 0 : $item->fail_count++;
            $item->last_check = date('Y-m-d H:i:s');
            $item->save();

            if ($item->up === 0 && $item->fail_count >= $item->alert_after_x_consecutive_fails) {
                $assetsToAlert[] = $item;
            }
        }

        # Send alerts
        if (count($assetsToAlert)) {
            $subject = 'ITAM: ' . Module::t('alert', 'You have') . ' ' . count($assetsToAlert) . ' ' . Module::t('alert', ' assets down!');
            $body = Module::t('alert', 'Assets not responding:<br>');
            foreach ($assetsToAlert as $i => $item) {
                $item->description . '<br>';
            }

            # TODO: Pushover alerts

        }

        \yii\helpers\VarDumper::dump($results, 10);

        return 0;
    }

    public function actionPortscan($ip)
    {
        $result = exec("nmap {$ip}", $output, $return);
        \yii\helpers\VarDumper::dump($output, 10); die;
        if (strstr($output[2], 'Nmap scan report for') !== false) {
        }
    }
}
