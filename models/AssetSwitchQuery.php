<?php

namespace marqu3s\itam\models;

/**
 * This is the ActiveQuery class for [[AssetSwitch]].
 *
 * @see AssetSwitch
 */
class AssetSwitchQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AssetSwitch[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AssetSwitch|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
