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

\marqu3s\itam\assets\ModuleAsset::register($this);
?>

<div class="smartphone-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->errorSummary($form); ?>

    <?php include (__DIR__ . '/../layouts/_assetForm.php') ?>
    <?= $form->field($model->assetSmartphone, 'imei')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->assetSmartphone, 'os')->dropDownList(['Android' => 'Android', 'iOS' => 'iOS'], ['prompt' => '--']) ?>
    <?= $form->field($model->assetSmartphone, 'os_version')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->assetSmartphone, 'user')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->asset->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->asset->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
