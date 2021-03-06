<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 17:59
 */

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use marqu3s\itam\models\SoftwareLicense;

/* @var $this yii\web\View */
/* @var $license SoftwareLicense */
/* @var $workstations \marqu3s\itam\models\AssetWorkstation[] */
/* @var $servers \marqu3s\itam\models\AssetServer[] */

$this->title = Module::t('app', 'Software usage by license - Analytic');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Reports'), 'url' => ['reports/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-software-license">
    <h1><?= $this->title ?></h1>

    <div class="well">
        <?= Module::t('app', 'Choose a Software license:') ?>
        <?= Html::dropDownList('idLicense', $license !== null ? $license->id : null, ArrayHelper::map(SoftwareLicense::find()->joinWith(['software'])->orderBy(['itam_software.name' => SORT_ASC])->all(), 'id', function ($model) { return $model->software->name . ' - ' . $model->key; }, function ($model) { return $model->software->name; }), ['prompt' => '--', 'id' => 'idLicense', 'class' => 'form-control']) ?>
    </div>

    <?php if ($license !== null): ?>
        <?php
        $inUse = count($servers) + count($workstations);
        if ($license->purchased_licenses > $inUse) {
            $alertClass = 'success';
        } elseif ($license->purchased_licenses == $inUse) {
            $alertClass = 'warning';
        } else {
            $alertClass = 'danger';
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="text-center alert alert-info">
                    <h2 style="margin-top: 0"><?= Module::t('model', 'Purchased licenses') ?></h2>
                    <h3><?= $license->purchased_licenses ?></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center alert alert-<?= $alertClass ?>">
                    <h2 style="margin-top: 0"><?= Module::t('model', 'In use') ?></h2>
                    <h3><?= count($servers) + count($workstations) ?></h3>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (count($servers)): ?>
        <h2><?= Module::t('app', 'Servers') ?></h2>
        <table class="table table-hover">
            <tr>
                <th style="width: 3%">#</th>
                <th style="width: 20%"><?= Module::t('model', 'Hostname') ?></th>
                <th style="width: 15%" class=""><?= Module::t('model', 'Location') ?></th>
                <th style="width: 10%" class=""><?= Module::t('model', 'Room') ?></th>
                <th style="" class=""><?= Module::t('model', 'IP address') ?></th>
            </tr>
            <?php foreach ($servers as $i => $item): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= Html::a($item->asset->hostname, ['asset-server/view', 'id' => $item->id]) ?></td>
                    <td><?= $item->asset->location->name ?></td>
                    <td><?= $item->asset->room ?></td>
                    <td><?= $item->asset->ip_address ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5"><strong>TOTAL: <?= count($servers) ?></strong></td>
            </tr>
        </table>
    <?php endif ?>

    <?php if (count($workstations)): ?>
        <h2><?= Module::t('app', 'Workstations') ?></h2>
        <table class="table table-hover">
            <tr>
                <th style="width: 3%">#</th>
                <th style="width: 20%"><?= Module::t('model', 'Hostname') ?></th>
                <th style="width: 15%" class=""><?= Module::t('model', 'Location') ?></th>
                <th style="width: 15%" class=""><?= Module::t('model', 'Room') ?></th>
                <th style="" class=""><?= Module::t('model', 'IP address') ?></th>
            </tr>
            <?php foreach ($workstations as $i => $item): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= Html::a($item->asset->hostname, ['asset-workstation/view', 'id' => $item->id]) ?></td>
                    <td><?= $item->asset->location->name ?></td>
                    <td><?= $item->asset->room ?></td>
                    <td><?= $item->asset->ip_address ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5"><strong>TOTAL: <?= count($workstations) ?></strong></td>
            </tr>
        </table>
    <?php endif ?>

    <?php if ($license !== null && count($servers) == 0 && count($workstations) == 0): ?>
        <div class="alert alert-info"><?= Module::t('app', 'No asset is using this Software license.') ?></div>
    <?php endif ?>
</div>
