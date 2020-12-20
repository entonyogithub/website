<?php

namespace springdev\urban\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class UbranAsset extends AssetBundle {

    public $sourcePath = '@vendor/springdev/yii2-urban-theme';
    public $css = [
        'dist/css/climacons-font.249593b4.css',
        'vendor/rickshaw/rickshaw.min.css',
        'dist/css/app.css',
    ];
    public $js = [
        'dist/js/perfect-scrollbar.jquery.js',
        'dist/js/app.js',
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}

