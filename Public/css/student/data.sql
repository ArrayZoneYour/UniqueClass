CREATE TABLE products ( 
	`id` int PRIMARY KEY AUTO_INCREMENT, 
	`type` TEXT, 
	`firstname` TEXT, 
	`mainname` TEXT, 
	`title` TEXT, 
	`price` float, 
	`numpages` int, 
	`playlength` int, 
	`discount` int 
	)ENGINE=InnoDB  DEFAULT CHARSET=utf8;