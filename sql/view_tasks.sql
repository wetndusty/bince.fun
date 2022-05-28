ALTER  
VIEW `v_tasks` AS select `requests`.`id` AS `id`,
`requests`.`title` AS `title`,
`requests`.`txt` AS `txt`,
`requests`.`author` AS `author` 
from requests

