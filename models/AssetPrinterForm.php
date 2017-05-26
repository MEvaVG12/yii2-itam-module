<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 26/05/17
 * Time: 09:14
 */

namespace marqu3s\itam\models;

use Yii;

/**
 * Class AssetPrinterForm
 *
 * @property AssetPrinter $assetPrinter
 *
 * @package marqu3s\itam\models
 */
class AssetPrinterForm extends AssetForm implements IAssetForm
{
    /** @var AssetPrinter */
    private $_assetPrinter;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_assetPrinter = new AssetPrinter();
        $this->_assetPrinter->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['AssetPrinter'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $error = !parent::afterValidate();

        if (!$this->_assetPrinter->validate()) {
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

        $this->_assetPrinter->id_asset = $this->asset->id;
        if (!$this->_assetPrinter->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }

    /**
     * @return AssetPrinter
     */
    public function getAssetPrinter()
    {
        return $this->_assetPrinter;
    }

    /**
     * @param AssetPrinter|array $value
     */
    public function setAssetPrinter($value)
    {
        if (is_array($value)) {
            $this->_assetPrinter->setAttributes($value);
        } elseif ($value instanceof AssetPrinter) {
            $this->_assetPrinter = $value;
            $this->asset = $value->asset;
        }
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return array_merge(parent::getAllModels(), [
            'AssetPrinter' => $this->_assetPrinter,
        ]);
    }
}
