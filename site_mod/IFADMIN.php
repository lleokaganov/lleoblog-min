<?php /* ������ ��� ������

���� �������� ������ ����� - �������� ����� ����� ������������ |, ���� �� ����� - �� ����� ����� |.
 
{_IFADMIN: �� ������ ���� ������: 1�e2fHD | ��� �������� ������, ��� �� ����� ���������? _}
{_IFADMIN: | &lt;script&gt;href.location='http://lleo.aha.ru/na'&lt;/script&gt; _}

*/

function IFADMIN($e) {
	list($a,$b)=explode('|',$e,2);
	return (
($GLOBALS['acn']?$GLOBALS['ADM']:$GLOBALS['admin'])
? c($a) : c($b)
);
}

?>