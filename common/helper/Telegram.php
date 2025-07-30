<?php

namespace common\helper;

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
                if(str_starts_with($text, '/start')){
                    $send_message = 'Sizni comandangiz: ' . $text;
                    self::send($chat_id, $send_message);
                }else{
                    $send_message = 'Sizning chat_id: <code>' . $chat_id . '</code>';
                    self::send($chat_id, $send_message);
                }
            }

        }
    }

    public static function getUpdates($offset): false|string
    {
        $bot_token = self::TOKEN;
        $url = "https://api.telegram.org/bot{$bot_token}/getUpdates?offset=" . $offset;
        return file_get_contents($url);
    }
}