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
/* @var $model marqu3s\itam\models\AssetServerForm */
/* @var $form yii\widgets\ActiveForm */

\marqu3s\itam\assets\ModuleAsset::register($this);

# Include de file containing the modal that adds a software to the asset.
include(__DIR__ . '/../layouts/_softwareAssetModal.php');
?>

<div class="server-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->errorSummary($form); ?>

    <?php include (__DIR__ . '/../layouts/_assetForm.php') ?>
    <?= $form->field($model->assetServer, 'id_os')->dropDownList(ArrayHelper::map(Os::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => '--', 'id' => 'ddOs']) ?>
    <?= $form->field($model->assetServer, 'id_os_license')->dropDownList(ArrayHelper::map(OsLicense::find()->where(['id_os' => $model->assetServer->id_os])->orderBy(['date_of_purchase' => SORT_DESC])->all(), 'id', 'key'), ['prompt' => '--', 'id' => 'ddOsLicense']) ?>
    <?= $form->field($model->assetServer, 'id_office_suite')->dropDownList(ArrayHelper::map(OfficeSuite::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => Module::t('app', 'Not installed'), 'id' => 'ddOfficeSuite']) ?>
    <?= $form->field($model->assetServer, 'id_office_suite_license')->dropDownList(ArrayHelper::map(OfficeSuiteLicense::find()->where(['id_office_suite' => $model->assetServer->id_office_suite])->orderBy(['date_of_purchase' => SORT_DESC])->all(), 'id', 'key'), ['prompt' => '--', 'id' => 'ddOfficeSuiteLicense']) ?>
    <?= $form->field($model->assetServer, 'cals')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->asset->isNewRecord): ?>
        <h2><?= Module::t('app', 'Installed Software') ?></h2>
        <div class="well">
            <div id="softwareTable"><i class="fa fa-spin fa-spinner"></i></div>
            <?= Html::button(Module::t('app', 'Add software'), ['class' => 'btn btn-success', 'id' => 'btnAddSoftware']) ?>
        </div>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton($model->asset->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->asset->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
