<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 11:56
 */

namespace marqu3s\itam\traits;

use marqu3s\itam\models\Os;

trait TraitOsLicense
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsLicense()
    {
        return $this->hasOne(OsLicense::className(), ['id' => 'id_os_license']);
    }
}
