<?php

use marqu3s\itam\Module;

/** @var $this \yii\web\View */
/** @var $osLicenses \marqu3s\itam\models\OsLicense[] */
/** @var $officeSuiteLicenses \marqu3s\itam\models\OfficeSuiteLicense[] */

$css = <<<CSS
.progress {
    height: 26px;
    margin-bottom: 0;
}
CSS;
$this->registerCss($css);

$this->title = Module::t('app', 'Dashboard');
//$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Dashboard'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Module::t('app', 'OS Licenses Usage') ?></h1>

<table class="table table-hover">
    <tr>
        <th style="width: 30%"><?= Module::t('model', 'OS') ?></th>
        <th style="width: 15%" class="text-center"><?= Module::t('model', 'Allowed activations') ?></th>
        <th style="width: 10%" class="text-center"><?= Module::t('model', 'In use') ?></th>
        <th></th>
    </tr>
    <?php foreach ($osLicenses as $license): ?>
        <?php
        $qtdInUse = $license->getLicensesInUse();
        $percentage = round(100 * $qtdInUse / $license->purchased_licenses, 1);
        if ($percentage < 100) {
            $barCssClass = 'success';
        } elseif ($percentage == 100) {
            $barCssClass = 'warning';
        } else {
            $percentage = 100;
            $barCssClass = 'danger';
        }
        ?>
        <tr>
            <td>
                <a href="/itam/reports/assets-by-os-license-analytic?idLicense=<?= $license->id ?>"><?= $license->os->name ?></a><br>
                <span class="label label-default">Key:</span> <?= $license->key ?>
            </td>
            <td class="text-center"><?= $license->purchased_licenses ?></td>
            <td class="text-center"><?= $qtdInUse ?></td>
            <th>
                <div class="progress">
                    <div class="progress-bar progress-bar-<?= $barCssClass ?>" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($percentage, 0) ?>%">
                        <span class="sr-only"><?= $percentage ?>%</span>
                        <?= $percentage ?>%
                    </div>
                </div>
            </th>
        </tr>
    <?php endforeach; ?>
</table>
<br>


<h1><?= Module::t('app', 'Office Suite Licenses Usage') ?></h1>

<table class="table table-hover">
    <tr>
        <th style="width: 30%"><?= Module::t('model', 'Office Suite') ?></th>
        <th style="width: 15%" class="text-center"><?= Module::t('model', 'Allowed activations') ?></th>
        <th style="width: 10%" class="text-center"><?= Module::t('model', 'In use') ?></th>
        <th></th>
    </tr>
    <?php foreach ($officeSuiteLicenses as $license): ?>
        <?php
        $qtdInUse = $license->getLicensesInUse();
        $percentage = round(100 * $qtdInUse / $license->purchased_licenses, 1);
        if ($percentage < 100) {
            $barCssClass = 'success';
        } elseif ($percentage == 100) {
            $barCssClass = 'warning';
        } else {
            $percentage = 100;
            $barCssClass = 'danger';
        }
        ?>
        <tr>
            <td>
                <?= $license->officeSuite->name ?><br>
                <span class="label label-default">Key:</span> <?= $license->key ?>
            </td>
            <td class="text-center"><?= $license->purchased_licenses ?></td>
            <td class="text-center"><?= $qtdInUse ?></td>
            <th>
                <div class="progress">
                    <div class="progress-bar progress-bar-<?= $barCssClass ?>" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($percentage, 0) ?>%">
                        <span class="sr-only"><?= $percentage ?>%</span>
                        <?= $percentage ?>%
                    </div>
                </div>
            </th>
        </tr>
    <?php endforeach; ?>
</table>
