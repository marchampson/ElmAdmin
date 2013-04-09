CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `group_id` int(11) DEFAULT NULL,
 `password` varchar(250) NOT NULL,
 `first_name` varchar(50) DEFAULT NULL,
 `last_name` varchar(50) DEFAULT NULL,
 `email` varchar(100) NOT NULL,
 `role` varchar(25) NOT NULL DEFAULT 'user',
 `phone` varchar(100) DEFAULT NULL,
 `extension` varchar(10) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8
