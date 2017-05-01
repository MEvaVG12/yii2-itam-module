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

$this->title = Module::t('app', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <h1>Reports</h1>
    <ul>
        <li><a href="/itam/reports/assets-by-os-license-analytic"><?= Module::t('app', 'OS usage by license - Analytic') ?></a></li>
        <li><a href="/itam/reports/assets-by-os-license-synthetic"><?= Module::t('app', 'OS usage by license - Synthetic') ?></a></li>
    </ul>
</div>
