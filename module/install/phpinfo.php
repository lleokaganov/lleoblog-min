<?php

// ��� ������� ���������� false, ���� ��������� ���� ������ �� ��������� (����. ������ ��� �������)
// ���� - ������ ��� ����������� ������ ������� ������.
function installmod_init() { return "phpinfo"; }
function installmod_do() { global $o; ob_start(); phpinfo(-1); $o=ob_get_clean(); return 0; }
function installmod_allwork() { return 0; }

?>