<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "itam_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property Asset[] $assets
 */
class Group extends ActiveRecord
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

        if (Yii::$app->getModule('itam') !== null && Yii::$app->getModule('itam')->rbacAuthorization) {
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
        return 'itam_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
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
            'description' => Module::t('model', 'Description'),
            'created_by' => Module::t('model', 'Created by'),
            'created_at' => Module::t('model', 'Created at'),
            'updated_by' => Module::t('model', 'Updated by'),
            'updated_at' => Module::t('model', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssets()
    {
        return $this->hasMany(Asset::className(), ['id_asset' => 'id'])
            //->joinWith(['software'])
            ->orderBy(['itam_asset.hostname' => SORT_ASC]);
    }
}
