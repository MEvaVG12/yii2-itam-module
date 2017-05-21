<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/05/17
 * Time: 17:20
 */

use marqu3s\itam\Module;

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
            'label' => Module::t('menu', 'Switches'),
            'url' => ['asset-switch/index'],
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
        [
            //'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports'),
            'label' => Module::t('menu', 'Monitoring'),
            'url' => ['monitoring/index'],
            //'linkOptions' => [...],
        ],
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

