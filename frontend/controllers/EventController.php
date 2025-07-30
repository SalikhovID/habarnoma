<?php

namespace frontend\controllers;

use common\constants\Status;
use common\models\Event;
use common\models\EventSearch;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class EventController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionDelete($id)
    {
        $model = Event::find()->where([
            'id' => $id,
            'user_id' => Yii::$app->user->id,
        ])->one();
        if(is_null($model)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->status = Status::DELETED->value;
        if($model->save()){
            return $this->redirect(['index']);
        }
        throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
    }
}