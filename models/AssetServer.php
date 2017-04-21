<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use Yii;

/**
 * This is the model class for table "asset_workstation".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property integer $id_os
 * @property integer $id_office_suite
 * @property string $user
 *
 * @property Asset $asset
 * @property Os $os
 * @property OfficeSuite $officeSuite
 */
class AssetServer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset_server';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset', 'id_os', 'id_office_suite', 'cals'], 'integer'],
            [['id_asset'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::className(), 'targetAttribute' => ['id_asset' => 'id']],
            [['id_os'], 'exist', 'skipOnError' => true, 'targetClass' => Os::className(), 'targetAttribute' => ['id_os' => 'id']],
            [['id_office_suite'], 'exist', 'skipOnError' => true, 'targetClass' => OfficeSuite::className(), 'targetAttribute' => ['id_office_suite' => 'id']],
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
            'id_os' => Module::t('model', 'Os'),
            'id_office_suite' => Module::t('model', 'Office Suite'),
            'cals' => Module::t('model', 'CALs'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasOne(Os::className(), ['id' => 'id_os']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficeSuite()
    {
        return $this->hasOne(OfficeSuite::className(), ['id' => 'id_office_suite']);
    }

    /**
     * @inheritdoc
     * @return AssetWorkstationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetServerQuery(get_called_class());
    }
}
