<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "itam_os_license".
 *
 * @property integer $id
 * @property integer $id_os
 * @property string $key
 * @property integer $purchased_licenses
 * @property integer $digital_license
 * @property string $date_of_purchase
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property Os $os
 */
class OsLicense extends ActiveRecord
{
    public $licensesInUse;

    /**
     * @return array
     */
    public function behaviors()
    {
        $config = [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeTypecastBehavior::className(),
                // 'attributeTypes' will be composed automatically according to `rules()`
            ],
        ];

        if (Yii::$app->getModule('itam')->rbacAuthorization) {
            $config = array_merge($config, [
                [
                    'class' => BlameableBehavior::className(),
                    'value' => Yii::$app->user->identity->username
                ],
            ]);
        }

        return $config;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_os_license';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_os'], 'required'],
            [['id_os', 'purchased_licenses', 'digital_license'], 'integer'],
            [['key'], 'string', 'max' => 50],
            [['date_of_purchase'], 'string', 'max' => 10],
            [['id_os'], 'exist', 'skipOnError' => true, 'targetClass' => Os::className(), 'targetAttribute' => ['id_os' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('model', 'ID'),
            'id_os' => Module::t('model', 'OS'),
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
    public function getOs()
    {
        return $this->hasOne(Os::className(), ['id' => 'id_os']);
    }


    public function getLicensesInUse()
    {
        $workstationCount = AssetWorkstation::find()->where(['id_os_license' => $this->id])->count();
        $serverCount = AssetServer::find()->where(['id_os_license' => $this->id])->count();

        return $workstationCount + $serverCount;
    }

    /**
     * @inheritdoc
     * @return OsLicenseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OsLicenseQuery(get_called_class());
    }
}
