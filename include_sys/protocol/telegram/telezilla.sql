-- --------------------------------------------------------
--
-- ��������� ������� `telezil_users`
--
CREATE TABLE IF NOT EXISTS `telezil_users` (
    `user` int(10) unsigned NOT NULL auto_increment COMMENT '���������� ����� �����',
    `id` bigint(20) unsigned COMMENT 'id telegram-�����',
    `bot` smallint(20) unsigned COMMENT 'id ����, � ������� �������� ����',
    `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '����� ������� ���������',
    `nick` varchar(128) NOT NULL COMMENT '������� �����',
    `name` varchar(255) NOT NULL COMMENT '��� � ������� �����',
PRIMARY KEY (`user`),
KEY `user` (`id`)
) ENGINE=XtraDB default CHARSET=utf8 COMMENT='���� ��������-������' ;

-- --------------------------------------------------------
--
-- ��������� ������� `telezil_messages`
--
--     `type` enum('in','out') NOT NULL COMMENT '��������/���������',
--
CREATE TABLE IF NOT EXISTS `telezil_messages` (
    `n` int(10) unsigned NOT NULL auto_increment COMMENT '���������� �����',
    `user` int(10) unsigned COMMENT '����� ����� � ���� ������',
    `bot` smallint(5) unsigned COMMENT 'id ����',
    `chat` int(11) unsigned COMMENT 'id ����',
    `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '����� ���������',
    `text` text NOT NULL COMMENT '����� ���������',
PRIMARY KEY (`n`),
KEY `time` (`time`),
KEY last (`user`,`bot`,`chat`)
) ENGINE=XtraDB default CHARSET=utf8 COMMENT='���� ���������' ;


