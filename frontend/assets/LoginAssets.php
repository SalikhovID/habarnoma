<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class LoginAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login-bootstrap.min.css',
        'css/login.css',
    ];
}