<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetSwitchForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="switch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->errorSummary($form); ?>

    <?php include (__DIR__ . '/../layouts/_assetForm.php') ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model->assetSwitch, 'ports')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model->assetSwitch, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model->assetSwitch, 'password')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model->assetSwitch, 'firmware_version')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model->assetSwitch, 'firmware_release_date')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model->assetSwitch, 'firmware_install_date')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php
    # Include the file containing the form part that adds an asset to a group.
    include(__DIR__ . '/../layouts/_assetGroupForm.php');

    # Include the file containing the form field to add an annotation to the asset.
    include(__DIR__ . '/../layouts/_assetAnnotations.php');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->asset->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->asset->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
