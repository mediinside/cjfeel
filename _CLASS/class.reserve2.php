<?
CLASS Reserve2 extends Dbconn
{
	private $DB;
	private $GP;
	function __construct($DB = array()) {
		global $C_DB, $GP;
		$this -> DB = (!empty($DB))? $DB : $C_DB;
		$this -> GP = $GP;
	}

	// desc	 : 퀵상담 등록
	// auth  : JH 2013-09-16 월요일
	// param
	function Reserve_Reg($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$qry = "
			INSERT INTO
				tblReserve
				(
					tr_idx,
					tr_name,
					tr_mobile,
					tr_reg_date,
					tr_gubun,
					tr_time,
					tr_time2,
					tr_content,
					tr_type
				)
				VALUES
				(
					''
					, '$tr_name'
					, '$tr_mobile'
					, NOW()
					, '$tr_gubun'
					, '$tr_time'
					, '$tr_time2'
					, '$tr_content'
					, '$tr_type'
				)
			";
		$rst =  $this -> DB -> execSqlInsert($qry);
		return $rst;
	}


	// desc	 : 퀵상담
	// auth  : JH 2013-09-16 월요일
	// param
	function Reserve_Chk_List($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			select * from tblReserve where tr_mobile = '$tr_mobile' order by tr_idx desc limit 0,1
		";
		$rst =  $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}



	// desc	 : 퀵상담 리스트
	// auth  : JH 2013-09-16 월요일
	// param
	function Reserve_List ($args = '') {
		global $C_Func;
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		global $C_ListClass;

		$tail = "";		
		$addQry = " tr_type ='Q' ";


		if (($s_date && $e_date) && ($s_date < $e_date)) {
			if ($addQry)
			$addQry .= " AND ";
			$addQry .= " tr_reg_date BETWEEN '$s_date 00:00:00' AND '$e_date 00:00:00'";
		}
		
		if ($search_key && $search_content) {
			if (!empty($addQry)) {
				$addQry .= " AND ";
				$addQry .= " $search_key LIKE ('%$search_content%')";
			}
		}

		$args['show_row'] = $show_row;
		$args['show_page'] = 5;
		$args['q_idx'] = "tr_idx";
		$args['q_col'] = "*";
		$args['q_table'] = "tblReserve ";
		$args['q_where'] = $addQry;
		$args['q_order'] = "tr_reg_date desc";
		$args['q_group'] = "";

		$args['tail'] = "s_date=" . $s_date . "&e_date=" . $e_date ."&serach_key=" . $search_key . "&search_content=" . $search_cotent;
		$args['q_see'] = "";
		return $C_ListClass -> listInfo($args);
	}

	function Reserve_Detail($args) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			select * from tblReserve where tr_idx = '$tr_idx'
		";
		$rst =  $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}
	
	
	
	
	// desc	 : 퀵상담 리스트
	// auth  : JH 2013-09-16 월요일
	// param
	function Reserve_List2 ($args = '') {
		global $C_Func;
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		global $C_ListClass;

		$tail = "";		
		$addQry = " tr_type ='C' ";


		if (($s_date && $e_date) && ($s_date < $e_date)) {
			if ($addQry)
			$addQry .= " AND ";
			$addQry .= " tr_reg_date BETWEEN '$s_date 00:00:00' AND '$e_date 00:00:00'";
		}
		
		if ($search_key && $search_content) {
			if (!empty($addQry)) {
				$addQry .= " AND ";
				$addQry .= " $search_key LIKE ('%$search_content%')";
			}
		}

		$args['show_row'] = $show_row;
		$args['show_page'] = 5;
		$args['q_idx'] = "tr_idx";
		$args['q_col'] = "*";
		$args['q_table'] = "tblReserve ";
		$args['q_where'] = $addQry;
		$args['q_order'] = "tr_reg_date desc";
		$args['q_group'] = "";

		$args['tail'] = "s_date=" . $s_date . "&e_date=" . $e_date ."&serach_key=" . $search_key . "&search_content=" . $search_cotent;
		$args['q_see'] = "";
		return $C_ListClass -> listInfo($args);
	}
	
	
	


	// desc	 : 퀵상담 답변
	// auth  : JH 2013-09-16 월요일
	// param
	function Reserve_Result($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			update
				tblReserve
			set
				tr_result = '$tr_result',
				tr_rt_date = '$tr_rt_date',
				tr_result_con = '$tr_result_con'
			where
				tr_idx = '$tr_idx'
			";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}

	// desc	 : 퀵상담 삭제
	// auth  : JH 2013-09-16 월요일
	// param
	function Reserve_Del($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			delete from tblReserve where tr_idx='$tr_idx'
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	
		// desc	 : 퀵상담 선택 삭제
	// auth  : JH 2013-09-13
	// param
	function Del_Real_Sel($args) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			delete from tblReserve where tr_idx in ($arr_idx)
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	// desc	 : 퀵상담
	// auth  : 
	// param
	function info_Sel($args) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			select * from tblReserve where tr_idx in ($arr_idx)
		";		
		$rst =  $this -> DB -> execSqlList($qry);
		return $rst;	
	}


}
?>