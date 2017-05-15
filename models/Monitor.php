<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 13/05/17
 * Time: 22:38
 */

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use marqu3s\itam\traits\TraitAsset;

/**
 * This is the model class for table "itam_monitor".
 *
 * @property integer $id
 * @property integer $id_asset
 * @property string $check_type
 * @property integer $socket_port
 * @property integer $socket_timeout
 * @property integer $ping_count
 * @property integer $ping_timeout
 * @property integer $up
 * @property string $last_check
 * @property integer $fail_count
 *
 * @property Asset $asset
 */
class Monitor extends \yii\db\ActiveRecord
{
    use TraitAsset;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_monitor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asset', 'check_type'], 'required'],
            [['id', 'id_asset', 'socket_port', 'socket_timeout', 'ping_count', 'ping_timeout', 'up', 'fail_count'], 'integer'],
            [['check_type'], 'string', 'max' => 15],
            [['last_check'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_asset' => Module::t('model', 'Asset'),
            'check_type' => Module::t('model', 'Check type'),
            'socket_port' => Module::t('model', 'Socket port'),
            'socket_timeout' => Module::t('model', 'Socket timeout'),
            'ping_count' => Module::t('model', 'Ping count'),
            'ping_timeout' => Module::t('model', 'Ping timeout'),
            'up' => Module::t('model', 'Up'),
            'last_check' => Module::t('model', 'Last check'),
            'fail_count' => Module::t('model', 'Fail count'),
        ];
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->up = 0;
                $this->fail_count = 0;
            }
        }

        return true;
    }
}
