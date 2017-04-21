<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\Module;

/**
 * AssetServerController implements the CRUD actions for AssetServer model.
 */
class AssetServerController extends BaseCrudController
{
    public function __construct($id, Module $module, array $config = [])
    {
        # Configure the assetType
        $this->assetType = 'AssetServer';

        # Configure the GridView columns
        $this->gridDataColumns = [
            'asset.location.name',
            'asset.room',
            'asset.hostname',
            'os.name',
            'officeSuite.name',
            'asset.ip_address',
            'asset.mac_address',
            'asset.brand',
            'asset.model',
            'cals',
        ];

        # Always call the parent constructor method!
        parent::__construct($id, $module, $config);
    }
}
