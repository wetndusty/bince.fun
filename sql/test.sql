create or replace view v_tables as
SELECT * FROM information_schema.tables where table_type='view'