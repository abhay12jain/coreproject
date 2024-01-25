<?php
class Core {

	function __construct() {

		$arrMonthShort = Array (
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		);
		 $arrMonthFull = Array (
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		);
		 $arr_month_full = Array (
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December'
		);
		 $_GET;
		 $varGet;

		
	}
	
	

	function standardRedirect($rdrctFile) {
		header("Location:$rdrctFile");
		exit ();
	}

	function skipArray($arr, $arrSkip) {
		$arrResult = array ();
		$arrResult = array_diff($arr, $arrSkip);
		return $arrResult;
	}

	function getRefineArray(& $argArray) {
		$arrRefined = array ();
		for ($i = 0; $i < count($argArray); $i++) {
			$varElement = trim($argArray[$i]);
			if ($varElement == "") {
				continue;
			} else {
				$arrRefined[count($arrRefined)] = $varElement;
			}
		}
		return $arrRefined;
	}

	function removeFrm($varFrm) {
		$strFrm = substr($varFrm, 3);
		return $strFrm;
	}

	function sortQryStr($arr, $skip1 = '', $skip2 = '') {
		//$varConcatStr = "?";
		$i = 0;
		if ($arr) {
			foreach ($arr as $key => $value) {
				if ($value == $skip1 || $value == $skip2) {
					continue;
				}
				$varConcatStr .= "&amp;$key=$value";
				$i = 1;
			} //end of outer foreach 
		}
		return $varConcatStr;
	}

	function getFrmQryStr($arr, $arrskip = array ()) {
		//$varConcatStr = "?";
		$i = 0;
		foreach ($arr as $key => $value) {
			if (in_array("$key", $arrskip)) {
				continue;
			}
			if (preg_match('/btn/i', "$key")) {
				continue;
			}
			if ($value == '') {
				continue;
			}
			$varConcatStr .= "&amp;$key=$value";
			$i = 1;
		} //end of outer foreach 
		return $varConcatStr;
	}

	function qryStr($arr, $skip = '') {
		$varConcatStr = "?";
		$i = 0;
		foreach ($arr as $key => $value) {
			if ($key != $skip) {
				if (is_array($value)) {
					foreach ($value as $value2) {
						if ($i == 0) {
							$varConcatStr .= "$key%5B%5D=$value2";
							$i = 1;
						} else {
							$varConcatStr .= "&amp;$key%5B%5D=$value2";
						}
					} //end of inner foreach
				} else {
					if ($i == 0) {
						$varConcatStr .= "$key=$value";
						$i = 1;
					} else {
						$varConcatStr .= "&amp;$key=$value";
					}
				}
			}
		} //end of outer foreach 
		return $varConcatStr;
	}

	function getQryStr($arrOverWriteKey = array (), $arrOverWriteValue = array ()) {
		$varGet = $_GET;
		if (is_array($arrOverWriteKey)) {
			$i = 0;
			foreach ($arrOverWriteKey as $key) {
				$varGet[$key] = $arrOverWriteValue[$i];
				$i++;
			}
		} else {
			$varGet[$arrOverWriteKey] = $arrOverWriteValue;
		}
		$varQryStr = $this->qryStr($varGet);
		return $varQryStr;
	}
	function removePrefix($arrFrm, $argStringNum) {
		if (count($arrFrm) > 0) {
			foreach ($arrFrm as $keyFrm => $valFrm) {
				$arrKeyFrm = substr($keyFrm, $argStringNum);
				$arrValFrm[$arrKeyFrm] = $valFrm;
			}
		}
		return $arrValFrm;
	}

	function sendMail($argUserMail, $argfrom, $argSubject, $argMessage) {
		//set html header
		$headers = "MIME-Version: 1.0 \r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		$headers .= "From: " . $argfrom . " \r\n";
        
		return @ mail($argUserMail, $argSubject, $argMessage, $headers);
		
	}

	function setCurrencySign($argCurrency) {
		$arrCurrencySign = array (
			'USD' => '$',
			'NGN' => '<s>N</s>',
			'EURO' => '&#8364;',
			'POUND' => '&pound;'
		);
		return $arrCurrencySign[$argCurrency];
	}
	function setPriceFormat($argPrice, $argCurrency = 'USD') {
		$varPrice = number_format($argPrice, 2);
		return $this->setCurrencySign($argCurrency) . '' . $varPrice;
	}
	function getFileName($argPath) {
		$varFileName = substr(strrchr($_SERVER['HTTP_REFERER'], "/"), 1);
		return $varFileName;
	}
	function getCardNumber($argCardNumber, $argLength, $argCardType = '') {
		if ($argCardType == 'americanExpress') {
			$varCardNumberLast = substr($argCardNumber, $argLength);
			$varCardNumber = substr($argCardNumber, 0, $argLength);
			$varLenOfCardnumber = strlen($varCardNumber);
		} else {
			$varCardNumberLast = substr($argCardNumber, $argLength);
			$varCardNumber = substr($argCardNumber, 0, $argLength);
			$varLenOfCardnumber = strlen($varCardNumber);
		}
		for ($x = 1; $x <= $varLenOfCardnumber; $x++) {
			$varCardNumberStar .= "* ";
		}
		return $varCardNumberStar . "" . $varCardNumberLast;
	}

