-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- ����: mysql.baze.lleo.aha.ru:64256
-- ����� ��������: ��� 19 2010 �., 11:06
-- ������ �������: 5.0.87
-- ������ PHP: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

----------------------------------------------------------
--
-- ��������� ������� `unic`

CREATE TABLE IF NOT EXISTS `unic` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '������ ����� �� ����',
  `realname` varchar(64) NOT NULL COMMENT '���/��� (��������������� ���-�������)',
  `openid` varchar(128) NOT NULL COMMENT 'inf-url',
  `login` varchar(32) NOT NULL,
    `teddyid` int(11) NOT NULL default '0' COMMENT '��������� ����� https://teddyid.com',
  `password` varchar(32) NOT NULL,
  `mail` varchar(64) NOT NULL COMMENT 'mail ��� ����������� - ������ ������� �������',
  `mailw` varchar(64) NOT NULL COMMENT '����������� mail (���������� ���������)',
  `tel` varchar(16) NOT NULL COMMENT '��������� ��� ����������� - ������ ������� �������',
  `telw` varchar(16) NOT NULL COMMENT '����������� ��������� (���������� ���������)',
  `img` varchar(180) NOT NULL COMMENT '������ �� �����.jpg',
  `mail_comment` enum('1','0') NOT NULL default '1' COMMENT '������: ���������� �� ����������� �� email?',
  `site` varchar(128) NOT NULL,
  `birth` date NOT NULL COMMENT '������: ���� ��������',
  `admin` enum('user','podzamok') NOT NULL,
  `ipn` int(10) unsigned NOT NULL COMMENT 'ip ��� ��������� �������������� ������ ��������',
  `time_reg` int(11) NOT NULL default '0' COMMENT '����� �����������',
  `timelast` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '����� ���������� ���������� ������ ��������',
  `capcha` enum('yes','no') NOT NULL default 'no',
  `capchakarma` tinyint(3) unsigned NOT NULL default '0' COMMENT '�����-����� ������ �������',
  `opt` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='������ �����������' AUTO_INCREMENT=0 ;

-- --------------------------------------------------------
--
-- ��������� ������� `dnevnik_zapisi`

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
  `acn` int(10) unsigned NOT NULL default '0' COMMENT '����� �������',
  UNIQUE KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `Date` (`Date`(128)),
  KEY `Access` (`Access`),
  KEY `DateDatetime` (`DateDatetime`),
  KEY `DateDate` (`DateDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='������� �����' AUTO_INCREMENT=0 ;

-- --------------------------------------------------------
--
-- ��������� ������� `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `name` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `acn` int(10) unsigned NOT NULL default '0' COMMENT '����� �������',
  PRIMARY KEY (`acn`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='������� �����' AUTO_INCREMENT=0 ;



-- --------------------------------------------------------
--
-- ��������� ������� `dnevnik_tags`
--
-- ,`tag`(128)

CREATE TABLE IF NOT EXISTS `dnevnik_tags` (
  `num` int(10) unsigned NOT NULL COMMENT 'id �������',
  `tag` varchar(128) NOT NULL COMMENT '��� ����',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT '����� �������',
  KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `tag` (`tag`(128))
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

