<?php /* ������ ��� ����������� ������

���� �������� ������ ����������, � �������� 'podzamok' - �������� ����� ����� ������������ |, ���� ������� 'user' - �� ����� ����� |.

{_is_podzamok: ��������� ���: http://10.8.0.1/rrr.zip | ��������� ����� ���� �� �����������. _}
{_is_podzamok: ��� ����� �������� �������! | _}

*/

function is_podzamok($e) {
        list($a,$b)=(strstr($e,'|')?explode('|',$e,2):array($e,''));

	if(!$GLOBALS['podzamok']) return c($b);
	$a=c($a);
	if(strstr($a,"\n")) return "<div style=\"background-color:".$GLOBALS['podzamcolor']."\">"
    ."<i class='e_podzamok'></i>&nbsp;"
    .$a."</div>";

	return "<span style=\"background-color:".$GLOBALS['podzamcolor']."\">$a</span>";

}

?>