	function getDateFormat($argDate, $argFormat = 'us', $argSeperator = '-',$timeReq=true) {
		global $arrMonthShort;
		$arrMonth = Array (
			'All',
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		);
		$arrMonthShort = Array (
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		);
		if (strlen($argDate) > 10) {
			if ($argDate == '0000-00-00' || $argDate == '0000-00-00 00:00:00') {
				return 'N/A';
			} else {
				
				if($timeReq){
					$varHour = substr($argDate, 11, 2);
					if ($varHour > 11) {
						$varAmPm = "PM";
						$varHour -= 12;
					} else {
						$varAmPm = "AM";
					}
					if ($varHour == 0) {
						$varHour = 12;
					}
					$varHour = str_pad($varHour, 2, "0", STR_PAD_LEFT);
				}
				
				if (strtolower($argFormat) == 'us') {
					if($varHour){					
						return $arrMonthShort[substr($argDate, 5, 2) - 1] . ' ' . substr($argDate, 8, 2) . ', ' . substr($argDate, 0, 4) . ' ' . $varHour . ':' . substr($argDate, 14, 2) . ' ' . $varAmPm;
					}else{
						return $arrMonthShort[substr($argDate, 5, 2) - 1] . ' ' . substr($argDate, 8, 2) . ', ' . substr($argDate, 0, 4);
					
					}
				} else
					if (strtolower($argFormat) == 'eu') {
						if($varHour){
							return substr($argDate, 8, 2) . $argSeperator . substr($argDate, 5, 2) . $argSeperator . substr($argDate, 0, 4) . ' ' . $varHour . ':' . substr($argDate, 14, 2) . ' ' . $varAmPm;
						}else{
							return substr($argDate, 8, 2) . $argSeperator . substr($argDate, 5, 2) . $argSeperator . substr($argDate, 0, 4);
					
						}
					}
			}
		} 
	}
	function creditDateFormat($date, $displayLength = 'short', $format = 'us', $seperator = '-') {
		if ($displayLength == 'short') {
			$arrMonth = $this->arrMonthShort;
		} else {
			$arrMonth = $this->arrMonthFull;
		}
		if (strlen($date) >= 6) {
			if ($date == '0000-00') {
				return 'N/A';
			} else {
				if (strtolower($format) == 'us') {
					return $arrMonth[substr($date, 5, 2) - 1] . ', ' . substr($date, 0, 4);
				} else
					if (strtolower($format) == 'eu') {
						return substr($date, 5, 2) . $seperator . substr($date, 0, 4);
					}
			}
		} else {
			return $s;
		}
	}
	function setSuccessMsg($sessMsg) {
		if ($sessMsg == "") {
			$_SESSION['sessMsg'] = '';
		} else {
			$_SESSION['sessMsg'] = '<div class="success">' . $sessMsg . '</div>';
		}
	}
	function setErrorMsg($sessMsg) {
		if ($sessMsg == "") {
			$_SESSION['sessMsg'] = '';
		} else {
			$_SESSION['sessMsg'] = '<div class="error">' . $sessMsg . '</div>';
		}
	}
	function displaySessMsg() {
		return $_SESSION['sessMsg'];
	}
	//******************************************************//
	function setNewMsg($sesMsg) {
		if ($sesMsg == "") {
			$_SESSION['sesMsg'] = '';
		} else {
			$_SESSION['sesMsg'] = '<div class="success">' . $sesMsg . '</div>';
		}
	}
	function setChangeMsg($sesMsg) {
		if ($sesMsg == "") {
			$_SESSION['sesMsg'] = '';
		} else {
			$_SESSION['sesMsg'] = '<div class="error">' . $sesMsg . '</div>';
		}
	}
	function displaySesMsg() {
		return $_SESSION['sesMsg'];
	}
	
	//*************************************************
	
	
	
