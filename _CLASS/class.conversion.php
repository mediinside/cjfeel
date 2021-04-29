<?
CLASS Conversion extends Dbconn
{
	private $DB;
	private $GP;
	function __construct($DB = array()) {
		global $C_DB, $GP;
		$this -> DB = (!empty($DB))? $DB : $C_DB;
		$this -> GP = $GP;
	}	
    
    function conversion_insert($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			INSERT INTO
			tblConversion
			(
                cv_idx,		
                cv_check,
                cv_type,	
                cv_gubun,
                cv_memo,
                cv_ip,
                cv_reg_date
			)
			VALUES
			(
            ''	
            , '$cv_check'	
            , '$cv_type'	
            , '$cv_gubun'	
            , '$cv_memo' 	
            ,'". $_SERVER["REMOTE_ADDR"]."'
			, NOW()
			)
		";
		$rst = $this -> DB -> execSqlInsert($qry);
		return $rst;
    }
    
    // desc	 : 게시판 리스트
	// auth  : JH 2013-04-26
	// param :
	function conversion_counter_List($args = '') {
		global $C_Func;
		global $C_ListClass;

        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;	
        
        $addQry = " cv_type = '$cv_type' ";

        if (($s_date && $e_date) && ($s_date < $e_date)) {
			if ($addQry)
			$addQry .= " AND ";
			$addQry .= " DATE_FORMAT(cv_reg_date,'%Y-%m-%d') between '$s_date' AND '$e_date'";
		}
	

		$args['search']			= array();
		$args['show_row']		= $show_row;
		$args['show_page']		= 5;
		$args['q_idx']			= "cv_idx";
		$args['q_col']			= "* ";
		$args['q_table']		= "tblConversion";
		$args['q_where']		= $addQry;
		$args['q_order']		= "cv_reg_date desc";
		$args['q_group']		= "";
		$args['tail']				= $tail;
		$args['q_see']			= "0";

		return $C_ListClass -> listInfo($args);
    }
    
    // desc	 : 통계 합계
	// auth  : JH 2013-09-16 월요일
	// param
	function conversion_counter_Total($args) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$arr_tmp = array();
		
        $qry = "SELECT COUNT(*) as cnt FROM tblConversion where cv_type = '$cv_type'";      
		$rst =  $this -> DB -> execSqlOneRow($qry);
		$arr_tmp[0] = $rst['cnt'];
		
        $qry1 = "SELECT COUNT(*) as cnt FROM tblConversion  WHERE cv_type = '$cv_type' AND DATE_FORMAT(cv_reg_date,'%Y') = '$Year' AND DATE_FORMAT(cv_reg_date,'%m') = '$Month'";        
		$rst1 =  $this -> DB -> execSqlOneRow($qry1);
		$arr_tmp[1] = $rst1['cnt'];
		
        $qry2 = "SELECT COUNT(*) as cnt FROM tblConversion  WHERE cv_type = '$cv_type' AND DATE_FORMAT(cv_reg_date,'%Y') = '$Year' AND DATE_FORMAT(cv_reg_date,'%m') = '$Month' AND DATE_FORMAT(cv_reg_date,'%d') = '$Day'";       
		$rst2 =  $this -> DB -> execSqlOneRow($qry2);
		$arr_tmp[2] = $rst2['cnt'];
		return $arr_tmp;		
	}
	
	
}
?>