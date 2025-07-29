<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class EventController extends Controller
{
    public function actionIndex()
    {
        // list
    }

    public function actionCreate()
    {
        $model = new \frontend\models\EventForm();

        // Set default start date to today
        $model->start_date = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Event created successfully.');
                return $this->redirect(['index']); // or wherever you want to redirect
            } else {
                Yii::$app->session->setFlash('error', 'Failed to create event. Please check the form for errors.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        //delete
    }
}