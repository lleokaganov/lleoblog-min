<?php // ���� ������ � �������� - ������ ���� ��������, ���� ��� - ������

// {_article_get:num_} - ������� htmlspecialchars($article['num']);

function article_get($e) { return h($GLOBALS['article'][$e]); }

?>