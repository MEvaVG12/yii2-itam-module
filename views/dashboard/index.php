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
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Access Points'), ['asset-access-point/index']) ?></h4>
            <h4><?= \marqu3s\itam\models\AssetAccessPoint::find()->count(); ?></h4>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="well text-center">
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Printers'), ['asset-printer/index']) ?></h4>
            <h4><?= \marqu3s\itam\models\AssetPrinter::find()->count(); ?></h4>
        </div>
    </div>
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
        <div class="well text-center">
            <h4 class="numbersHeader"><?= Html::a(Module::t('app', 'Assets Monitored'), ['monitoring/index']) ?></h4>
            <h4>
                <span title="<?= Module::t('app', 'Total') ?>" data-toggle="tooltip" data-placement="bottom"><?= \marqu3s\itam\models\Monitoring::find()->where(['enabled' => 1])->count(); ?></span> /
                <span title="<?= Module::t('app', 'Online') ?>" class="text-success" data-toggle="tooltip" data-placement="bottom"><?= \marqu3s\itam\models\Monitoring::find()->where(['enabled' => 1, 'up' => 1])->count(); ?></span> /
                <span title="<?= Module::t('app', 'Offline') ?>" class="text-danger" data-toggle="tooltip" data-placement="bottom"><?= \marqu3s\itam\models\Monitoring::find()->where(['enabled' => 1, 'up' => 0])->count(); ?></span>
            </h4>
        </div>
    </div>

</div>

<?php if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports')): ?>
    <h1><?= Module::t('app', 'OS Licenses Usage') ?></h1>
    <?php foreach ($osLicenses as $i => $license): ?>
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
        <div class="row">
            <div class="col-sm-6">
                <h5 class="software-name"><a href="/itam/reports/assets-by-os-license-analytic?idLicense=<?= $license->id ?>"><?= $license->os->name ?></a></h5>
                <span class="label label-default"><?= ucfirst(Module::t('model', 'key')) ?>:</span> <?= $license->key ?>
            </div>
            <div class="col-sm-6">
                <div class="progress">
                    <div class="progress-bar progress-bar-<?= $barCssClass ?>" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($percentage, 0) ?>%">
                        <span class="sr-only"><?= $percentage ?>%</span>
                        <?= $percentage ?>%
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?= Module::t('model', 'In use') ?>: <?= $qtdInUse ?>
                    </div>
                    <div class="col-xs-6 text-right">
                        <?= Module::t('model', 'Purchased licenses') ?>: <?= $license->purchased_licenses ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($i < count($osLicenses) - 1): ?>
            <hr style="margin-top: 10px; margin-bottom: 10px">
        <?php endif ?>
    <?php endforeach; ?>
    <br><br>



    <h1><?= Module::t('app', 'Office Suite Licenses Usage') ?></h1>
    <?php foreach ($officeSuiteLicenses as $i => $license): ?>
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
        <div class="row">
            <div class="col-sm-6">
                <h5 class="software-name"><a href="/itam/reports/assets-by-office-suite-license-analytic?idLicense=<?= $license->id ?>"><?= $license->officeSuite->name ?></a></h5>
                <span class="label label-default"><?= ucfirst(Module::t('model', 'key')) ?>:</span> <?= $license->key ?>
            </div>
            <div class="col-sm-6">
                <div class="progress">
                    <div class="progress-bar progress-bar-<?= $barCssClass ?>" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($percentage, 0) ?>%">
                        <span class="sr-only"><?= $percentage ?>%</span>
                        <?= $percentage ?>%
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?= Module::t('model', 'In use') ?>: <?= $qtdInUse ?>
                    </div>
                    <div class="col-xs-6 text-right">
                        <?= Module::t('model', 'Purchased licenses') ?>: <?= $license->purchased_licenses ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($i < count($officeSuiteLicenses) - 1): ?>
            <hr style="margin-top: 10px; margin-bottom: 10px">
        <?php endif ?>
    <?php endforeach; ?>
    <br><br>


    <h1><?= Module::t('app', 'Software Licenses Usage') ?></h1>
    <?php foreach ($softwareLicenses as $i => $license): ?>
        <?php
        $qtdInUse = $license['in_use'];
        $percentage = (int) $license['purchased_licenses'] == 0 ? 101 : round(100 * $qtdInUse / $license['purchased_licenses'], 1);
        if ($percentage < 100) {
            $barCssClass = 'success';
        } elseif ($percentage == 100) {
            $barCssClass = 'warning';
        } else {
            $percentage = 100;
            $barCssClass = 'danger';
        }
        ?>
        <div class="row">
            <div class="col-sm-6">
                <h5 class="software-name"><a href="/itam/reports/assets-by-software-license-analytic?idLicense=<?= $license['id_software_license']  ?>"><?= $license['name'] ?></a></h5>
                <span class="label label-default"><?= ucfirst(Module::t('model', 'key')) ?>:</span> <?= $license['key'] ?>
            </div>
            <div class="col-sm-6">
                <div class="progress">
                    <div class="progress-bar progress-bar-<?= $barCssClass ?>" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($percentage, 0) ?>%">
                        <span class="sr-only"><?= $percentage ?>%</span>
                        <?= $percentage ?>%
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?= Module::t('model', 'In use') ?>: <?= $qtdInUse ?>
                    </div>
                    <div class="col-xs-6 text-right">
                        <?= Module::t('model', 'Purchased licenses') ?>: <?= $license['purchased_licenses'] ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($i < count($softwareLicenses) - 1): ?>
            <hr style="margin-top: 10px; margin-bottom: 10px">
        <?php endif ?>
    <?php endforeach; ?>
    <br><br>
<?php endif ?>
