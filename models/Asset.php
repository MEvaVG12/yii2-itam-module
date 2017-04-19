<?php

namespace marqu3s\itam\models;

use Yii;

/**
 * This is the model class for table "asset".
 *
 * @property integer $id
 * @property integer $id_location
 * @property string $room
 * @property string $hostname
 * @property string $ip_address
 * @property string $mac_address
 * @property string $brand
 * @property string $model
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property Location $idLocation
 * @property AssetAccessPoint[] $assetAccessPoints
 * @property AssetPrinter[] $assetPrinters
 * @property AssetSwitch[] $assetSwitches
 * @property AssetWorkstation[] $assetWorkstations
 */
class Asset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_location'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['room'], 'string', 'max' => 20],
            [['hostname', 'brand', 'model', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['ip_address'], 'string', 'max' => 15],
            [['mac_address'], 'string', 'max' => 14],
            [['id_location'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['id_location' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_location' => 'Id Location',
            'room' => 'Room',
            'hostname' => 'Hostname',
            'ip_address' => 'Ip Address',
            'mac_address' => 'Mac Address',
            'brand' => 'Brand',
            'model' => 'Model',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetAccessPoints()
    {
        return $this->hasMany(AssetAccessPoint::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetPrinters()
    {
        return $this->hasMany(AssetPrinter::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetSwitches()
    {
        return $this->hasMany(AssetSwitch::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetWorkstations()
    {
        return $this->hasMany(AssetWorkstation::className(), ['id_asset' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AssetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetQuery(get_called_class());
    }
}
