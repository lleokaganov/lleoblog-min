<?php /* �������� ��� ���

���� ����� �������� (� ��� ��� ��������� ������ � �����) - ������ ���� �� ���� ������ �������� [...], ���� ������� (������ � ���������� �����) - �������� ����� [��������&nbsp;����������] �� ������.
��� ������� ������ ����� �������� ��, ��� ���� ������.

���� �������� ������� � GET-���������� ?showall - �� cut �� �����������, ����� ������.

����� ����� ������ ��������������, ������ �� � ������ � ���������� �������.

<script>function cut(e,d){e.style.display='none';e.nextSibling.style.display=d;}</script>
<style>.cut{cursor:pointer;color:blue;text-align:center;}.cut:hover{text-decoration:underline;}</style>

��� � �������� ��������, ��� ������� ������ {_cut:����_}.
�������� ���� ��� ���� ������ ������ {_cut:�������_}.
��������� � ����� �������� � ������ {_cut:������_}.
������ ����� ���� ����, {_cut:[���������� ������� ����]������ ��� ����� �����_}.

*/

SCRIPTS("cut","function cut(e){e.style.display='none'; e=e.nextSibling; e.style.display=e.tagName=='DIV'?'block':'inline';}");
STYLES("cut",".cut,.cutnc{cursor:pointer;color:blue;}.cut{text-align:center}.cut:hover,.cutnc:hover{text-decoration:underline;}");

function cut($e) {

$conf=array_merge(array(
// 'otl'=>0,
// 'center'=>0,
'if'=>'',
'txt'=>"[...]",
'text'=>"[��������&nbsp;����������]",
'template_div'=>"<div class='{cut}' onclick='cut(this)'>{click}</div><div style='display:none'>{text}</div>",
'template_span'=>"<span class='{cut}' onclick='cut(this)'>{click}</span><span style='display:none'>{text}</span>",
'template'=>''
),parse_e_conf($e)); $e=$conf['body'];

    if(stristr($e,'#nocenter#')) { $cut='cutnc'; $e=str_ireplace('#nocenter#','',$e); } else $cut='cut';

    if(preg_match("/^\s*\[(.*?)\]([^\]].*?)$/si",$e,$m)) { $e=c($m[2]); $click=$m[1]; }

    if(isset($_GET['showall']) || ($conf['if']!=''&&isset($GLOBALS[$conf['if']])) ) return $e;


    if(isset($GLOBALS['PUBL'])) $conf['template_div']=$conf['template_span']="[ ����� ��� �����: �������� ������ � ������������ ������� �� ����� ]";

    if($conf['template']!='') $tmpl=$conf['template'];
    else {
	if( strstr($e,"\n")
	||stristr($e,'<p')
	||stristr($e,'<div')
	||stristr($e,'<center')
	) { $tmpl=$conf['template_div']; if(!isset($click)) $click=$conf['text']; }
	else { $tmpl=$conf['template_span']; if(!isset($click)) $click=$conf['txt']; }
    }

    return mpers($tmpl,array('cut'=>$cut,'text'=>$e,'click'=>$click));
}

/*

	if(stristr($e,'#nocenter#')) { $cut='cutnc'; $e=str_ireplace('#nocenter#','',$e); } else $cut='cut';

	if(preg_match("/^\s*\[(.*?)\]([^\]].*?)$/si",$e,$m)) { $e=c($m[2]); $text=$m[1]; }

if(isset($_GET['showall'])) return $e;

	if(strstr($e,"\n")||stristr($e,'<p')||stristr($e,'<div')||stristr($e,'<center')) { if(!isset($text)) $text="[��������&nbsp;����������]"; $tag="div"; $display="block"; }
	else { if(!isset($text)) $text="[...]"; $tag="span"; $display="inline";	}

// if($GLOBALS['admin']) return h("<$tag class=".$cut." onclick=\"cut(this,'$display')\">$text</$tag><$tag style='display:none'>$e</$tag>");
	return "<$tag class=".$cut." onclick=\"cut(this,'$display')\">$text</$tag><$tag style='display:none'>$e</$tag>";

*/

?>