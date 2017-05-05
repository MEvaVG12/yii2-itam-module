<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 17:59
 */

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\OsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('menu', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <h1><?= $this->title ?></h1>
    <ul>
        <li><?= Html::a(Module::t('app', 'OS usage by license - Analytic'), ['reports/assets-by-os-license-analytic']) ?></li>
        <li><?= Html::a(Module::t('app', 'OS usage by license - Synthetic'), ['reports/assets-by-os-license-synthetic']) ?></li>
        <li><?= Html::a(Module::t('app', 'Office Suite usage by license - Analytic'), ['reports/assets-by-office-suite-license-analytic']) ?></li>
        <li><?= Html::a(Module::t('app', 'Office Suite usage by license - Synthetic'), ['reports/assets-by-office-suite-license-synthetic']) ?></li>
        <li><?= Html::a(Module::t('app', 'Software usage by license - Analytic'), ['reports/assets-by-software-license-analytic']) ?></li>
        <li><?= Html::a(Module::t('app', 'Software usage by license - Synthetic'), ['reports/assets-by-software-license-synthetic']) ?></li>
    </ul>
</div>
