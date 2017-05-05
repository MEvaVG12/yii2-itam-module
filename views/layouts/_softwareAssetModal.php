<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 01/05/17
 * Time: 12:26
 */

use marqu3s\itam\Module;
use marqu3s\itam\models\Software;
use marqu3s\itam\models\SoftwareAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $model marqu3s\itam\models\AssetForm */
?>
<div id="modalAddSoftware" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= Module::t('app', 'Add software') ?></h4>
            </div>
            <div class="modal-body">
                <?php $softwareAssetModel = new SoftwareAsset(); ?>
                <?php $form = ActiveForm::begin(['id' => 'formAddSoftware']); ?>
                <input type="hidden" id="idAsset" name="SoftwareAsset[id_asset]" value="<?= $model->asset->id ?>">
                <?= $form->field($softwareAssetModel, 'id_software')->dropDownList(ArrayHelper::map(Software::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => '--']) ?>
                <?= $form->field($softwareAssetModel, 'id_software_license')->dropDownList([], ['prompt' => '--']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Module::t('app', 'Cancel') ?></button>
                <button type="button" class="btn btn-primary" id="btnModalAddSoftwareSave"><?= Module::t('app', 'Save') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
