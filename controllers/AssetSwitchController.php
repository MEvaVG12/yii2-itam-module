<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\AssetSwitch;
use marqu3s\itam\models\Group;
use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;

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
                'value' => 'asset.hostname'
            ],
            [
                'attribute' => 'ipMacAddress',
                'format' => 'html',
                'value' => function ($model) {
                    $ip = empty($model->asset->ip_address) ? Module::t('app', 'Dynamic IP') : $model->asset->ip_address;
                    return $ip . '<br><small>' . $model->asset->mac_address . '</small>';
                }
            ],
            [
                'attribute' => 'group',
                'format' => 'html',
                'value' => function (AssetSwitch $model) {
                    if (empty($model->asset->groups)) return null;
                    $str = '';
                    foreach ($model->asset->groups as $item) {
                        $str .= $item->group->name . '<br>';
                    }
                    return $str;
                },
                'filter' => ArrayHelper::map(Group::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
            ],
            [
                'attribute' => 'brandAndModel',
                'format' => 'html',
                'value' => function ($model) {
                    if (empty($model->asset->brand) && empty($model->asset->model)) return null;
                    return $model->asset->brand . '<br><small>' . $model->asset->model . '</small>';
                }
            ],
            [
                'attribute' => 'locationName',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->asset->location->name . '<br><small>' . $model->asset->room . '</small>';
                }
            ],
        ];

        # Always call the parent constructor method!
        parent::__construct($id, $module, $config);
    }
}
