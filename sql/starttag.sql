create procedure starttag (in tag_name varchar(40))
begin
  select '2' as 'xml_pipe', tag_name as wrapper;
end

