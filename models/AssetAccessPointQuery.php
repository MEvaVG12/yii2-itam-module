<?php

namespace marqu3s\itam\models;

/**
 * This is the ActiveQuery class for [[AssetAccessPoint]].
 *
 * @see AssetAccessPoint
 */
class AssetAccessPointQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AssetAccessPoint[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AssetAccessPoint|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
