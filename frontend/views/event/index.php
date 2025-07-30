<?php

use common\models\Event;
use frontend\components\Gridview;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'headerButtons' => Html::a(Yii::t('app', 'Create Event'), ['create'], ['class' => 'btn btn-success']),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
        [
            'attribute' => 'color',
            'format' => 'raw',
            'value' => function (Event $model) {
                return '<span class="colorinput-color" style="background-color: '.$model->color.'"></span>';
            }
        ],
        'description:ntext',
        'repeat_type',
        [
            'attribute' => 'days',
            'format' => 'raw',
            'value' => function (Event $model) {
                return match ($model->repeat_type) {
                  'daily' => $model->repeat_interval,
                  'weekly' => $model->repeat_days_week,
                  'monthly' => $model->repeat_days_month,
                  default => '---'
                };
            }
        ],
        'start_date:date',
        'end_date:date',
        [
            'attribute' => 'times',
            'format' => 'raw',
            'value' => function (Event $model) {
                $times = [];
                foreach ($model->eventTimes as $eventTime) {
                    $times[] = substr($eventTime->start_time, 0, 5);
                }
                return implode(', ', $times);
            }
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{delete}',

        ],
    ],
]); ?>
