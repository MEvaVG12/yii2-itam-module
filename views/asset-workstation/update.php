<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetWorkstationForm */

$this->title = Module::t('app', 'Update: ') . $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Workstations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->asset->hostname, 'url' => ['view', 'id' => $model->assetWorkstation->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Update');
?>
<div class="workstation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
