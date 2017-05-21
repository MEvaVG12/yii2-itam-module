<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $osLicenses \marqu3s\itam\models\OsLicense[] */
/** @var $officeSuiteLicenses \marqu3s\itam\models\OfficeSuiteLicense[] */
/** @var $softwareLicenses \marqu3s\itam\models\SoftwareAsset[] */

$css = <<<CSS
.numbersHeader {
    margin-top: 0;
}
.progress {
    height: 26px;
    margin-bottom: 0;
}
CSS;
$this->registerCss($css);

$this->title = Module::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Module::t('app', 'Number of assets in database') ?>:</h1>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center">
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Servers'), ['asset-server/index']) ?></h4>
            <h4><?= \marqu3s\itam\models\AssetServer::find()->count(); ?></h4>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center">
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Smartphones'), ['asset-smartphone/index']) ?></h4>
            <h4><?= \marqu3s\itam\models\AssetSmartphone::find()->count(); ?></h4>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center">
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Switches'), ['asset-switch/index']) ?></h4>
            <h4><?= \marqu3s\itam\models\AssetSwitch::find()->count(); ?></h4>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center">
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Workstations'), ['asset-workstation/index']) ?></h4>
            <h4><?= \marqu3s\itam\models\AssetWorkstation::find()->count(); ?></h4>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center text-muted">
            <h4 class="numbersHeader"><?= Module::t('app', 'Printers') ?></h4>
            <h4>TBD</h4>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center text-muted">
            <h4 class="numbersHeader"><?= Module::t('app', 'Wi-Fi APs') ?></h4>
            <h4>TBD</h4>
        </div>
    </div>
</div>

<?php if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports')): ?>
<h1><?= Module::t('app', 'OS Licenses Usage') ?></h1>
<table class="table table-hover">
    <tr>
        <th style="width: 30%"><?= Module::t('model', 'OS') ?></th>
        <th style="width: 15%" class="text-center"><?= Module::t('model', 'Purchased licenses') ?></th>
        <th style="width: 10%" class="text-center"><?= Module::t('model', 'In use') ?></th>
        <th><?= Module::t('model', 'Usage') ?></th>
    </tr>
    <?php foreach ($osLicenses as $license): ?>
        <?php
        $qtdInUse = $license->getLicensesInUse();
        $percentage = $license->purchased_licenses == 0 ? 101 : round(100 * $qtdInUse / $license->purchased_licenses, 1);
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
                <span class="label label-default"><?= ucfirst(Module::t('model', 'key')) ?>:</span> <?= $license->key ?>
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
        <th style="width: 15%" class="text-center"><?= Module::t('model', 'Purchased licenses') ?></th>
        <th style="width: 10%" class="text-center"><?= Module::t('model', 'In use') ?></th>
        <th><?= Module::t('model', 'Usage') ?></th>
    </tr>
    <?php foreach ($officeSuiteLicenses as $license): ?>
        <?php
        $qtdInUse = $license->getLicensesInUse();
        $percentage = $license->purchased_licenses == 0 ? 101 : round(100 * $qtdInUse / $license->purchased_licenses, 1);
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
                <a href="/itam/reports/assets-by-office-suite-license-analytic?idLicense=<?= $license->id ?>"><?= $license->officeSuite->name ?></a><br>
                <span class="label label-default"><?= ucfirst(Module::t('model', 'key')) ?>:</span> <?= $license->key ?>
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

<h1><?= Module::t('app', 'Software Licenses Usage') ?></h1>
<table class="table table-hover">
    <tr>
        <th style="width: 30%"><?= Module::t('model', 'Software') ?></th>
        <th style="width: 15%" class="text-center"><?= Module::t('model', 'Purchased licenses') ?></th>
        <th style="width: 10%" class="text-center"><?= Module::t('model', 'In use') ?></th>
        <th><?= Module::t('model', 'Usage') ?></th>
    </tr>
    <?php foreach ($softwareLicenses as $license): ?>
        <?php
        $qtdInUse = $license['inUse'];
        $percentage = (int) $license['purchasedLicenses'] == 0 ? 101 : round(100 * $qtdInUse / $license['purchasedLicenses'], 1);
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
                <a href="/itam/reports/assets-by-software-license-analytic?idLicense=<?= $license['idSoftwareLicense']  ?>"><?= $license['software'] ?></a><br>
                <span class="label label-default"><?= ucfirst(Module::t('model', 'key')) ?>:</span> <?= $license['key'] ?>
            </td>
            <td class="text-center"><?= $license['purchasedLicenses'] ?></td>
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
<?php endif ?>
