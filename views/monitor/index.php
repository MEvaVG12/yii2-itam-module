<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\MonitorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('menu', 'Monitoring');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('app', 'New monitoring item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'hostname',
                    'value' => 'asset.hostname',
                ],
                [
                    'attribute' => 'check_type',
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'filter' => ['ping' => 'Ping', 'socket' => 'Socket']
                ],
                [
                    'attribute' => 'socket_port',
                    'headerOptions' => [
                        'style' => 'width: 115px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                ],
                [
                    'attribute' => 'socket_timeout',
                    'headerOptions' => [
                        'style' => 'width: 115px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                ],
                [
                    'attribute' => 'ping_count',
                    'headerOptions' => [
                        'style' => 'width: 115px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                ],
                [
                    'attribute' => 'ping_timeout',
                    'headerOptions' => [
                        'style' => 'width: 115px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                ],
                [
                    'attribute' => 'up',
                    'headerOptions' => [
                        'style' => 'width: 100px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'format' => 'html',
                    'value' => function(\marqu3s\itam\models\Monitor $model) {
                        $faIcon = ($model->up === 1) ? 'circle-o' : 'circle';
                        $cssClass = ($model->up === 1) ? 'success' : 'danger';
                        return \rmrevin\yii\fontawesome\FA::i($faIcon, ['class' => 'text-' . $cssClass]);
                    },
                    'filter' => ['0' => Module::t('app', 'Offline'), '1' => Module::t('app', 'Online')]
                ],
                [
                    'attribute' => 'fail_count',
                    'headerOptions' => [
                        'style' => 'width: 100px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
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
