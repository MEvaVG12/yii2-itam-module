<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_os".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property OsLicense[] $licences
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
            'created_by' => Module::t('model', 'Created by'),
            'created_at' => Module::t('model', 'Created at'),
            'updated_by' => Module::t('model', 'Updated by'),
            'updated_at' => Module::t('model', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicenses()
    {
        return $this->hasMany(OsLicense::className(), ['id' => 'id_os']);
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
