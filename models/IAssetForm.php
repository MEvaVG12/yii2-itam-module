<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 01:39
 */

namespace marqu3s\itam\models;

interface IAssetForm
{
    public function init();
    public function rules();
    public function afterValidate();
    public function save();
    public function getAllModels();
}
