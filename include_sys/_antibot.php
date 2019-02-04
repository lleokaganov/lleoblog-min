<?php
/*
 * AntiBot - ����� ��� �������� ����������� ����������� ��������
 * ���������� � ������� ���������� ������� �����, ��� ����, ��� ��
 * ��������, ��� �� �������� ����, � �� ������� ���.
 * 
 * ������� GetPic �������� ���� ��������, ���������� � SID -
 * ���, �� �������� ����� ����� ��������� ������������
 * � ����������� �������������.
 *
 * ������� CheckCode($code) �������� ��������� ������������ �����
 * � ��������� - ���� ����� �������� �� ����� �����������
 * � � ���������� ����������� �������� �����, �� �� -
 * ����������� TRUE � aqk �������� ���������.
 * ���� ������������ FALSE.
 *
 * ������� ����� ������������ �������� aka ��zi������
 * 26-�� ������� 2004 ���� ��� ������� FlirtCenter.com
 *
 * � ����� ���������� LLeo
 * ��������� � ����� � ������� ������� �� ���� ��� ������� ��������� ����������������
 * � ��� ������� ��������� ������, ��� ��� ��� ����!
*/

function antibot_make($antibot_C=0) { global $antibot_pic, $antibot_H, $antibot_W, $antibot_add2hash, $antibot_file, $antibot_hash;
	if(!$antibot_C) $antibot_C=$GLOBALS['antibot_C'];

	// ���� ��� GD - ��� ���, � �� �����
	if(!function_exists('imagecreatefromjpeg')) return '';

	$bgs=glob($antibot_pic."bg-*"); $um=imagecreatefromjpeg($bgs[rand(0,count($bgs)-1)]); // ����� ��������� ��������
	$iml=$antibot_C*(imagesx($um)/5); $im=imagecreate($iml,imagesy($um));
	for($x=0;$x<$iml;$x+=imagesx($um)) imagecopy($im,$um,$x,0,0,0,imagesx($um),imagesy($um));

	$h = round((imagesy($im)-$antibot_H)/2); // ������� ������
	$w = round(imagesx($im)/$antibot_C); // ������� ������

	// ��������� ������ �������� � ���������� �� �� �������
	$path=$antibot_pic."sum_"; $lpath=strlen($path); 
// $files=glob($path."*.png");
$files=glob($path."*.gif");
$n=count($files)-1; // ������, ����� ������� ����
	$imS=array(); $sums=''; for($i=0; $i<$antibot_C; $i++) {
		$f=$files[rand(0,$n)]; // �������� ��������� ���������� ����
		$l=substr($f,$lpath,1); // ��������, ��� ��� �� ������
		

		if(!isset($imS[$l])) 
// $imS[$l]=imagecreatefrompng($f); // ���� �� ���� - ���������� ��� ��������
$imS[$l]=imagecreatefromgif($f); // ���� �� ���� - ���������� ��� ��������
		if($imS[$l]===false) idie("Error antibot imagecreatefrompng(`".$f."`)".(!is_file($f)?' file not found!':' unknown error'));
		imagecopymerge($im,$imS[$l],($w*$i)+rand(0,$w-$antibot_W),rand(2,$h*2-2),0,0,18,20,40); // ����������� �� �������
		$sums.=$l; // �������� ������ � ������
	}

// dier($imM);

// �������������� ���������� - ������ ���������
//	$color = ImageColorAllocate($im, 200, 200, 200);
//	for($i=0; $i<=round(ImageSX($im)/7); $i++) { $x = $i*7; ImageLine($im, $x, 0, $x-ImageSY($im), ImageSY($im), $color); }

//	// �������������� ���������� - �����������
	$imT=imagecreate(1,1); imagefill($imT,1,1,imagecolorallocate($imT,0,0,0));
	// ��������� �� ����������� � ���������
	$t=rand(4,15); for($i=round(imagesy($im)/$t);$i>=0;$i--) imagecopymerge($im,$imT,0,$i*$t,0,0,imagesx($im),1,20);
	$t=rand(4,15); for($i=round(imagesx($im)/$t);$i>=0;$i--) imagecopymerge($im,$imT,$i*$t,0,0,0,1,imagesy($im),20);

	$antibot_hash = md5($sums.$antibot_add2hash);

	$nam=$antibot_file.$antibot_hash.".jpg";
	if(!imagejpeg($im,$nam)) { // ��������� ��������
		testdir($GLOBALS['antibot_file']); if(!imagejpeg($im,$nam)) // ��������� �������� �����
		idie("������! �� ���� ��������� �������� � ���������� \"".$antibot_file."\", ���������, ������� �� ���, � ����������� �� ����� ������?");
	} filechmod($nam);

	$GLOBALS['antibot_imW'] = imagesx($im);
	$GLOBALS['antibot_imH'] = imagesy($im);
	imagedestroy($im);
	return $antibot_hash;
}

/* �������� �������� - ��������� �� ��� � ����� � ���� �� ����� �������� */
function antibot_check($code, $hash) {
	// ���� ��� GD - ��� ���, � �� �����
	if(!function_exists('imagecreatefromjpeg')) return true;

	$code = preg_replace("/[^0-9a-z]/si","",$code); // ������ ����������� �������, ����� ���� (� ����)
	$hash2=md5($code.$GLOBALS['antibot_add2hash']);
	$f = $GLOBALS['antibot_file'].$hash2.".jpg";
	if($hash==$hash2 and is_file($f)) { unlink($f); return true; }
	if(is_file($f)) unlink($f); return false;
}

/* �������� ������� ���������� HTML ��� ������ ��� �������� ��������. <img src="URL" width=WIDTH height=HEIGHT border=0> */
function antibot_img() {
return "<img src='".$GLOBALS['antibot_www'].$GLOBALS['antibot_hash'].".jpg' width=".$GLOBALS['antibot_imW']." height=".$GLOBALS['antibot_imH']." alt='captcha' border=0>";
}

/* ������� ������ ��������, ������� ���� ������� ����� ���� �����. */
function antibot_del() { $old = time()-$GLOBALS['antibot_deltime']; $deleted = 0;
	$p=glob($GLOBALS['antibot_file']."*.jpg"); if($p===false or !sizeof($p)) return "����������� �������� ���";
	foreach($p as $f) if(filemtime($f)<$old) { unlink($f); $deleted++; }
	return "����������� ��������, �������: ".$deleted;
}

?>