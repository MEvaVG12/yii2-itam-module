<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_os".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AssetWorkstation[] $assetWorkstations
 * @property AssetServer[] $assetServers
 */
class Os extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_os';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Module::t('model', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetWorkstations()
    {
        return $this->hasMany(AssetWorkstation::className(), ['id_os' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetServers()
    {
        return $this->hasMany(AssetServer::className(), ['id_os' => 'id']);
    }
}
