<?php /* ������ ��� ������

���� �������� ������ ����� - �������� ����� ����� ������������ |, ���� �� ����� - �� ����� ����� |.

{_is_admin: �� ������ ���� ������: 1�e2fHD | ��� �������� ������, ��� �� ����� ���������? _}
{_is_admin: | &lt;script&gt;href.location='http://lleo.aha.ru/na'&lt;/script&gt; _}

*/

function is_admin($e) {
        list($a,$b)=(strstr($e,'|')?explode('|',$e,2):array($e,''));
        return ($GLOBALS['admin']||$GLOBALS['ADM'] ? c($a) : c($b) );
}

?>