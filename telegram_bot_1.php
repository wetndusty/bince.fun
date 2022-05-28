<?php

include "sql.php";

function jabber($input) {
    return match ($input) {
        'привет', 'пока' => $input,
        'еблан' => 'Сам еблан!',
        'ты кто?' => 'Я Альфец!',
        'я маме скажу' => 'Ябеда!',
        'пошёл нахуй' => 'Сам иди!',
        default => null
    };
}

$data = json_decode(file_get_contents('php://input'), TRUE);
//пишем в файл лог сообщений
//file_put_contents('telegram_log.txt', '$data: ' . print_r($data, 1) . "\n", FILE_APPEND);

$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];

define('TOKEN', '5126525407:AAEjbImx17qtQlj7DoyAtHd7dhlXM-605eg');

$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');

sql_insert("messages", ["message" => $message]);

switch ($message) {
    case 'да':
        $method = 'sendMessage';
        $send_data = [
            'text' => 'Что вы хотите заказать?',
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard' => [
                    [
                        ['text' => 'Яблоки'],
                        ['text' => 'Груши'],
                    ],
                    [
                        ['text' => 'Лук'],
                        ['text' => 'Чеснок'],
                    ]
                ]
            ]
        ];
        break;
    case 'нет':
        $method = 'sendMessage';
        $send_data = ['text' => 'Приходите еще'];
        break;
    case 'яблоки':
        $method = 'sendMessage';
        $send_data = ['text' => 'заказ принят!'];
        break;
    case 'груши':
        $method = 'sendMessage';
        $send_data = ['text' => 'заказ принят!'];
        break;
    case 'лук':
        $method = 'sendMessage';
        $send_data = ['text' => 'заказ принят!'];
        break;
    case 'чеснок':
        $method = 'sendMessage';
        $send_data = ['text' => 'заказ принят!'];
        break;
    default:
        $answer = jabber($message);
        if ($answer):
            $method = 'sendMessage';
            $send_data = ['text' => $answer];
            break;
        else:
            $method = 'sendMessage';
            $send_data = [
                'text' => 'Вы хотите сделать заказ?',
                'reply_markup' => [
                    'resize_keyboard' => true,
                    'keyboard' => [
                        [
                            ['text' => 'Да'],
                            ['text' => 'Нет'],
                        ]
                    ]
                ]
            ];
    endif;
}

$send_data['chat_id'] = $data['chat'] ['id'];

$res = sendTelegram($method, $send_data);

function sendTelegram($method, $data, $headers = []) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
    ]);
    $result = curl_exec($curl);
//    file_put_contents('telegram_log.txt', '\nresult: ' . print_r($result, 1) . "\n", FILE_APPEND);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}

?>
