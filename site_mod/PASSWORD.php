<?php /* ���������� ������ �������

����� ����, ��� ������������ ������ ������ � ������������ ����� (������ - ����� � ������ ������), �� ������ ������� ����������.

{_PASSWORD: kreotif123
������� �����
_}

��� � ����� �������:

{_PASSWORD:
dostup=podzamok
password=kreotif123

������� �����
_}

{_PASSWORD:
dostup=admin
password=kreotif123

������� �����
_}


*/

function PASSWORD($e) {
$conf=array_merge(array(
'password'=>false,
'dostup'=>false // ������: 'podzamok' - ��������, 'admin' - ������ �����
),parse_e_conf($e));

$pass=$conf['password'];
$e=$conf['body'];
if($pass===false) list($pass,$e)=explode("\n",$e,2);

    if(
	$GLOBALS['podzamok'] && $conf['dostup']=='podzamok' // ��� ����������
	or $GLOBALS['ADM'] && $conf['dostup']=='admin' // ��� ������
	or isset($_POST['password'])&&$_POST['password']==c($pass) // ��� ���� ������ ������ ������
    ) return c($e);
	if(isset($_POST['password'])) sleep(5);
	return "<center><table border=1 cellspacing=0 cellpadding=40><tr><td align=center>
<form method=post action=".$GLOBALS['mypage'].">������ ��� ���� ��������:
<br><input type=text size=20 name=password>&nbsp;<input type=submit value='�����'></form>
</td></tr></table></center>";
}

?>