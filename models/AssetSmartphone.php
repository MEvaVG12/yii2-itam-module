<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use marqu3s\itam\traits\TraitAsset;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_asset_smartphone".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property string $imei
 * @property string $os
 * @property string $os_version
 * @property string $user
 *
 * @property Asset $asset
 */
class AssetSmartphone extends ActiveRecord
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
        return 'itam_asset_smartphone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset'], 'integer'],
            [['imei'], 'string', 'max' => 20],
            [['os', 'os_version', 'user'], 'string', 'max' => 30],
            [['id_asset'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::className(), 'targetAttribute' => ['id_asset' => 'id']],

            # Custom attributes
            [['locationName', 'hostname', 'ipMacAddress', 'brandAndModel'], 'safe'],
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
            'imei' => Module::t('model', 'IMEI Number'),
            'os' => Module::t('model', 'OS'),
            'os_version' => Module::t('model', 'OS version'),
            'user' => Module::t('model', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsset()
    {
        return $this->hasOne(Asset::className(), ['id' => 'id_asset']);
    }

    /**
     * @inheritdoc
     * @return AssetSmartphoneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetSmartphoneQuery(get_called_class());
    }
}
