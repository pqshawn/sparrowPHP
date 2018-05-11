use ldos;
DROP TABLE IF EXISTS `dos_comments`;
CREATE TABLE `dos_comments` (
	`comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`comment_post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
	`comment_author` tinytext NOT NULL,
	`comment_author_email` varchar(100) NOT NULL DEFAULT '',
	`comment_author_url` varchar(200) NOT NULL DEFAULT '',
	`comment_author_IP` varchar(100) NOT NULL DEFAULT '',
	`comment_cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`comment_udate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`comment_content` text NOT NULL,
	`comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
	`user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`comment_id`),
	KEY `comment_post_ID` (`comment_post_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0; 

