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
    ]
];
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetManager') || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetCreator')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            'label' => Module::t('menu', 'Access Points'),
            'url' => ['asset-access-point/index'],
        ],
        [
            'label' => Module::t('menu', 'Printers'),
            'url' => ['asset-printer/index'],
        ],
        [
            'label' => Module::t('menu', 'Servers'),
            'url' => ['asset-server/index'],
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
            'label' => Module::t('menu', 'Workstations'),
            'url' => ['asset-workstation/index'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            'label' => Module::t('menu', 'OSes'),
            'url' => ['os/index'],
        ],
        [
            'label' => Module::t('menu', 'Office Suites'),
            'url' => ['office-suite/index'],
        ],
        [
            'label' => Module::t('menu', 'Softwares'),
            'url' => ['software/index'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            'label' => Module::t('menu', 'OS Licenses'),
            'url' => ['os-license/index'],
        ],
        [
            'label' => Module::t('menu', 'Office Suite Licenses'),
            'url' => ['office-suite-license/index'],
        ],
        [
            'label' => Module::t('menu', 'Software Licenses'),
            'url' => ['software-license/index'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports')) {
    $items = array_merge($items, [
        '<li class="divider"></li>',
        [
            'label' => Module::t('menu', 'Reports'),
            'url' => ['reports/index'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin')) {
    $items = array_merge($items, [
        [
            'label' => Module::t('menu', 'Monitoring'),
            'url' => ['monitoring/index'],
        ],
        '<li class="divider"></li>',
        [
            'label' => Module::t('menu', 'Asset Groups'),
            'url' => ['group/index'],
        ],
        [
            'label' => Module::t('menu', 'Locations'),
            'url' => ['location/index'],
        ],
    ]);
}
if (!$this->context->module->rbacAuthorization || ($this->context->module->rbacAuthorization && Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'))) {
    $items = array_merge($items, [
        [
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
