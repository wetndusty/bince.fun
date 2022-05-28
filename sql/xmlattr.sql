delimiter //
drop procedure if exists xmlattr//
create procedure xmlattr (in tag_name varchar(40), in attrvalue varchar(400))
begin
  select '5' as 'xml_pipe', tag_name as attname, attrvalue as attvalue;
end//
