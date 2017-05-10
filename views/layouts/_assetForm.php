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
<?= $form->field($model->asset, 'hostname')->textInput(['maxlength' => true]) ?>
<?= $form->field($model->asset, 'brand')->textInput(['maxlength' => true]) ?>
<?= $form->field($model->asset, 'model')->textInput(['maxlength' => true]) ?>
<?= $form->field($model->asset, 'serial_number')->textInput(['maxlength' => true]) ?>
<?= $form->field($model->asset, 'ip_address')->textInput(['maxlength' => true]) ?>
<?= $form->field($model->asset, 'mac_address')->textInput(['maxlength' => true]) ?>
<?= $form->field($model->asset, 'id_location')->dropDownList(ArrayHelper::map(Location::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>
<?= $form->field($model->asset, 'room')->textInput(['maxlength' => true]) ?>
