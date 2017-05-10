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
 * Class AssetSmartphoneForm
 *
 * @property AssetSmartphone $assetSmartphone
 *
 * @package marqu3s\itam\models
 */
class AssetSmartphoneForm extends AssetForm implements IAssetForm
{
    /** @var AssetSmartphone */
    private $_assetSmartphone;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_assetSmartphone = new AssetSmartphone();
        $this->_assetSmartphone->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['AssetSmartphone'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $error = !parent::afterValidate();

        if (!$this->_assetSmartphone->validate()) {
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

        $this->_assetSmartphone->id_asset = $this->asset->id;
        if (!$this->_assetSmartphone->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }

    /**
     * @return AssetSmartphone
     */
    public function getAssetSmartphone()
    {
        return $this->_assetSmartphone;
    }

    /**
     * @param AssetSmartphone|array $value
     */
    public function setAssetSmartphone($value)
    {
        if (is_array($value)) {
            $this->_assetSmartphone->setAttributes($value);
        } elseif ($value instanceof AssetSmartphone) {
            $this->_assetSmartphone = $value;
            $this->asset = $value->asset;
        }
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return array_merge(parent::getAllModels(), [
            'AssetServer' => $this->_assetSmartphone,
        ]);
    }
}
