<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OfficeSuiteLicense */

$this->title = Module::t('app', 'Update') . ': ' . $model->officeSuite->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Office Suite Licenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->officeSuite->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Update');
?>
<div class="office-suite-license-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
