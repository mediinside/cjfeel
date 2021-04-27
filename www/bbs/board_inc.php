<?php
include_once($GP -> CLS."class.jhboard.php");
include_once($GP -> CLS."class.list.php");
$C_JHBoard = new JHBoard();
$C_ListClass 	= new ListClass();

$key="";
$value="";
//magic_quotes_gpc 설정이 ON이 아닐경우만 addslashes 처리
//extract()는 반복적으로 변수를 가공하기에 적합하지 않아서 사용안함
if(__MAGIC_QUOTES_GPC__ != 1) {
	foreach($_GET as $key => $value) { $$key=stripslashes(trim($value)); }
	foreach($_POST as $key => $value)	{ $$key=stripslashes(trim($value));}
} else {
	foreach($_GET as $key => $value) { $$key=trim($value); }	
	foreach($_POST as $key => $value) {	$$key=trim($value);	}
}
unset($key, $value);

# 게시판설정정보...
include $GP -> INC_PATH . "/board_config.php";


# 검색키워드 설정
//$search_key['jb_name'] = $_GET['search_key']['jb_name'];
//$search_key['jb_title'] = $_GET['search_key']['jb_title'];
//$search_key['jb_content'] = $_GET['search_key']['jb_content'];
//$search_key="search_key[jb_name]=${search_key[jb_name]}&search_key[jb_title]=$search_key[jb_title]&search_key[jb_content]=$search_key[jb_content]";
$search_key = "search_key=" . $_GET['search_key'];


//게시판 제어 모듈
switch($jb_mode) {
	
	#  읽기와 글 리스트
	case("tlist") :
		include $GP -> INC_PATH . "/action/default.inc.php";		
		break;


	# 글쓰기
	case("twrite") :
		include $GP -> INC_PATH . "/action/twrite.inc.php";		
		include $GP -> INC_PATH . "/$skin_dir/board_write.php"; //입력폼 스킨...		
		break;


	# 수정
	case("tmodify") :
	
		//회원 또는 관리자의 경우 비밀번호
		if(isset($check_id) && empty($input_passd)) {
			$args = '';
			$args['jb_code'] = $jb_code;
			$args['jb_idx'] = $jb_idx;			
			$args['check_level'] = $check_level;
			$args['check_id'] = $check_id;
			$rst = $C_JHBoard->Board_Detail($args);
			$input_passd = $rst['jb_password'];
		}	
	
		if(empty($input_passd)) //비밀번호 입력 체크
		{
			$get_par = "${index_page}?jb_code=${jb_code}&jb_idx=${jb_idx}";
			$get_par .= "&search_key=${search_key}&search_keyword=${search_keyword}&page=${page}&jb_mode=tmodify";
			
			//$C_Func->put_msg_and_back("수정 권한이 없습니다.");					
			//die;
			include $GP -> INC_PATH . "/${skin_dir}/input_passd.php"; //비밀번호 입력폼 스킨...
		}
		else
		{		
			include $GP -> INC_PATH . "/action/tmodify.inc.php";
			include $GP -> INC_PATH . "/$skin_dir/board_modify.php"; //수정폼 스킨...
		}
		break;


	# 답글
	case("treply") :

		include $GP -> INC_PATH . "/action/treply.inc.php";
		include $GP -> INC_PATH . "/$skin_dir/board_reply.php"; //답변폼 스킨...
		break;


	# 해당글 삭제시 비밀번호입력폼
	case("tdelete") :			
	
		//회원 또는 관리자의 경우 비밀번호
		if(isset($check_id) && empty($input_passd)) {
			$args = '';
			$args['jb_code'] = $jb_code;
			$args['jb_idx'] = $jb_idx;			
			$args['check_level'] = $check_level;
			$args['check_id'] = $check_id;
			$rst = $C_JHBoard->Board_Detail($args);
			$input_passd = $rst['jb_password'];
		}
		
		$get_par = "${query_page}?jb_code=${jb_code}&jb_idx=${jb_idx}";
		$get_par .= "&${search_key}&search_keyword=${search_keyword}&page=${page}&jb_mode=tdelete";


//echo $get_par;

		if(empty($input_passd)) //비밀번호 입력 체크
		{
			//$C_Func->put_msg_and_back("삭제 권한이 없습니다.");					
			//die;
			include $GP -> INC_PATH . "/${skin_dir}/input_passd.php"; //비밀번호 입력폼 스킨...
		}
		else
		{
			$get_par.="&input_passd=${input_passd}";
			
			//게시물 삭제 페이지로 이동			
			echo ("	<script language='javascript'>
							if(confirm('해당게시물과 관련된 모든정보가 삭제됩니다.\\n\\n삭제하시겠습니까?'))\n
								document.location.href = '${get_par}';\n
							else\n
								history.go(-1);\n
						</script>\n
			");
		}
		break;


	# 비밀글열람시 비밀번호 입력폼
	case("tsecret") :		

		$get_par = "${index_page}?jb_code=${jb_code}&jb_idx=${jb_idx}";
		$get_par.= "&search_key=${search_key}&search_keyword=${search_keyword}&page=${page}";
		if($jb_code == '20') {
			$C_Func->put_msg_top_go_url("로그인후 이용가능합니다","/member/login.html?reurl=/info/info07.html");
		}else{
			include $GP -> INC_PATH . "/${skin_dir}/input_passd.php"; //비밀번호 입력폼 스킨...
		}
		break;


	# 댓글삭제시 비밀번호입력폼
	case("comment_delete") :
	
		//회원 또는 관리자의 경우 비밀번호
		if(isset($check_id) && empty($input_passd)) {
			$args = '';
			$args['jb_code'] = $jb_code;
			$args['jb_idx'] = $jb_idx;
			$args['jbc_idx'] = $jbc_idx;
			$args['check_level'] = $check_level;
			$args['check_id'] = $check_id;
			$rst = $C_JHBoard->Board_Comment_Detail($args);
			$input_passd = $rst['jbc_password'];
		}
	
		$get_par = "${query_page}?jb_code=${jb_code}&jb_idx=${jb_idx}&jbc_idx=${jbc_idx}";
		$get_par .= "&search_key=${search_key}&search_keyword=${search_keyword}&page=${page}&jb_mode=comment_delete";
		
		if(empty($input_passd)) { //비밀번호 입력 체크
			//$C_Func->put_msg_and_back("삭제 권한이 없습니다.");					
			//die;
			include $GP -> INC_PATH . "/${skin_dir}/input_passd.php"; //비밀번호 입력폼 스킨...			
		} else {
			$get_par.="&input_passd=${input_passd}";
			
			//게시물 삭제 페이지로 이동			
			echo ("	<script language='javascript'>
							if(confirm('해당코멘트와 관련된 모든정보가 삭제됩니다.\\n\\n삭제하시겠습니까?'))\n
								document.location.href = '${get_par}';\n
							else\n
								history.go(-1);\n
						</script>\n
			");
		}
		break;


	# Default(글 읽기와 글 리스트)
	default :
		include $GP -> INC_PATH . "/action/default.inc.php";
}
?>