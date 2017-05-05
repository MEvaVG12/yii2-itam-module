<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetWorkstation */

$this->title = $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Workstations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workstation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

    <?php include(__DIR__ . '/../layouts/_assetViewBaseDetails.php') ?>

    <h2><?= Module::t('app', 'Asset Details') ?></h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => Module::t('model', 'OS'),
                'value' => $model->os !== null ? $model->os->name : null,
            ],
            [
                'label' => Module::t('model', 'OS') . ' - ' . Module::t('model', 'Activation key'),
                'value' => $model->osLicense !== null ? $model->osLicense->key : null,
            ],
            [
                'label' => Module::t('model', 'Office Suite'),
                'value' => $model->officeSuite !== null ? $model->officeSuite->name : null,
            ],
            [
                'label' => Module::t('model', 'Office Suite') . ' - ' . Module::t('model', 'Activation key'),
                'value' => $model->officeSuiteLicense !== null ? $model->officeSuiteLicense->key : null,
            ],
            'user'
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewRecordDetails', ['model' => $model->asset]) ?>
    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
