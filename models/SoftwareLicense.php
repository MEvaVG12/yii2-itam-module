<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_software_license".
 *
 * @property integer $id
 * @property integer $id_software
 * @property string $key
 * @property integer $purchased_licenses
 * @property integer $digital_license
 * @property string $date_of_purchase
 *
 * @property Software $software
 * @property integer $licensesInUse
 */
class SoftwareLicense extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_software_license';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_software'], 'required'],
            [['id_software', 'purchased_licenses', 'digital_license'], 'integer'],
            [['key'], 'string', 'max' => 50],
            [['date_of_purchase'], 'string', 'max' => 10],
            [['id_software'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['id_software' => 'id']],

            # Add the custom attributes that will be used to store the data to be search
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('model', 'ID'),
            'id_software' => Module::t('model', 'Software'),
            'key' => Module::t('model', 'Activation key'),
            'purchased_licenses' => Module::t('model', 'Purchased licenses'),
            'digital_license' => Module::t('model', 'Digital license'),
            'date_of_purchase' => Module::t('model', 'Date of purchase'),

            # Custom attributes used in the GridView
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoftware()
    {
        return $this->hasOne(Software::className(), ['id' => 'id_software']);
    }

    /**
     * @return int
     */
    public function getLicensesInUse()
    {
        return (int) SoftwareAsset::find()->where(['id_software_license' => $this->id])->count();
    }

    /**
     * @inheritdoc
     * @return SoftwareLicenseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SoftwareLicenseQuery(get_called_class());
    }
}
