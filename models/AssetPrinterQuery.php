<?php

namespace marqu3s\itam\models;

/**
 * This is the ActiveQuery class for [[AssetPrinter]].
 *
 * @see AssetPrinter
 */
class AssetPrinterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AssetPrinter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AssetPrinter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
