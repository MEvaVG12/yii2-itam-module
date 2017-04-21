<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 11:56
 */

namespace marqu3s\itam\traits;

use marqu3s\itam\models\OfficeSuite;

trait TraitOfficeSuite
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficeSuite()
    {
        return $this->hasOne(OfficeSuite::className(), ['id' => 'id_office_suite']);
    }
}
