<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function readableDate($strDate, $showDateFormat) {
	
	if((!empty($strDate)) && ($strDate != '0000-00-00')) {
		return date($showDateFormat, strDateToStamp($strDate));
	} else { 
		return "-";
	}
	
}

function getUserIP() {
	
	if(!empty($_SERVER["HTTP_CF_CONNECTING_IP"])) {	# CHECK IP FROM CLOUDFLARE
		$strIP = $_SERVER["HTTP_CF_CONNECTING_IP"];
	} elseif ((!empty($_SERVER['HTTP_CLIENT_IP'])) && ($_SERVER['HTTP_CLIENT_IP'] != 'unknown')) {  # CHECK IP FROM SHARED INTERNET
		$strIP = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ((!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) && ($_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown')) {  # CHECK IP PASS FROM PROXY
		$strIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$strIP = $_SERVER['REMOTE_ADDR'];
	}
	
	return $strIP;
}

?>
