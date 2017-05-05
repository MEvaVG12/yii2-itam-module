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
use marqu3s\itam\models\OfficeSuiteLicense;
use marqu3s\itam\models\OsLicense;
use marqu3s\itam\models\Software;
use marqu3s\itam\models\SoftwareAsset;
use marqu3s\itam\models\SoftwareLicense;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ReportsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $config = [];

        if ($this->module->rbacAuthorization) {
            $config = array_merge($config, [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => [$this->module->rbacItemPrefix . 'ViewReports']
                        ],
                    ],
                ],
            ]);
        }

        return $config;
    }

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

    public function actionAssetsByOfficeSuiteLicenseAnalytic($idLicense = null)
    {
        $idLicense = (int) $idLicense;

        # Find out what are the assets using the given Office Suite.
        $workstations = $servers = [];
        if (!empty($idLicense)) {
            $workstations = AssetWorkstation::find()
                ->joinWith('asset')
                ->where(['id_office_suite_license' => $idLicense])
                ->orderBy(['itam_asset.hostname' => SORT_ASC])
                ->all();
            $servers = AssetServer::find()
                ->joinWith('asset')
                ->where(['id_office_suite_license' => $idLicense])
                ->orderBy(['itam_asset.hostname' => SORT_ASC])
                ->all();
        }

        return $this->render('assetsByOfficeSuiteLicenseAnalytic', [
            'license' => OfficeSuiteLicense::findOne($idLicense),
            'workstations' => $workstations,
            'servers' => $servers,
        ]);
    }

    public function actionAssetsByOfficeSuiteLicenseSynthetic()
    {
        # Get all Office Suite licenses
        $licenses = OfficeSuiteLicense::find()->all();

        return $this->render('assetsByOfficeSuiteLicenseSynthetic', [
            'licenses' => $licenses,
        ]);
    }

    public function actionAssetsBySoftwareLicenseAnalytic($idLicense = null)
    {
        $idLicense = (int) $idLicense;

        # Find out what are the assets using the given Software License.
        $assets = SoftwareAsset::find()->where(['id_software_license' => $idLicense])->all();

        # Find out wich ones are workstations and wich ones are workstations
        $assetsIds = ArrayHelper::getColumn($assets, 'id_asset');

        $workstations = $servers = [];
        if (!empty($idLicense)) {
            $workstations = AssetWorkstation::find()
                ->joinWith('asset')
                ->where(['id_asset' => $assetsIds])
                ->orderBy(['itam_asset.hostname' => SORT_ASC])
                ->all();
            $servers = AssetServer::find()
                ->joinWith('asset')
                ->where(['id_asset' => $assetsIds])
                ->orderBy(['itam_asset.hostname' => SORT_ASC])
                ->all();
        }

        return $this->render('assetsBySoftwareLicenseAnalytic', [
            'license' => SoftwareLicense::findOne($idLicense),
            'workstations' => $workstations,
            'servers' => $servers,
        ]);
    }

    public function actionAssetsBySoftwareLicenseSynthetic()
    {
        # Get all Software licenses
        $licenses = SoftwareLicense::find()->all();

        return $this->render('assetsBySoftwareLicenseSynthetic', [
            'licenses' => $licenses,
        ]);
    }
}
