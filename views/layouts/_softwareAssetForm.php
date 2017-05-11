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
<h2><?= Module::t('app', 'Installed Softwares') ?></h2>
<div class="well">
<?php if (!$model->asset->isNewRecord): ?>
    <div id="softwareTable"><i class="fa fa-spin fa-spinner"></i></div>
    <?= Html::button(Module::t('app', 'Add software'), ['class' => 'btn btn-success', 'id' => 'btnAddSoftware']) ?>
<?php else: ?>
    <div class="alert alert-info">
        <?= Module::t('app', 'Please save this asset first and than edit it to configure the installed softwares.') ?>
    </div>
<?php endif ?>
</div>
