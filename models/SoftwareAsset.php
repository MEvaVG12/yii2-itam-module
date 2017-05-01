<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_software_asset".
 *
 * @property integer $id_software
 * @property integer $id_software_license
 * @property integer $id_asset

 * @property Asset $asset
 * @property Software $software
 * @property SoftwareLicense $softwareLicense
 */
class SoftwareAsset extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_software_asset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_software', 'id_software_license', 'id_asset'], 'integer'],
            [['id_software', 'id_software_license', 'id_asset'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_software' => Module::t('model', 'Software'),
            'id_software_license' => Module::t('model', 'Software license'),
            'id_asset' => Module::t('model', 'Asset'),
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
    public function getSoftware()
    {
        return $this->hasOne(Software::className(), ['id' => 'id_software']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoftwareLicense()
    {
        return $this->hasOne(SoftwareLicense::className(), ['id' => 'id_software_license']);
    }
}
