<?php

namespace marqu3s\itam\models;

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
 * @property Asset $idAsset
 * @property Os $idOs
 * @property OfficeSuite $idOfficeSuite
 */
class AssetWorkstation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset_workstation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset', 'id_os', 'id_office_suite'], 'integer'],
            [['user'], 'string', 'max' => 100],
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
            'id_os' => 'Id Os',
            'id_office_suite' => 'Id Office Suite',
            'user' => 'User',
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
     * @return \yii\db\ActiveQuery
     */
    public function getIdOs()
    {
        return $this->hasOne(Os::className(), ['id' => 'id_os']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOfficeSuite()
    {
        return $this->hasOne(OfficeSuite::className(), ['id' => 'id_office_suite']);
    }

    /**
     * @inheritdoc
     * @return AssetWorkstationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetWorkstationQuery(get_called_class());
    }
}
