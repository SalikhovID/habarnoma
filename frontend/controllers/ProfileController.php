<?php

namespace frontend\controllers;

use yii\web\Controller;

class ProfileController extends Controller
{
    public function actionSettings()
    {
        return $this->render('settings');
    }
}