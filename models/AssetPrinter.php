<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;
use marqu3s\itam\traits\TraitAsset;

/**
 * This is the model class for table "itam_asset_printer".
 *
 * @property integer $id
 * @property integer $id_asset
 *
 * @property Asset $idAsset
 */
class AssetPrinter extends ActiveRecord
{
    /**
     * TraitAsset adds properties used to filter the GridView and methods
     * to work with the related Asset model.
     */
    use TraitAsset;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_asset_printer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset'], 'integer'],
            [['id_asset'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::className(), 'targetAttribute' => ['id_asset' => 'id']],

            # Custom attributes
            [['locationName', 'hostname', 'ipMacAddress', 'brandAndModel', 'group'], 'safe'],
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
     * @inheritdoc
     * @return AssetPrinterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetPrinterQuery(get_called_class());
    }
}
