<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "itam_office_suite_license".
 *
 * @property integer $id
 * @property integer $id_office_suite
 * @property string $key
 * @property integer $purchased_licenses
 * @property integer $digital_license
 * @property string $date_of_purchase
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property OfficeSuite $officeSuite
 */
class OfficeSuiteLicense extends ActiveRecord
{
    public $licensesInUse;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_office_suite_license';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_office_suite'], 'required'],
            [['id_office_suite', 'purchased_licenses', 'digital_license'], 'integer'],
            [['key'], 'string', 'max' => 50],
            [['date_of_purchase'], 'string', 'max' => 10],
            [['id_office_suite'], 'exist', 'skipOnError' => true, 'targetClass' => OfficeSuite::className(), 'targetAttribute' => ['id_office_suite' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('model', 'ID'),
            'id_office_suite' => Module::t('model', 'Office Suite'),
            'key' => Module::t('model', 'Activation key'),
            'purchased_licenses' => Module::t('model', 'Purchased licenses'),
            'digital_license' => Module::t('model', 'Digital license'),
            'date_of_purchase' => Module::t('model', 'Date of purchase'),
            'created_by' => Module::t('model', 'Created by'),
            'created_at' => Module::t('model', 'Created at'),
            'updated_by' => Module::t('model', 'Updated by'),
            'updated_at' => Module::t('model', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficeSuite()
    {
        return $this->hasOne(OfficeSuite::className(), ['id' => 'id_office_suite']);
    }


    public function getLicensesInUse()
    {
        $workstationCount = AssetWorkstation::find()->where(['id_office_suite_license' => $this->id])->count();
        $serverCount = AssetServer::find()->where(['id_office_suite_license' => $this->id])->count();

        return $workstationCount + $serverCount;
    }

    /**
     * @inheritdoc
     * @return OfficeSuiteLicenseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfficeSuiteLicenseQuery(get_called_class());
    }
}
