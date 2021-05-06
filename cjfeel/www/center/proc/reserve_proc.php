<?php
	include_once  '../../_init.php';
	include_once $GP -> CLS . 'class.online.php';
	$C_Online = new Online();


//error_reporting(E_ALL);
//ini_set("display_errors", 1);
	
	switch($_POST['mode']){
		
		
		case "TIME_CNT" :
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;	
			
			$args = '';
			$args['tor_rs_date'] = $date;
			$args['tor_rs_time'] = $tm;
			$rst = $C_Online->Time_Cnt_Rs($args);
			
			if($rst['cnt'] == 0) {
				echo "true";
				exit();				
			}else{
				echo "false";
				exit();				
			}
		break;
		
		case "ONLINE_RESERVE_REG":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;	
			
			 $now_date = date('Y-m-d H:i:s');
			
			include $GP -> INC_PATH .'/zmSpamFree/zmSpamFree.php';
			include $GP -> INC_PATH . "/xssFilter/HTML/Safe.php"; // xss filter을 include			

			//스팸방지
			if ( !zsfCheck( $_POST['zsfCode'] ) ) {
				$C_Func->put_msg_and_back("스팸차단코드가 틀렸습니다.");
				die;	
			}
			
			$args = "";
			$args['tor_mb_code'] 		= $mb_code;
			$args['tor_rs_date'] 		= $rs_date;
			$args['tor_rs_time'] 		= $rs_time . "시" . $rs_minute."분";
			$args['tor_rs_phone']		= $tor_rs_phone1."-".$tor_rs_phone2."-".$tor_rs_phone3;
			$args['tor_rs_name'] 		= $tor_rs_name;
			$args['tor_rs_exam']		= $tor_rs_exam;
			$args['tor_rs_doc']			= $tor_rs_doc;
			$args['tor_rs_content']			= $tor_rs_content;
			$args['tor_rs_gender']			= $tor_rs_gender;
			$args['tor_rs_birth']			= $tor_rs_birth;
		/*	$args['tor_rs_content'] = base64_decode($jb_content);
			
			
			$safe = new HTML_Safe; // xss filter 객체 생성
			$input = base64_decode($jb_content); 
			$output = $safe->parse($input); // html 태그를 필터링 하여 $output에 대입			
			$jb_content = $C_Func->enc_contents($output);			
			$args['contents'] = $jb_content;	
			*/
			
			$rst = $C_Online->Online_Reserve_Reg($args);
			
			if($rst) {
				
				//SMS문자발송 
				include_once($GP -> CLS."/class.sms.php");
				include_once($GP -> CLS."/class.api.php");
				$C_Sms 	= new Sms;
				$C_Api = new Api;
				
				
				$msg = $tor_rs_name."님의 진료 예약이 들어왔습니다.";
				
				
                //$send_mobile = "010-3202-4541,010-7128-0140,010-3212-3970,010-4523-9299";
                
			
				
				$send_num = "4";
				
				$args = '';
				$args['message'] 	= $msg;
				$args['rphone'] 	= $send_mobile;
				$args['sphone1'] 	= $GP -> SMS_HP1;
				$args['sphone2'] 	= $GP -> SMS_HP2;
				$args['sphone3'] 	= $GP -> SMS_HP3;
				$args['rdate'] 		= '';
				$args['rtime'] 		= '';
				$args['returnurl'] = '';
				$args['testflag'] = 'N';
				$args['destination'] = '';
				$args['repeatFlag'] = '';
				$args['repeatNum'] = '1';
				$args['repeatTime'] = '15';
				$args['send_num'] = $send_num;	
				
				$rst = $C_Api -> Api_Sms_Send($args);	
				
				
				//발송히스토리
				
				// $args['result'] = $rst;				
				// $args['ssa_idx'] = '9999';	
				
				// $year = date("Y");		//년
				// $table = "tblSmsSendList_". $year;	 //생성테이블명		
				// $ck_table = $C_Func->TableExists($table, $GP->DB_TABLE);	//테이블 존재여부		
				
				// if($ck_table)	{ //테이블이 존재하면 등록
				// 	$args['table'] = $table;
				// 	$rst = $C_Api -> SMS_Send_Insert($args);
				// }else{		
				// 	$args['table'] = $table;
				// 	$rst = $C_Api -> Creat_Sms_Table($args);
					
				// 	if($rst) {
				// 		$rst = $C_Api -> SMS_Send_Insert($args);
				// 	}
				// }	
				
				
				$C_Func->put_msg_and_go("예약 신청 완료 되었습니다.", "/member/reserve.html");
				exit();
			}else{
				$C_Func->put_msg_and_go("예약 신청에 실패하였습니다", "/");
				exit();
			}
		break;
	}
?>