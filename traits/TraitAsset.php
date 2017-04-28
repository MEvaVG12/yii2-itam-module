<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 11:56
 */

namespace marqu3s\itam\traits;

use marqu3s\itam\models\Asset;

trait TraitAsset
{
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
        # Duplicate the asset model
        $assetModel = $this->asset;
        $assetModel->id = null;
        $assetModel->hostname .= ' - Copy';
        $assetModel->isNewRecord = true;
        $assetModel->save();

        # Duplicate this model
        $this->id = null;
        $this->id_asset = $assetModel->id;
        $this->isNewRecord = true;
        $this->save();

        return $this->id;
    }
}
