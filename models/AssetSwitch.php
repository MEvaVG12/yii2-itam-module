<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
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
            'ports' => Module::t('model', 'Ports'),
            'firmware_version' => Module::t('model', 'Firmware version'),
            'firmware_release_date' => Module::t('model', 'Firmware release date'),
            'firmware_install_date' => Module::t('model', 'Firmware install date'),
            'username' => Module::t('model', 'Username'),
            'password' => Module::t('model', 'Password'),
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