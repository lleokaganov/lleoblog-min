<?php

$admin_unics="26"; // ���� ���� ����� ������� ����� ������� ������ ������� ����� ��������� ������, ������ ����� �� ������ ������ � �������� ����� 1

ini_set('session.use_trans_sid', 0);
ini_set('session.use_cookies', 0);

$HTTPS=(isset($_SERVER['HTTPS']) && 'off'!=$_SERVER['HTTPS'] || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https'==$_SERVER['HTTP_X_FORWARDED_PROTO']?'https':'http');

$a="1"; if(ini_get('register_globals')!=false) foreach(array_merge($_GET,$_POST,$_REQUEST,$_COOKIE) as $n=>$l) unset(${$n});

# ���� memcache �� ����������, �������� false (��������), ����� ��� ��������! ���� ���������� - �������� ��������� ����������:
$memcache = false;
# if(($memcache=function_exists('memcache_connect'))) { $a=intval(ini_get('memcache.default_port')); if($a) $memcache=memcache_connect('localhost',$a); }

// date_default_timezone_set("Etc/GMT-3"); //date_default_timezone_set('Europe/Moscow'); // ���������� ������������� ����� ����� ������� ���� �� �� � ������

# �������������� ���������

# ��� ������ ������ (��� ������ �� ��������! ��� ����������� ���������� ������ ���� ������, ����� ������ ��� ������, ��� �������!)
$newhash_user="0gW1iKwDemAri0P3anb_9nQHAYcQR8IIIp5ENiK2SDwtbwrvrAwmaH7Gdpxkcc65GBV7l4wVkB6TettUhPTCr0VudAMMNg1s_3qCi2PVRLOADzk1fge83Wua0onWUSFY";
$hashinput = "M87Ui4fp2YCs9aMFQ0EOnqe2xYb7Lr8S8lrYXowJFVpIB4c97rkJOG0lJ7lFn_A8NJANgFtgdw763wzOWR1qgGsFiVPc0S2VQl9Wr7sJODUyghmwTTUj3SuF6BAKUlPJ"; // ������ ��� ������ ������� ������ �������� � ������� ��� �� ��������� �����
$hashlogin = "2IKmjAPUNu9JGZX4ns21rOea4_QqkDMPkrCeAQ6BUD4LIxP5Q3dIAPw4F00HKM9qR3qEt8dP6L02dfrYQClNcYSLAfmflHRG4muyG6QZYNhybn2Jw1njuUZ6dTT2eTA9"; // ������ ��
$hashrss = "8eJQq9zvOaB4YMv5XdkeKAIViE4z_Het3t1XlBKc76Z2xf1WjJTlBmxzGfN2T10EW7t9S0oaajOWXep_AR4AD_8XB9JkMNAbMNWhdnZ5C06rXQADgo1q1a_L0Qs2WRvd"; // hash ��� rss-�����

# $HTTPS_REDIRECT=1; // ������������ ��� ��������� http �� https

$httpsite = $HTTPS."://".$_SERVER['HTTP_HOST'];
$blogdir = "min/"; // ��� ����� ����� ��� ��������� ������ �� � ������, �������� "dnevnik/", ���� ������ � ����� ����� - �������� ������

# ��������� mysql
$msq_host = "localhost";
$msq_login = "root";
$msq_pass = "GuGuLi";
$msq_basa = "blogs";
$msq_charset = "cp1251";

# ��� �����
$admin_name = "������ �������";
$admin_mail = "lleo@lleo.me";
$blog_name = "lleo.me";
$admin_site = "lleo.me"; // ��� ����� ������ �� ������� - ���� ����� �������� �� ����, � ����

// $rootpage = 'index.html'; // ��������, ������� ����������� � ����� (���� �� ���������� - ��������� ��������� ������� �����)
$rootpage = ''; // ��������, ������� ����������� � ����� (���� ������ - ��������� ��������� ������� �����)


$signature = "� ".$admin_name."��<a href='mailto:".$admin_mail."'>".$admin_mail."</a>";

# ��������� RSS �����
$RSSZ_skip = 10; // ������� �������� �� ��� � RSS �������
$RSSC_skip = 30; // ������� �������� �� ��� � RSS ������������
$RSSZ_mode = 0; // 0 - �������� ������ ����� � rss, 1 - ������ ��������� �����

$cookie_site = ""; // �� ����� ������ ��������� ����
$pravka_paranoid=true; // true - ���������� � ���� ���� ����������� ������, ����� ����� ����� ���� ��������
$pravki_npage=50; // ������� ���������� ������ �� ������ �������� ��� �������� ������

# ��������� �����
$maxcommlevel=10; // �������, ����� �������� ����������� ���������� ��� �����������
$enter_comentary_days = 7; // ����� ����, ����� ������� ��������
$N_maxkomm = 20000; // ����� ��������� ����������� ��������������
$max_comperday = 20; // ������������ ����� ����������� ������������ �� �������� � �����
$comment_otstup=25; // ���������� ������ � �������� �� ����� ������� ������� �����������-������
$comment_pokazscr=1; // 1 - ���������� ������� ����������� ������ "�����", 0 - �� ����������

# �����, ��� ������� ������ ���������� �����
$host = rtrim($_SERVER["DOCUMENT_ROOT"],'/').'/'; // $host = "/home/lleo/www/";
$wwwhost = "/".$blogdir; // ����� ����� ������������ ������� ������� (/dnevnik/)
$httphost = $httpsite.$wwwhost; // ������ ����� ����� (http://lleo.me/dnevnik/)
$filehost = $host.$blogdir; // ���������� ����� ����� �� �������
$wwwtmp = $wwwhost."hidden/tmp/"; // ����� ��������� ������
$hosttmp = $filehost."hidden/tmp/"; // ���� �� ��������� ������
$hosthidden = $filehost."hidden/"; // ���� �� ������� ������

# ��������� ������������� ��� ���������
$host_log = $filehost."hidden/log/"; // ���� ����� �������� ����
$cronfile = $host_log."cron.flag"; // ��������� �����
$cache_get = true; // �������� �������� ����������� (���������� ������������� ������ ��� �������!)
$wwwcharset = "windows-1251"; // ��������� ������� �����
$syscharset = "koi8-r"; // ��������� �������� ������� �������
$include_sys = $filehost."include_sys/"; // ����������, ��� ����� ��������� ������
$include_blog = $filehost."include_blog/"; // ����������, ��� ����� ������ �����
$host_design = $filehost."design/"; // ����������, ��� ����� ������
$www_design = $wwwhost."design/"; // ����������, ��� ����� ������
$host_module = $filehost."module/"; // ����������, ��� ����� ������
$www_ico = $wwwhost."design/ico/"; // ����������, ��� ����� ������
$www_css = $wwwhost."css/"; // ����������, ��� ����� CSS
$file_css = $filehost."css/"; // ����������, ��� ����� CSS
$www_js = $wwwhost."js/"; // ����������, ��� ����� JS
$www_ajax = $wwwhost."ajax/"; // ����������, ��� ����� AJAX
$file_template = $filehost."template/"; // ����������, ��� ����� CSS
$fileget_tmp = $hosttmp."get/";

############ ������ ###########################################################################
$db_pravka='pravki'; // ��� ������� MySQL, ���� ���������� ������.
$db_unic="`unic`"; // ��� ���� �������, �� ������ �������� �� `basa1`.`unic` ���� � ��� ��������� ������� � ������ ������ �����
$db_mailbox="`mailbox`";  // ��� ���� ������ ���������, �� ������ �������� �� `basa1`.`mailbox` ���� � ��� ��������� ������� � ������ ������ �����
// $db_fkey="`lleoblog`.`fkey`"; // ��� ���� ������, ���������� ����, �� ������������

############ ������� ###########################################################################
$antibot_pic = $include_sys."antibot_pic/";        // ���� �� ����� � ����������
$antibot_cash = "antibot_cash/";
$antibot_file = $filehost."tmp/".$antibot_cash; // ���� �� ����� � ��������� �������
$antibot_www = $wwwhost."tmp/".$antibot_cash; // ����� ����� � ��������� ������� ��� ����
$antibot_C = 3;   // ������� ����� ��������
$antibot_W = 18;   // ������ � ������ ��������
$antibot_H = 20;
$antibot_add2hash = $_SERVER["REMOTE_ADDR"].$hashinput; // ��������� ��� ����
$antibot_deltime = 60*60; // ������� ������ �������� ����� 1 ���

### ����-�������� ##############################################################################
$db_site = "site";
$site_mod = $filehost."site_mod/"; // ����������, ��� ����� ������������ ������ ������ �����
$site_module = $filehost."site_module/"; // ����������, ��� ����� ������������ ������ ������ �����

### �������� � ������� #########################################################################
$foto_ttf=$host_design."ttf/PTC55F.ttf"; // ���� ������, ���� ������������ ����������� ����������� ����������
$foto_res_small=1024;
$foto_qality_small=85;
$foto_res_preview=100;
$foto_qality_preview=70;
$foto_logo=chr(169)." ".chr(171).$admin_name." ".$httpsite.chr(187); // �������������� ������� �����

### ����������� #################################################################################
$comment_friend_scr = false; // true - �������� ������� ��������� � �������� ����� � ���� �����������, false - ������ ������
$podzamcolor = '#CADFEF'; // ���� ����������� ���������
$maxcommload = 15; // ������� ������� ������ ��� �����������
$comments_on_page = 100; // ������������ �� ��������
$zopt_Comment_view='on'; // on off rul load timeload
$editor_height = 700; // ���������� �������� �� ������ � ���� ��������� �������
$editor_width = 1100; // ���������� �������� �� ������ � ���� ��������� �������
$zopt_Comment_foto_logo = ""; //chr(169)." ".chr(171)."{name}: ".$httpsite.chr(187);
$zopt_Comment_foto_q = 75;
$zopt_Comment_foto_x = 600;
$zopt_Comment_media = 'all';
$zopt_Comment_screen = 'open'; // open screen friends-open
$zopt_Comment_tree = '0'; // 0 1
$zopt_Comment_write = 'off'; // on off friends-only login-only timeoff login-only-timeoff
$zopt_autoformat = 'p'; // no p pd
$zopt_autokaw = 'auto'; // auto no
$zopt_include = '';
$zopt_template = 'blog'; // �������� ������� �� ��������� blog (����: template/blog.htm)
$del_user_comments = 0; // ��������� ������������� ������� ����������� �����������? �� - 1
$comment_autosave_count=100; // �����������: ����� ������� ������� ������ ������ ����������
$comment_time_edit_sec=15*60; // �����������: ������� ������ ��������� ������������� ������������ ����������� (0 - �����)";

$rekomenda_pass="blagovest"; // ������ ��� ������ REKOMENDA
$redirect_www=1; // ���� �������� - ����� ����������� ��� ��������� http://www. �� ������� http://

$uset=array();
$uset['X']=900;
$uset['x']=150;
$uset['Q']=80;
$uset['q']=90;
$uset['dir']='';
$uset['logo']="{name} {site}";

// ��������� ������� ����������� ���� ����
$wintempl_div='pop2 zoomIn animated'; // ����� ����
$wintempl="<div id='{id}_body'>{s}</div><i id='{id}_close' title='Close' class='can'></i>"; // ������ ���������� ������ ����

$uc='unic'; // ��� ���������� ��� ���
$cookiepre='unic_'; // � ������ ���� ������ �������, �� � ������ ������, �� ���� ��������� �� �� ������ ���

$ttl=60; // ����� ���� MySQL
$ahtung=0;
$ttl_longsite=10000; // ������� �������� ������

# ����� ������ ������
$mnogouser=0; // ��������������������� �����
$mnogouser_html=0; // ��������� html ������
$passip=0; // ����������� ���������� ������ ����� IP
$xdomain='x';

$fchmod=0666; // =0644; create files with permissions
$dchmod=0777; // =0755; create folders with permissions

# ��������� ������ ��������� ����� ��� ������� ������ �����������
$smtp_mail='sendmail@lleo.me';
$smtp_pass='jdHDHshjJSDHJSJSJDSJDjsDHJthsdhdSDGhsdshdshH';
$smtp_smtp='ssl://smtp.yandex.ru';
$smtp_name='LLeo';
$smtp_port='465';

// $SLONPLAY_DAT_CONVERT_SERVICE_SERVER='http://home.lleo.me';
# $SLONPLAY_DAT_CONVERT_SERVICE_PASSWORD='danuna';
# $findimg_microsoft_key="7faedb04b9ad4437b7867b62b3cf8ca6";

// �������� ��� ������������
// $telegram_API_key="284051442:fEtSFSgETEGHSShshhSTthdh112hsHshwsdhwshexehFc";
// $telegram_API_myusername="lleokaganov";
// $telegram_IP='149.154.167.204';

// $realdom='kz'; // ����� ������� ��������� ClawdFlare

# $sendmail_service_pass='muha'; $sendmail_gate_pass='SyuajsyeE'; // ��������� ������������ �������� ������� ������� ��� ��������� ������ �������� ��������
# $flatlogin='root'; $flatpassword='KuliBuli'; // ��������� �������������� ������� � ��� ���� �� ��������� �� flat
# $uploadpassword='KruSiu'; // ��� /backup

# $db_rekomenda = "`lleoblog`.`rekomenda`"; // ��� ���� ������������

?>