<?php

use marqu3s\itam\Module;
use marqu3s\itam\models\Software;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\SoftwareLicense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="software-license-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_software')->dropDownList(ArrayHelper::map(Software::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => Module::t('app', 'Choose a software')]) ?>
    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'purchased_licenses')->textInput() ?>
    <?= $form->field($model, 'digital_license')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
