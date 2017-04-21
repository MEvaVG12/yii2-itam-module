<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 11:56
 */

namespace marqu3s\itam\traits;

use marqu3s\itam\models\OfficeSuiteLicense;

trait TraitOfficeSuiteLicense
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficeSuiteLicense()
    {
        return $this->hasOne(OfficeSuiteLicense::className(), ['id' => 'id_office_suite_license']);
    }
}
