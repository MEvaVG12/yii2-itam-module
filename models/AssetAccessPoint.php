<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;
use marqu3s\itam\traits\TraitAsset;

/**
 * This is the model class for table "itam_asset_access_point".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property string $firmware_version
 * @property string $firmware_release_date
 * @property string $firmware_install_date
 *
 * @property Asset $idAsset
 */
class AssetAccessPoint extends ActiveRecord
{
    /**
     * TraitAsset adds properties used to filter the GridView and methods
     * to work with the related Asset model.
     */
    use TraitAsset;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_asset_access_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset'], 'integer'],
            [['firmware_release_date', 'firmware_install_date'], 'safe'],
            [['firmware_version'], 'string', 'max' => 30],
            [['id_asset'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::className(), 'targetAttribute' => ['id_asset' => 'id']],

            # Use NULL instead of '' (empty string)
            [['firmware_release_date', 'firmware_install_date', 'firmware_version'], 'default', 'value' => null],

            # Custom attributes
            [['locationName', 'hostname', 'ipMacAddress', 'brandAndModel', 'group'], 'safe'],
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
            'ports' => Module::t('model', 'Ports'),
            'firmware_version' => Module::t('model', 'Firmware version'),
            'firmware_release_date' => Module::t('model', 'Firmware release date'),
            'firmware_install_date' => Module::t('model', 'Firmware install date'),

            # Custom attributes used in the GridView
            'locationName' => Module::t('model', 'Location'),
            'hostname' => Module::t('model', 'Hostname'),
            'ipMacAddress' => Module::t('model', 'IP/MAC address'),
            'brandAndModel' => Module::t('model', 'Brand and model'),
            'group' => Module::t('model', 'Group'),
        ];
    }

    /**
     * @inheritdoc
     * @return AssetAccessPointQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetAccessPointQuery(get_called_class());
    }
}
