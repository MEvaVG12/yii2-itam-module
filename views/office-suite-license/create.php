<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OfficeSuiteLicense */

$this->title = Module::t('app', 'Create Office Suite License');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Office Suite Licenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-suite-license-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
