<?php

namespace marqu3s\itam\models;

use app\modules\itam\Module;
use Yii;

/**
 * This is the model class for table "os".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AssetWorkstation[] $assetWorkstations
 */
class Os extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os';
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
}
