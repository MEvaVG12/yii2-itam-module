<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 15/04/17
 * Time: 00:00
 */

use marqu3s\itam\Module;

rmrevin\yii\fontawesome\AssetBundle::register($this);
marqu3s\itam\assets\ModuleAsset::register($this);

/** @var $this \yii\web\View */
/** @var $content string */

# Create menu items
$items = [
    [
        'label' => Module::t('menu', 'Dashboard'),
        'url' => ['dashboard/index'],
        //'linkOptions' => ['class' => 'list-group-item'],
    ]
];
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetManager') || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetCreator')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetManager'),
            'label' => Module::t('menu', 'Servers'),
            'url' => ['asset-server/index'],
            //'linkOptions' => ['class' => 'list-group-item'],
        ],
        [
            'label' => Module::t('menu', 'Smartphones'),
            'url' => ['asset-smartphone/index'],
        ],
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetManager'),
            'label' => Module::t('menu', 'Workstations'),
            'url' => ['asset-workstation/index'],
            //'linkOptions' => ['class' => 'list-group-item'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager'),
            'label' => Module::t('menu', 'OSes'),
            'url' => ['os/index'],
            //'linkOptions' => [...],
        ],
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager'),
            'label' => Module::t('menu', 'Office Suites'),
            'url' => ['office-suite/index'],
            //'linkOptions' => [...],
        ],
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager'),
            'label' => Module::t('menu', 'Softwares'),
            'url' => ['software/index'],
            //'linkOptions' => [...],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager'),
            'label' => Module::t('menu', 'OS Licenses'),
            'url' => ['os-license/index'],
            //'linkOptions' => [...],
        ],
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager'),
            'label' => Module::t('menu', 'Office Suite Licenses'),
            'url' => ['office-suite-license/index'],
            //'linkOptions' => [...],
        ],
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager'),
            'label' => Module::t('menu', 'Software Licenses'),
            'url' => ['software-license/index'],
            //'linkOptions' => [...],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports'),
            'label' => Module::t('menu', 'Reports'),
            'url' => ['reports/index'],
            //'linkOptions' => [...],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'),
            'label' => Module::t('menu', 'Asset Groups'),
            'url' => ['group/index'],
            //'linkOptions' => ['class' => 'list-group-item'],
        ],
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'),
            'label' => Module::t('menu', 'Locations'),
            'url' => ['location/index'],
            //'linkOptions' => ['class' => 'list-group-item'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || ($this->context->module->rbacAuthorization && Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'))) {
    $items = array_merge($items, [
        [
            //'visible' => $this->context->module->rbacAuthorization && Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'),
            'label' => 'Admin',
            'items' => [
                ['label' => Module::t('menu', 'User Management'), 'url' => ['user/index']],
                ['label' => Module::t('menu', 'User Permissions'), 'url' => ['user/permissions']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">' . Module::t('menu', 'Authorization') . '</li>',
                ['label' => Module::t('menu', 'Create authorization rules'), 'url' => ['authorization/index']],
            ],
        ],
    ]);
}
?>
<?php $this->beginContent(Yii::$app->viewPath . '/layouts/' . Yii::$app->layout . '.php') ?>
<div class="itam-module">
    <div class="row">
        <div class="col-md-2">
            <?php echo \yii\bootstrap\Nav::widget([
                'activateParents' => true,
                'items' => $items,
                'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
            ]);
            ?>
        </div>
        <div class="col-md-10">
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
