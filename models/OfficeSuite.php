<?php

namespace marqu3s\itam\models;

use app\modules\itam\Module;
use Yii;

/**
 * This is the model class for table "office_suite".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AssetWorkstation[] $assetWorkstations
 */
class OfficeSuite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'office_suite';
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
        return $this->hasMany(AssetWorkstation::className(), ['id_office_suite' => 'id']);
    }
}
