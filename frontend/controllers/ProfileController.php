<?php

namespace frontend\controllers;

use common\models\UserAccount;
use Yii;
use yii\web\Controller;

class ProfileController extends Controller
{
    public function actionSettings()
    {
        $accounts = UserAccount::findAll(['user_id' => Yii::$app->user->id]);
        return $this->render('settings', [
            'accounts' => $accounts,
            'redirect_link' => $this->link(),
        ]);
    }

    private function link()
    {
        return 'https://t.me/habarnoma_bot?start=' . Yii::$app->user->id;
    }

    public function actionDeleteChatid($id)
    {
        $user = UserAccount::findOne(['chat_id' => $id, 'user_id' => Yii::$app->user->id]);
        $user->delete();
        return $this->redirect(['settings']);
    }
}