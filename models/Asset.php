<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "itam_asset".
 *
 * @property integer $id
 * @property integer $id_location
 * @property string $room
 * @property string $hostname
 * @property string $ip_address
 * @property string $mac_address
 * @property string $brand
 * @property string $model
 * @property string $serial_number
 * @property string $service_tag
 * @property string $annotations
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property Location $location
 * @property AssetAccessPoint[] $assetAccessPoints
 * @property AssetPrinter[] $assetPrinters
 * @property AssetSwitch[] $assetSwitches
 * @property AssetWorkstation[] $assetWorkstations
 * @property SoftwareAsset[] $installedSoftwares
 */
class Asset extends ActiveRecord
{
    const ASSET_TYPES = [
        'accessPoint', 'printer', 'server', 'smartphone', 'switch', 'workstation'
    ];

    public $groupId = [];

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

        # Add the BlameableBehavior only in web application
        if (is_a(Yii::$app, '\yii\web\Application')) {
            $config[] = [
                'class' => BlameableBehavior::className(),
                'value' => Yii::$app->user->identity->username
            ];
        }

        return $config;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itam_asset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hostname'], 'required'],
            [['hostname'], 'unique'],
            [['id_location'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['room', 'service_tag'], 'string', 'max' => 20],
            [['hostname', 'brand', 'model', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['serial_number'], 'string', 'max' => 30],
            [['ip_address'], 'string', 'max' => 15],
            [['mac_address'], 'string', 'max' => 17],
            [['annotations'], 'string'],
            [['id_location'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['id_location' => 'id']],

            # Use NULL instead of '' (empty string)
            [['room', 'brand', 'model', 'service_tag', 'serial_number', 'ip_address', 'mac_address', 'annotations'], 'default', 'value' => null],

            # Custom attributes
            [['groupId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_location' => Module::t('model', 'Location'),
            'room' => Module::t('model', 'Room'),
            'hostname' => Module::t('model', 'Hostname'),
            'ip_address' => Module::t('model', 'IP address'),
            'mac_address' => Module::t('model', 'MAC address'),
            'brand' => Module::t('model', 'Brand'),
            'model' => Module::t('model', 'Model'),
            'serial_number' => Module::t('model', 'Serial number'),
            'service_tag' => Module::t('model', 'Service tag'),
            'annotations' => Module::t('model', 'Annotations'),
            'created_by' => Module::t('model', 'Created by'),
            'created_at' => Module::t('model', 'Created at'),
            'updated_by' => Module::t('model', 'Updated by'),
            'updated_at' => Module::t('model', 'Updated at'),

            # Custom attributes
            'groupId' => Module::t('model', 'Groups'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetAccessPoints()
    {
        return $this->hasMany(AssetAccessPoint::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetPrinters()
    {
        return $this->hasMany(AssetPrinter::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetServers()
    {
        return $this->hasMany(AssetServer::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetSmartphones()
    {
        return $this->hasMany(AssetSmartphone::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetSwitches()
    {
        return $this->hasMany(AssetSwitch::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssetWorkstations()
    {
        return $this->hasMany(AssetWorkstation::className(), ['id_asset' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstalledSoftwares()
    {
        return $this->hasMany(SoftwareAsset::className(), ['id_asset' => 'id'])
            ->joinWith(['software'])
            ->orderBy(['itam_software.name' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(GroupAsset::className(), ['id_asset' => 'id'])
            ->joinWith(['group'])
            ->orderBy(['itam_group.name' => SORT_ASC]);
    }

    /**
     * @inheritdoc
     * @return AssetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        # Store each group this asset belongs to in the groupId attribute.
        foreach ($this->groups as $group) {
            $this->groupId[] = $group->id_group;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        
        # Saves the groups association
        $sql = "DELETE FROM itam_group_asset WHERE id_asset = $this->id";
        Yii::$app->db->createCommand($sql)->execute();
        if (!empty($this->groupId)) {
            foreach ($this->groupId as $id_group) {
                $sql = "INSERT INTO itam_group_asset (id_asset, id_group) VALUES ($this->id, $id_group)";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }

    /**
     * Return a URL to an asset according to its type.
     *
     * @param string $action 'view', 'create', 'update'
     *
     * @return array|null
     *
     * @throws InvalidParamException
     */
    public function getUrl($action = 'view')
    {
        if (!in_array($action, ['view', 'update', 'create'])) {
            throw new InvalidParamException('The $action parameter only accepts "create", "update" or "view" values.');
        }

        foreach (self::ASSET_TYPES as $type) {
            $classname = 'marqu3s\itam\models\Asset' . ucfirst($type);
            if (($model = $classname::find()->where(['id_asset' => $this->id])->one()) !== null) {
                $url = ['asset-' . Inflector::camel2id($type) . '/' . $action];
                if (in_array($action, ['view', 'update'])) {
                    $url['id'] = $model->id;
                }

                return $url;
            }
        }

        return null;
    }
}
