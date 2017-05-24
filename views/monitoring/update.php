<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Monitoring */
/* @var $availableAssets marqu3s\itam\models\Asset[] */

$this->title = Module::t('app', 'Update: ') . $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Monitoring'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->asset->hostname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Update');
?>
<div class="monitoring-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'availableAssets' => $availableAssets,
    ]) ?>

</div>
