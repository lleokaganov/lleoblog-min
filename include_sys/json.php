<?php // ������ ����� JSON ��� � ��� �������� ����� ������

/*
function uXXX($t) {
return "|".iconv("utf-8","windows-1251//IGNORE",chr("0x".$t[1]))."|";
$s=chr(base_convert(substr($t[1],0,2),16,10)).chr(base_convert(substr($t[1],2),16,10));
return iconv("utf-8","windows-1251//IGNORE","|$s|");
return iconv("utf-8","windows-1251//IGNORE",chr(base_convert($t[1],16,10)));
}
*/

function jdecoder($json_str){ $cyr_chars = array (
         '\u0430' => '�', '\u0410' => '�',
         '\u0431' => '�', '\u0411' => '�',
         '\u0432' => '�', '\u0412' => '�',
         '\u0433' => '�', '\u0413' => '�',
         '\u0434' => '�', '\u0414' => '�',
         '\u0435' => '�', '\u0415' => '�',
         '\u0451' => '�', '\u0401' => '�',
         '\u0436' => '�', '\u0416' => '�',
         '\u0437' => '�', '\u0417' => '�',
         '\u0438' => '�', '\u0418' => '�',
         '\u0439' => '�', '\u0419' => '�',
         '\u043a' => '�', '\u041a' => '�',
         '\u043b' => '�', '\u041b' => '�',
         '\u043c' => '�', '\u041c' => '�',
         '\u043d' => '�', '\u041d' => '�',
         '\u043e' => '�', '\u041e' => '�',
         '\u043f' => '�', '\u041f' => '�',
         '\u0440' => '�', '\u0420' => '�',
         '\u0441' => '�', '\u0421' => '�',
         '\u0442' => '�', '\u0422' => '�',
         '\u0443' => '�', '\u0423' => '�',
         '\u0444' => '�', '\u0424' => '�',
         '\u0445' => '�', '\u0425' => '�',
         '\u0446' => '�', '\u0426' => '�',
         '\u0447' => '�', '\u0427' => '�',
         '\u0448' => '�', '\u0428' => '�',
         '\u0449' => '�', '\u0429' => '�',
         '\u044a' => '�', '\u042a' => '�',
         '\u044b' => '�', '\u042b' => '�',
         '\u044c' => '�', '\u042c' => '�',
         '\u044d' => '�', '\u042d' => '�',
         '\u044e' => '�', '\u042e' => '�',
         '\u044f' => '�', '\u042f' => '�',
         '\r' => '',
//         '\n' => '<br />',
         '\t' => ''
     );

     foreach ($cyr_chars as $key => $value) {
         $json_str = str_replace($key, $value, $json_str);
     }
     return $json_str;
}

function jsonDecode($json) {
	$json = str_replace('\\/','/',$json);
	$json = jdecoder($json);
	$json = str_replace(array("\\\\", "\\\""), array("&#92;", "&#34;"), $json);


      $parts = preg_split("@(\"[^\"]*\")|([\[\]\{\},:])|\s@is", $json, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);


//return $parts;
      foreach($parts as $i=>$part) {
          if(strlen($part) == 1) {
              switch ($part) {
                  case "[": case "{": $parts[$i] = "array("; break;
                  case "]": case "}": $parts[$i] = ")"; break;
                  case ":": $parts[$i] = "=>"; break;   
                  case ",": break;
                  default: return false; //array('e'=>$part);
              }
          }
          else {
		if($part=="null") $parts[$i] = "\"\"";
		else if((substr($part,0,1) != '"') || (substr($part,-1,1) != '"')) $parts[$i]='"'.trim($parts[$i]).'"';
	}
//return null;
      }

      $json = str_replace(array("&#92;", "&#34;", "$"), array("\\\\", "\\\"", "\\$"), implode("", $parts));

//return array('dd'=>$json);
      return eval("return $json;");
}
?>