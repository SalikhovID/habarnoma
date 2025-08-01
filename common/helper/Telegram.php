<?php

namespace common\helper;

use common\models\UserAccount;

class Telegram
{
    const string TOKEN = '8218420101:AAELUtmdYnVxFgzkhSHiO0IJCejO88iThAM';

    public static function send($chat_id, $message): void
    {
        $bot_token = self::TOKEN;
        foreach (str_split($message, 4096) as $value){
            $url = "https://api.telegram.org/bot{$bot_token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text=" . urlencode($value);
            @file_get_contents($url);
        }
    }

    public static function run($message)
    {

        if(isset($message['chat']['id'])){
            $chat_id = $message['chat']['id'];
            if(isset($message['text'])){
                $text = $message['text'];
                echo $text . PHP_EOL;
                $check =  self::is_chat_id_valid($text);
                if($check['success']){
                    // Shu joyida Laravelda bo'lsa laravelga moslab ketish kerak
                    $model = UserAccount::findOne(['chat_id' => $chat_id, 'user_id' => $check['id']]);
                    if($model){
                        $send_message = 'Bu Telegram sizga oldin ulangan';
                    }else{
                        $model = new UserAccount;
                        $model->chat_id = $chat_id;
                        $model->user_id = $check['id'];
                        $model->save();
                        $send_message = 'Sizni Telegramingiz muvofaqiyatli ulandi.';
                    }

                    self::send($chat_id, $send_message);
                }else{
                    $send_message = 'Sizning chat_id: <code>' . $chat_id . '</code>';
                    self::send($chat_id, $send_message);
                }
            }

        }
    }

    private static function is_chat_id_valid($text)
    {
        // Check if text matches the pattern "/start {number}"
        if (preg_match('/^\/start\s+(-?\d+)$/', $text, $matches)) {
            return ['success' => true, 'id' => (int)$matches[1]];
        }

        return ['success' => false];
    }

    public static function getUpdates($offset): false|string
    {
        $bot_token = self::TOKEN;
        $url = "https://api.telegram.org/bot{$bot_token}/getUpdates?offset=" . $offset;
        return file_get_contents($url);
    }
}