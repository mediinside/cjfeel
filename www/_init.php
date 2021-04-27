<?php
session_start();
// default include path
$_DEF_PATH = str_replace('\\', '/', dirname(__FILE__));
$_DEF_PATH = explode('/',$_DEF_PATH);
array_pop($_DEF_PATH);
$_DEF_PATH = implode('/',$_DEF_PATH);
include_once  $_DEF_PATH . '/_INC/config.inc';
include_once $GP -> CLS . 'class.func.php';
include_once $GP -> CLS . 'class.button.php';
$C_Func = new Func();
$C_Button = new Button();
include_once $GP -> CLS . 'class.dbconn.php';
$C_DB = new Dbconn($GP -> DB);


$mobile_agent = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/';		
		
$mobile_ck = 0;	
$ssl_url = $GP -> HTTPS . ":" . $GP -> HTTPS_PORT;
$sc_url = $GP -> SERVICE_DOMAIN;
if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
	$mobile_ck = 1;
	$ssl_url = "";
	$sc_url = "";
}


?>