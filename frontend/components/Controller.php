<?php

namespace frontend\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

/**
 *
 * @property-write string $successFlash
 */
class Controller extends \yii\web\Controller
{
    protected function setSuccessFlash(string $message): void
    {
        Yii::$app->session->setFlash('success', $message);
    }

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->language = Yii::$app->user->identity->language;
        }
        return parent::beforeAction($action);
    }
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}