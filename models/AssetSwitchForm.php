<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 20/04/17
 * Time: 23:04
 */

namespace marqu3s\itam\models;

use Yii;

/**
 * Class AssetSwitchForm
 *
 * @property AssetSwitch $assetSwitch
 *
 * @package marqu3s\itam\models
 */
class AssetSwitchForm extends AssetForm implements IAssetForm
{
    /** @var AssetSwitch */
    private $_assetSwitch;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_assetSwitch = new AssetSwitch();
        $this->_assetSwitch->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['AssetSwitch'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $error = !parent::afterValidate();

        if (!$this->_assetSwitch->validate()) {
            $error = true;
        }

        if ($error) {
            $this->addError(null); // add an empty error to prevent saving
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        if (!parent::save()) {
            $transaction->rollBack();
            return false;
        }

        $this->_assetSwitch->id_asset = $this->asset->id;
        if (!$this->_assetSwitch->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }

    /**
     * @return AssetSwitch
     */
    public function getAssetSwitch()
    {
        return $this->_assetSwitch;
    }

    /**
     * @param AssetSwitch|array $value
     */
    public function setAssetSwitch($value)
    {
        if (is_array($value)) {
            $this->_assetSwitch->setAttributes($value);
        } elseif ($value instanceof AssetSwitch) {
            $this->_assetSwitch = $value;
            $this->asset = $value->asset;
        }
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return array_merge(parent::getAllModels(), [
            'AssetSwitch' => $this->_assetSwitch,
        ]);
    }
}
