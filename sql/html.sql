delimiter //
drop procedure if exists html//
create procedure html()
begin
  call starttag('html');
  call starttag('head');
  call starttag('title');
  call xmltext('test');
  call endtag(); --title
  call starttag('meta');
  call xmlattr('name', 'viewport');
  call xmlattr('content', 'width=device-width, initial-scale=1.0');
  call endtag(); --meta
  call starttag('link');
  call xmlattr('rel', 'stylesheet');
  call xmlattr('href', 'https://cdn.simplecss.org/simple.min.css');
  call endtag(); --link
  call endtag(); --head
  call starttag('body');
  call starttag('h1');
  call xmltext('hello, world');
  #закрывать замыкающие тэги нет необходимости - 
end//

