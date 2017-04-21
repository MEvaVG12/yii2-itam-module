<?php

use marqu3s\itam\Module;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OfficeSuite */

$this->title = Module::t('app', 'Create Office Suite');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Office Suites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-suite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
