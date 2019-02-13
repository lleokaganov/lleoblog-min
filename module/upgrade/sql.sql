----------------------------------------------------------
--
-- —труктура таблицы `unic`
--
--    `teddyid` int(11) NOT NULL default '0' COMMENT 'мобильный логин https://teddyid.com',
--   `aboutme` varchar(2048) NOT NULL COMMENT 'личное: ќ себе',

CREATE TABLE IF NOT EXISTS `unic` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Ћичный номер из куки',
  `realname` varchar(64) NOT NULL default '' COMMENT 'им€/ник (предпочтительно им€-фамили€)',
  `openid` varchar(128) NOT NULL default '' COMMENT 'inf-url',
  `login` varchar(32) NOT NULL default '' COMMENT 'логин на сайте',
  `password` varchar(32) NOT NULL default '' COMMENT 'пароль',
  `mail` varchar(64) NOT NULL default '' COMMENT 'mail при регистрации - нельз€ сменить никогда',
  `mailw` varchar(64) NOT NULL default '' COMMENT 'действующий mail (изначально совпадает)',
  `tel` varchar(16) NOT NULL default '' COMMENT 'мобильник при регистрации - нельз€ сменить никогда',
  `telw` varchar(16) NOT NULL default '' COMMENT 'действующий мобильник (изначально совпадает)',
  `img` varchar(180) NOT NULL default '' COMMENT 'ссылка на фотку.jpg',
  `mail_comment` enum('1','0') NOT NULL default '1' COMMENT 'личное: отправл€ть ли комментарии на email?',
  `site` varchar(128) NOT NULL default '' COMMENT 'пользователь указал личный сайт',
  `birth` date NOT NULL default '0000-00-00' COMMENT 'пользователь указал дату рождени€',
  `admin` enum('user','podzamok') NOT NULL default 'user' COMMENT 'подзамочный доступ',
  `ipn` int(10) unsigned NOT NULL default '0' COMMENT 'ip при последнем редактировании личной карточки',
  `time_reg` int(11) NOT NULL default '0' COMMENT 'врем€ регистрации',
  `timelast` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'врем€ последнего обновлени€ личной карточки',
  `capcha` enum('yes','no') NOT NULL default 'no',
  `capchakarma` tinyint(3) unsigned NOT NULL default '0' COMMENT ' апча-карма нового формата',
  `opt` text NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='Ћогины посетителей' AUTO_INCREMENT=0;

----------------------------------------------------------
--
-- —труктура таблицы `dnevnik_zapisi`
--
CREATE TABLE IF NOT EXISTS `dnevnik_zapisi` (
  `num` int(10) unsigned NOT NULL auto_increment,
  `Date` varchar(128) NOT NULL default '',
  `Header` varchar(255) NOT NULL default '',
  `Body` mediumtext NOT NULL default '',
  `Access` enum('all','podzamok','admin') NOT NULL default 'admin',
  `visible` enum('1','0') NOT NULL default '1',
  `DateUpdate` int(10) unsigned NOT NULL default '0',
  `view_counter` int(10) unsigned NOT NULL default '0',
  `DateDatetime` int(11) NOT NULL default '0',
  `DateDate` int(11) NOT NULL default '0',
  `opt` text NOT NULL default '',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT 'Ќомер журнала',
  UNIQUE KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `Date` (`Date`(128)),
  KEY `Access` (`Access`),
  KEY `DateDatetime` (`DateDatetime`),
  KEY `DateDate` (`DateDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='«аметки блога' AUTO_INCREMENT=0;

----------------------------------------------------------
--
-- —труктура таблицы `site`
--
CREATE TABLE IF NOT EXISTS `site` (
  `name` varchar(128) NOT NULL default '',
  `text` text NOT NULL default '',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT 'Ќомер журнала',
  PRIMARY KEY (`acn`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='ѕолезные переменные пользователей' AUTO_INCREMENT=0;

----------------------------------------------------------
--
-- —труктура таблицы `dnevnik_tags`
--
CREATE TABLE IF NOT EXISTS `dnevnik_tags` (
  `num` int(10) unsigned NOT NULL default '0' COMMENT 'id заметки',
  `tag` varchar(128) NOT NULL default '' COMMENT 'им€ тэга',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT 'Ќомер журнала',
  PRIMARY KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `tag` (`tag`(128))
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
