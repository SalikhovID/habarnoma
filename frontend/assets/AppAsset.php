<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main admin application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
//        'css/plugins.min.css',
        'css/kaiadmin.min.css',
        'css/demo.css',
    ];
    public $js = [
//        'js/core/jquery-3.7.1.min.js',
        'js/core/popper.min.js',
        'js/core/bootstrap.min.js',
        'js/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
        'js/plugin/bootstrap-notify/bootstrap-notify.min.js',
        'js/kaiadmin.min.js',
        'js/index.global.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
}
