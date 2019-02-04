-- --------------------------------------------------------
--
-- ��������� ������� `telezil_projects`
--
CREATE TABLE IF NOT EXISTS `telezil_projects` (
    `project_id` smallint(10) unsigned NOT NULL auto_increment COMMENT '�� �������',
    `project_name` varchar(256) COMMENT '��� �������',
    `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '����� ��������',
    `mail` varchar(128) COMMENT '��� �����������',
    `comment` text COMMENT '���������� �����������',
PRIMARY KEY (`project_id`)
) ENGINE=XtraDB default CHARSET=utf8 COMMENT='���� ��������-������' ;


-- --------------------------------------------------------
--
-- ��������� ������� `telezil_scenary`
--
CREATE TABLE IF NOT EXISTS `telezil_scenary` (
    `i` smallint(10) unsigned NOT NULL auto_increment COMMENT 'id ��������',
    `project_id` smallint(10) unsigned NOT NULL COMMENT 'id �������, � �������� �� ���������',
    `scenary_name` varchar(256) COMMENT '��� ��������',
    `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '����� ��������',
        `lz_url` varchar(256) COMMENT 'URL �������',
        `lz_login` varchar(256) COMMENT 'login',
        `lz_pass` char(32) COMMENT '��������',
        `lz_group` varchar(128) COMMENT '������',
        `lz_user` varchar(128) COMMENT '������������',
        `lz_lang` varchar(5) COMMENT '���� �� ���������',
        `lz_err_message` varchar(512) COMMENT '��������� � ������������� ��������',
    `tg_API_id` bigint(20) unsigned COMMENT '�� ���� telegram_API_myid',
    `tg_API_key` varchar(45) COMMENT '���� API ���� telegram_API_key',
    `tg_name` varchar(32) COMMENT '��� ����',
    `tg_info` varchar(512) COMMENT '���� ����',
    `tg_image` varchar(128) COMMENT '��� �������� ����',
    `tg_err_message` varchar(512) COMMENT '��������� � ������������� ��������',
    `tg_wait_message` varchar(512) COMMENT '����� �� ��������',
        `command_list` text COMMENT '������ ������',
        `keywords` text COMMENT '����� (��������)',
        `name_template` varchar(128) COMMENT '��������� ������������ ����� ������������',
        `banlist` text COMMENT '���-����� ��������� �� ��������� user_id',
PRIMARY KEY (`i`),
KEY `project_id` (`project_id`)
) ENGINE=XtraDB default CHARSET=utf8 COMMENT='���� ��������-������' ;

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
    `tel` bigint(12) unsigned NOT NULL COMMENT '������� ����� 1844674407-370-955-16-15',
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


