----------------------------------------------------------
--
-- ��������� ������� `unic`
--
--    `teddyid` int(11) NOT NULL default '0' COMMENT '��������� ����� https://teddyid.com',
--   `aboutme` varchar(2048) NOT NULL COMMENT '������: � ����',

CREATE TABLE IF NOT EXISTS `unic` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '������ ����� �� ����',
  `realname` varchar(64) NOT NULL default '' COMMENT '���/��� (��������������� ���-�������)',
  `openid` varchar(128) NOT NULL default '' COMMENT 'inf-url',
  `login` varchar(32) NOT NULL default '' COMMENT '����� �� �����',
  `password` varchar(32) NOT NULL default '' COMMENT '������',
  `mail` varchar(64) NOT NULL default '' COMMENT 'mail ��� ����������� - ������ ������� �������',
  `mailw` varchar(64) NOT NULL default '' COMMENT '����������� mail (���������� ���������)',
  `tel` varchar(16) NOT NULL default '' COMMENT '��������� ��� ����������� - ������ ������� �������',
  `telw` varchar(16) NOT NULL default '' COMMENT '����������� ��������� (���������� ���������)',
  `img` varchar(180) NOT NULL default '' COMMENT '������ �� �����.jpg',
  `mail_comment` enum('1','0') NOT NULL default '1' COMMENT '������: ���������� �� ����������� �� email?',
  `site` varchar(128) NOT NULL default '' COMMENT '������������ ������ ������ ����',
  `birth` date NOT NULL default '0000-00-00' COMMENT '������������ ������ ���� ��������',
  `admin` enum('user','podzamok') NOT NULL default 'user' COMMENT '����������� ������',
  `ipn` int(10) unsigned NOT NULL default '0' COMMENT 'ip ��� ��������� �������������� ������ ��������',
  `time_reg` int(11) NOT NULL default '0' COMMENT '����� �����������',
  `timelast` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '����� ���������� ���������� ������ ��������',
  `capcha` enum('yes','no') NOT NULL default 'no',
  `capchakarma` tinyint(3) unsigned NOT NULL default '0' COMMENT '�����-����� ������ �������',
  `opt` text NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='������ �����������' AUTO_INCREMENT=0;

----------------------------------------------------------
--
-- ��������� ������� `dnevnik_zapisi`
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
  `acn` int(10) unsigned NOT NULL default '0' COMMENT '����� �������',
  UNIQUE KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `Date` (`Date`(128)),
  KEY `Access` (`Access`),
  KEY `DateDatetime` (`DateDatetime`),
  KEY `DateDate` (`DateDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='������� �����' AUTO_INCREMENT=0;

----------------------------------------------------------
--
-- ��������� ������� `site`
--
CREATE TABLE IF NOT EXISTS `site` (
  `name` varchar(128) NOT NULL default '',
  `text` text NOT NULL default '',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT '����� �������',
  PRIMARY KEY (`acn`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='�������� ���������� �������������' AUTO_INCREMENT=0;

----------------------------------------------------------
--
-- ��������� ������� `dnevnik_tags`
--
CREATE TABLE IF NOT EXISTS `dnevnik_tags` (
  `num` int(10) unsigned NOT NULL default '0' COMMENT 'id �������',
  `tag` varchar(128) NOT NULL default '' COMMENT '��� ����',
  `acn` int(10) unsigned NOT NULL default '0' COMMENT '����� �������',
  PRIMARY KEY `num` (`num`),
  KEY `acn` (`acn`),
  KEY `tag` (`tag`(128))
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
