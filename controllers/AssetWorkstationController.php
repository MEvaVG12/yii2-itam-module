<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\Module;

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
                'value' => 'asset.location.name'
            ],
            [
                'attribute' => 'room',
                'value' => 'asset.room'
            ],
            [
                'attribute' => 'hostname',
                'value' => 'asset.hostname'
            ],
            [
                'attribute' => 'osName',
                'value' => 'os.name',
            ],
            [
                'attribute' => 'officeSuiteName',
                'value' => 'officeSuite.name',
            ],
            [
                'attribute' => 'ipAddress',
                'value' => 'asset.ip_address'
            ],
            [
                'attribute' => 'macAddress',
                'value' => 'asset.mac_address'
            ],
            [
                'attribute' => 'brand',
                'value' => 'asset.brand'
            ],
            [
                'attribute' => 'model',
                'value' => 'asset.model'
            ],
            'user',
        ];

        # Always call the parent constructor method!
        parent::__construct($id, $module, $config);
    }
}
