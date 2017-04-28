<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\OfficeSuite;
use marqu3s\itam\models\Os;
use marqu3s\itam\Module;
use yii\helpers\ArrayHelper;

/**
 * AssetWorkstationController implements the CRUD actions for AssetWorkstation model.
 */
class AssetWorkstationController extends BaseCrudController
{
    public function __construct($id, Module $module, array $config = [])
    {
        # Configure the assetType
        $this->assetType = 'AssetWorkstation';

        # Configure the GridView columns
        $this->gridDataColumns = [
            [
                'attribute' => 'locationName',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->asset->location->name . '<br><small>' . $model->asset->room . '</small>';
                }
            ],
            [
                'attribute' => 'hostname',
                'value' => 'asset.hostname'
            ],
            [
                'attribute' => 'id_os',
                'value' => 'os.name',
                'filter' => ArrayHelper::map(Os::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
            ],
            [
                'attribute' => 'id_office_suite',
                'value' => 'officeSuite.name',
                'filter' => ArrayHelper::map(OfficeSuite::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
            ],
            [
                'attribute' => 'ipMacAddress',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->asset->ip_address . '<br><small>' . $model->asset->mac_address . '</small>';
                }
            ],
            [
                'attribute' => 'brandAndModel',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->asset->brand . '<br><small>' . $model->asset->model . '</small>';
                }
            ],
            [
                'attribute' => 'serviceTag',
                'value' => 'asset.service_tag'
            ],
            'user',
        ];

        # Always call the parent constructor method!
        parent::__construct($id, $module, $config);
    }
}
