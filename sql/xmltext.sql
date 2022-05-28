delimiter //
drop procedure if exists xmltext//
create procedure xmltext (in txt varchar(1024))
begin
  select '4' as 'xml_pipe', txt as xmltext;
end//