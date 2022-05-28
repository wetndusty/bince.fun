<?php

include "sql.php";

define('TOKEN', '5253159562:AAE_6qq7y3upUcHvbbKILTU8rN5oo7T7a-A');

$method = 'sendMessage';
$send_data = ['text' => 'Test'];

$send_data['chat_id'] = '-1001713373125'; //$data['chat'] ['id'];

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
    //file_put_contents('telegram_log.txt', '\nresult: ' . print_r($result, 1) . "\n", FILE_APPEND);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}

?>
