<?php // ������

function LOGIN($e) { global $img,$dom,$dob,$name,$info,$site,$mail,$conf,$newhash_user,$unic,$db_unic,$newhash_user;

// header("Access-Control-Allow-Origin: *");
// die("alert(1);");


$thispath=acc_link($GLOBALS['acc'],'/'.$GLOBALS['blogdir']);
$thispage=$thispath.'login';

// ========= ����������� EMAIL ===========
if(isset($_GET['a'])) { $a=$_GET['a'];
    // ------
if($a=='mailconfirm') { $js=$s=''; $u=intval($_GET['u']); $mail=$_GET['m'];
	if(md5($mail.$u.$newhash_user)!=$_GET['h']) return "������� ����������� email `".h($mail)."` �� �������!";
	if(false===($a=ms("SELECT `mail`,`mailw` FROM $db_unic WHERE `id`='$u'","_1",0)))  return "������� ����������� email `".h($mail)."` ��� unic=`$u` �� �������!";

	if($a['mail']=='!'.$mail) $s.="<font color=gray>����� `$mail` ��� ��� ����������� ��� ��������.</font>";
	if($a['mailw']=='!'.$mail) $s.="<font color=gray>����� `$mail` ��� ��� ����������� ��� ��������������.</font>";

	if($a['mail']==$mail) { msq_update($db_unic,array('mail'=>'!'.$mail),"WHERE `id`='$u'"); $s.="<font color=green>����� `$mail` ����������� ��� ��������.</font>"; }
	if($a['mailw']==$mail) { msq_update($db_unic,array('mailw'=>'!'.$mail),"WHERE `id`='$u'"); $s.="<font color=green>����� `$mail` ����������� ��� ��������������.</font>"; }

	if($unic!=$u) { // ���� � ����� �������� �� ��� unic, �� ������� �� ���
		$up=$u.'-'.md5($u.$newhash_user);
        	$js.="up='$up'; fc_save('up',up); f5_save('up',up); c_save(uc,up,1); uname='#$u'; f5_save('uname',uname); salert('Login restore: '+uname,1000);";
		if(!empty($GLOBALS['xdomain'])) $js.="ux='".uxset($u)."'; c_save(ux_name,ux,1); zabilc('uname',uname); f5_save('uname',uname); ifhelpc(xdom+'&upx=".upx_set($u)."','xdomain','xdomain');";
	}

	return ($js==''?'':"<script>page_onstart.push('".njsn($js)."');</script>").$s
."<p>������� � ������� ��������: <a href='".$GLOBALS['httphost']."'>".$GLOBALS['httphost']."</a>";
}
    // ------
if($a=='restore') {
	$u=intval($_GET['u']); $p=$_GET['p']; $h=$_GET['h'];
	if(gettype(($e=check_change_pass($u,$p,$h)))!='array') return $e;
	return "<center>
<div class='uname' style='font-weight: bold; font-size: 18px;'>".$GLOBALS['IS']['imgicourl']."</div>
<b>Enter new password:</b>
<div id='newpassform'><form onsubmit=\"return send_this_form(this,'module.php',{mod:'LOGIN',a:'newpassword'})\">
<input type='hidden' name='u' value='".$u."'>
<input type='hidden' name='p' value='".h($p)."'>
<input type='hidden' name='h' value='".h($h)."'>
<input type='text' name='password' value=''>
<input type='submit' value='GO'>
</form></div></center>
";
}
    // ------
}

/// idie('##');

// http://lleo.me/dnevnik/login?loginza=0abd4de33270c2101925b9a92ed817fb
// &QUERY=ulogin%3Dc7c5b0ba5c0b6c5609528d4b1bc415c6%26QUERY%3Dloginza%253Dcd70ca9c5e6687328de425741f11429c%2526QUERY%253Dloginza%25253D215d062f057578e8d35f87bbacf44005%252526QUERY%25253Dloginza%2525253Df424e73a44eb8c6620973c5a29433b5f%25252526QUERY%2525253Dcache%252525253D0.3764322321842041

// ========= TOKEN - ulogin ===========
if(isset($_GET['token'])) { die("<html><body><script>
        var a={},b=location.search.substr(1).split('&');
        for(var c=0;c<b.length;c++){ var d=b[c].split('='); a[d[0]]=d[1]; }
	window.parent.location='".$thispage."?ulogin='+a['token']+'&QUERY='".h($_GET['QUERY'])."';
</script></body></html>");
}
// ========= TOKEN - ulogin ===========

$conf=array_merge(array(
    'redirect'=>false,
    'log'=>0,
    'page'=>get_sys_tmp("login.htm")
),parse_e_conf($e)); // onclick='openid_ifr_post()'

	ini_set("display_errors","1");
	ini_set("display_startup_errors","1");
	ini_set('error_reporting', E_ALL);

if(isset($_GET['loginza'])) {
	$s=file_get_contents("http://loginza.ru/api/authinfo?token=".$_GET['loginza']);
// $s='{"identity":"https:\/\/www.google.com\/accounts\/o8\/id?id=AItOawl-5JFpsxQqspiHpVmMdogLsfNpff8BPoo","provider":"https:\/\/www.google.com\/accounts\/o8\/ud","name":{"first_name":"Leonid","last_name":"Kaganov","full_name":"Leonid Kaganov"},"email":"lleo.kaganov@gmail.com","language":"en","address":{"home":{"country":"RU"}},"uid":"103926980431102214659"}';
	include $GLOBALS['include_sys']."json.php"; $j=jsonDecode($s);
	$ll=login_do($j);
}

if(isset($_GET['ulogin'])) {
	$s=file_get_contents('http://ulogin.ru/token.php?token='.$_GET['ulogin'].'&host='.$_SERVER['HTTP_HOST']);
	include $GLOBALS['include_sys']."json.php"; $j=jsonDecode($s);
	$ll=login_do($j);
}

//$user = json_decode($s, true);
//$user['network'] ? ���. ����, ����� ������� ������������� ������������
//$user['identity'] ? ���������� ������ ������������ ����������� ������������ ���. ����
//$user['first_name'] ? ��� ������������
//$user['last_name'] ? ������� ������������

// =============================================================================
// =============================================================================
// =============================================================================
// =============================================================================
// =============================================================================


if(''!=trim($conf['body'])) $conf['page']=$conf['body'];

return str_replace(array("\n","\r","\t"),'',mper($conf['page'],array(
'thispage'=>$thispage,
'xd_url'=>$thispath."ajax/ulogin_xd.php",
'wwwhost'=>$GLOBALS['wwwhost'],
'httphost'=>$GLOBALS['httphost'],
'teddyid_nodeid'=>(isset($GLOBALS['teddyid_nodeid'])?$GLOBALS['teddyid_nodeid']:0)
)));
}


function dier1($a) {
	$e=explode("\n",print_r($a,1));
	$o=array(); foreach($e as $l) { if(str_replace(array("\r","\n","\t"," ","(",")","Array"),'',$l)!='') $o[]=h($l); }
	return implode("\n",$o);
}

//===============================================================================
function login_do($j) { global $conf; // $img,$dom,$dob,$name,$info,$site,$mail;

/*Array
//    if(isset($_GET['QUERY'])) parse_str($_GET['QUERY'],$e);
if($e['clean']=='userid') { $s='';
    if($e['opt'=='openid']) $s.="idd('openid_no').stype.display='none'; idd('openid_yes').stype.display='inline'; idd('openid_id').href=idd('openid_id').innerHTML='".h()."';";
    if($e['opt'=='teddyid']) $s.="idd('teddyid_no').stype.display='none'; idd('teddyid_yes').stype.display='inline'; zabil('teddyid_id','".intval()."');";
}
*/

	$birth=(isset($j['bdate'])?$j['bdate']:isset($j['dob'])?$j['dob']:'');
	$birth=strtotime($birth); if($birth) $birth=date("Y-m-d",$birth); else $birth='';

	$mail=(!empty($j['email'])?$j['email']:'');
	if(!preg_match("/^[a-z0-9\-\_\.]+\@[a-z0-9\-\_\.]+\.[a-z]{2,10}$/si",$mail)) $mail='';

	if(empty($j['identity'])) idie("Identity fatal error!");

	// �� ������� cats.shadow
	if(!empty($j['profile'])&&empty($j['real_identity'])) $j['real_identity']=$j['profile'];

	if(!empty($j['real_identity'])) { $a=strlen($j['real_identity']); $b=strlen($j['identity']);
		if(substr($j['real_identity'],0,min($a,$b))!=substr($j['identity'],0,min($a,$b)))
		$openid=$j['real_identity']; else $openid=($a>$b?$j['real_identity']:$j['identity']);
	} else $openid=$j['identity'];

	if(strstr($openid,'facebook.com/') && isset($j['uid'])) $openidfb='https://facebook.com/'.h($j['uid']);

	$openid=trim($openid,'/'); if(!strstr($openid,':')) $openid="http://".$openid;

$uf='http://ulogin.ru/img/photo.png'; // ��� ��� �� ���� ����� ���
	$img=(!empty($j['photo_big'])&&$j['photo_big']!=$uf?$j['photo_big']:
!empty($j['photo'])&&$j['photo']!=$uf?$j['photo']:'');

	$site=(!empty($j['web']['default'])?$j['web']['default']:
!empty($j['web']['blog'])?$j['web']['blog']:'');

	// ���� �������� ��������
	preg_match("/^(.*?)([^\.]+\.[^\.]+)$/s",preg_replace("/www\./si",'',parse_url($openid,PHP_URL_HOST)),$m);
	$port=$m[2];
	//$liboname=trim(basename('/'.$m[1]),'.');

	// ����� ������ � ����� ����

if($conf['log']) logi('login_log.txt',"\n--------------------\n".print_r($j,1));


$i=array('http://www.','https://www.','http://','https://');
$l=str_ireplace($i,'',$openid);
//$p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `openid`='".e($openid)."'","_a",0);
$p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `openid` IN ('".e($i[0].$l)."','".e($i[1].$l)."','".e($i[2].$l)."','".e($i[3].$l)."'"
.(isset($openidfb)?",'".e($openidfb)."'":'')
.")","_a",0);

	if(sizeof($p)) { $p=$p[0];
if($conf['log']) logi('login_log.txt',"\nopenid: '".$openid."' EXIST");
	} else {
if($conf['log']) logi('login_log.txt',"\nopenid not found: `".$openid."`");
	$p=false;
	}

//	if($p['openid']=='http://samposebem.livejournal.com') $p['img']='';

	// � ���� ���� - ������� ��� �� ����� � ���
	if(empty($p['img']) /*&& empty($img)*/ && $port=='livejournal.com' // �� �� �����, ��� ��� ����� �����
	&& ($l=fileget($openid."/data/foaf"))!==false) {
		if(preg_match("/<foaf\:name>(.+?)<\/foaf\:name>/si",$l,$m)) $j['nickname']=uw($m[1]);
		if(preg_match("/<foaf\:img\s+rdf\:resource=\"(.+?)\"/si",$l,$m)) $img=$m[1];
	}

	if(!isset($j['full_name']) && isset($j['name']['full_name'])) $j['full_name']=$j['name']['full_name'];
	if(!isset($j['first_name']) && isset($j['name']['first_name'])) $j['first_name']=$j['name']['first_name'];
	if(!isset($j['last_name']) && isset($j['name']['last_name'])) $j['last_name']=$j['name']['last_name'];
	if(!isset($j['middle_name']) && isset($j['name']['middle_name'])) $j['middle_name']=$j['name']['middle_name'];

	$realname=( //!empty($j['openid.sreg_fullname'])?$j['openid.sreg_fullname']:
		     !empty($j['full_name'])?$j['full_name']:
	 	      !empty($j['nickname'])?$j['nickname']:'');
	if($realname=='') {
		if(!empty($j['first_name'])&&!empty($j['last_name'])) $realname=$j['first_name'].' '.$j['last_name'];
		elseif(($realname=trim(parse_url($openid,PHP_URL_PATH),'/'))!=''){}
		else $realname=preg_replace("/^(.*)\.[^\.]+\.[^\.]+$/s","$1",preg_replace("/www\./si",'',parse_url($openid,PHP_URL_HOST)));
	}

	// [openid.sreg_gender]=&gt;M
	// logi('openid_david.txt',"\n\n\n".dier1(array_merge(array('openid'=>$info),$j)));


// ��������� url IMG
$img=site_validate($img);
if(empty($img)) $img=$p['img'];

$x="\n\n<!-- $openid --><table style='width: 80%; border: 1px dashed rgb(255,0,0); padding: 20px; margin-left: 50px; margin-right: 50px; background-color: rgb(255,252,223);'><tr><td>"
.(empty($img)?'':"<img src='".h($img)."' align='right' hspace='20'>")
."<img src='http://".h($port)."/favicon.ico'><b>".h($realname).(empty($port)?'':" / ".h($port))."</b>"
."<br>info: <a href='".h($openid)."'>".h($openid)."</a>"
//.(empty($mail)?'':"\nmail: <a href='mailto:".h($mail)."'>".h($mail)."</a>")
.(empty($mail)?'':"<br>mail: <i>�������</i>")
.(empty($site)?'':"<br>site: <a href='".h($site)."'>".h($site)."</a>")
.(empty($dob)?'':"<br>birth: ".h($dob))
."</td></tr></table>";

$o='';

if($p===false) { // ���, ������ ��� � ��� �� ����
	$o.="<h1><font color=green>New Login</font></h1>";
	//����� ��� ���� �������� unic �������, �� �������/�������� � ��� ���� `openid`, ������ �����������
	$img=load_farimg($img,$GLOBALS['unic']); // ��������� ���� ��������

	if(isset($openidfb)) $openid=$openidfb; // ���� FB, �� ��������

	$ara=array('openid'=>$openid,'realname'=>$realname,'birth'=>$birth,'img'=>$img);
	msq_update($GLOBALS['db_unic'],arae($ara),"WHERE `id`='".$GLOBALS['unic']."'");
if($conf['log']) logi('login_log.txt',"\np=false, UPDATE id=unic=`".$GLOBALS['unic']."`: openid=`".$openid."`: ".print_r($ara,1));
	$p=get_ISi($ara);
	$js=reset_the_unic($p['imgicourl'],false,$_GET['QUERY'],$openid);
	// ��������� ���������, openid ����������, unic �� ������.

} else { // � ���� ������������
	$o.="<h1><font color=green>in base: ".$p['id']."</font></h1>";
		$unic_tot=$p['id']; // ��-������ ������ unic �� ������, ��� �� ����.
	// ������ ������������
	$ara=array();
		if(isset($openidfb) && $p['openid']!=$openidfb) $ara['openid']=$openidfb; // ���� FB, �� ��������
		if(empty($p['birth'])&&!empty($birth)) $ara['birth']=$birth;
		if(empty($p['realname'])&&!empty($realname)) $ara['realname']=$realname;
		if(empty($p['mail'])&&!empty($mail)) $ara['mail']=$mail;
		if(empty($p['img'])&&!empty($img)) $ara['img']=load_farimg($img,$p['id']); // ��������� ���� ��������
	if(sizeof($ara)) msq_update($GLOBALS['db_unic'],arae($ara),"WHERE `id`='".$p['id']."'");
if($conf['log']) logi('login_log.txt',"\np[id]=`".$p['id']."` UPDATE id (unic=`".$GLOBALS['unic']."`):".(sizeof($ara)?print_r($ara,1):' NOT NEED UPDATES'));
	$p=get_ISi($p);
	$js=reset_the_unic($p['imgicourl'],$unic_tot,$_GET['QUERY'],$openid);
}

if($GLOBALS['msqe']) {
	if($conf['log']) logi('login_log.txt',"\nE R R O R! msqe=".$GLOBALS['msqe']);
	logi('NEW_login_msqe.txt',"\n\n".$GLOBALS['msqe']); die($GLOBALS['msqe']);
}

// if(!$GLOBALS['admin'])
ob_clean();
die("<script>".$js."</script>".$o."<font color=green>success</font><p>$x<p><pre>".dier1($j)."</pre>");
}





//===============================================================================
function LOGIN_ajax() { $a=RE('a'); // ����������� �� ������-������

$GLOBALS['teddyid_ping']=1000; // ���� ��� � �������
$GLOBALS['teddyid_max']=30; // ������ ��������

function teddyidfunc_dopdata($a) {
    $mail=$tel='';
    if($a['response']=='N') teddy_endreg(RE0('eid'),RE('elogin'),'','','');
    if($a['response']=='Y' && isset($a['arrFieldValues'])) { $e=(array)$a['arrFieldValues'];
	if(isset($e['email'])&&($mail='!'.mail_validate($e['email']))) {}
	if(isset($e['phone'])&&($tel='!'.tel_validate($e['phone']))) {}
	teddy_endreg(RE0('eid'),RE('elogin'),'',$mail,$tel);
    }
    dier($a,'Error #10 response dopdata');
}
/*
Array
    [result] => ok
    [response] => Y
    [response_date] => 2015-01-31 05:44:29
    [arrFieldValues] => stdClass Object
        (
            [email] => lleo@lleo.me
            [phone] => 79166801685
        )
Array
(
    [result] => ok
    [response] => N
    [response_date] => 2015-01-31 05:45:11
)


$e=explode('&',$_GET['QUERY']); unset($_GET['QUERY']); foreach($e as $l) { list($a,$b)=explode('=',$l); $_GET[urldecode($a)]=urldecode($b); }
*/

function echor($a) { return "<pre>".nl2br(h(print_r($a,1)))."</pre>"; }

function teddy_zapros_dopdata($eid,$elogin) { // ��������� �������������� ������
    list(,$site)=explode("://",$GLOBALS['httpsite']);

    $fls=array('email','phone');
    $ara=array('node_id'=>$GLOBALS['teddyid_nodeid'],'token'=>teddysha(),  // ���� � sha, // to_node_id=1 (������������� ����)
        'employee_id'=>$eid,
	'domain'=>$site, // 'lleo.me'
        'requested_fields'=>implode(',',$fls));

    $a=(array)json_decode1(curlpost('https://www.teddyid.com/authorize.php',$ara));
    if(isset($a['missing_fields'])) {
	foreach($a['missing_fields'] as $l) unset($fls[array_search($l,$fls)]); // ��������� �� ������� ������������� ����
	if(empty($fls)) teddy_endreg($eid,$elogin,'','',''); // ���� �� �������� ����� ��� ������� - ���������
	// � ��������� ������ � ����� ������� �����
	$ara['requested_fields']=implode(',',$fls); $a=(array)json_decode1(curlpost('https://www.teddyid.com/authorize.php',$ara));
    }

    if(isset($a['error'])) { dier($a,'TeddyID Error #6'); }
    if(!isset($a['result'])||$a['result']!='ok') idie('ERROR #7','TeddyID.com');
    if(!isset($a['request_id'])||!intval($a['request_id'])) idie('ERROR #8: bad request_id','TeddyID.com');
    $rid=intval($a['request_id']);
    otprav("
	ohelpc('teddyid','Check your phone',\"<center><img width=\"+(getWinW()/3)+\" src='".h($a['auth_picture'])."'><p>���������� teddyid.com ����� email � phone... <span style=\\'font-size:30px\\' id='teddyidn'>".$GLOBALS['teddyid_max']."</span></span></center>\");
	posdiv('teddyid',-1,20);
	setTimeout(\"majax('module.php',{mod:'LOGIN',a:'teddyid_pid',n:".$GLOBALS['teddyid_max'].",f:'dopdata',eid:".intval($eid).",elogin:'".h($elogin)."',rid:".$rid.",QUERY:'".h(htmlspecialchars_decode(RE('QUERY')))."'})\",".$GLOBALS['teddyid_ping'].");
    ");
}


function teddy_endreg($eid,$elogin,$p='',$mail='',$tel='') { // ��������� �����������
    if(!intval($eid)) idie("Error eid");
    if($p=='') $p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `teddyid`='".e($eid)."' LIMIT 1","_1",0);
    $o='';
    if($p===false) { // ���, ������ ��� � ��� �� ����
	$o.="<h1><font color=green>New Login</font></h1>";
	//����� ��� ���� �������� unic �������, �� �������/�������� � ��� ���� mail,tel,realname � ������� teddyid
	$ara=array('teddyid'=>$eid);
		if(empty($GLOBALS['IS']['realname'])) { $GLOBALS['IS']['realname']=$ara['realname']=h($elogin); }
		if(empty($GLOBALS['IS']['mail'])&&!empty($mail)) $ara['mail']=$mail;
		if(empty($GLOBALS['IS']['tel'])&&!empty($tel)) $ara['tel']=$tel;
	msq_update($GLOBALS['db_unic'],arae($ara),"WHERE `id`='".$GLOBALS['unic']."'");
	$p=get_ISi($GLOBALS['IS']);
	$js=reset_the_unic($p['imgicourl'],false,htmlspecialchars_decode(RE('QUERY')),$eid);
	// ��������� ���������, openid ����������, unic �� ������.
    } else { // � ���� ������������
	$o.="<h1><font color=green>in base: ".$p['id']."</font></h1>";
	    $unic_tot=$p['id']; // ��-������ ������ unic �� ������, ��� �� ����.
	    $p=get_ISi($p);
	$js=reset_the_unic($p['imgicourl'],$unic_tot,htmlspecialchars_decode(RE('QUERY')),$eid);
    }
    if($GLOBALS['msqe']) die($GLOBALS['msqe']);

    ob_clean();
    die("<script>".$js."</script>".$o."<font color=green>success</font>");
}


// teddyid
// majax('module.php',{mod:'LOGIN',a:'teddyid_request',text:'�������� ������� �����?',f:'rezreshim'});
if($a=='teddyid_request') { if(empty($GLOBALS['IS']['teddyid'])) otprav("salert('No Teddyid',3000);");
    $text=RE('text'); $id=$GLOBALS['IS']['teddyid']; // RE0('id');
    $f=preg_replace("/[^a-z0-9\_]+/si",'',''.RE('f'));

    include_once $GLOBALS['include_sys']."protocol/_protocol_patchs.php"; $a=(array)json_decode1(curlpost('https://www.teddyid.com/authorize.php',array(
	'node_id'=>$GLOBALS['teddyid_nodeid'], 'token'=>teddysha(), 'employee_id'=>$id, 'question'=>wu($text)  )));
    if(isset($a['error'])) idie('ERROR #4: '.h($a['error']),'TeddyID.com');
    if(!isset($a['result'])||$a['result']!='ok') idie('ERROR #5','TeddyID.com');
    if(!isset($a['request_id'])||!intval($a['request_id'])) idie('ERROR #3: bad request_id','TeddyID.com');
    $rid=intval($a['request_id']);
    otprav("
	ohelpc('teddyid','Check your phone',\"<center><img width=\"+(getWinW()/3)+\" src='".h($a['auth_picture'])."'><div style=\\'font-size:30px\\'>".h($text)."<b><div id='teddyidn'>".$GLOBALS['teddyid_max']."</div></b></div></center>\");
	setTimeout(\"majax('module.php',{mod:'LOGIN',a:'teddyid_pid',n:".$GLOBALS['teddyid_max'].",f:'".$f."',rid:".$rid.",QUERY:'".h(RE('QUERY'))."'})\",".($GLOBALS['teddyid_ping']+1000).");
    ");
}

if($a=='teddyid_pid') { // polling
    $n=RE0('n')-1; if($n<=0) otprav("salert('teddyid.com timeout',10000); clean('teddyid');");
    $rid=RE0('rid'); if(!$rid) idie('Error rid','teddyid.com');
    $f=preg_replace("/[^a-z0-9\_]+/si",'',''.RE('f'));

    include_once $GLOBALS['include_sys']."protocol/_protocol_patchs.php";
    $a=(array)json_decode1(curlpost('https://www.teddyid.com/get_authorization_response.php',array(
	'node_id'=>$GLOBALS['teddyid_nodeid'],'token'=>teddysha(),  // ���� � sha, // to_node_id=1 (������������� ����)
	'request_id'=>$rid
    )));
    if(isset($a['response'])) { // result: �ok�, response: �Y�, response_date: �2014-01-21 16:59:22�
	$ff='teddyidfunc_'.$f; if(function_exists($ff)) $f=call_user_func($ff,$a);
	otprav("clean('teddyid');"
// .($f==''?'':(strstr($f,'(')?$f:$f."('".h($a['response'])."','".h($a['response_date'])."');")));
.($f==''?'':$ff."('".h($a['response'])."','".h($a['response_date'])."','".teddysha($a['response'].$a['response_date'].$GLOBALS['unic'].RE('QUERY'))."');")
);
    }
    otprav("zabil('teddyidn','".$n."'); setTimeout(\"majax('module.php',{mod:'LOGIN',a:'teddyid_pid',n:".$n.",rid:".$rid.",f:'".$f."',eid:".intval(RE0('eid')).",elogin:'".h(RE('elogin'))."',QUERY:'".h(htmlspecialchars_decode(RE('QUERY')))."'})\",".$GLOBALS['teddyid_ping'].");");
}


if($a=='teddyid') { // ��������� ������ �� URL https://www.teddyid.com/confirm_auth.php  � ��������� ������� POST ��������� ���������:
    include_once $GLOBALS['include_sys']."protocol/_protocol_patchs.php";
    $a=(array)json_decode1(curlpost('https://www.teddyid.com/confirm_auth.php',array(
        'node_id'=>$GLOBALS['teddyid_nodeid'], 'token'=>teddysha(),  // ���� � sha, // to_node_id=1 (������������� ����)
        'auth_token_id'=>RE('auth_token_id'), // ID �������������� ([error] => some params missing)
        'auth_token'=>RE('auth_token'), // �����, ���������� ([error] => some params missing) ([authenticated] => 0 [authentication_error] => no such request)
        'url'=>RE('url'), // URL ��������, � ������� ��� ������ ������ ([error] => some params missing)
        'ip'=>$GLOBALS['IP'], // IP ����� ������������. Teddy ���������, ��� �� ��������� � �������, � �������� ��� ������ ������ ([error] => some params missing)
    )));
        if(isset($a['error'])) idie('ERROR #1: '.h($a['error']),'TeddyID.com');
	if(!isset($a['authenticated']) || $a['authenticated']!=1) idie('ERROR #2: '.h($a['authentication_error']),'TeddyID.com');
	if(!isset($a['employee_id'])||!intval($a['employee_id'])) idie('ERROR #3: bad employee_id','TeddyID.com');
    $eid=$a['employee_id'];
    $elogin=uw($a['login']);

    // ������ � ����� ����
    $p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `teddyid`='".e($eid)."' LIMIT 1","_1",0);
    if($p===false) { // ���� ��� ������
	if($GLOBALS['IS']['mail']=='' || $GLOBALS['IS']['tel']=='') teddy_zapros_dopdata($eid,$elogin); // ���� ��� �������� ����� - ��������� ������ �������������� ������
	teddy_endreg($eid,$elogin); // ����� ������ ��������� �����������
    } // � ���� ����
	// if($p['mail']=='' || $p['tel']=='') // ��� �� ���� �������� ������ - �� ����� ������ �� �� ����, ���� ����������� ������� �����-��? ����� ��� �� �������?
    teddy_endreg($eid,$elogin,$p); // ����� ������ ��������� �����������
}





function forgotpas_link($p) { $pa=substr($p['password'],0,7);
	return $GLOBALS['httphost']."login?a=restore&u=".$p['id']."&p=".urlencode($pa)."&h=".md5($p['id'].$GLOBALS['newhash_user'].$pa);
}

function forgotpas_send($p) { global $include_sys,$httphost,$unic,$hashlogin,$admin_name,$admin_mail,$IP,$BRO,$unic,$login,$openid,$realname;

    $o=''; foreach($p as $pp) {
	$pp=get_ISi($pp,"#{id}"); $name=$pp['imgicourl']; $link=h(forgotpas_link($pp));
	$o.="<p><b>".$name.":</b> <a href='".$link."'>$link</a>";
    }
	list($mail,)=var_confirmed($p[0]['mail']); if(!mail_validate($mail)) idie("�������� ������ ".h($mail));
	if($p[0]['realname']=='') $realname=$mail;
	$h=trim($httphost,'/');
	$s=mpers(get_sys_tmp("mail_restore_pass.htm"),array(
'httphost'=>$h,'admin_name'=>$admin_name,'links'=>$o,'mail'=>$mail,
'name'=>$p['realname'],'IP'=>$IP,'BRO'=>$BRO,'unic'=>$unic,'login'=>$login,'openid'=>$openid,'realname'=>$realname
));
	include_once $include_sys."_sendmail.php";
	if(1!=sendmail(h($admin_name),h($admin_mail),h($p['realname']),h($mail),h($h." - restore password"),$s)) idie("������ ��� �������� ����� �� <b>".h($mail));
        idie("�� email"
//."<b>".h($mail)."</b>"
." ������� ������ �� ������� ��� �������������� ��������",'�������������� ������'
// ."<blockquote style='border: 1px dashed rgb(255,0,0); padding: 20px; margin-left: 50px; margin-right: 50px; background-color: rgb(255,252,223);'>".$s."</blockquote>"
);
}

//------------------

if($a=='newpassword') {
    $u=RE0('u'); if(gettype(($p=check_change_pass($u,RE('p'),RE('h'))))!='array') return "idie(\"".njsn($p)."\")";
    if(($np=trim(RE('password')))=='') idie("������ �� ������ ���� ������!");
    $p=get_ISi($p); $js="zabilc('uname',\"".$p['imgicourl']."\"); zakryl('newpassform');";

    msq_update($GLOBALS['db_unic'],array('password'=>md5($np.$GLOBALS['hashlogin'])),"WHERE `id`='$u'");

	if($GLOBALS['unic']!=$u) { // ���� � ����� �������� �� ��� unic, �� ������� �� ���
		$up=$u.'-'.md5($u.$GLOBALS['newhash_user']);
        	$js.="up='$up'; fc_save('up',up); f5_save('up',up); c_save(uc,up,1); uname='#$u'; f5_save('uname',uname); salert('Login restore: '+uname,1000);";
		if(!empty($GLOBALS['xdomain'])) $js.="ux='".uxset($u)."'; c_save(ux_name,ux,1); zabilc('uname',uname); f5_save('uname',uname); ifhelpc(xdom+'&upx=".upx_set($u)."','xdomain','xdomain');";
	}
    return $js.="salert('Password changed succsessfully: <b>".h($np)."</b>',1500);
    setTimeout(\"document.location.href='".$GLOBALS['httphost']."';\",1500);";
}

//------------------

if($a=='forgotpas') {
    if(($log=trim(RE('log')))!='' &&
	false!==($p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `login`='".e($log)."'","_1",0))
    ) forgotpas_send(array($p));

    if(preg_match("/^\#\d+$/s",$log) &&
	false!==($p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `id`='".e(substr($log,1))."'","_1",0))
    ) forgotpas_send(array($p));

    if(($mail=trim(RE('mail')))=='') idie('������, ������� ������');

    if(!sizeof(($p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `mail`='".e('!'.$mail)."'","_a",0)))) {
	    if(!sizeof(($p=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `mail`='".e($mail)."'","_a",0))))
		idie('����� email �� ���������������, ��������.');
    }

// $p=ms("SELECT * FROM ".$GLOBALS['db_unic']." LIMIT 800","_a",0);
    forgotpas_send($p);
}

if($a=='logpas') { // ����������� �� ������ � ������
	$mylog=RE('log'); $mypas=RE('pas');
	if(preg_match("/[^0-9a-z\-\_\.\/\~\=\@]/si",$mylog)) idie("Wrong symbols in login");
	if(($p=ms("SELECT `id`,`password` FROM ".$GLOBALS['db_unic']." WHERE `login`='".e($mylog)."'","_1",0))===false
	) idie('User `'.h($mylog).'` not found!');

	if(md5($mypas.$GLOBALS['hashlogin']) != $p['password']) {
		// llog("error_LOGIN.PHP: log: `".h($mylog)."`, pas: `".h($mypas)."` (`".substr($p['password'],0,5)."[...]`) ");
		sleep(5); idie("wrong password");
	}
	if(getis_global($p['id'])===false) idie('Error #118');
	return reset_the_unic($GLOBALS['imgicourl'],$p['id']);
}


if($a=='logout') { // �������������
	$name="<input tiptitle='Login' value='anonymous' type='button' onclick=\"majax('login.php',{action:'do_login'})\">";
	return "if(confirm('Logout?')){".reset_the_unic($name,0)."}";
}

idie('LOGIN.php:'.h($a));

}
//===============================================================================

// 		sendm(\"setunc|".($u===false?'':"ux=".hl(uxset($u))."|")."uname=".hl(njsn($uname))."|\");

function check_change_pass($u,$p,$h) {
	if(!$u||false==($pp=ms("SELECT * FROM ".$GLOBALS['db_unic']." WHERE `id`='".$u."'","_1",0))) return "Error: unic #".$u;
	$pa=substr($pp['password'],0,7);
	if($pa!=$p) return "Error: password already changed";
        if($h!=md5($u.$GLOBALS['newhash_user'].$pa)) return "Error :)";
	return $pp;
}


//	$img=load_farimg($img,$GLOBALS['unic']); // ��������� ���� ��������
function load_farimg($url,$unic) { // ��������� ���� ��������
    $url=site_validate($url); if(empty($url)) return '';
    $s=fileget($url); if(empty($s)) return '';
    $img=imagecreatefromstring($s); if(!is_resource($img)) return ''; // �� ������� ���������
    $W=imagesx($img); $H=imagesy($img); $itype=2;
    $GLOBALS['foto_replace_resize']=1; require_once $GLOBALS['include_sys']."_fotolib.php";
    $imgs=obrajpeg_sam($img,150,$W,$H,$itype,''); imagedestroy($img);
    $ff="user/".$unic."/userpick.jpg";
    $f=rpath($GLOBALS['filehost'].$ff); testdir(dirname($f));
    closeimg($imgs,$f,$itype,95);
    if(!is_file($f)) return '';
    return $GLOBALS['httphost'].$ff;
}

?>