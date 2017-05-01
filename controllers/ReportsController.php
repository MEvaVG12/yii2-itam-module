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

    public function actionAssetsByOsLicenseAnalytic($idLicense = null)
    {
        $idLicense = (int) $idLicense;

        # Find out what are the assets using the given OS.
        $workstations = $servers = [];
        if (!empty($idLicense)) {
            $workstations = AssetWorkstation::find()
                ->joinWith('asset')
                ->where(['id_os_license' => $idLicense])
                ->orderBy(['itam_asset.hostname' => SORT_ASC])
                ->all();
            $servers = AssetServer::find()
                ->joinWith('asset')
                ->where(['id_os_license' => $idLicense])
                ->orderBy(['itam_asset.hostname' => SORT_ASC])
                ->all();
        }

        return $this->render('assetsByOsLicenseAnalytic', [
            'license' => OsLicense::findOne($idLicense),
            'workstations' => $workstations,
            'servers' => $servers,
        ]);
    }

    public function actionAssetsByOsLicenseSynthetic()
    {
        # Get all OS licenses
        $licenses = OsLicense::find()->all();

        return $this->render('assetsByOsLicenseSynthetic', [
            'licenses' => $licenses,
        ]);
    }
}
