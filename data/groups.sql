CREATE TABLE `groups` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `type` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `reference` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `address1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `address2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `town` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `county` varchar(100) COLLATE utf8_bin DEFAULT NULL,
 `postcode` varchar(20) COLLATE utf8_bin DEFAULT NULL,
 `country` varchar(10) COLLATE utf8_bin DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
