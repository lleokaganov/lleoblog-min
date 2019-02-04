-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Хост: mysql.baze.lleo.aha.ru:64256
-- Время создания: Янв 19 2010 г., 11:06
-- Версия сервера: 5.0.87
-- Версия PHP: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

----------------------------------------------------------
--
-- Структура таблицы `unic`

CREATE TABLE IF NOT EXISTS `unic` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Личный номер из куки',
  `realname` varchar(64) NOT NULL COMMENT 'имя/ник (предпочтительно имя-фамилия)',
  `openid` varchar(128) NOT NULL COMMENT 'inf-url',
  `login` varchar(32) NOT NULL,
    `teddyid` int(11) NOT NULL default '0' COMMENT 'мобильный логин https://teddyid.com',
  `password` varchar(32) NOT NULL,
  `mail` varchar(64) NOT NULL COMMENT 'mail при регистрации - нельзя сменить никогда',
  `mailw` varchar(64) NOT NULL COMMENT 'действующий mail (изначально совпадает)',
  `tel` varchar(16) NOT NULL COMMENT 'мобильник при регистрации - нельзя сменить никогда',
  `telw` varchar(16) NOT NULL COMMENT 'действующий мобильник (изначально совпадает)',
  `img` varchar(180) NOT NULL COMMENT 'ссылка на фотку.jpg',
  `mail_comment` enum('1','0') NOT NULL default '1' COMMENT 'личное: отправлять ли комментарии на email?',
  `site` varchar(128) NOT NULL,
  `birth` date NOT NULL COMMENT 'личное: дата рождения',
  `admin` enum('user','podzamok') NOT NULL,
  `ipn` int(10) unsigned NOT NULL COMMENT 'ip при последнем редактировании личной карточки',
  `time_reg` int(11) NOT NULL default '0' COMMENT 'время регистрации',
  `timelast` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'время последнего обновления личной карточки',
  `capcha` enum('yes','no') NOT NULL default 'no',
  `capchakarma` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Капча-карма нового формата',
  `opt` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='Логины посетителей' AUTO_INCREMENT=0 ;

-- --------------------------------------------------------
--
-- Структура таблицы `dnevnik_zapisi`

CREATE TABLE IF NOT EXISTS `dnevnik_zapisi` (
  `Date` varchar(128) NOT NULL,
  `Header` varchar(255) NOT NULL default '',
  `Body` mediumtext NOT NULL,
  `Access` enum('all','podzamok','admin') NOT NULL default 'admin',
  `visible` enum('1','0') NOT NULL default '1',
  `DateUpdate` int(10) unsigned NOT NULL default '0',
  `view_counter` int(10) unsigned NOT NULL default '0',
  `num` int(10) unsigned NOT NULL auto_increment,
  `DateDatetime` int(11) NOT NULL default '0',
  `DateDate` int(11) NOT NULL default '0',
  `opt` text NOT NULL,
  `acn` int(10) unsigned NOT NULL default '0' COMMENT 'Номер журнала',
  UNIQUE KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `Date` (`Date`(128)),
  KEY `Access` (`Access`),
  KEY `DateDatetime` (`DateDatetime`),
  KEY `DateDate` (`DateDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='Заметки блога' AUTO_INCREMENT=0 ;

-- --------------------------------------------------------
--
-- Структура таблицы `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `name` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `acn` int(10) unsigned NOT NULL default '0' COMMENT 'Номер журнала',
  PRIMARY KEY (`acn`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='Контент сайта' AUTO_INCREMENT=0 ;



-- --------------------------------------------------------
--
-- Структура таблицы `dnevnik_tags`
--
-- ,`tag`(128)

CREATE TABLE IF NOT EXISTS `dnevnik_tags` (
  `num` int(10) unsigned NOT NULL COMMENT 'id заметки',
  `tag` varchar(128) NOT NULL COMMENT 'имя тэга',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT 'Номер журнала',
  KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `tag` (`tag`(128))
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

