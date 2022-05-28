create view tasks_nj as

select * from v_users_js natural join tasks_js
