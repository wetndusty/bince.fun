create or replace view telegram_learn_js
as
select 
json_value(json, '$.message.text') as txt, json_value(json, '$.message.reply_to_message.text') as reply 
from telegram_js order by ts desc
;
