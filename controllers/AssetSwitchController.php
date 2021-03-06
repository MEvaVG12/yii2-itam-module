<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\Asset;
use marqu3s\itam\models\AssetSwitch;
use marqu3s\itam\models\Group;
use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * AssetSwitchController implements the CRUD actions for AssetSwitch model.
 */
class AssetSwitchController extends BaseCrudController
{
    public function __construct($id, Module $module, array $config = [])
    {
        # Configure the assetType
        $this->assetType = 'AssetSwitch';

        # Configure the GridView columns
        $this->gridDataColumns = [
            [
                'attribute' => 'hostname',
                'format' => 'raw',
                'value' => function (AssetSwitch $model) {
                    return Html::a($model->asset->hostname, 'http://' . $model->asset->ip_address, ['target' => '_blank', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Module::t('app', 'Go to Web UI')]);
                }
            ],
            [
                'attribute' => 'ports',
                'headerOptions' => [
                    'style' => 'width: 150px',
                    'class' => 'hidden-xs'
                ],
                'contentOptions' => [
                    'class' => 'text-center hidden-xs'
                ],
                'filterOptions' => [
                    'class' => 'hidden-xs'
                ],
            ],
            [
                'attribute' => 'ipMacAddress',
                'format' => 'html',
                'value' => function (AssetSwitch $model) {
                    $ip = empty($model->asset->ip_address) ? Module::t('app', 'Dynamic IP') : $model->asset->ip_address;
                    return $ip . '<br><small>' . $model->asset->mac_address . '</small>';
                }
            ],
            [
                'attribute' => 'group',
                'headerOptions' => [
                    'class' => 'hidden-xs'
                ],
                'contentOptions' => [
                    'class' => 'hidden-xs'
                ],
                'format' => 'html',
                'value' => function (AssetSwitch $model) {
                    if (empty($model->asset->groups)) return null;
                    $str = '';
                    foreach ($model->asset->groups as $group) {
                        $str .= $group->name . '<br>';
                    }
                    return $str;
                },
                'filter' => ArrayHelper::map(Group::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                'filterOptions' => [
                    'class' => 'hidden-xs'
                ],
            ],
            [
                'attribute' => 'brandAndModel',
                'headerOptions' => [
                    'class' => 'hidden-xs'
                ],
                'contentOptions' => [
                    'class' => 'hidden-xs'
                ],
                'format' => 'html',
                'value' => function (AssetSwitch $model) {
                    if (empty($model->asset->brand) && empty($model->asset->model)) return null;
                    return $model->asset->brand . '<br><small>' . $model->asset->model . '</small>';
                },
                'filterOptions' => [
                    'class' => 'hidden-xs'
                ],
            ],
            [
                'attribute' => 'locationName',
                'headerOptions' => [
                    'class' => 'hidden-xs'
                ],
                'contentOptions' => [
                    'class' => 'hidden-xs'
                ],
                'format' => 'html',
                'value' => function (AssetSwitch $model) {
                    return $model->asset->location->name . '<br><small>' . $model->asset->room . '</small>';
                },
                'filterOptions' => [
                    'class' => 'hidden-xs'
                ],
            ],
        ];

        # Always call the parent constructor method!
        parent::__construct($id, $module, $config);
    }
}
