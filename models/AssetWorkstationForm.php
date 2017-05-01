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
 * Class AssetWorkstationForm
 *
 * @property AssetWorkstation $assetWorkstation
 *
 * @package marqu3s\itam\models
 */
class AssetWorkstationForm extends AssetForm implements IAssetForm
{
    /** @var AssetWorkstation */
    private $_assetWorkstation;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_assetWorkstation = new AssetWorkstation();
        $this->_assetWorkstation->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['AssetWorkstation'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $error = !parent::afterValidate();

        if (!$this->_assetWorkstation->validate()) {
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

        $this->_assetWorkstation->id_asset = $this->asset->id;
        if (!$this->_assetWorkstation->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }

    /**
     * @return AssetWorkstation
     */
    public function getAssetWorkstation()
    {
        return $this->_assetWorkstation;
    }

    /**
     * @param AssetWorkstation|array $value
     */
    public function setAssetWorkstation($value)
    {
        if (is_array($value)) {
            $this->_assetWorkstation->setAttributes($value);
        } elseif ($value instanceof AssetWorkstation) {
            $this->_assetWorkstation = $value;
            $this->asset = $value->asset;
        }
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return array_merge(parent::getAllModels(), [
            'AssetWorkstation' => $this->_assetWorkstation,
        ]);
    }
}
