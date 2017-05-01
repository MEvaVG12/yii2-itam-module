<?php

namespace marqu3s\itam\assets;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class ModuleAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    //public $css = [
    //    'css/site.css',
    //];

    public $js = [
        'main.js'
    ];

    public $depends = [
        //'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
