<?php
function date_time_format($date, $format = 'us', $seperator = '-'){
	return dateTimeFormat($date, $format, $seperator);
}

function dateTimeFormat($date, $format = 'us', $seperator = '-') {
		$arr_month = Array ('All', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
		$arr_month_short = Array ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
		if (strlen ( $date ) > 10) {
			if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
				return '';
			} else {
				$hour = substr ( $date, 11, 2 );
				if ($hour > 11) {
					$ampm = "PM";
					$hour -= 12;
				} else {
					$ampm = "AM";
				}
				if ($hour == 0) {
					$hour = 12;
				}
				$hour = str_pad ( $hour, 2, "0", STR_PAD_LEFT );
				if (strtolower ( $format ) == 'us') {
					return $arr_month_short [substr ( $date, 5, 2 ) - 1] . ' ' . substr ( $date, 8, 2 ) . ', ' . substr ( $date, 0, 4 ) . '<br/>' . $hour . ':' . substr ( $date, 14, 2 ) . ' ' . $ampm;
				} else if (strtolower ( $format ) == 'eu') {
					return substr ( $date, 8, 2 ) . $seperator . substr ( $date, 5, 2 ) . $seperator . substr ( $date, 0, 4 ) . '<br/>' . $hour . ':' . substr ( $date, 14, 2 ) . ' ' . $ampm;
				}
			}
		} else {
			if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00' || trim($date)=='') {
				return '';
			} else {
				if (strtolower ( $format ) == 'us') {
					return $arr_month_short [substr ( $date, 5, 2 ) - 1] . ' ' . substr ( $date, 8, 2 ) . ', ' . substr ( $date, 0, 4 ) . '';
				} else if (strtolower ( $format ) == 'eu') {
					return substr ( $date, 8, 2 ) . $seperator . substr ( $date, 5, 2 ) . $seperator . substr ( $date, 0, 4 ) . ' ';
				}
			}
		}
	}
	

	 function nextDay($timeStamp) {//arg:date timestamp, return:next date timestamp 
 	if($timeStamp=='' || $timeStamp==0){
		$timeStamp=strtotime(date("Y-m-d"));
	}
	
	$timeStamp=strtotime("+1 Day",$timeStamp);
	return $timeStamp;

}

function previousDay($timeStamp) {//arg:date timestamp, return:previous date timestamp 
	if($timeStamp=='' || $timeStamp==0){
		$timeStamp=strtotime(date("Y-m-d"));
	}
	$timeStamp=strtotime("-1 Day",$timeStamp);
	return $timeStamp;
}

  
function nextWeek($timeStamp) {//arg:date timestamp, return:next week timestamp 
 	if($timeStamp=='' || $timeStamp==0){
		$timeStamp=strtotime(date("Y-m-d"));
	}
	
	$timeStamp=strtotime("+1 week",$timeStamp);
	return $timeStamp;

}

function previousWeek($timeStamp) {//arg:date timestamp, return:previous week timestamp 
	if($timeStamp=='' || $timeStamp==0){
		$timeStamp=strtotime(date("Y-m-d"));
	}
	$timeStamp=strtotime("-1 week",$timeStamp);
	return $timeStamp;
}

function getWeekStartDate($dateTimeStamp)//arg:current date timestamp, return:week start date timestamp 
{
	$tempWeekDay = date('l',$dateTimeStamp);
	$i = 0;
    $stDateStamp=$dateTimeStamp;
    while($tempWeekDay != "Monday") {
        $stDateStamp = strtotime("-".$i." day",$dateTimeStamp);
        $tempWeekDay=date("l",$stDateStamp);
       
        $i++;
    }
     return $stDateStamp;
}
function getWeekEndDate($dateTimeStamp)//arg:current date timestamp, return:week end date timestamp 
{
	 
	$tempWeekDay = date('l',$dateTimeStamp);
    $i = 0;
   	$enDateStamp=$dateTimeStamp;
    while($tempWeekDay != "Sunday") {
        $enDateStamp = strtotime("+".$i." day",$dateTimeStamp);
        $tempWeekDay=date("l",$enDateStamp);
   		
        $i++;
     }
	 return $enDateStamp;
}


function nextMonth($timeStamp) {//arg:date timestamp, return:next week timestamp 
 	if($timeStamp=='' || $timeStamp==0){
		$timeStamp=strtotime(date("Y-m-d"));
	}
	
	$timeStamp=strtotime("+1 month",$timeStamp);
	return $timeStamp;

}

function previousMonth($timeStamp) {//arg:date timestamp, return:previous week timestamp 
	if($timeStamp=='' || $timeStamp==0){
		$timeStamp=strtotime(date("Y-m-d"));
	}
	$timeStamp=strtotime("-1 month",$timeStamp);
	return $timeStamp;
}

	
	
	
	

?>