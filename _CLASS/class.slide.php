<?
CLASS Slide extends Dbconn
{
	private $DB;
	private $GP;
	function __construct($DB = array()) {
		global $C_DB, $GP;
		$this -> DB = (!empty($DB))? $DB : $C_DB;
		$this -> GP = $GP;
	}
	
	
	// desc	 : 메인 슬라이드 리스트
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Main_Slide_Show($args='') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        
        $addQry = '';
		if($ts_gubun != ''){
			$addQry .=" and ts_gubun = '$ts_gubun' ";
		}
		
		$qry = "
			select * from tblSlide where ts_show ='Y'  $addQry order by ts_regdate desc $limit
		";
	//	echo $qry;
		$rst =  $this -> DB -> execSqlList($qry);
		return $rst;
	}
	
		
	// desc	 : 슬라이드 수정
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Slide_Modi($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			update
				tblSlide
			set
				ts_title = '$ts_title',
				ts_link = '$ts_link',
				ts_content = '$ts_content',
				ts_img = '$ts_img',
				ts_m_img = '$ts_m_img',
				ts_t_img = '$ts_t_img',
				ts_show = '$ts_show',
				ts_link2 = '$ts_link2',
				ts_link3 = '$ts_link3',
				ts_img2 = '$ts_img2',
				ts_m_img2 = '$ts_m_img2',
				ts_t_img2 = '$ts_t_img2'		
			where
				ts_idx = '$ts_idx'			
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	// desc	 : 슬라이드 삭제
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Slide_Del($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			delete from tblSlide where ts_idx = '$ts_idx'	
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	// desc	 : 슬라이드 정보
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Slide_ImgUpdate($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$addQry = "";
		if($type == "W") {
			$addQry = " ts_img = '' ";
		}else if($type == "T") {
			$addQry = " ts_t_img = '' ";
		}else if($type == "M") {
			$addQry = " ts_m_img = '' ";
		}else if($type == "MW") {
			$addQry = " ts_img2 = '' ";
		}else if($type == "MT") {
			$addQry = " ts_t_img2 = '' ";
		}else if($type == "MM") {
			$addQry = " ts_m_img2 = '' ";
		}
		
		$qry = "
			update
				tblSlide
			set				
				$addQry
			where
				ts_idx = '$ts_idx'			
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}
	
	
	// desc	 : 슬라이드 정보
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Slide_Info($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "
			select * from tblSlide where ts_idx = '$ts_idx'
		";
		$rst =  $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}
	
	// desc	 : 슬라이드 등록
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Slide_Reg($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		
		$qry = "
			INSERT INTO
				tblSlide
				(
					ts_idx,
					ts_title,
					ts_link,
					ts_content,
					ts_img,
					ts_m_img,
					ts_t_img,
					ts_show,
					ts_regdate,
					ts_link2,
					ts_link3,
					ts_img2,
					ts_m_img2,
                    ts_t_img2,
                    ts_gubun
					
				)
				VALUES
				(
					''		
					, '$ts_title'
					, '$ts_link'
					, '$ts_content'
					, '$ts_img'
					, '$ts_m_img'
					, '$ts_t_img'
					, '$ts_show'
					,  NOW()
					, '$ts_link2'
					, '$ts_link3'
					, '$ts_img2'
					, '$ts_m_img2'
                    , '$ts_t_img2'
                    , '$ts_gubun'
				)
			";
		$rst =  $this -> DB -> execSqlInsert($qry);
		return $rst;
	}
	
	
	// desc	 : 태그 리스트
	// auth  : JH 2012-12-05 2012-11-06
	// param
	function Slide_List ($args = '') {
		global $C_Func;
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		global $C_ListClass;

		$tail = "";
		$addQry = " 1=1 ";
		
		if(!empty($ts_show)) {
			$addQry .= " AND ";
			$addQry .= " ts_show = '$ts_show' ";
        }	
        
        if(!empty($ts_gubun)) {
			$addQry .= " AND ";
			$addQry .= " ts_gubun = '$ts_gubun' ";
		}	
		
		if ($search_key && $search_content) {
			if (!empty($addQry)) {
				$addQry .= " AND ";
				$addQry .= " $search_key LIKE ('%$search_content%')";
			}
		}
		
		$args['show_row'] = $show_row;
		$args['show_page'] = 10;
		$args['q_idx'] = "ts_idx";
		$args['q_col'] = "*";
		$args['q_table'] = "tblSlide";
		$args['q_where'] = $addQry;
		$args['q_order'] = "ts_regdate desc";
		$args['q_group'] = "";
		$args['tail'] = "s_date=" . $s_date . "&e_date=" . $e_date ."&serach_key=" . $search_key . "&search_content=" . $search_cotent . "&tt_cate=" . $tt_cate;
		$args['q_see'] = "";
		return $C_ListClass -> listInfo($args);
	}
	
}
?>