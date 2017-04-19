<?php

namespace marqu3s\itam\models;

use Yii;

/**
 * This is the model class for table "asset_switch".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property integer $ports
 * @property string $firmware_version
 * @property string $firmware_release_date
 * @property string $firmware_install_date
 * @property string $username
 * @property string $password
 *
 * @property Asset $idAsset
 */
class AssetSwitch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset_switch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset', 'ports'], 'integer'],
            [['firmware_release_date', 'firmware_install_date'], 'safe'],
            [['firmware_version'], 'string', 'max' => 30],
            [['username', 'password'], 'string', 'max' => 20],
            [['id_asset'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::className(), 'targetAttribute' => ['id_asset' => 'id']],
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
            'ports' => 'Ports',
            'firmware_version' => 'Firmware Version',
            'firmware_release_date' => 'Firmware Release Date',
            'firmware_install_date' => 'Firmware Install Date',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsset()
    {
        return $this->hasOne(Asset::className(), ['id' => 'id_asset']);
    }

    /**
     * @inheritdoc
     * @return AssetSwitchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetSwitchQuery(get_called_class());
    }
}
