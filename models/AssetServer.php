<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use marqu3s\itam\traits\TraitAsset;
use marqu3s\itam\traits\TraitOfficeSuite;
use marqu3s\itam\traits\TraitOs;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_asset_server".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property integer $id_os
 * @property integer $id_office_suite
 * @property integer $cals
 *
 * @property Asset $asset
 * @property Os $os
 * @property OfficeSuite $officeSuite
 */
class AssetServer extends ActiveRecord
{
    use TraitAsset;
    use TraitOs;
    use TraitOfficeSuite;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_asset_server';
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
     * @inheritdoc
     *
     * @return AssetServerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetServerQuery(get_called_class());
    }
}
