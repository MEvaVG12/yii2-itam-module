<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OsLicense */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Os Licences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-license-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_os',
            'key',
            'allowed_activations',
        ],
    ]) ?>

</div>
