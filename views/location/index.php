<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\LocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('menu', 'Locations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('app', 'Create Location'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} &nbsp; {update} &nbsp; {delete}',
                    'header' => Module::t('app', 'Actions'),
                    'headerOptions' => [
                        'style' => 'width: 70px'
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
