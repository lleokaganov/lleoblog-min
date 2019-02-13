<?php

/*
$d=$_SERVER["REQUEST_URI"]; if(($i=strpos($d,'?'))!==false) $d=substr($d,0,$i); if(''!=($d=trim($d,'/'))) {
    $d=$_SERVER["DOCUMENT_ROOT"].'/'.$d;
    foreach(array("/index.htm","/index.html","/index.shtml","/INDEX.HTM") as $l) if(is_file($d.$l)) { readfile($d.$l); exit; }
    if(is_file($d."/index.php")) { chdir($d); include "index.php"; exit; }
}
*/

// die('REMONT');

include "config.php";
$_SCRIPT=array(0=>"var page_onstart=[];");
$_SCRIPT_ADD=$_STYLE=$_HEADD=array();
include $include_sys."_autorize.php";
include $include_sys."_modules.php";
// include_once $include_sys."blogpage.php"; // потом удалить!!!

if(isset($HTTPS_REDIRECT) && 'http'==$HTTPS) redirect($httpsite.$_SERVER["REQUEST_URI"]);

// <------>$httpsite = $HTTPS."://".$rootdomain; // $httpsite = $HTTPS."://".$_SERVER['HTTP_HOST'];

if(!empty($acc)) {

  if(!empty($xdomain)&&$xdomain==$acc) die('E-XDM: '.$GLOBALS['MYPAGE']); // нехуй на xdomain ломиться
  if(substr($acc,0,4)=='www.') { $acc=substr($acc,4); if(isset($redirect_www)) redirect($HTTPS."://".($acc==''?'':$acc.'.').$MYHOST.$_SERVER["REQUEST_URI"]);  } // www.
  if(!$mnogouser) idie("Error 404#: Subdomain <b>".h($acc)."</b> not exist on http[s]://".$MYHOST,"HTTP/1.1 404 Not Found"); // однопользовательский блог не понимает доменов
  if(false==strpos($acc,'.')) { // поддомен пользователя
	if(false==($p=ms("SELECT `acn`,`unic` FROM `jur` WHERE `acc`='".e($acc)."'","_1"))) { $acn=-1; $ADM=0; }
	else { $acn=$p['acn']; $ADM=($unic==$p['unic']?1:0); if($ADM) $ttl=0; }
  } else { // заход как бы с внешнего домена, но в поддомен пользователя
	if(false==($p=ms("SELECT `acn`,`acc`,`unic` FROM `jur` WHERE `domain`='".e($acc)."'","_1"))) { $acn=-1; $ADM=0; }
	else { $acn=$p['acn']; $acc=$p['acc']; $ADM=($unic==$p['unic']?1:0); if($ADM) $ttl=0; }
  }

} else { $acc=''; $acn=0; $ADM=$admin; } // нет работы с поддоменами

//====================================

// if($admin) die("<pre>".print_r($GLOBALS,1));
// if($admin) idie('#<pre>'.print_r($_SERVER,1));

mystart();

//SCRIPTS("jog_kuki",$jog_scripts." function setIsReady() { c_rest('".$uc."'); c_rest('lju'); } ");
//SCRIPTS("jog_kuki","function setIsReady() { c_rest('".$uc."'); c_rest('lju'); }");

// SCRIPT_ADD($GLOBALS['www_design']."JsHttpRequest.js"); // подгрузить аякс

function getbasaDate($Date) {
	if(!isset($_GET['hash'])
// || strstr($BRO,'Yandex')
|| $IP=='78.110.50.100' // Робот Яндекса
|| strstr($BRO,'Google') // Робот Google
) return ms("SELECT * FROM `dnevnik_zapisi` ".WHERE("`Date`='".e($Date)."'",$novis),"_1");

    $Before=$_GET['before']; list($Y,$M,$D,,$H,$I,$S)=explode('-',$Before);
    if(time()<strtotime("$Y-$M-$D $H:$I:$S") && test_hashlink($Date." ".$Before,$GLOBALS['acc'],$_GET['hash'])) return ms("SELECT * FROM `dnevnik_zapisi` WHERE `Date`='".e($Date)."'","_1");
    return ms("SELECT * FROM `dnevnik_zapisi` ".WHERE("`Date`='".e($Date)."'",$novis),"_1");
}


