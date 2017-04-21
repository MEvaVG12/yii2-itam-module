<?php

use marqu3s\itam\Module;
use marqu3s\itam\models\OfficeSuite;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OfficeSuiteLicense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-suite-license-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_office_suite')->dropDownList(ArrayHelper::map(OfficeSuite::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => Module::t('app', 'Choose an office suite')]) ?>
    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'allowed_activations')->textInput() ?>
    <?= $form->field($model, 'digital_license')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
