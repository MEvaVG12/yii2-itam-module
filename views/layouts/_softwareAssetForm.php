<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 10/05/17
 * Time: 10:54
 */

use marqu3s\itam\Module;
use yii\helpers\Html;
?>
<?php if (!$model->asset->isNewRecord): ?>
    <h2><?= Module::t('app', 'Installed Softwares') ?></h2>
    <div class="well">
        <div id="softwareTable"><i class="fa fa-spin fa-spinner"></i></div>
        <?= Html::button(Module::t('app', 'Add software'), ['class' => 'btn btn-success', 'id' => 'btnAddSoftware']) ?>
    </div>
<?php endif ?>
