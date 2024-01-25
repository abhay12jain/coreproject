<?php
/*function neat_trim($str, $n, $delim='...') {
   $len = strlen($str);
   if ($len > $n) {
       preg_match('/(.{'.$n.'}.*?)\b/', $str, $matches);
       return rtrim($matches[1]) . $delim;
   }
   else {
       return $str;
   }
}*/


function neat_trim($string, $limit, $break=" ", $pad="...") {
	if (strlen ( $string ) <= $limit)
		return $string;
	
	$string = substr ( $string, 0, $limit );
	if (false !== ($breakpoint = strrpos ( $string, $break ))) {
		$string = substr ( $string, 0, $breakpoint );
	}
	
	return $string . $pad;
}

?>