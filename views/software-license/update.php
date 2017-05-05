<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Software */

$this->title = Module::t('app', 'Update') . ': ' . $model->software->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Software Licenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->software->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Update');
?>
<div class="software-license-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
