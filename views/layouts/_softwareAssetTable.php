<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 01/05/17
 * Time: 11:14
 */

use marqu3s\itam\Module;

/** @var $this \yii\web\View */
/** @var $models \marqu3s\itam\models\SoftwareAsset[] */
?>
<?php if (count($models) == 0): ?>
    <div class="alert alert-info">
        <?= Module::t('app', 'No software installed'); ?>
    </div>
<?php else: ?>
    <table class="table">
        <tr>
            <th><?= Module::t('app', 'Software'); ?></th>
            <th><?= Module::t('app', 'Software license'); ?></th>
            <th class="text-center" style="width: 70px"><?= Module::t('app', 'Actions'); ?></th>
        </tr>
        <?php foreach ($models as $model):?>
            <tr>
                <td><?= $model->software->name ?></td>
                <td><?= $model->softwareLicense->key ?></td>
                <td class="text-center"><a href="/itam/dashboard/ajax-del-software-asset?ids=<?= $model->id_software ?>,<?= $model->id_software_license ?>,<?= $model->id_asset ?>" class="btn-del-software"><i class="fa fa-trash"></i></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
