<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetSwitch */

$this->title = Module::t('app', 'Create Switch');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Switches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="switch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
