<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 26/05/17
 * Time: 08:04
 */

namespace marqu3s\itam\models;

use Yii;

/**
 * Class AssetAccessPointForm
 *
 * @property AssetAccessPoint $assetAccessPoint
 *
 * @package marqu3s\itam\models
 */
class AssetAccessPointForm extends AssetForm implements IAssetForm
{
    /** @var AssetAccessPoint */
    private $_assetAccessPoint;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_assetAccessPoint = new AssetAccessPoint();
        $this->_assetAccessPoint->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['AssetAccessPoint'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $error = !parent::afterValidate();

        if (!$this->_assetAccessPoint->validate()) {
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

        $this->_assetAccessPoint->id_asset = $this->asset->id;
        if (!$this->_assetAccessPoint->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }

    /**
     * @return AssetAccessPoint
     */
    public function getAssetAccessPoint()
    {
        return $this->_assetAccessPoint;
    }

    /**
     * @param AssetAccessPoint|array $value
     */
    public function setAssetAccessPoint($value)
    {
        if (is_array($value)) {
            $this->_assetAccessPoint->setAttributes($value);
        } elseif ($value instanceof AssetAccessPoint) {
            $this->_assetAccessPoint = $value;
            $this->asset = $value->asset;
        }
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return array_merge(parent::getAllModels(), [
            'AssetAccessPoint' => $this->_assetAccessPoint,
        ]);
    }
}
