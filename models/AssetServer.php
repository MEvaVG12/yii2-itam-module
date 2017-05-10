<?php

namespace marqu3s\itam\models;

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
    /**
     * TraitAsset adds properties used to filter the GridView and methods
     * to work with the related Asset model.
     */
    use TraitAsset;
    use TraitOs;
    use TraitOsLicense;
    use TraitOfficeSuite;
    use TraitOfficeSuiteLicense;


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

            # Use NULL instead of '' (empty string)
            [['cals'], 'default', 'value' => null],

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
            'id_office_suite' => Module::t('model', 'Office Suite'),
            'id_office_suite_license' => Module::t('model', 'Office Suite license'),
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
