<?php

use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use marqu3s\itam\models\OfficeSuite;
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
            [
                'attribute' => 'id_office_suite',
                'value' => 'officeSuite.name',
                'filter' => ArrayHelper::map(OfficeSuite::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
            ],
            'key',
            'purchased_licenses',
            [
                'header' => Module::t('app', 'Licenses in use'),
                'format' => 'html',
                'value' => function (OfficeSuiteLicense $model) {
                    $inUse = $model->getLicensesInUse();
                    $faName = ($inUse <= $model->purchased_licenses) ? 'check' : 'exclamation-circle';
                    $faClass = ($inUse <= $model->purchased_licenses) ? 'text-success' : 'text-danger';
                        return $inUse . ' ' . FA::icon($faName, ['class' => $faClass]);
                    },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} &nbsp; {delete}',
                'header' => Module::t('app', 'Actions'),
                'headerOptions' => [
                    'style' => 'width: 70px'
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-pencil"></i>', $url, ['title' => Module::t('app', 'Update'), 'data-pjax' => 0]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['title' => Module::t('app', 'Delete'), 'data' => ['pjax' => 0, 'method' => 'post', 'confirm' => Module::t('app', 'Are you sure you want to delete this item?')]]);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
