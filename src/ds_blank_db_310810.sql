-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Počítač: localhost:3306
-- Vygenerováno: Úterý 31. srpna 2010, 12:39
-- Verze MySQL: 5.1.37
-- Verze PHP: 5.2.6
-- 
-- Databáze: `janzavjcb137cz1044_dszavrelnet`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_friends`
-- 

CREATE TABLE `ds_friends` (
  `userid` smallint(5) unsigned DEFAULT NULL,
  `friendid` smallint(5) unsigned DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_friends`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_logs`
-- 

CREATE TABLE `ds_logs` (
  `FK_user` smallint(5) unsigned NOT NULL DEFAULT '0',
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `log_IP` varchar(50) NOT NULL DEFAULT '',
  `log_host` varchar(50) NOT NULL DEFAULT '',
  `log_agent` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_logs`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_mailbox`
-- 

CREATE TABLE `ds_mailbox` (
  `fromid` smallint(5) unsigned DEFAULT NULL,
  `toid` smallint(5) unsigned DEFAULT NULL,
  `message` mediumtext,
  `date` int(10) unsigned DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT NULL,
  `sender` smallint(5) unsigned DEFAULT NULL,
  `genhash` bigint(16) unsigned NOT NULL DEFAULT '0',
  KEY `fromid` (`fromid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_mailbox`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_pools`
-- 

