<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 17:50
 */

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\AssetServer;
use marqu3s\itam\models\AssetWorkstation;
use marqu3s\itam\models\OsLicense;
use yii\web\Controller;

class ReportsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionAssetsByOsLicense($idLicense = null)
    {
        $idLicense = (int) $idLicense;

        # Find out what are the assets using the given OS.
        $workstations = $servers = [];
        if (!empty($idLicense)) {
            $workstations = AssetWorkstation::find()->where(['id_os_license' => $idLicense])->all();
            $servers = AssetServer::find()->where(['id_os_license' => $idLicense])->all();
        }

        return $this->render('assetsByOsLicense', [
            'license' => OsLicense::findOne($idLicense),
            'workstations' => $workstations,
            'servers' => $servers,
        ]);
    }
}
