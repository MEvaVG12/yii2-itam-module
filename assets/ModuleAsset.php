<?php

namespace marqu3s\itam\assets;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class ModuleAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'itam.css',
    ];

    public $js = [
        'itam.js'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
