create or replace view v_users_js as

select json_value(json, '$.сid') as id, json_value(json, '$.name') as name, 
json_value(json, '$.tel') as `tel`, json_value(json, '$.email') as email 
from json 
where json_value(json, '$.tel') is not null order by ts desc
