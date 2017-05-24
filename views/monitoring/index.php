<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\MonitoringSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $config \marqu3s\itam\models\Config */

$this->title = Module::t('menu', 'Monitoring');
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
setInterval(function(){
   // window.location.reload(1);
   $.pjax.reload(('#grid'));
}, 5000);
JS;
$this->registerJs($js);
?>
<div class="monitoring-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['options' => ['id' => 'grid']]); ?>
        <?php
        $color = (int) $config->asset_query_running == 1 ? 'success' : 'muted';
        ?>

        <div class="row">
            <div class="col-sm-6">
                <h6><?= Module::t('app', 'Query is running') ?>: <?= \rmrevin\yii\fontawesome\FA::i('circle', ['class' => 'text-' . $color]) ?></h6>
            </div>
            <div class="col-sm-6">
                <h6><?= Module::t('app', 'Next query scan') ?>: <?= Yii::$app->formatter->asDatetime($config->next_asset_query_time) ?></h6>
            </div>
        </div><br>

        <p>
            <?= Html::a(Module::t('app', 'New monitoring item'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'hostname',
                    'format' => 'html',
                    'value' => function (\marqu3s\itam\models\Monitoring $model) {
                        return Html::a($model->asset->hostname, $model->asset->getUrl(), ['target' => 'blank']);
                    }
                ],
                [
                    'attribute' => 'description',
                ],
                [
                    'attribute' => 'check_type',
                    'headerOptions' => [
                        'class' => 'hidden-xs',
                    ],
                    'contentOptions' => [
                        'class' => 'hidden-xs text-center'
                    ],
                    'filter' => ['ping' => 'Ping', 'socket' => 'Socket'],
                    'filterOptions' => [
                        'class' => 'hidden-xs',
                    ],
                ],
                /*[
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
                ],*/
                [
                    'attribute' => 'up',
                    'headerOptions' => [
                        'style' => 'width: 100px;'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'format' => 'html',
                    'value' => function(\marqu3s\itam\models\Monitoring $model) {
                        $faIcon = ($model->up === 1) ? 'circle' : 'circle';
                        $cssClass = ($model->up === 1) ? 'success' : 'danger';
                        return \rmrevin\yii\fontawesome\FA::i($faIcon, ['class' => 'text-' . $cssClass]);
                    },
                    'filter' => ['0' => Module::t('app', 'Offline'), '1' => Module::t('app', 'Online')]
                ],
                [
                    'attribute' => 'fail_count',
                    'headerOptions' => [
                        'style' => 'width: 100px;',
                        'class' => 'hidden-xs',
                    ],
                    'contentOptions' => [
                        'class' => 'text-center hidden-xs'
                    ],
                    'filterOptions' => [
                        'class' => 'text-center hidden-xs'
                    ],
                ],
                [
                    'attribute' => 'enabled',
                    'format' => 'html',
                    'value' => function(\marqu3s\itam\models\Monitoring $model) {
                        $icon = (int) $model->enabled === 1 ? 'check-circle' : 'ban';
                        $color = (int) $model->enabled === 1 ? 'success' : 'muted';
                        return \rmrevin\yii\fontawesome\FA::i($icon, ['class' => 'text-' . $color]);
                    },
                    'headerOptions' => [
                        'style' => 'width: 100px;',
                        'class' => 'hidden-xs'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center hidden-xs'
                    ],
                    'filter' => ['0' => Module::t('app', 'No'), '1' => Module::t('app', 'Yes')],
                    'filterOptions' => [
                        'class' => 'text-center hidden-xs'
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

<div class="row">
    <div class="col-sm-6">
        <small>
            <strong>Legend:</strong><br>
            <?= \rmrevin\yii\fontawesome\FA::i('circle', ['class' => 'text-success']) ?> Asset is UP<br>
            <?= \rmrevin\yii\fontawesome\FA::i('circle', ['class' => 'text-danger']) ?> Asset is DOWN<br>
            <?= \rmrevin\yii\fontawesome\FA::i('check-circle', ['class' => 'text-success']) ?> Monitoring is enabled<br>
            <?= \rmrevin\yii\fontawesome\FA::i('ban', ['class' => 'text-muted']) ?> Monitoring is disabled
        </small>
    </div>
</div>
