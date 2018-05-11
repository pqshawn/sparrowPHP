/*
MySQL Data Transfer
Date: 2015-01-13 11:31:49
*/

/*
文章表
*/
DROP TABLE IF EXISTS `dos_posts`;
CREATE TABLE `dos_posts` (
  `post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_udate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_title` varchar(250) NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_content` longtext NOT NULL,
  `post_name` varchar(100) NOT NULL DEFAULT 'nickname',
  `post_password` varchar(20) NOT NUlL DEFAULT '',
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_url` varchar(100) NOT NULL DEFAULT '',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `comment_count`  bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `post_author` (`post_author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

DROP TABLE IF EXISTS `dos_users`;
CREATE TABLE `dos_users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nickname` varchar(60) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_udate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;