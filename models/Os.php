<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

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
