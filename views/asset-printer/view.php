<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetPrinter */

$this->title = $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Printers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="printer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

    <?php include(__DIR__ . '/../layouts/_assetViewBaseDetails.php') ?>

    <!--<h2><?/*= Module::t('app', 'Asset Details') */?></h2>
    --><?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'firmware_version',
            'firmware_release_date',
            'firmware_install_date',
        ],
    ]) */?>

    <?= $this->render('/layouts/_arViewRecordDetails', ['model' => $model->asset]) ?>
    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
