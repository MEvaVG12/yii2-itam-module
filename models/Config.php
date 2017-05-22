<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "itam_config".
 *
 * @property integer $id
 * @property integer $asset_query_running
 * @property string $next_asset_query_time
 */
class Config extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['asset_query_running'], 'integer'],
            [['next_asset_query_time'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_query_running' => Module::t('model', 'Asset query is running'),
            'next_asset_query_time' => Module::t('model', 'Next asset query time'),
        ];
    }
}
