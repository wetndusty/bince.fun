create procedure JSON(IN j json)
begin
select now() as now;
select version() as v;
insert into json (json) values (j);
call starttag('json');
select * from json;
call endtag;
call starttag('id');
select last_insert_id() as last;
end

