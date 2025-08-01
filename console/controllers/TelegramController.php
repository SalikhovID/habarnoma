<?php

namespace console\controllers;

use common\helper\Telegram;
use yii\console\Controller;

class TelegramController extends Controller
{
    public function actionIndex()
    {
        echo "start\n";
        $update_id = 0;
        while (true) {
            $updates = json_decode(Telegram::getUpdates($update_id), 1);
            foreach ($updates['result'] as $update) {
                Telegram::run($update['message']);
                $update_id = $update['update_id'] + 1;
            }
            sleep(1);
        }

    }

    public function actionTest()
    {
        $string = '/start 12312';
        var_dump(str_starts_with( $string, '/start'));
    }

    function getEvents(){
        //fill here
    }
}