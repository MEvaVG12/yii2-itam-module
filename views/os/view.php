<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Os */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'OSes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

    <?= $this->render('/layouts/_arViewRecordDetails', ['model' => $model]) ?>
    <?= $this->render('/layouts/_arViewButtons', ['model' => $model]) ?>

</div>
