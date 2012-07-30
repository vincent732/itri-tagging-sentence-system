<?php

function fullToHalf($str, $encode='Big5') {
	if ($encode != 'UTF8') {
		$str = mb_convert_encoding($str, 'UTF-8', $encode);
	}
	$ret='';
	for ($i=0; $i < strlen($str); $i++) {
 
		$s1 = $str[$i];
 
		// 判斷 $c 第八位是否為 1 (漢字）
		if( ($c=ord($s1)) & 0x80 ) { 
			$s2 = $str[++$i];
			$s3 = $str[++$i];
			$c = (($c & 0xF) << 12) | ((ord($s2) & 0x3F) << 6) | (ord($s3) & 0x3F);
 
			if ($c == 12288) {
				$ret .= ' ';
			} elseif ($c > 65280 && $c < 65375) {
				$c -= 65248;
				$ret .= chr($c);
			} else {
				$ret .= $s1 . $s2 . $s3;
			}
 
		} else {
			$ret .= $str[$i];
		}
	}
 
	return ($encode== 'UTF-8' ? $ret : mb_convert_encoding($ret, $encode, 'UTF-8'));
 
}
?>