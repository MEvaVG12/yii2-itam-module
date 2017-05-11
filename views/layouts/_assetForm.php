<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 08/05/17
 * Time: 09:55
 */

use yii\helpers\ArrayHelper;
use marqu3s\itam\models\Location;
?>
<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model->asset, 'hostname')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model->asset, 'brand')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model->asset, 'model')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model->asset, 'serial_number')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model->asset, 'ip_address')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model->asset, 'mac_address')->widget(\yii\widgets\MaskedInput::className(), [
            'definitions' => [
                'h' => [
                    'validator' => '[0-9a-fA-F]',
                    'cardinality' => 1,
                    'casing' => "upper",
                ]
            ],
            'mask' => 'hh:hh:hh:hh:hh:hh',
            'clientOptions' => [
                'clearIncomplete' => true,
                'removeMaskOnSubmit' => true,
            ]
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model->asset, 'id_location')->dropDownList(ArrayHelper::map(Location::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => '--']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model->asset, 'room')->textInput(['maxlength' => true]) ?>
    </div>
</div>
