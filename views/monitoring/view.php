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
            'enabled',
            'up',
            'last_check:datetime'
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
