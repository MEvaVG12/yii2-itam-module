<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetAccessPrinterForm */

$this->title = Module::t('app', 'Update: ') . $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Printers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->asset->hostname, 'url' => ['view', 'id' => $model->assetPrinter->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Update');
?>
<div class="printer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
