<?php /* DAT

������� �������� ��������� �� ���������. � ������ ������ ��������� ����������� |, ������
�������� ���������� {0}, ������ {1} � �.�. ������ ������ ���������� �� ��������.

����� {n} ���������� �� ���������� ����� ������� ��������, ����� ���� {n2}, {n3} � �.�. - �� ���������� ����� � N ����� � ������ (001, 0001)

{_DAT: template=\n<p>{n2}. <a href='/dnevnik/{1}.html'>{1} ? {2}</a><br>{@MP3: http://lleo.me/audio/f5/{0}@}
facebook.mp3	| 2011/10/17 | ��� ���������� �����
konoplya.mp3	| 2011/10/03 | ��� �������� ��������
china.mp3	| 2011/09/26 | ��� ��� ��� � ����
shlagbaum.mp3	| 2011/09/19 | ��� ���������
_}
*/

function DAT($e) {
	$c=array_merge(array('template'=>'{0} {1} {2} {3} {4} {5}'),parse_e_conf($e));
	$c['template']=str_replace(array("\\n","<space>"),array("\n"," "),$c['template']);

// dier($c);

	$s=''; $i=1; foreach(explode("\n",$c['body']) as $l) { if(empty($l))continue; $a=explode('|',$l);
		foreach($a as $n=>$l) $a[$n]=trim($l,"\t\r\n ");
		if(preg_match("/\{n(\d+)\}/s",$c['template'],$m)) $a['n'.$m[1]]=sprintf("%0".$m[1]."d",$i);
		if(preg_match("/\{sum(\d+)\}/s",$c['template'],$m)) { if(!isset($GLOBALS['DAT_SUM_'.$m[1]])) $GLOBALS['DAT_SUM_'.$m[1]]=0; $GLOBALS['DAT_SUM_'.$m[1]]+=$a[$m[1]]; $a['sum'.$m[1]]=$GLOBALS['DAT_SUM_'.$m[1]]; }
//		if(preg_match("/\{itogo(\d+)\}/s",$c['template'],$m)) $a['itogo'.$m[1]]=(isset($GLOBALS['DAT_SUM_'.$m[1]])?$GLOBALS['DAT_SUM_'.$m[1]]:'[empty '.$m[1].']');
		$a['n']=($i++);
		$s.=mper($c['template'],$a);
	}
	return str_replace(array('{@','@}'),array('{_','_}'),$s);
}
?>