	function prepareStringValue($value) {
		$new_value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;
		$new_value = ($value != "") ? trim($value) : "";
		return $new_value;

	}
	function generateUniqueID() {
		return md5(uniqid(rand(), true));
	}
	function export_delimited_file($sql, $arr_columns, $file_name, $ext) {
		if ($ext == "csv")
			$sep = ",";
		else
			$sep = "\t";
		$fileName = $file_name . time() . "." . $ext;
		header("Content-type: application/txt");
		header("Content-disposition: attachment; filename=$fileName");
		header("Pragma: no-cache");
		header("Expires: 0");
		$finalHeader = '';
		$arr_headers = array ();
		$arr_headers = array_values($arr_columns);
		$num_cols = count($arr_columns);
		foreach ($arr_headers as $header) {
			echo $header . $sep;
		}
		$result = $this->executeQuery($sql);
		$i = 0;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "\r\n";
			$i++;
			echo $i . $sep;
			foreach ($line as $key => $value) {
				$value = str_replace("\n", "", $value);
				$value = str_replace("\r", "", $value);
				$value = str_replace($sep, "", $value);
				if (is_array($arr_substitutes[$key])) {
					$value = $arr_substitutes[$key][$value];
				}
				if (isset ($arr_tpls[$key])) {
					$code = str_replace('{1}', $value, $arr_tpls[$key]);
					eval ("\$value = $code;");
				}
				echo $value . $sep;
			}
		}
	}
	function getThumbImageName($argImageName) {
		//Get file extention	
		if ($argImageName != '') {
			$varExt = substr(strrchr($argImageName, "."), 1);
			$varImageFileName = substr($argImageName, 0, - (strlen($varExt) + 1));
			if ($varExt == 'jpeg') {
				$varExt = 'jpg';
			}
			//Create thumb file name
			$varImageNameThumb = $varImageFileName . '_thumb.' . $varExt;
		}
		return $varImageNameThumb;
	}
	function getMidImageName($argImageName) {
		//Get file extention	
		if ($argImageName != '') {
			$varExt = substr(strrchr($argImageName, "."), 1);
			$varImageFileName = substr($argImageName, 0, - (strlen($varExt) + 1));
			if ($varExt == 'jpeg') {
				$varExt = 'jpg';
			}
			//Create thumb file name
			$varImageNameThumb = $varImageFileName . '_mid.' . $varExt;
		}
		return $varImageNameThumb;
	}
	function executeQuery($sql) {
		return mysql_query($sql);
	}
	function datetime_format($date, $format = 'us', $seperator = '-') {
		global $arr_month_short;
		$arr_month = Array (
			'All',
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		);
		$arr_month_short = Array (
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		);
		if (strlen($date) > 10) {
			if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
				return 'N/A';
			} else {
				$hour = substr($date, 11, 2);
				if ($hour > 11) {
					$ampm = "PM";
					$hour -= 12;
				} else {
					$ampm = "AM";
				}
				if ($hour == 0) {
					$hour = 12;
				}
				$hour = str_pad($hour, 2, "0", STR_PAD_LEFT);
				if (strtolower($format) == 'us') {
					return $arr_month_short[substr($date, 5, 2) - 1] . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4) . ' ' . $hour . ':' . substr($date, 14, 2) . ' ' . $ampm;
				} else
					if (strtolower($format) == 'eu') {
						return substr($date, 8, 2) . $seperator . substr($date, 5, 2) . $seperator . substr($date, 0, 4) . ' ' . $hour . ':' . substr($date, 14, 2) . ' ' . $ampm;
					}
			}
		} else {
			if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
				return 'N/A';
			} else {
				if (strtolower($format) == 'us') {
					return $arr_month_short[substr($date, 5, 2) - 1] . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4) . '';
				} else
					if (strtolower($format) == 'eu') {
						return substr($date, 8, 2) . $seperator . substr($date, 5, 2) . $seperator . substr($date, 0, 4) . ' ';
					}
			}
		}
	}
	function getActiveInactiveImage($argStatus) {
		if ($argStatus == 'Active') {
			$arrImage['name'] = 'active.jpg';
			$arrImage['alt'] = 'Active';
		} else {
			$arrImage['name'] = 'deactive.jpg';
			$arrImage['alt'] = 'Inactive';
		}
		return $arrImage;
	}
	function getModelType($argStatus) {
		if ($argStatus == 'Model') {
			$arrModelImage['name'] = 'model.gif';
			$arrModelImage['alt'] = 'Model';
		} else {
			$arrModelImage['name'] = 'training.gif';
			$arrModelImage['alt'] = 'In Training';
		}
		return $arrModelImage;
	}
	function getDefaultLang() {
		if ($_COOKIE['cook_lang'] == '') {
			$varCookLang = 'english';
			setcookie('cook_lang', 'english', time() + 60 * 60 * 24 * 265);
		} else {
			$varCookLang = $_COOKIE['cook_lang'];
		}
		return $varCookLang;
	}
	function setDefaultLanguage($argArrPost) {
		$varCookLang = $argArrPost['Language'];
		setcookie('cook_lang', $varCookLang, time() + 60 * 60 * 24 * 265);
		if ($_COOKIE['cook_lang'] == '') {
			$varCookLang = 'english';
			setcookie('cook_lang', 'english', time() + 60 * 60 * 24 * 265);
		} else {
			$varCookLang = $_COOKIE['cook_lang'];
		}
		return $varCookLang;
	}
	function generateValidateString($varQryStr, $skip = '') {
		$varQryStr = str_replace('?&page', '?page', $varQryStr);
		$varQryStr = str_replace('&page', '&amp;page', $varQryStr);
		$varQryStr = str_replace('&', '&amp;', $varQryStr);
		$varQryStr = str_replace('&amp;amp;', '&amp;', $varQryStr);
		if (@ preg_match('^(&amp;|&)', $varQryStr)) {
			$varQryStr = @ preg_replace('(&amp;|&){1,}', '', $varQryStr);
		}
		if (trim($skip) != '') {
			$varQryStr = @ preg_replace('(' . $skip . ')=[0-9]{1,}(&amp;)|(' . $skip . ')=[0-9]{1,}(&)|(' . $skip . ')=[0-9]{1,}', '', $varQryStr);
			$varQryStr = @ preg_replace('(' . $skip . ')=[a-zA-Z_\.]{1,}(&amp;)|(' . $skip . ')=[a-zA-Z_\.]{1,}(&)|(' . $skip . ')=[a-zA-Z_\.]{1,}', '', $varQryStr);
			//$varQryStr = trim($varQryStr, '&amp;');
			$varQryStr = trim($varQryStr, '&');
		}
		//echo $varQryStr;
		return $varQryStr;
	}
	function addPrefix($arrFrm, $argPrefix = '') {
		if (count($arrFrm) > 0) {
			foreach ($arrFrm as $keyFrm => $valFrm) {
				$arrKeyFrm = $argPrefix . $keyFrm;
				$arrValFrm[$arrKeyFrm] = $valFrm;
			}
		}
		return $arrValFrm;
	}
	function replaceFromArrayKeys($arrPost, $argFind = '', $argReplace = '') {
		if ($arrPost) {
			foreach ($arrPost as $keyFrm => $valFrm) {
				if (!preg_match('/Skip/', $keyFrm)) {
					$arrKeyFrm = preg_replace("/$argFind/", "$argReplace", $keyFrm);
					$arrNewFrm[$arrKeyFrm] = $valFrm;
				}
			}
			return $arrNewFrm;
		} else {
			echo 'Supplied argument is not an Array';
			die();
		}
	}

	function formatString($str, $endEndex) {
		$str = trim($str);
		$strLen = strlen($str);
		if ($strLen > $endEndex) {
			$str = substr($str, 0, $endEndex);
			$flag = 0;
			$arrStr = explode(" ", $str);

			if (count($arrStr) >= $endEndex) {
				$arrStr = explode(",", $str);
				$flag = 1;
			}

			if (count($arrStr) > 1) {
				array_pop($arrStr);
				if ($flag == 1) {
					$str = implode(", ", $arrStr);
				} else {
					$str = implode(" ", $arrStr);
				}
				$str .= ' ...';
			}

		}
		return $str;
	}

	function eleminateExtraQueryString($varReques) {
		if (isset ($varReques['PHPSESSID'])) {
			unset ($varReques['PHPSESSID']);
		}
		if (isset ($varReques['__utmz'])) {

			unset ($varReques['__utmz']);
		}
		if (isset ($varReques['__utma'])) {
			unset ($varReques['__utma']);

		}
		if (isset ($varReques['__utmc'])) {
			unset ($varReques['__utmc']);

		}
		if (isset ($varReques['__utmb'])) {

			unset ($varReques['__utmb']);
		}
		if (isset ($varReques['celeb'])) {
			unset ($varReques['celeb']);

		}
		if (isset ($varReques['TinyMCE_mce_editor_0_width'])) {
			unset ($varReques['TinyMCE_mce_editor_0_width']);
		}
		if (isset ($varReques['TinyMCE_mce_editor_0_height'])) {
			unset ($varReques['TinyMCE_mce_editor_0_height']);
		}

		return $varReques;
	}

}
?>