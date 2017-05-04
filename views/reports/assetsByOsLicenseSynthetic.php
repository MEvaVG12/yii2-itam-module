<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 17:59
 */

use marqu3s\itam\Module;
use marqu3s\itam\models\OsLicense;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $licenses OsLicense[] */

$this->title = Module::t('app', 'OS usage by license - Synthetic');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Reports'), 'url' => ['reports/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-os-license">
    <h1><?= $this->title ?></h1>

    <?php if (count($licenses)): ?>
        <table class="table table-hover">
            <tr>
                <th style="width: 30%"><?= Module::t('model', 'OS') ?></th>
                <th style="width: 30%"><?= Module::t('model', 'key') ?></th>
                <th style="width: 20%" class="text-center"><?= Module::t('model', 'Purchased licenses') ?></th>
                <th style="width: 20%" class="text-center"><?= Module::t('model', 'In use') ?></th>
            </tr>
            <?php foreach ($licenses as $license): ?>
                    <?php
                    $inUse = $license->getLicensesInUse();
                    if ($license->purchased_licenses > $inUse) {
                        $alertClass = 'success';
                    } elseif ($license->purchased_licenses == $inUse) {
                        $alertClass = 'warning';
                    } else {
                        $alertClass = 'danger';
                    }
                    ?>
                    <tr class="<?= $alertClass ?>">
                        <td><?= $license->os->name ?></td>
                        <td><?= Html::a($license->key, ['reports/assets-by-os-license-analytic', 'idLicense' => $license->id]) ?></td>
                        <td class="text-center"><?= $license->purchased_licenses ?></td>
                        <td class="text-center"><?= $inUse ?></td>
                    </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <div class="alert alert-info"><?= Module::t('app', 'No license contains allowed activations greater than zero.') ?></div>
    <?php endif ?>
</div>
