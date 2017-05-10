<?php

use marqu3s\itam\Module;
use marqu3s\itam\models\Location;
use marqu3s\itam\models\Os;
use marqu3s\itam\models\OsLicense;
use marqu3s\itam\models\OfficeSuite;
use marqu3s\itam\models\OfficeSuiteLicense;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetSmartphoneForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="smartphone-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->errorSummary($form); ?>

    <?php include (__DIR__ . '/../layouts/_assetForm.php') ?>
    <?= $form->field($model->assetSmartphone, 'imei')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->assetSmartphone, 'os')->dropDownList(['Android' => 'Android', 'iOS' => 'iOS'], ['prompt' => '--']) ?>
    <?= $form->field($model->assetSmartphone, 'os_version')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->assetSmartphone, 'user')->textInput(['maxlength' => true]) ?>

    <?php
    # Include the file containing the form field to add an annotation to the asset.
    include(__DIR__ . '/../layouts/_assetAnnotations.php');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->asset->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->asset->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>