<?php
function formateQueryString($arr, $arrskip = array()) {
	//$varConcatStr = "?";		$i = 0;
	foreach ( $arr as $key => $value ) {
		if (in_array ( "$key", $arrskip )) {
			continue;
		}
		if (preg_match ( '/btn/i', "$key" )) {
			continue;
		}
		if ($value == '') {
			continue;
		}
		$varConcatStr .= "&$key=$value";
		$i = 1;
	} //end of outer foreach 
	return $varConcatStr;
}

function close_html_tags($input) {
    $opened = array();

    // loop through opened and closed tags in order
    if(preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
      foreach($matches[1] as $tag) {
        if(preg_match("/^[a-z]+$/i", $tag, $regs)) {
          // a tag has been opened
          if(strtolower($regs[0]) != 'br') $opened[] = $regs[0];
        } elseif(preg_match("/^\/([a-z]+)$/i", $tag, $regs)) {
          // a tag has been closed
          unset($opened[array_pop(array_keys($opened, $regs[1]))]);
        }
      }
    }

    // close tags that are still open
    if($opened) {
      $tagstoclose = array_reverse($opened);
      foreach($tagstoclose as $tag) $input .= "</$tag>";
    }

    return $input;
}


function sendRedirect($url){
	header('location:'.$url);
	die;
}

?>