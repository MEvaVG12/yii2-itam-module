<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use marqu3s\itam\models\OfficeSuiteLicense;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\OfficeSuiteLicenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Office Suite Licenses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-suite-license-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Office Suite License', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'officeSuite.name',
            'key',
            'allowed_activations',
            [
                'header' => Module::t('app', 'Licenses in use'),
                'format' => 'html',
                'value' => function (OfficeSuiteLicense $model) {
                    $inUse = $model->getLicensesInUse();
                    $faName = ($inUse <= $model->allowed_activations) ? 'check' : 'exclamation-circle';
                    $faClass = ($inUse <= $model->allowed_activations) ? 'text-success' : 'text-danger';
                        return $inUse . ' ' . FA::icon($faName, ['class' => $faClass]);
                    },
            ],
            Module::$defaultGridActionColumn,
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
