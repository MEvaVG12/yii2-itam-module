<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\AssetSmartphone;
use marqu3s\itam\models\Group;
use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;

/**
 * AssetSmartphoneController implements the CRUD actions for AssetSmartphone model.
 */
class AssetSmartphoneController extends BaseCrudController
{
    public function __construct($id, Module $module, array $config = [])
    {
        # Configure the assetType
        $this->assetType = 'AssetSmartphone';

        # Configure the GridView columns
        $this->gridDataColumns = [
            [
                'attribute' => 'hostname',
                'value' => 'asset.hostname'
            ],
            [
                'attribute' => 'os',
                'value' => function (AssetSmartphone $model) {
                    $value = $model->os;
                    if (!empty($model->os_version)) $value .= ' - ' . $model->os_version;
                    return $value;
                },
            ],
            [
                'attribute' => 'ipMacAddress',
                'headerOptions' => [
                    'class' => 'hidden-xs'
                ],
                'contentOptions' => [
                    'class' => 'hidden-xs'
                ],
                'format' => 'html',
                'value' => function ($model) {
                    $ip = empty($model->asset->ip_address) ? Module::t('app', 'Dynamic IP') : $model->asset->ip_address;
                    return $ip . '<br><small>' . $model->asset->mac_address . '</small>';
                },
                'filterOptions' => [
                    'class' => 'hidden-xs'
                ],
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
                'value' => function (AssetSmartphone $model) {
                    if (empty($model->asset->groups)) return null;
                    $str = '';
                    foreach ($model->asset->groups as $item) {
                        $str .= $item->group->name . '<br>';
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
                'value' => function ($model) {
                    if (empty($model->asset->brand) && empty($model->asset->model)) return null;
                    return $model->asset->brand . '<br><small>' . $model->asset->model . '</small>';
                },
                'filterOptions' => [
                    'class' => 'hidden-xs'
                ],
            ],
            [
                'attribute' => 'user',
                'headerOptions' => [
                    'class' => 'hidden-xs'
                ],
                'contentOptions' => [
                    'class' => 'hidden-xs'
                ],
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
                'value' => function ($model) {
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
