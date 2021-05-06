<?php
	include_once("../../../_init.php");
	include_once($GP -> CLS."/class.reserve2.php");
	$C_Reserve2 	= new Reserve2;

	switch($_POST['mode']){		
		case "RESERVE_REG":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;	
			
			 $now_date = date('Y-m-d H:i:s');	
			
			$args = '';
			$args['tr_name']		= $tr_name;
			$args['tr_time']			= $tr_time;
			$args['tr_time2']			= $tr_time2;
			$args['tr_gubun']			= $tr_gubun;
			$args['tr_content']			= $tr_content;
			$args['tr_time']			= $tr_time;
			$args['tr_type']			= $tr_type;
			$args['tr_mobile']		= $tr_mobile1."-".$tr_mobile2."-".$tr_mobile3;

			

			$rst = $C_Reserve2 -> Reserve_Reg($args);

			if($rst) {
				
			
					
				
				$C_Func->put_msg_and_go("상담/예약 신청이 정상적으로 처리되었습니다. ", "/");
				exit();
			}else{
				$C_Func->put_msg_and_go("상담/예약 신청이 실패하였습니다", "/");
				exit();
			}
	break;
	
	
				case "RESERVE_REG2":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;	
			
			 $now_date = date('Y-m-d H:i:s');	
			
			$args = '';
			$args['tr_name']		= $tr_name;
			$args['tr_time']			= $tr_time;
			$args['tr_time2']			= $tr_time2;
			$args['tr_gubun']			= $tr_gubun;
			$args['tr_content']			= $tr_content;
			$args['tr_time']			= $tr_time;
			$args['tr_type']			= $tr_type;
			$args['tr_mobile']		= $tr_mobile1."-".$tr_mobile2."-".$tr_mobile3;

			

			$rst = $C_Reserve2 -> Reserve_Reg($args);

			if($rst) {
				
				
					
				
				$C_Func->put_msg_and_go("상담/예약 신청이 정상적으로 처리되었습니다. ", "/");
				exit();
			}else{
				$C_Func->put_msg_and_go("상담/예약 신청이 실패하였습니다", "/");
				exit();
			}
	break;
	
		
		
		//고객의 소리 삭제
		case "RESERVE_DEL":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			$args = "";
			$args['tr_idx'] = $tr_idx;
			$rst = $C_Reserve2 -> Reserve_Del($args);
			
			echo "true";
			exit();
		break;
		
		//고객의 소리 처리
		case "RESERVE_MODI":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			include $GP -> INC_PATH . "/xssFilter/HTML/Safe.php"; // xss filter을 include
			
			$arg = "";
			$args['tr_idx'] 				= $tr_idx;
			$args['tr_result'] 			= $tr_result;
			$args['tr_rt_date'] 		= $tr_rt_date;		
			
			$safe = new HTML_Safe; // xss filter 객체 생성
			$input = base64_decode($tr_result_con); 
			$output = $safe->parse($input); // html 태그를 필터링 하여 $output에 대입			
			$tr_result_con = $C_Func->enc_contents($output);			
			$args['tr_result_con'] = $tr_result_con;
			$rst = $C_Reserve2 -> Reserve_Result($args);		

			$C_Func->put_msg_and_modalclose("처리 되었습니다");		
			exit();
		break;
		
	case 'USER_DEL' :
		if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;
		
		$args = '';
		$args['arr_idx'] = $arr_idx;
		$rst = $C_Reserve2 -> Del_Real_Sel($args);
		
		echo "true";
		exit();
	break;	
	
	case 'tr_send' :
		if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;

		$args['tr_result'] 			= 'Y';

		
		$C_Func->put_msg_and_modalclose("처리 되었습니다");		
			exit();
	break;	

	}
?>