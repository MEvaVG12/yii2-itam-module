<?php

use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use marqu3s\itam\models\Asset;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Monitoring */
/* @var $form yii\widgets\ActiveForm */
/* @var $availableAssets marqu3s\itam\models\Asset[] */

$js = <<<JS
activateMonitoringSettings();
JS;
$this->registerJs($js);
?>

<div class="monitor-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'id_asset')->dropDownList(ArrayHelper::map($availableAssets, 'id', 'hostname')) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'description')->textInput(['maxlenght' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'check_type')->dropDownList(['ping' => 'Ping', 'socket' => 'Socket']) ?>
        </div>
    </div>

    <div class="row">
        <div id="socketSettings">
            <div class="col-sm-4">
                <?php
                if (!empty($model->socket_open_ports)) {
                    $availablePorts = explode(',', $model->socket_open_ports);
                    foreach ($availablePorts as $port) {
                        $tmp = explode(' - ', $port);
                        $options[$tmp[0]] = $port;
                    }
                } else {
                    $options = ['' => 'No ports open detected'];
                }
                ?>
                <?= $form->field($model, 'socket_port')->dropDownList($options) ?>
            </div>
            <div class="col-sm-4">
                <br>
                <button id="btnScanPorts" class="btn btn-sm btn-success" style="margin-top: 10px"><?= Module::t('app', 'Scan ports') ?></button>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'socket_timeout')->textInput(['maxlenght' => true]) ?>
            </div>
        </div>

        <div id="pingSettings">
            <div class="col-sm-4">
                <?= $form->field($model, 'ping_count')->textInput(['maxlenght' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'ping_timeout')->textInput(['maxlenght' => true]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'alert_after_x_consecutive_fails')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'enabled')->checkbox() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'socket_open_ports')->hiddenInput()->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
