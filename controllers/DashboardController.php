<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\OfficeSuiteLicense;
use marqu3s\itam\models\OsLicense;
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        # Show data about OS licenses in use.
        $osLicenses = OsLicense::find()->where("allowed_activations IS NOT NULL AND allowed_activations != ''")->all();

        # Show data about OS licenses in use.
        $officeSuiteLicenses = OfficeSuiteLicense::find()->where("allowed_activations IS NOT NULL AND allowed_activations != ''")->all();

        return $this->render('index', [
            'osLicenses' => $osLicenses,
            'officeSuiteLicenses' => $officeSuiteLicenses,
        ]);
    }

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

        $licenses = OsLicense::find()->where(['id_os' => (int) $id_os])->orderBy(['date' => SORT_DESC])->all();

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

        $licenses = OfficeSuiteLicense::find()->where(['id_office_suite' => (int) $id_office_suite])->orderBy(['date' => SORT_DESC])->all();

        return Html::renderSelectOptions(null, ArrayHelper::map($licenses, 'id', 'key'));
    }
}
