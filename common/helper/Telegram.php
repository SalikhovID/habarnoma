<?php

namespace common\helper;

use common\models\UserAccount;
use DateInterval;
use DateTime;
use yii\db\Query;

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

    public static function getEvents($start_date, $end_date, $user_id = null) {
        $result = [];

        // Build the query using Yii2 Query Builder
        $query = (new Query())
            ->select(['e.*', 'et.start_time'])
            ->from(['e' => 'event'])
            ->leftJoin(['et' => 'event_time'], 'e.id = et.event_id')
            ->where(['e.status' => 10])
            ->andWhere(['<=', 'e.start_date', $end_date])
            ->andWhere(['or',
                ['is', 'e.end_date', null],
                ['>=', 'e.end_date', $start_date]
            ]);

        // Add user filter if provided
        if ($user_id !== null) {
            $query->andWhere(['e.user_id' => $user_id]);
        }

        $events = $query->all();

        $start_timestamp = strtotime($start_date);
        $end_timestamp = strtotime($end_date);

        foreach ($events as $event) {
            $event_start = strtotime($event['start_date']);
            $event_end = $event['end_date'] ? strtotime($event['end_date']) : $end_timestamp;

            // Helper function to format event output
            $formatEventOutput = function($event, $date) {
                $start_time = $event['start_time'] ?: '00:00:00';

                return [
                    'title' => $event['title'],
                    'start' => $date . 'T' . $start_time,
                    'color' => $event['color']
                ];
            };

            // Generate occurrences based on repeat type
            switch ($event['repeat_type']) {
                case 'none':
                    // Single occurrence
                    if ($event_start >= $start_timestamp && $event_start <= $end_timestamp) {
                        $result[] = $formatEventOutput($event, $event['start_date']);
                    }
                    break;

                case 'daily':
                    $interval = $event['repeat_interval'] ?: 1;
                    $current = $event_start;

                    while ($current <= $end_timestamp && $current <= $event_end) {
                        if ($current >= $start_timestamp) {
                            $result[] = $formatEventOutput($event, date('Y-m-d', $current));
                        }
                        $current = strtotime("+{$interval} days", $current);
                    }
                    break;

                case 'weekly':
                    $interval = $event['repeat_interval'] ?: 1;
                    $repeat_days = $event['repeat_days_week'] ? explode(',', $event['repeat_days_week']) : [date('w', $event_start)];

                    // Start from the beginning of the week containing start_date or event start_date
                    $week_start = strtotime('last sunday', max($event_start, $start_timestamp));
                    if (date('w', max($event_start, $start_timestamp)) == 0) {
                        $week_start = max($event_start, $start_timestamp);
                    }

                    $current_week = $week_start;

                    while ($current_week <= $end_timestamp && $current_week <= $event_end) {
                        foreach ($repeat_days as $day) {
                            $occurrence = strtotime("+{$day} days", $current_week);

                            if ($occurrence >= $event_start &&
                                $occurrence >= $start_timestamp &&
                                $occurrence <= $end_timestamp &&
                                $occurrence <= $event_end) {
                                $result[] = $formatEventOutput($event, date('Y-m-d', $occurrence));
                            }
                        }
                        $current_week = strtotime("+{$interval} weeks", $current_week);
                    }
                    break;

                case 'monthly':
                    $interval = $event['repeat_interval'] ?: 1;
                    $repeat_days = $event['repeat_days_month'] ? explode(',', $event['repeat_days_month']) : [date('j', $event_start)];

                    $current_date = new DateTime($event['start_date']);
                    $end_date_obj = new DateTime($end_date);
                    $start_date_obj = new DateTime($start_date);

                    while ($current_date <= $end_date_obj && $current_date->getTimestamp() <= $event_end) {
                        foreach ($repeat_days as $day) {
                            $occurrence = clone $current_date;
                            $occurrence->setDate($current_date->format('Y'), $current_date->format('n'), min($day, $occurrence->format('t')));

                            if ($occurrence >= $start_date_obj &&
                                $occurrence <= $end_date_obj &&
                                $occurrence->getTimestamp() >= $event_start &&
                                $occurrence->getTimestamp() <= $event_end) {
                                $result[] = $formatEventOutput($event, $occurrence->format('Y-m-d'));
                            }
                        }
                        $current_date->add(new DateInterval("P{$interval}M"));
                    }
                    break;

                case 'yearly':
                    $interval = $event['repeat_interval'] ?: 1;
                    $current_date = new DateTime($event['start_date']);
                    $end_date_obj = new DateTime($end_date);
                    $start_date_obj = new DateTime($start_date);

                    while ($current_date <= $end_date_obj && $current_date->getTimestamp() <= $event_end) {
                        if ($current_date >= $start_date_obj && $current_date->getTimestamp() >= $event_start) {
                            $result[] = $formatEventOutput($event, $current_date->format('Y-m-d'));
                        }
                        $current_date->add(new DateInterval("P{$interval}Y"));
                    }
                    break;
            }
        }

        return $result;
    }

    public static function formatEventOutput($event, $date) {
        $start_time = $event['start_time'] ?: '00:00:00';

        return [
            'title' => $event['title'],
            'start' => $date . 'T' . $start_time,
            'color' => $event['color']
        ];
    }
}