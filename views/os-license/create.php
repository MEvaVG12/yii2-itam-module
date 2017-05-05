<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OsLicense */

$this->title = Module::t('app', 'Create OS License');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'OS Licenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-license-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
