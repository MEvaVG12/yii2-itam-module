<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Monitoring */

$this->title = $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Monitoring'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitoring-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'asset.hostname',
            'check_type',
            'socket_port',
            'socket_timeout',
            'ping_count',
            'ping_timeout',
            'fail_count',
            'alert_after_x_consecutive_fails',
            [
                'attribute' => 'enabled',
                'format' => 'html',
                'value' => function(\marqu3s\itam\models\Monitoring $model) {
                    $icon = (int) $model->enabled === 1 ? 'check-circle' : 'ban';
                    $color = (int) $model->enabled === 1 ? 'success' : 'muted';
                    return \rmrevin\yii\fontawesome\FA::i($icon, ['class' => 'text-' . $color]);
                },
            ],
            [
                'attribute' => 'up',
                'format' => 'html',
                'value' => function(\marqu3s\itam\models\Monitoring $model) {
                    $faIcon = ($model->up === 1) ? 'circle-o' : 'circle';
                    $cssClass = ($model->up === 1) ? 'success' : 'danger';
                    return \rmrevin\yii\fontawesome\FA::i($faIcon, ['class' => 'text-' . $cssClass]);
                },
            ],
            'last_check:datetime'
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
