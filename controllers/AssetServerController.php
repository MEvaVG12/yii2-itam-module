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
        $this->assetType = 'AssetServer';
        $this->modelClass = 'marqu3s\itam\models\AssetServer';
        $this->modelForm = 'marqu3s\itam\models\AssetServerForm';
        $this->searchClass = 'marqu3s\itam\models\AssetServerSearch';

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

        parent::__construct($id, $module, $config);
    }
}
