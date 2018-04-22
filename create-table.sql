CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `srcUrlHash` int(11) unsigned NOT NULL,
  `srcUrl` text,
  `created` datetime NOT NULL,
  `title` text,
  `img` text,
  `text` longtext,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_srcUrl` (`srcUrlHash`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8