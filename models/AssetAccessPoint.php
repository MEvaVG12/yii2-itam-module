<?php

namespace marqu3s\itam\models;

use Yii;

/**
 * This is the model class for table "asset_access_point".
 *
 * @property integer $id
 * @property integer $id_asset
 *
 * @property Asset $idAsset
 */
class AssetAccessPoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset_access_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset'], 'integer'],
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
     * @return AssetAccessPointQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetAccessPointQuery(get_called_class());
    }
}
