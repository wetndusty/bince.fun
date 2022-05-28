create or replace procedure get_task(in task_id int)
begin
  call starttag('wrapper');
  select '1' as 'xml_pipe', '' as 'table_root', 'author' as 'table_row';
  set @author_id:=(select author from tasks_js where id=task_id);
set @un:=(select name from users where id=@author_id);
  select * from users where id=@author_id;
  call endtag();
  select '1' as 'xml_pipe', 'wrapper' as wrapper, 'tasks' as 'table_root', 'task' as 'table_row';
  select * from tasks_js where id=task_id;
  select '1' as 'xml_pipe', 'wrapper' as wrapper, 'tasks_types' as 'table_root', 'task_type' as 'table_row';
end