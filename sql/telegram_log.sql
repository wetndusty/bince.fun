create or replace procedure telegram_log(IN j json)
begin
insert into telegram_js (json) values (j);
end

