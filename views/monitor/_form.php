<?php

use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use marqu3s\itam\models\Asset;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Monitor */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
activateMonitoringSettings();
JS;
$this->registerJs($js);
?>

<div class="monitor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_asset')->dropDownList(ArrayHelper::map(Asset::find()->where("ip_address IS NOT NULL && ip_address != ''")->orderBy(['hostname' => SORT_ASC])->all(), 'id', 'hostname')) ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'check_type')->dropDownList(['ping' => 'Ping', 'socket' => 'Socket']) ?>
        </div>

        <div id="socketSettings">
            <div class="col-sm-4">
                <?= $form->field($model, 'socket_port')->dropDownList([$model->socket_port => $model->socket_port]) ?>
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
