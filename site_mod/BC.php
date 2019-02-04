<?php /* blockquote

���� ��������. ������� ��������� ����� ��������� ���, ������������ � '@' - � ���� ������ �� ��������� ����� �������� (��� ��������� ����� @0).
��� ����� � ���� ������ ������� ����� ������� ��� ����� �������� ������.
�������������� ����� �����:

{_BC:
��������, ������� �����, �������� ������.
��� �������. ������� � ���� ������.
����� �������� � ���� ��� ������ �����.
�� ���������, ��� ������ ��� ������!
��� ��� ������ �����: @0
 _}

---

{_BC: @1
����� � ����������� �������� �������!
������� ������� ��������� ������!
������� ����, ������������ �����,
����� ����� � ��������� ����!
��� ��� ������ �����: @1
_}

---

{_BC: @table
������ ���� ������ � ������,
������ ������ ����:
��� ������ ��� �� �����?
�������������, ����!
��� ��� ������ �����: @table
_}

---

{_BC: @tblue
����������� � ��������� � ������ ����� �����
������� �������, � ����� ������ ������
���������� � ������ ����� � ������� ������
� ����� ����� �� ��������� � ����� �������
��� ��� ������ �����: @tblue
_}

---

{_BC: @tgreen
����� ����, ��� ������
������ ������ �������
�������� ���� ������,
�� �� ������ �����, ����!
��� ��� ������ �����: @tgreen
_}

---

{_BC: @tyellow
������ �������
���� �� ���� ������
�� ������ � ��������
� ������� ������
�� ����� ������
�� ������ �����
�� ���� �� �����
����� ���, �����!
��� ��� ������ �����: @tyellow  _}

---

{_BC: @pre

� ������� � ����� � ��� ��� �������?
����� �� ������� ���, �� � ����� ����.
� ������� � ������ � ��� ��� �������?
������ �� ������� ��� � ������ ��� �����.

� ������� � ����� � ��� ��� �������?
����� ��� ��������, ������� � �����:
�� ������� ���������! �� ������� ���������!
�������, ����, ���������! ����� �� �����!
��� ��� ������ �����: @pre _}
*/

function BC($e) { return substr($e,0,1)=='@'?preg_replace_callback("/^([^\s]+)\s*(.*)\s*$/s",'BC_callback',$e):BC_callback(array('','@0',$e)); }

$GLOBALS['BC_table']=array(
'@0'=>"<blockquote style='border: 1px dashed rgb(255,0,0); padding: 20px; margin-left: 50px; margin-right: 50px;"
."box-shadow: 0px 2px 4px 0px rgba(255,0,0,0.4); background-color: rgb(255,252,223);border-radius: 11px 11px 11px 11px;'>{0}</blockquote>",
'@1'=>"<blockquote style='border-left:6px double #ad6f74;margin:1em 1em .5em;padding:.5em .75em;'>{0}</blockquote>",
'@table'=>"<table style='border-collapse: collapse; border: 1px solid red; margin: 20pt;' bgcolor=#fffff0 border=1 cellpadding=20><td><div align=justify>{0}</div></td></table>",
'@tblue'=>"<table bgcolor=#fff0ff border=1 cellpadding=50 cellspacing=0 width=80%><td><div align=justify>{0}</div></td></table>",
'@tgreen'=>"<table bgcolor=#f0ffff border=1 cellpadding=50 cellspacing=0 width=80%><td><div align=justify>{0}</div></td></table>",
'@tyellow'=>"<table bgcolor=#fffff0 border=1 cellpadding=50 cellspacing=0 width=80%><td><div align=justify>{0}</div></td></table>",
'@pre'=>"<pre style='border: 0.01mm solid rgb(0,0,0); padding: 4px; line-height: 100%; font-family: monospace; background-color: rgb(255,255,255);'>{0}</pre>"
);

function BC_callback($e) {
    foreach($GLOBALS['BC_table'] as $l=>$s){ if($e[1]==$l) return str_replace('{0}',$e[2],$s); }
    $o=''; foreach($GLOBALS['BC_table'] as $l=>$s) $o.="<p>".str_replace('{0}',"{<b></b>_BC:".$l." test _<b></b>}",$s);
    return "<fieldset style='font-color:red;border: 5px solid red; padding: 10px; margin 10px 50px 10px 50px;'><legend>BC: error `".h($e[1])."`, see example</legend>".$o."</fieldset>";
}

?>