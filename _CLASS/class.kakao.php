<?
CLASS Kakao extends Dbconn
{
	private $DB;
	private $GP;
	function __construct($DB = array()) {
		global $C_DB, $GP;
		$this -> DB = (!empty($DB))? $DB : $C_DB;
		$this -> GP = $GP;
	}	
	
	
	// desc	 : 카카오 상담 답변
	// auth  : JH 2013-09-16 월요일
	// param
	function Kakao_Result($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			update
				tbl_kakao_realtime
			set
				tkk_result = '$tkk_result',
				tkk_result_date = '$tkk_result_date',
				tkk_result_con = '$tkk_result_con'
			where
				tkk_idx = '$tkk_idx'
			";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	// desc	 : 카카오 상담 상세
	// auth  : JH 2013-09-16 월요일
	// param
	function Kakao_Chk_List($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
	if($tkk_mobile){	
		
		$qry = "
			select * from tbl_kakao_realtime where tkk_mobile = '$tkk_mobile' order by tkk_idx desc limit 0,1
		";
		
	}else{
		$qry = "
			select * from tbl_kakao_realtime where tkk_id = '$tkk_id' order by tkk_idx desc limit 0,1
		";
		
		}
		$rst =  $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}
	
	
	// desc	 : 카카오 상담 상세
	// auth  : JH 2013-09-16 월요일
	// param
	function Kakao_Detail($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			select * from tbl_kakao_realtime where tkk_idx = '$tkk_idx'
		";
		$rst =  $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}
	
	// desc	 : 카카오 상담 삭제
	// auth  : JH 2013-09-16 월요일
	// param
	function Kakao_Del($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			update			
				tbl_kakao_realtime 
			set
				tkk_del_flag = 'Y'
			where 
				tkk_idx='$tkk_idx'
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	// desc	 : 카카오 상담 등록
	// auth  : JH 2013-09-16 월요일
	// param
	function Kakao_Reg($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			INSERT INTO
				tbl_kakao_realtime
				(
					tkk_idx,
					tkk_type,
					tkk_name,
					tkk_mobile,
					tkk_regdate,
					tkk_result,
					tkk_id,
					tkk_del_flag
				)
				VALUES
				(
					''
					, '$tkk_type'
					, '$tkk_name'
					, '$tkk_mobile'
					, NOW()
					, 'N'
					, '$tkk_id'
					, 'N'
				)
			";
		$rst =  $this -> DB -> execSqlInsert($qry);
		return $rst;
	}
	
	// desc	 : 카카오 상담 리스트
	// auth  : JH 2013-09-16 월요일
	// param
	function Kakao_List ($args = '') {
		global $C_Func;
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		global $C_ListClass;

		$tail = "";		
		$addQry = " 1=1 and TKR.tkk_del_flag = 'N' ";

		if (($s_date && $e_date) && ($s_date < $e_date)) {
			if ($addQry)
			$addQry .= " AND ";
			$addQry .= " TKR.tkk_regdate BETWEEN '$s_date 00:00:00' AND '$e_date 00:00:00'";
		}
		
		if ($search_key && $search_content) {
			if (!empty($addQry)) {
				$addQry .= " AND ";
				$addQry .= " $search_key LIKE ('%$search_content%')";
			}
		}

		$args['show_row'] = $show_row;
		$args['show_page'] = 5;
		$args['q_idx'] = "TKR.tkk_idx";
		$args['q_col'] = "*";
		$args['q_table'] = "tbl_kakao_realtime TKR LEFT OUTER JOIN tblMember M ON TKR.mb_code=M.mb_code";
		$args['q_where'] = $addQry;
		$args['q_order'] = "TKR.tkk_regdate desc";
		$args['q_group'] = "";

		$args['tail'] = "s_date=" . $s_date . "&e_date=" . $e_date ."&serach_key=" . $search_key . "&search_content=" . $search_cotent;
		$args['q_see'] = "";
		return $C_ListClass -> listInfo($args);
	}
	
	
}
?>