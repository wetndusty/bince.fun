create or replace view tasks_js as

select tsk.id as id, json_value(tsk.json, '$.title') as title, 
json_value(tsk.json, '$.txt') as txt, 
json_value(tsk.json, '$.author') as author, 
users.name from json as tsk inner join v_users_js as users 
on json_value(tsk.json, '$.author')=users.id