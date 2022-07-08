<?php

error_reporting(E_ERROR | E_PARSE);
include "pipe.php";

function jabber($input) {
    global $data_in;
    return match ($input) {
        'Ты кто?' => 'Дед пыхто!',
        'суефа' => ["камень", "ножницы", "бумага"][random_int(0, 2)],
        'chat id' => $data_in['message']['chat']['id'],
        default => (sql_get_table_fx('telegram_learn_js', ["txt", "reply"], ["reply" => $input])[0]['txt'])
    };
}

$json = file_get_contents('php://input');
$data_in = json_decode($json, TRUE);
//пишем в файл лог сообщений
//file_put_contents('telegram_log.txt', '$data: ' . $json . "\n", FILE_APPEND); // print_r($data_in, 1)

$data = $data_in['callback_query'] ? $data_in['callback_query'] : $data_in['message'];

define('TOKEN', '5537630755:AAFuhg4Dm_vC0AMi9o32VSQ8NXp2ExjVvQ4');

//$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');
$message = $data['text'] ? $data['text'] : $data['data'];
$location = $data['location'];
$message = $location ? 'location' : $message;
sql_insert("messages", ["message" => $message]);
$global_heap['log'] = $json;
$pipe_log = <<<XML
        <stored_proc name="telegram_log" heap="log"/>
XML;
process_pipeline($pipe_log);
//sql_insert("telegram_js", ["json" => $data]);
$method = 'sendMessage';
$reply = $data_in["message"]["reply_to_message"];
$url = $data_in["message"]["entities"][0]["type"] === "url";
$answer = $reply ? 'ладненько' : jabber($message);
$answer = $url ? "интересная ссылка" : $answer;
if ($answer):
    $send_data = ['text' => $answer];
else:
    $send_data = ['text' => "извини, в ответах я ограничен - правильно задавай вопросы..."];
endif;

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
