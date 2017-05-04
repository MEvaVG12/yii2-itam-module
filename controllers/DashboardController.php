<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\OfficeSuiteLicense;
use marqu3s\itam\models\OsLicense;
use marqu3s\itam\models\Software;
use marqu3s\itam\models\SoftwareAsset;
use marqu3s\itam\models\SoftwareLicense;
use marqu3s\itam\Module;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/**
 * DashboardController for the `itam` module
 */
class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        /** @var Module $module */
        $module = $this->module;
        if ($module->rbacAuthorization) {
            $config = [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ],
                    ],
                ]
            ];
        } else {
            $config = [];
        }

        return $config;
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        # Show data about OS licenses in use.
        $osLicenses = OsLicense::find()
            ->joinWith('os')
            ->where("purchased_licenses IS NOT NULL AND purchased_licenses != ''")
            ->orderBy(['itam_os.name' => SORT_ASC])
            ->all();

        # Show data about Office Suite licenses in use.
        $officeSuiteLicenses = OfficeSuiteLicense::find()
            ->joinWith('officeSuite')
            ->where("purchased_licenses IS NOT NULL AND purchased_licenses != ''")
            ->orderBy(['itam_office_suite.name' => SORT_ASC])
            ->all();

        # Show data about Software license in use.
        $idSoftwares = (new Query())
            ->select(['id_software', 'id_software_license'])
            ->distinct()
            ->from('itam_software_asset')
            ->innerJoin('itam_software', 'itam_software_asset.id_software = itam_software.id')
            ->orderBy(['itam_software.name' => SORT_ASC])
            ->all();

        $softwareLicenses = [];
        foreach ($idSoftwares as $id) {
            /** @var Software $software */
            $software = Software::findOne($id['id_software']);
            foreach ($software->licenses as $license) {
                $softwareLicenses[] = [
                    'idSoftwareLicense' => $license->id,
                    'software' => $software->name,
                    'key' => $license->key,
                    'purchasedLicenses' => $license->purchased_licenses,
                    'inUse' => $license->licensesInUse,
                ];
            }
        }
        //\yii\helpers\VarDumper::dump($softwareLicenses, 10, true); die;

        return $this->render('index', [
            'osLicenses' => $osLicenses,
            'officeSuiteLicenses' => $officeSuiteLicenses,
            'softwareLicenses' => $softwareLicenses,
        ]);
    }



    ### AJAX ACTIONS ###

    /**
     * Return <option> tags to populate a dropdown showing licensing options for an OS.
     *
     * @param integer $id_os
     *
     * @return string
     */
    public function actionAjaxGetOsLicensesDropdownOptions($id_os)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $licenses = OsLicense::find()->where(['id_os' => (int) $id_os])->orderBy(['date_of_purchase' => SORT_DESC])->all();

        return Html::renderSelectOptions(null, ArrayHelper::map($licenses, 'id', 'key'));
    }

    /**
     * Return <option> tags to populate a dropdown showing licensing options for an Office Suite.
     *
     * @param integer $id_office_suite
     *
     * @return string
     */
    public function actionAjaxGetOfficeSuiteLicensesDropdownOptions($id_office_suite)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $licenses = OfficeSuiteLicense::find()->where(['id_office_suite' => (int) $id_office_suite])->orderBy(['date_of_purchase' => SORT_DESC])->all();

        return Html::renderSelectOptions(null, ArrayHelper::map($licenses, 'id', 'key'));
    }

    /**
     * Return <option> tags to populate a dropdown showing licensing options for a Software.
     *
     * @param integer $id_software
     *
     * @return string
     */
    public function actionAjaxGetSoftwareLicensesDropdownOptions($id_software)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $licenses = SoftwareLicense::find()->where(['id_software' => (int) $id_software])->orderBy(['date_of_purchase' => SORT_DESC])->all();

        return Html::renderSelectOptions(null, ArrayHelper::map($licenses, 'id', 'key'));
    }

    /**
     * Saves a relation between an asset and a software and its license.
     *
     * @return string
     */
    public function actionAjaxAddSoftwareAsset()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new SoftwareAsset();
        $model->load(Yii::$app->request->post());
        if ($model->save()){
            return ['result' => true];
        }

        return ['result' => false];
    }

    /**
     * Deletes a relation between an asset and a software and its license.
     *
     * @return string
     */
    public function actionAjaxDelSoftwareAsset($ids)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        list($idSoftware, $idSoftwareLicense, $idAsset) = explode(',', $ids);

        $model = SoftwareAsset::findOne(['id_software' => $idSoftware, 'id_software_license' => $idSoftwareLicense, 'id_asset' => $idAsset]);
        if ($model->delete()){
            return ['result' => true];
        }

        return ['result' => false];
    }

    /**
     * Returns a table with all the software marked as installed in an Asset.
     *
     * @param integer $idAsset
     *
     * @return string
     */
    public function actionAjaxGetSoftwareTable($idAsset)
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $models = SoftwareAsset::find()->joinWith(['software'])->where(['id_asset' => $idAsset])->orderBy(['itam_software.name' => SORT_ASC])->all();

        return $this->renderAjax('../layouts/_softwareAssetTable', [
            'models' => $models,
        ]);
    }
}
