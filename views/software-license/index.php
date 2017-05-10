<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use marqu3s\itam\models\Software;
use marqu3s\itam\models\SoftwareLicense;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\SoftwareLicenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('menu', 'Software Licenses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="software-license-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('app', 'Create Software License'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id_software',
                'value' => 'software.name',
                'filter' => ArrayHelper::map(Software::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
            ],
            'key',
            'purchased_licenses',
            [
                'header' => Module::t('app', 'Licenses in use'),
                'format' => 'html',
                'value' => function (SoftwareLicense $model) {
                    $inUse = $model->getLicensesInUse();
                    $faName = ($inUse <= $model->purchased_licenses) ? 'check' : 'exclamation-circle';
                    $faClass = ($inUse <= $model->purchased_licenses) ? 'text-success' : 'text-danger';
                    return $inUse . ' ' . FA::icon($faName, ['class' => $faClass]);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} &nbsp; {update} &nbsp; {delete}',
                'header' => Module::t('app', 'Actions'),
                'headerOptions' => [
                    'style' => 'width: 75px'
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-eye"></i>', $url, ['title' => Module::t('app', 'View'), 'data-pjax' => 0]);
                    },
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
