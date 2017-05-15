<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 11:56
 */

namespace marqu3s\itam\traits;

use marqu3s\behaviors\SaveGridFiltersBehavior;
use marqu3s\behaviors\SaveGridPaginationBehavior;
use marqu3s\itam\models\Asset;
use Yii;

trait TraitAsset
{
    # Add the custom attributes that will be used to store the data to be searched
    public $locationName;
    public $hostname;
    public $ipMacAddress;
    public $brandAndModel;
    public $serviceTag;
    public $group;

    public function behaviors()
    {
        if (is_a(Yii::$app, '\yii\web\Application')) {
            return [
                'saveGridPage' => [
                    'class' => SaveGridPaginationBehavior::className(),
                    'sessionVarName' => static::className() . 'GridPage'
                ],
                'saveGridFilters' => [
                    'class' => SaveGridFiltersBehavior::className(),
                    'sessionVarName' => static::className() . 'GridFilters'
                ]
            ];
        } else {
            return [];
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsset()
    {
        return $this->hasOne(Asset::className(), ['id' => 'id_asset']);
    }

    /**
     * Duplicates an asset.
     *
     * @return int|null The ID of the new model
     */
    public function duplicate()
    {
        $trans = Yii::$app->db->beginTransaction();
        try {
            # Duplicate the asset model
            $assetModel = clone($this->asset);
            $assetModel->id = null;
            $assetModel->hostname .= ' - Copy';
            $assetModel->isNewRecord = true;
            $assetModel->save();

            # Duplicate this model
            $this->id = null;
            $this->id_asset = $assetModel->id;
            $this->isNewRecord = true;
            $this->save();

            # Duplicate the installed software
            foreach ($this->asset->installedSoftwares as $item) {
                $newItem = clone($item);
                $newItem->id_asset = $assetModel->id;
                $newItem->isNewRecord = true;
                $newItem->save();
            }

            $trans->commit();

            return $this->id;
        } catch (\Exception $e) {
            $trans->rollback();
            \yii\helpers\VarDumper::dump($e->getMessage(), 10, true);
            return false;

        }
    }
}
