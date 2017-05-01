<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 20/04/17
 * Time: 23:04
 */

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
use Yii;
use yii\base\Model;

/**
 * Class AssetForm
 *
 * @property Asset $asset
 *
 * @package marqu3s\itam\models
 */
abstract class AssetForm extends Model implements IAssetForm
{
    /** @var Asset */
    private $_asset;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->asset = new Asset();
        $this->asset->loadDefaultValues();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Asset'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        parent::afterValidate();

        return $this->_asset->validate();
    }

    /**
     * @return bool
     */
    public function save()
    {
        return $this->_asset->save();
    }

    /**
     * @return Asset
     */
    public function getAsset()
    {
        return $this->_asset;
    }

    /**
     * @param Asset|array $asset
     */
    public function setAsset($asset)
    {
        if ($asset instanceof Asset) {
            $this->_asset = $asset;
        } else if (is_array($asset)) {
            $this->_asset->setAttributes($asset);
        }
    }

    /**
     * @param yii\widgets\ActiveForm $form
     *
     * @return string
     */
    public function errorSummary($form)
    {
        $errorLists = [];
        foreach ($this->getAllModels() as $id => $model) {
            $errorList = $form->errorSummary($model, [
                'header' => '<p>' . Module::t('app', 'Please fix the following errors for') . '<b>' . $id . '</b></p>',
            ]);
            $errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
            $errorLists[] = $errorList;
        }
        return implode('', $errorLists);
    }

    /**
     * @return array
     */
    public function getAllModels()
    {
        return [
            'Asset' => $this->_asset,
        ];
    }
}
