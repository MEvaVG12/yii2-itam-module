<?php

namespace marqu3s\itam\models;

use marqu3s\behaviors\SaveGridFiltersBehavior;
use marqu3s\behaviors\SaveGridPaginationBehavior;
use marqu3s\itam\Module;
use marqu3s\itam\traits\TraitAsset;
use marqu3s\itam\traits\TraitOfficeSuite;
use marqu3s\itam\traits\TraitOfficeSuiteLicense;
use marqu3s\itam\traits\TraitOs;
use marqu3s\itam\traits\TraitOsLicense;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_asset_server".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property integer $id_os
 * @property integer $id_os_license
 * @property integer $id_office_suite
 * @property integer $id_office_suite_license
 * @property integer $cals
 *
 * @property Asset $asset
 * @property Os $os
 * @property OsLicense $osLicense
 * @property OfficeSuite $officeSuite
 * @property OfficeSuiteLicense $officeSuiteLicense
 */
class AssetServer extends ActiveRecord
{
    use TraitAsset;
    use TraitOs;
    use TraitOsLicense;
    use TraitOfficeSuite;
    use TraitOfficeSuiteLicense;

    # Add the custom attributes that will be used to store the data to be search
    public $locationName;
    public $hostname;
    public $ipMacAddress;
    public $brandAndModel;
    public $model;
    public $serviceTag;


    public function behaviors()
    {
        return [
            'saveGridPage' =>[
                'class' => SaveGridPaginationBehavior::className(),
                'sessionVarName' => self::className() . 'GridPage'
            ],
            'saveGridFilters' =>[
                'class' => SaveGridFiltersBehavior::className(),
                'sessionVarName' => self::className() . 'GridFilters'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_asset_server';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset', 'id_os', 'id_os_license', 'id_office_suite', 'id_office_suite_license', 'cals'], 'integer'],
            [['id_asset'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::className(), 'targetAttribute' => ['id_asset' => 'id']],
            [['id_os'], 'exist', 'skipOnError' => true, 'targetClass' => Os::className(), 'targetAttribute' => ['id_os' => 'id']],
            [['id_os_license'], 'exist', 'skipOnError' => true, 'targetClass' => OsLicense::className(), 'targetAttribute' => ['id_os_license' => 'id']],
            [['id_office_suite'], 'exist', 'skipOnError' => true, 'targetClass' => OfficeSuite::className(), 'targetAttribute' => ['id_office_suite' => 'id']],
            [['id_office_suite_license'], 'exist', 'skipOnError' => true, 'targetClass' => OfficeSuiteLicense::className(), 'targetAttribute' => ['id_office_suite_license' => 'id']],

            # Custom attributes
            [['locationName', 'hostname', 'ipMacAddress', 'brandAndModel', 'serviceTag'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_asset' => 'Id Asset',
            'id_os' => Module::t('model', 'OS'),
            'id_os_license' => Module::t('model', 'OS license'),
            'id_office_suite' => Module::t('model', 'Office suite'),
            'id_office_suite_license' => Module::t('model', 'Office suite license'),
            'cals' => Module::t('model', 'CALs'),

            # Custom attributes used in the GridView
            'locationName' => Module::t('model', 'Location'),
            'hostname' => Module::t('model', 'Hostname'),
            'ipMacAddress' => Module::t('model', 'IP/MAC address'),
            'brandAndModel' => Module::t('model', 'Brand and model'),
            'serviceTag' => Module::t('model', 'Service tag'),
        ];
    }

    /**
     * @inheritdoc
     *
     * @return AssetServerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetServerQuery(get_called_class());
    }
}
