<?php

namespace marqu3s\itam\models;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[SoftwareLicense]].
 *
 * @see SoftwareLicence
 */
class SoftwareLicenseQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SoftwareLicense[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SoftwareLicense|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
