<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/_init.php");

switch ($jb_code)
{
	case "40" :
		$index_page = "page01.html";  	//진료상담
		break;
	case "60" :
		$index_page = "page03.html";  	//
		break;
	case "70" :
		$index_page = "page05.html";  	//감사편지
		break;
	default :
		$index_page = "page01.html";	// 
		break;
}
$query_page = "page01.php";

include $GP -> INC_PATH . "/board_insert.php";
?>