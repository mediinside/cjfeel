<?php
	include_once("../../../_init.php");
	include_once $GP -> CLS . 'class.online.php';
	$C_Online = new Online();

	switch($_POST['mode']){	
	
		case "ONLINE_RESERVE_SMS" :		
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			$args = "";
			$args['tor_idx'] = $tor_idx;
			$rst = $C_Online->Online_Reserve_Detail($args);   
	
			if($rst) {
				extract($rst);
				
				$arr_date = explode('-',$tor_rs_date);
				$arr_time = explode(':',$tor_rs_time);	
				
				$msg = $tor_rs_name . "님 " . $arr_date[0] . "년 " . $arr_date[1] . "월 " . $arr_date[2] ."일 " . $arr_time[0] . "시 " . $arr_time[1] ."분 진료예약확정 완료되었습니다";        
        
				//보낼 데이터
				$data = array(
				  'type' => 'send',
				  'msg' => $msg,    
				  'sm_to' => $tor_rs_phone,
				  'destination' => '',
				  'sm_from1' => $GP -> SMS_HP1,
				  'sm_from2' => $GP -> SMS_HP2,
				  'sm_from3' => $GP -> SMS_HP3,
				  'send_date' => '',
				  'send_time' => '',
				  'returnurl' => '',
				  'testflag' => 'N',			//Y:실방송 N:테스트발송
				  'repeatFlag' => '',
				  'repeatNum' => '1',
				  'repeatTime' => '15',			
				  'send_num' => '1',
				  'return_type' => 'json',			
				  'login_id' => $GP -> SMS_ID,			
				  'login_pwd' => $GP -> SMS_PWD	
				);		
				
				// Send a request to example.com 
				//$result = $C_Func->post_request('http://mediinside.co.kr/api/sms_api.php', $data); 
				
				if ($result['status'] == 'ok'){ 
				  $re_msg = $result['content'];			
				  $obj_result = json_decode($re_msg); 
							
					if($obj_result->msg == "true") {						
						$rst1= $C_Online->Online_Reserve_SMS($args); 
					}
				  
				  $arr = array('msg'=> $obj_result->msg, 'error' => $obj_result->error);
				  echo json_encode($arr);
				  exit();			
				} else { 
				  $arr = array('msg'=>'false', 'error' => $result['error']);
				  echo json_encode($arr);
				  exit();			
				} 
			}
		break;
		
		//온라인 예약처리
		case "ONLINE_RESERVE_MODI":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			include $GP -> INC_PATH . "/xssFilter/HTML/Safe.php"; // xss filter을 include
			
			$arg = "";
			$args['tor_idx'] 				= $tor_idx;
			$args['tor_rs_clinic'] 				= $tor_rs_clinic;
			$args['tor_rs_doc'] 				= $tor_rs_doc;
			$args['tor_rs_type'] 			= $tor_rs_type;
			$args['tor_rs_result_date'] 		= $tor_rs_result_date;	
			$args['tor_rs_result_content'] = base64_decode($tor_rs_result_content);
			
			$rst = $C_Online -> Online_Reserve_Result($args);			

			$C_Func->put_msg_and_modalclose("처리 되었습니다");		
			exit();
		break;
		
		//온라인 예약삭제
		case "ONLINE_RESERVE_DEL" :
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			$args = "";
			$args['tor_idx'] = $tor_idx;
			$rst = $C_Online -> Online_Reserve_Del($args);
			
			echo "true";
			exit();
		break;
		
	}
?>