<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetSwitch */

$this->title = $model->asset->hostname;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Switches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="switch-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

    <?php include(__DIR__ . '/../layouts/_assetViewBaseDetails.php') ?>

    <h2><?= Module::t('app', 'Asset Details') ?></h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ports',
            'firware_version',
            'firware_release_date',
            'firware_install_date',
            'username',
            'password'
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewRecordDetails', ['model' => $model->asset]) ?>
    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
