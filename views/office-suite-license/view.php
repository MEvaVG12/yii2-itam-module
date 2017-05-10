<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \marqu3s\itam\models\OfficeSuiteLicense */

$this->title = $model->officeSuite->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Office Suite Licenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-suite-license-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'officeSuite.name',
            'key',
            'purchased_licenses',
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewRecordDetails', ['model' => $model]) ?>
    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
