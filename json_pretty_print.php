<?php

$json = '{"update_id":220867313, "message":{"message_id":154,"from":{"id":1317985512,"is_bot":false,"first_name":"Slava","last_name":"Sedov","username":"wetndusty","language_code":"ru"},"chat":{"id":1317985512,"first_name":"Slava","last_name":"Sedov","username":"wetndusty","type":"private"},"date":1652681636,"reply_to_message":{"message_id":152,"from":{"id":1317985512,"is_bot":false,"first_name":"Slava","last_name":"Sedov","username":"wetndusty","language_code":"ru"},"chat":{"id":1317985512,"first_name":"Slava","last_name":"Sedov","username":"wetndusty","type":"private"},"date":1652681617,"text":"Hello"},"text":"Hi"}}';
$json = json_decode($json);
echo print_r($json, 1);
