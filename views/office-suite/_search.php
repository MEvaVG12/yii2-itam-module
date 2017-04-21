<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OfficeSuiteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-suite-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton(Module::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Module::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
