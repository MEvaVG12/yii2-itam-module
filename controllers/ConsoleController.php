<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 13/05/17
 * Time: 19:16
 */

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\Monitor;

class ConsoleController extends \yii\console\Controller
{
    public function actionCheck()
    {
        # Get assets to check
        /** @var Monitor[] $itemsToMonitor */
        $itemsToMonitor = Monitor::find()->all();

        $results = [];
        foreach ($itemsToMonitor as $i => $item) {
            if ($item->check_type == 'ping') {
                $pingResult = exec("ping -c {$item->ping_count} -t {$item->ping_timeout} {$item->asset->ip_address}", $output, $return); // t = timeout, c = count
                if (strstr($pingResult, '100.0% packet loss') !== false) {
                    $results[$i] = 0;
                } else {
                    $results[$i] = 1;
                }
            } else {
                $fp = @ fsockopen($item->asset->ip_address, $item->socket_port, $numeroDoErro, $stringDoErro, $item->socket_timeout); // Este último é o timeout, em segundos
                if ($fp === false) {
                    $results[$i] = 0;
                } else {
                    fclose($fp);
                    $results[$i] = 1;
                }
            }

            $item->up = $results[$i];
            $item->fail_count = $item->up === 1 ? 0 : $item->fail_count++;
            $item->last_check = date('Y-m-d H:i:s');
            $item->save();
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
