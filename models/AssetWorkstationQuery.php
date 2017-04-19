<?php

namespace marqu3s\itam\models;

/**
 * This is the ActiveQuery class for [[AssetWorkstation]].
 *
 * @see AssetWorkstation
 */
class AssetWorkstationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AssetWorkstation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AssetWorkstation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