function ARTICLE_Date($Date,$novis) { global $article,$acc;
	$article=getbasaDate($Date);
        if($article!==false) ARTICLE();
    return false;
/*
	idie(mpers(get_sys_tmp("404_issue.htm"),array(
		'before'=>issor('_GET|before',0),
		'Date'=>h($Date),
		'wwwhost'=>$GLOBALS['wwwhost'],
		'Date_last'=>ms("SELECT `Date` FROM `dnevnik_zapisi` ".WHERE("`DateDatetime`!=0")." ORDER BY `DateDatetime` DESC LIMIT 1","_l"),
		'hash'=>issor('_GET|hash',0)
	)),"HTTP/1.1 404 Not Found");
*/
}


function get_userfile($l) { global $acc,$filehost;
	if($acc!='') {
		$f=rpath($filehost."userdata/".$acc."/".$l);
		if(is_file($f)) return file_get_contents($f);
	}
	$f=rpath($filehost.$l);
	if(is_file($f)) return file_get_contents($f);
	return false;
}

function ARTICLE() { global $acc,$_PAGE,$article,$file_template,$wwwhost,$REF,$httpsite;

        if($GLOBALS['acn'] && !empty($GLOBALS['mnogouser']) && !$GLOBALS['mnogouser_html']) {
                $article['Body']=h($article['Body']); // экранировать
                $article['Header']=h($article['Header']);
        }

	$article=mkzopt($article);

// $REF='http://lurkmore.to/Синдром_поиска_глубинного_смысла';

	if($REF!='' && substr($REF,0,strlen($httpsite))!=$httpsite) {
            include_once $GLOBALS['include_sys']."_refferer.php"; $GLOBALS['linksearch']=refferer($REF,$article['num']);
	    if(empty($_GET['search']) && !empty($GLOBALS['linksearch'][0])) $_GET['search']=str_replace('&#34;','',$GLOBALS['linksearch'][0]);
	}

if(empty($article['template'])) $article['template']='blog';


if(false===($design=get_userfile("template/".$article['template'].'.html'))
&& false===($design=get_userfile("template/".$article['template'].'.htm'))
) {
    $design="<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"ru\" lang=\"ru\"><head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset={wwwcharset}\" />
{_MAIN:_}{_STYLE_ADD: {www_css}sys.css _}</head><body>
{_UNIC:<div style='display:inline;position:absolute;z-index:1;top:5px;right:9px;'>логин: <span class='myunic' onclick=\"{onclick}\">{name}</span></div>_}
<font color=red>Template not found: ".h($article['template']).".htm</font><p>
<article><div id=\"bodyz\">{_TEXT:_}</div></article>
</body></html>";
}

$_PAGE=array();
$_PAGE['link']=getlink($article['Date']);
$_PAGE['acc']=h($GLOBALS['acc']);
$_PAGE['acc_link']=acc_link($GLOBALS['acc']);
$_PAGE['num']=$article['num'];
$_PAGE['Date']=h($article['Date']);
$_PAGE['prevlink']=$wwwhost;
$_PAGE['nextlink']=$wwwhost;
$_PAGE['uplink']=$wwwhost;
$_PAGE['downlink']=$wwwhost."contents/";
$_PAGE['www_design']=$GLOBALS['www_design'];
$_PAGE['admin_name']=h($GLOBALS['admin_name']);
$_PAGE['httphost']=$GLOBALS['httphost'];
$_PAGE['wwwhost']=$wwwhost;
$_PAGE['signature']=$GLOBALS['signature'];
$_PAGE['wwwcharset']=h($GLOBALS['wwwcharset']);
// $_PAGE['hashpage']=$GLOBALS['hashpage'];
// $_PAGE['foto_www_preview']=$GLOBALS['foto_www_preview'];
// $_PAGE['foto_res_small']=$GLOBALS['foto_res_small'];
// $hashpage=rand(0,1000000); $hashpage=substr(broident($hashpage.$hashinput),0,6).'-'.$hashpage;

$_PAGE['design']=modules($design);
if($GLOBALS['ADM']||$GLOBALS['admin']) {
	if(!stristr($_PAGE['design'],'</body>')) idie('Not fount `</body>` in template `'.h($design).'`');
	$_PAGE['design']=str_ireplace('</body>',
mpers(str_replace(array("\n","\r","\t"),'',get_sys_tmp("adminpanel.htm")),
array('num'=>$article['num'],
'Date'=>h($article['Date'])
// 'www_design'=>$www_design
))
// get_userfile("template/adminpanel.htm")
.'</body>',$_PAGE['design']);
}

exit;
}




list($path)=explode('?',$GLOBALS['MYPAGE']); $path=rtrim(rpath($path),'\/');
$pwwwhost=str_replace('/','\/',$wwwhost);

// ============== начали выяснять, какой модуль подцепить ==============

// рядовая заметка
if(preg_match("/^".$pwwwhost."(\d\d\d\d\/\d\d\/\d\d.*)\.html/si", $path, $m)) ARTICLE_Date($m[1],'novis');

// заметка месяца
if(preg_match("/^".$pwwwhost."(\d\d\d\d\/\d\d)$/si", $path, $m)) ARTICLE_Date($m[1],''); // Заметка

// Корень => Последняя заметка ???
if($path."/"==$wwwhost //&& empty($_SERVER['QUERY_STRING'])
) {
 	// Yandex заебал индексировать титул блога! Он же меняется все время! Блять, для кого robots.txt был написан?!
 	if(($rootpage=='' || strstr($rootpage,'last')) && (
// strstr($BRO,'Yandex') || 
$IP=='78.110.50.100')) {
 	logi("yandex_nah.log","\n".date("Y/m/d H:i:s")." Yandex пошел нахуй $IP $BRO");
 	redirect('http://natribu.org/?WWFuZGV4JSDy+yDt6PXz-yDt5SD36PLg5fj8IHJvYm90cy50eHQg6CDr5efl+Pwg6vPk4CDt5SDt4OTuLiDfIOTr-yDq7uPuIHJvYm90cy50eHQg7+jx4Os-JSDv8OXq8OD54Okg6O3k5erx6PDu4uDy-CDy6PLz6yDv5fDl4OTw5fHg9ujoIPLl7CDq7u3y5e3y7uwsIOru8u7w++kg7+4g7OXx8vMg7+Xw5eDk8OXx4Pbo6C4gx+Dl4eDrLCBZYW5kZXgsIPfl8fLt7uUg8evu4u4h');
 	}

/*
	if(isset($_GET['module'])) {
		if(preg_match("/[^0-9a-z_\-\.\/]+/si",$mod_name)) idie("Error 404: wrong name \"<b>".h($mod_name)."</b>\"");
		$mod_name=substr($path,strlen($wwwhost)); $mod_name=str_replace('..','.',$mod_name);
		$article=array('template'=>'module','num'=>0,'Date'=>h($mod_name)); ARTICLE(); }
*/

	if(!empty($rootpage)) {
		if(substr($rootpage,0,6)=='index.') { // index в базе дневника
			$article=ms("SELECT * FROM `dnevnik_zapisi` ".WHERE("`Date`='".e($rootpage)."'")." LIMIT 1","_1");
			if($article!==false) ARTICLE();
			if(!empty($acc)) {
			$article=array('num'=>0,'Date'=>h($rootpage),'Body'=>"{_CONTENTS:_}
{_IFADMIN: <p class=br><a href=\"javascript:majax('editor.php',{a:'newform',hid:hid,acn:acn,Body:'{'+'_CONTENTS:_'+'}',Date:'".$rootpage."'})\">Create ".$rootpage."?</a> _}
",'opt'=>ser(array('template'=>'blank'))); ARTICLE();
			}
		}
		redirect($httphost.$rootpage); // если в конфиге установлен адрес заметки по умолчанию
	}

//	$admin=0; $podzamok=1;

	$last=ms("SELECT `Date` FROM `dnevnik_zapisi` ".WHERE("`DateDatetime`!=0")." ORDER BY `Date` DESC LIMIT 1","_l");

/*
if($admin) die('tony #4'."<p>
<br>admin: `$admin`
<br>podzamok: `$podzamok`
<br>acn: `$acn`
<br>ADM: `$ADM`
<p>".h("SELECT `Date` FROM `dnevnik_zapisi` ".WHERE("`DateDatetime`!=0")." ORDER BY `Date` DESC LIMIT 1"));
*/

	if($last=='') {
	if(/*!msq_table('site') and */!msq_table('dnevnik_zapisi')) redirect($httphost."install",302); // в админку, если по первому разу
	redirect(acc_link($acc)."contents",302); // в содержание, если записей нет
	} redirect(acc_link($acc).$last.".html",302); // на последнюю
	/*
	300 Multiple Choices (Множество выборов).
	301 Moved Permanently (Перемещено окончательно).
	302 Found (Найдено).
	303 See Other (Смотреть другое).
	304 Not Modified (Не изменялось).
	305 Use Proxy (Использовать прокси).
	306 (зарезервировано).
	307 Temporary Redirect (Временное перенаправление).
	*/

}

/* lleo */ // Старый стиль именования
/* lleo */ if(preg_match("/^".$pwwwhost."(\d\d\d\d)\-(\d\d)\-(\d\d)\.s*html/si", $path, $m)) redirect($httphost.$m[1]."/".$m[2]."/".$m[3].".html");

// ===== подключение внешних модулей из директории /module/* ====
if(preg_match("/[^0-9a-z_\-\.\/]+/si",$mod_name)) idie("Error 404: wrong name \"<b>".h($mod_name)."</b>\"");
$mod_name=substr($path,strlen($wwwhost)); $mod_name=rpath($mod_name);

// сперва ищем в модулях-страницах (темплайтах, вызывающих модуль - это более новый прогрессивный формат)
//if(file_exists($file_template.$mod_name.".htm")) { $article=array('template'=>$mod_name,'num'=>0,'Date'=>h($mod_name)); ARTICLE(); }

// затем ищем в модулях
$mod=$host_module.$mod_name.".php"; if(file_exists($mod)) { include($mod); exit; }

// затем в базе site
//$text=ms("SELECT `text` FROM `site` ".WHERE("`name`='".e($mod_name)."' AND `type`='page'"),"_l",$ttl);
//if($text!='') { $name=$mod_name; include("site.php"); exit; }

// затем в базе дневника
if(false!==($article=getbasaDate($mod_name))) ARTICLE();


$article=ms("SELECT * FROM `dnevnik_zapisi` ".WHERE("(`Date`='".e($mod_name)."'
OR `Date`='".e($mod_name)."/index.htm'
OR `Date`='".e($mod_name)."/index.shtml'
OR `Date`='".e($mod_name)."/index.html'
)",'novis')." LIMIT 1","_1"); if($article!==false && $article!='') {
	if(preg_match("/^\d\d\d\d\/\d\d\/\d\d[\_\d]*$/si",$mod_name)) idie("Wrong name.<p>Try: <a href='".getlink($mod_name)."'>".getlink($mod_name)."</a>");
	ARTICLE();
}

// или в таблице редиректов, пример:
// ?p=171 2011/04/21.html
// ?page_jopa=666 2011/08/16.html


if(($p=ms("SELECT `text` FROM `site` WHERE `name`='redirect'","_l",$ttl*10))!==false) {
        if($mod_name=='') $mod_name='?'.$_SERVER['QUERY_STRING'];
        $e=explode("\n",$p);
// dier($e,$mod_name);
        foreach($e as $p) { list($a,$b)=explode(' ',$p,2); $b=trim($b); if(empty($a)) continue;

//		logi("pilim_index.txt","\n`$a`=`".substr($a,0,1).'|'.substr($a,strlen($a)-2,2)."` strlen=".strlen($a));
/*
`/^\?redirect=1.*?$/s`
`sportmaster`
`mir-iz-moego-okna`
`documents`
`2015/03/25.html`
``
*/
		
                if($a==$mod_name || substr($a,0,1).substr($a,strlen($a)-2,2)=='//s' && preg_match($a,$mod_name) ) redirect($httphost.($b=='/'?'':$b));
        }
}

// и если совсем ничего не нашлось

// то еще ищем в папке страниц: $site_module = $filehost."site_module/";

$modp=strtoupper($mod_name); $mod=$site_module.$modp.".php"; if(file_exists($mod)) {
	$article=array(
		'Date'=>$modp,'Header'=>$modp,'Body'=>'{_'.$modp.':_}',
		'Access'=>'all','DateUpdate'=>0,'num'=>0,'DateDatetime'=>0,'DateDate'=>0,
		'opt'=>'a:3:{s:8:"template";s:5:"blank";s:10:"autoformat";s:2:"no";s:7:"autokaw";s:2:"no";}',
		'view_counter'=>0
        );
//	SCRIPTS("alert(7);page_onstart.push('hotkey_reset=function(){}; hotkey=[];');");
	ARTICLE();
}


// если это папка, и в ней есть индекс
if(is_dir($filehost.$mod_name)) {
    foreach(array('index.php','index.htm','index.html','index.shtml') as $a) { if(is_file($filehost.$mod_name."/".$a)) redirect($wwwhost.$mod_name."/".$a); }
    // тут еще дописать самостоятельную обработку индекса
}

if(preg_match("/\.js/si",$mod_name)) die( ($admin?"alert('Admin $admin_name! Script not found:\\n".h($mypage)."')":"") ); // запрошен .js

header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");

$article=array('num'=>0,'Date'=>h($mod_name),'opt'=>ser(array('template'=>'error')));

ARTICLE();


//===============================================================================================================================
function SCRIPTS_mine() { global $BRO;

//  /*httpsite'].$GLOBALS['mypage']."';
// var hashpage='".$GLOBALS['hashpage']."';

$o=array();
$e=$GLOBALS['IS']['useropt']; if(gettype($e)=='array'&&sizeof($e)) foreach($e as $n=>$l) $o[]=njsn($n).':'.($l==intval($l)?intval($l):'"'.njsn($l).'"'); $o=implode(',',$o);

/*  НАХУЙ ОТЛОЖИМ
if($GLOBALS['unic']) {
    $r=ms("SELECT `fkey` FROM ".issor('db_fkey','fkey')." WHERE `unic`='".$GLOBALS['unic']."'");
    if(empty($r)) $fkeys=''; else { $fkeys=array(); foreach($r as $l) $fkeys[]=$l['fkey']; $fkeys=implode(',',$fkeys); }
}
*/

SCRIPTS("main","
var useropt={".$o."};
var acn='".$GLOBALS['acn']."';
var IMBLOAD_MYID='top';
var MYHOST='".$GLOBALS['MYHOST']."';
var wwwhost='".$GLOBALS['wwwhost']."';
var admin=".($GLOBALS['admin']?1:0).";
var adm=".($GLOBALS['ADM']?1:0).";
var mypage='".acc_link($GLOBALS['acc'],$GLOBALS['mypage'])."';
var uc='".$GLOBALS['uc']."';
var www_js='".$GLOBALS['www_js']."';
var www_css='".$GLOBALS['www_css']."';
var wwwcharset='".$GLOBALS['wwwcharset']."';
var www_design='".$GLOBALS['www_design']."';
var www_ajax='".$GLOBALS['www_ajax']."';
var num='".$GLOBALS['article']['num']."';
var up='".$GLOBALS['up']."';
var realname=\"".njsn($GLOBALS['imgicourl'])."\";
var unic='".$GLOBALS['unic']."';

var hashpage='".get_hashpage()."';

var ux='".$GLOBALS['ux']."';
var uname=\"".njsn($GLOBALS['uname'])."\";
var ux_name='".$GLOBALS['ux_name']."';

var mnogouser=".($GLOBALS['mnogouser']==1?1:0).";
var xdomain='".$GLOBALS['HTTPS']."://".$GLOBALS['xdomain'].".".(isset($GLOBALS['rootdomain'])?$GLOBALS['rootdomain']:$GLOBALS['MYHOST'])."';
var xdom=xdomain+www_ajax+'autoriz.php?x=1';

var wintempl=\"".(isset($GLOBALS['wintempl'])?$GLOBALS['wintempl']:"<div class='corners'><div class='inner'><div class='content' id='{id}_body' align=left>{s}</div><div onclick=\\\"clean('{id}')\\\" title='Close' class='can'></div></div></div></div>")."\";
var wintempl_cls='".(isset($GLOBALS['wintempl_div'])?$GLOBALS['wintempl_div']:'popup')."';
".(isset($_GET['search'])?"page_onstart.push(\"window.location.hash='search_0';\");":'')
); //if(aharu && admin) alert(up);


// ."page_onstart.push(\"if(1*unic)fpkeytest();\");function fpkeytest(){ fkey=fpkey(); if(!fkey || in_array(fkey,fkeys)!==false) return; majax('autoriz.php',{a:'fkey',fkey:fkey}); }"
// var fkeys=[".$fkeys."];
// var fkey=0;

// var xdomain='".str_replace('http://','http://'.$GLOBALS['xdomain'].'.',$GLOBALS['httpsite'])."';

//var page_onstart=[];
// ".($GLOBALS['admin']?"setTimeout(\"inject('counter.php?num=".$GLOBALS['article']['num']."&ask=1&old=0');\",5000);":'')."
	SCRIPT_ADD($GLOBALS['www_js']."main.js");
	if($GLOBALS['IS']['useropt']['n']) SCRIPT_ADD($GLOBALS['www_js']."ipad.js");
	// if($GLOBALS['mnogouser'])
	SCRIPT_ADD($GLOBALS['www_js']."transportm.js");
}

/*
function get_mainjs(){ // получить кешированный main.js
        $file=$GLOBALS['filehost']."js/main.js";
        $i=md5_file($file); $n="main-".substr($i,4,12).".js";
        $name=$GLOBALS['filehost']."js/".$n;
        if(!is_file($name)) copy($file,$name);
        return $n;
}
*/

//===============================================================================================================================

?>
