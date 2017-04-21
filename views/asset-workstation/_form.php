<?php

use marqu3s\itam\Module;
use marqu3s\itam\models\Location;
use marqu3s\itam\models\Os;
use marqu3s\itam\models\OfficeSuite;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workstation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->errorSummary($form); ?>

    <?= $form->field($model->asset, 'hostname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->asset, 'brand')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->asset, 'model')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->assetWorkstation, 'id_os')->dropDownList(ArrayHelper::map(Os::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>
    <?= $form->field($model->assetWorkstation, 'id_office_suite')->dropDownList(ArrayHelper::map(OfficeSuite::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => Module::t('app', 'Not installed')]) ?>
    <?= $form->field($model->asset, 'ip_address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->asset, 'mac_address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->asset, 'id_location')->dropDownList(ArrayHelper::map(Location::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>
    <?= $form->field($model->asset, 'room')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->assetWorkstation, 'user')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->asset->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->asset->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
