<?php
	include_once("../../../_init.php");
	include_once $GP -> CLS . 'class.kakao.php';
	$C_Kakao = new Kakao();

	switch($_POST['mode']){		
		
		//카카오 상담 삭제
		case "Kakao_DEL":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			$args = "";
			$args['tkk_idx'] = $tkk_idx;
			$rst = $C_Kakao -> Kakao_Del($args);
			
			echo "true";
			exit();
		break;
		
		//온라인 상담 처리
		case "KAKAO_MODI":
			if (is_array($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;				
			
			include $GP -> INC_PATH . "/xssFilter/HTML/Safe.php"; // xss filter을 include
			
			$arg = "";
			$args['tkk_idx'] 				= $tkk_idx;
			$args['tkk_result'] 			= $tkk_result;
			$args['tkk_result_date'] 		= $tkk_result_date;		
			
			$safe = new HTML_Safe; // xss filter 객체 생성
			$input = base64_decode($tkk_result_con); 
			$output = $safe->parse($input); // html 태그를 필터링 하여 $output에 대입			
			$tkk_result_con = $C_Func->enc_contents($output);			
			$args['tkk_result_con'] = $tkk_result_con;
			$rst = $C_Kakao -> Kakao_Result($args);		

			$C_Func->put_msg_and_modalclose("처리 되었습니다");		
			exit();
		break;
	}
	
?>