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
        $this->assetType = 'AssetWorkstation';
        $this->modelClass = 'marqu3s\itam\models\AssetWorkstation';
        $this->modelForm = 'marqu3s\itam\models\AssetWorkstationForm';
        $this->searchClass = 'marqu3s\itam\models\AssetWorkstationSearch';

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
            'user',
        ];

        parent::__construct($id, $module, $config);
    }
}
