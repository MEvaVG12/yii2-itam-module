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
 * Class AssetServerForm
 *
 * @property AssetServer $assetServer
 *
 * @package marqu3s\itam\models
 */
class AssetServerForm extends AssetForm implements IAssetForm
{
    /** @var AssetServer */
    private $_assetServer;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_assetServer = new AssetServer();
        $this->_assetServer->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['AssetServer'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $error = !parent::afterValidate();

        if (!$this->_assetServer->validate()) {
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

        $this->_assetServer->id_asset = $this->asset->id;
        if (!$this->_assetServer->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }

    /**
     * @return AssetServer
     */
    public function getAssetServer()
    {
        return $this->_assetServer;
    }

    /**
     * @param AssetServer|array $value
     */
    public function setAssetServer($value)
    {
        if (is_array($value)) {
            $this->_assetServer->setAttributes($value);
        } elseif ($value instanceof AssetServer) {
            $this->_assetServer = $value;
            $this->asset = $value->asset;
        }
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return array_merge(parent::getAllModels(), [
            'AssetServer' => $this->_assetServer,
        ]);
    }
}
