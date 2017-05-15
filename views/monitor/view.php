<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Monitor */

$this->title = $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Monitoring'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitor-view">

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
            'up',
            'fail_count',
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