CREATE TABLE `ds_pools` (
  `pool_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `roomid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `question` varchar(200) NOT NULL DEFAULT '',
  `answ01` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ02` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ03` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ04` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ05` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ06` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ07` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ08` smallint(5) unsigned NOT NULL DEFAULT '0',
  `answ09` smallint(5) unsigned NOT NULL DEFAULT '0',
  `count` tinyint(3) NOT NULL DEFAULT '0',
  `answs_text` text NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `voters` text NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pool_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `ds_pools`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_room`
-- 

CREATE TABLE `ds_room` (
  `msg_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `roomid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `fromid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `message` mediumtext NOT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `genhash` bigint(16) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `roomid` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `ds_room`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_room_banned_writers`
-- 

CREATE TABLE `ds_room_banned_writers` (
  `roomid` smallint(5) NOT NULL DEFAULT '0',
  `banned_writer_id` smallint(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_room_banned_writers`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_room_deniers`
-- 

CREATE TABLE `ds_room_deniers` (
  `roomid` smallint(5) NOT NULL DEFAULT '0',
  `denier_id` smallint(5) NOT NULL DEFAULT '0',
  KEY `room_id` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_room_deniers`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_room_keepers`
-- 

CREATE TABLE `ds_room_keepers` (
  `roomid` smallint(5) NOT NULL DEFAULT '0',
  `keeper_id` smallint(5) NOT NULL DEFAULT '0',
  KEY `room_id` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_room_keepers`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_room_viewers`
-- 

CREATE TABLE `ds_room_viewers` (
  `roomid` smallint(5) NOT NULL DEFAULT '0',
  `viewer_id` smallint(5) NOT NULL DEFAULT '0',
  `last_access` int(10) NOT NULL DEFAULT '0',
  KEY `room_id` (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_room_viewers`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_rooms`
-- 

CREATE TABLE `ds_rooms` (
  `roomid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `discussion_password` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `count` mediumint(8) unsigned DEFAULT NULL,
  `founderid` smallint(5) unsigned DEFAULT NULL,
  `founddate` int(10) unsigned DEFAULT NULL,
  `FK_topic` smallint(5) unsigned DEFAULT NULL,
  `FK_subtopic` smallint(5) unsigned NOT NULL DEFAULT '0',
  `home` text COLLATE utf8_czech_ci,
  `home_source` text COLLATE utf8_czech_ci,
  `minihome` text COLLATE utf8_czech_ci,
  `minihome_source` text COLLATE utf8_czech_ci,
  `delown` tinyint(1) DEFAULT '0',
  `allowrite` tinyint(1) DEFAULT '1',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `last` int(10) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `book_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`roomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `ds_rooms`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_rooms_access`
-- 

CREATE TABLE `ds_rooms_access` (
  `FK_user` smallint(5) unsigned DEFAULT NULL,
  `FK_room` smallint(5) unsigned DEFAULT NULL,
  `access_time` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_rooms_access`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_rooms_bookmarks`
-- 

CREATE TABLE `ds_rooms_bookmarks` (
  `FK_user` smallint(5) unsigned DEFAULT NULL,
  `FK_room` smallint(5) unsigned DEFAULT NULL,
  KEY `roomid` (`FK_room`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_rooms_bookmarks`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_stats`
-- 

CREATE TABLE `ds_stats` (
  `impresion` smallint(5) unsigned NOT NULL DEFAULT '0',
  `date` varchar(10) NOT NULL DEFAULT '',
  KEY `impresion` (`impresion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_stats`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_subtopics`
-- 

CREATE TABLE `ds_subtopics` (
  `PK_subtopic` smallint(5) NOT NULL DEFAULT '0',
  `FK_topic` smallint(5) NOT NULL DEFAULT '0',
  `subtopic_name` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_subtopics`
-- 

INSERT INTO `ds_subtopics` (`PK_subtopic`, `FK_topic`, `subtopic_name`) VALUES (0, 0, 'nezařazené'),
(0, 2, 'nezařazené'),
(0, 3, 'nezařazené'),
(0, 4, 'nezařazené'),
(0, 5, 'nezařazené'),
(0, 6, 'nezařazené'),
(0, 7, 'nezařazené'),
(0, 8, 'nezařazené'),
(0, 9, 'nezařazené'),
(0, 10, 'nezařazené'),
(0, 11, 'nezařazené'),
(0, 12, 'nezařazené'),
(0, 13, 'nezařazené'),
(0, 14, 'nezařazené'),
(0, 15, 'nezařazené'),
(0, 16, 'nezařazené'),
(0, 17, 'nezařazené'),
(0, 18, 'nezařazené'),
(0, 19, 'nezařazené'),
(0, 20, 'nezařazené'),
(0, 21, 'nezařazené'),
(0, 22, 'nezařazené'),
(0, 23, 'nezařazené'),
(0, 24, 'nezařazené'),
(0, 25, 'nezařazené'),
(0, 26, 'nezařazené'),
(0, 27, 'nezařazené'),
(0, 28, 'nezařazené');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_topics`
-- 

CREATE TABLE `ds_topics` (
  `PK_topic` smallint(5) NOT NULL DEFAULT '0',
  `topic_name` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `ds_topics`
-- 

INSERT INTO `ds_topics` (`PK_topic`, `topic_name`) VALUES (27, 'DS'),
(1, 'AKTUÁLNĚ'),
(2, 'AUDIO A VIDEO'),
(3, 'CESTOVÁNÍ'),
(4, 'DROGY'),
(5, 'FILM A TELEVIZE'),
(6, 'GRAFICKÁ TVORBA'),
(7, 'HARDWARE A KOMUNIKACE'),
(8, 'HISTORIE'),
(9, 'HRY'),
(10, 'HUDBA'),
(11, 'INTERNET'),
(12, 'KULTURA A UMĚNÍ'),
(13, 'LITERATURA'),
(14, 'MÓDA A STYL'),
(15, 'MOTORISMUS A DOPRAVA'),
(16, 'POLITIKA A EKONOMIKA'),
(17, 'PŘÍRODA'),
(18, 'SOFTWARE A PROGRAMOVÁNÍ'),
(19, 'SPOLEČNOST'),
(20, 'VĚDA A TECHNIKA'),
(21, 'VÍRA'),
(22, 'VZDĚLÁNÍ'),
(23, 'VZTAHY A SEX'),
(24, 'ZÁBAVA A ZÁJMY'),
(25, 'ZDRAVÍ A SPORT'),
(26, 'CHAT'),
(0, 'NEZAŘAZENÉ'),
(28, 'VAŘENÍ A JÍDLO');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `ds_users`
-- 

CREATE TABLE `ds_users` (
  `userid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(15) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `regdate` int(10) unsigned DEFAULT NULL,
  `lastaccess` int(10) unsigned DEFAULT NULL,
  `AT` mediumint(8) unsigned DEFAULT NULL,
  `level` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `mobil` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `autologout` int(5) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `surname` varchar(100) NOT NULL DEFAULT '',
  `birth` varchar(100) NOT NULL DEFAULT '',
  `age` varchar(10) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `e_mail` varchar(100) NOT NULL DEFAULT '',
  `web` varchar(100) NOT NULL DEFAULT '',
  `icq` varchar(100) NOT NULL DEFAULT '',
  `hobby` varchar(100) NOT NULL DEFAULT '',
  `sex` varchar(100) NOT NULL DEFAULT '',
  `single` varchar(100) NOT NULL DEFAULT '',
  `height` varchar(100) NOT NULL DEFAULT '',
  `weight` varchar(100) NOT NULL DEFAULT '',
  `eyes` varchar(100) NOT NULL DEFAULT '',
  `hair` varchar(100) NOT NULL DEFAULT '',
  `show_new` tinyint(1) NOT NULL DEFAULT '0',
  `show_room_ico` tinyint(1) NOT NULL DEFAULT '0',
  `show_pool` tinyint(1) NOT NULL DEFAULT '0',
  `show_home` tinyint(1) NOT NULL DEFAULT '0',
  `bg` varchar(200) NOT NULL DEFAULT '',
  `css` varchar(200) NOT NULL DEFAULT '',
  `msgs` tinyint(4) NOT NULL DEFAULT '0',
  `address01` varchar(100) NOT NULL DEFAULT '',
  `label01` varchar(40) NOT NULL DEFAULT '',
  `address02` varchar(100) NOT NULL DEFAULT '',
  `label02` varchar(40) NOT NULL DEFAULT '',
  `address03` varchar(100) NOT NULL DEFAULT '',
  `label03` varchar(40) NOT NULL DEFAULT '',
  `address04` varchar(100) NOT NULL DEFAULT '',
  `label04` varchar(40) NOT NULL DEFAULT '',
  `address05` varchar(100) NOT NULL DEFAULT '',
  `label05` varchar(40) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT '',
  `menu` char(1) NOT NULL DEFAULT '',
  `editor` tinyint(1) NOT NULL DEFAULT '1',
  `infopage` text NOT NULL,
  `infopage_source` text NOT NULL,
  `infopage_editor_type` tinyint(1) NOT NULL DEFAULT '0',
  `viewers` text NOT NULL,
  `user_lang` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `ds_users`
-- 

INSERT INTO `ds_users` (`userid`, `login`, `password`, `regdate`, `lastaccess`, `AT`, `level`, `active`, `location`, `mobil`, `email`, `autologout`, `name`, `surname`, `birth`, `age`, `address`, `phone`, `e_mail`, `web`, `icq`, `hobby`, `sex`, `single`, `height`, `weight`, `eyes`, `hair`, `show_new`, `show_room_ico`, `show_pool`, `show_home`, `bg`, `css`, `msgs`, `address01`, `label01`, `address02`, `label02`, `address03`, `label03`, `address04`, `label04`, `address05`, `label05`, `status`, `menu`, `editor`, `infopage`, `infopage_source`, `infopage_editor_type`, `viewers`, `user_lang`) VALUES (1, 'sys', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 1, '', '', 0, '', '');
