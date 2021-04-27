<?
CLASS Login extends Dbconn
{
	private $DB;
	private $GP;
	function __construct($DB = array()) {
		global $C_DB, $GP;
		$this -> DB = (!empty($DB))? $DB : $C_DB;
		$this -> GP = $GP;
	}
	
	// desc	 : 회원로그인 정보-facebook
	// auth  : JH 2013-10-04 금요일
	// param :
	function userLoginFB($args = '') {

		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$qry = "
			SELECT
				*
			FROM
				tblMember
			where
			1=1 
			and mb_id = '$mb_id'
			and mb_gubun = 'facebook'
			and mb_status = 'M'
		";

		$rst = $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}	
	
	
	
		// desc	 : 회원로그인 정보-NAVER
	// auth  : JH 2013-10-04 금요일
	// param :
	function userLoginNaver($args = '') {

		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$qry = "
			SELECT
				*
			FROM
				tblMember
			where
			1=1 
			and mb_id = '$mb_id'
			and mb_gubun = 'naver'
			and mb_status = 'M'
		";
		
		$rst = $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}	
			
	
	// desc	 : 구패스워드를 신패스워드로 체인지
	// auth  : JH 2013-09-16
	// param :
	function Mem_Pass_Update($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
			
			$qry = "
				update
					tblMember
				set
					mb_password = '$mb_password'
				where
					mb_id = '$mb_id'				
			";
			
			$rst = $this -> DB ->execSqlUpdate($qry);
			return $rst;	
	}
	
		// desc	 : 어드민 로그인정보
	// auth  : JH 2013-09-16
	// param :
	function AdminLoginInfoCheck($args){
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$rst = false;
		$nowData = date("Y-m-d");
		$qry = "
			select 
				* 
			from 
				tblAdmin A LEFT OUTER JOIN tblAdminAuth B ON A.mb_level=B.tl_level
			where 
				mb_id ='" . mysql_real_escape_string($adm_mem_id) . "' 
		";
		$rst = $this -> DB ->execSqlOneRow($qry);
		return $rst;

	}
	
	// desc	 : 잘못된 로그인
	// auth  : 
	// param :
	function AdminWrongLogin($args){
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		$qry = "
			UPDATE 
				tblAdmin 
			SET 
				mb_wrong_login = (mb_wrong_login + 1) 
			WHERE 
				mb_id ='$adm_mem_id' 
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}	
	
	// desc	 : 정상 로그인
	// auth  : 
	// param :
	function AdminOkLogin($args){
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		$qry = "
			UPDATE 
				tblAdmin 
			SET 
				mb_wrong_login = ''
			WHERE 
				mb_id ='$adm_mem_id' 
		";
		$rst =  $this -> DB -> execSqlUpdate($qry);
		return $rst;
	}		
	
	// desc	 : 회원로그인 정보
	// auth  : JH 2013-10-04 금요일
	// param :
	function userLogin($args = '') {

		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$qry = "
			SELECT
				*
			FROM
				tblMember
			where
			1=1 
			and mb_email = '$mb_email'
			and mb_password = '$mb_password'
			and mb_del_flag = 'N'
			and mb_status = 'M'
		";

		$rst = $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}
	
	// desc	 : 회원로그인 정보
	// auth  : JH 2013-10-04 금요일
	// param :
	function userLogin_ID($args = '') {

		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$qry = "
			SELECT
				*
			FROM
				tblMember
			where
			1=1 
			and mb_id = '$mb_id'			
			and mb_del_flag = 'N'
			and mb_status = 'M'
		";

		$rst = $this -> DB -> execSqlOneRow($qry);
		return $rst;
	}
	
	// desc	 : 회원 로그인 history
	// auth  : JH 2013-10-04 금요일
	// param :
	function Mem_Login_history_ID($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
			
			$qry = "
				update
					tblMember
				set
					mb_lastlogin_date = '$mb_lastlogin_date',
					mb_lastlogin_ip = '$mb_lastlogin_ip',
					mb_login_number = (mb_login_number + 1)
				where
					mb_id = '$mb_id'					
			";
			$rst = $this -> DB ->execSqlUpdate($qry);
			return $rst;			
	}
	
	// desc	 : 회원 로그인 history
	// auth  : JH 2013-10-04 금요일
	// param :
	function Mem_Login_history($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
			
			$qry = "
				update
					tblMember
				set
					mb_lastlogin_date = '$mb_lastlogin_date',
					mb_lastlogin_ip = '$mb_lastlogin_ip',
					mb_login_number = (mb_login_number + 1)
				where
					mb_email = '$mb_email'					
			";
			$rst = $this -> DB ->execSqlUpdate($qry);
			return $rst;			
	}
	
		// desc	 : 어드민 로그인 history
	// auth  : JH 2013-09-16
	// param :
	function Admin_Login_history($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
			
			$qry = "
				update
					tblAdmin
				set
					mb_lastlogin_date = '$mb_lastlogin_date',
					mb_lastlogin_ip = '$mb_lastlogin_ip',
					mb_login_number = (mb_login_number + 1)
				where
					mb_id = '$mb_id'					
			";
			
			$rst = $this -> DB ->execSqlUpdate($qry);
			return $rst;			
	}

	function Mem_Admin_Login_history($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
			
			$qry = "
				INSERT INTO
				tblAdminLog
				(
					s_idx,
					s_ID,
					s_register_date,
					s_StatusIP,
					s_Browser,
					s_OS,
					s_Agent
				)
					VALUES
				(
					''
					, '$s_ID'
					, NOW()
					, '$s_StatusIP'
					, '$s_Browser'
					, '$s_OS'
					, '$s_Agent'
				)";

			$rst = $this -> DB -> execSqlInsert($qry);
			return $rst;			
	}
	// desc	 : 어드민 로그인정보
	// auth  : JH 2013-09-16
	// param :
	function AdminLoginInfoCheck2($args){
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$rst = false;
		$nowData = date("Y-m-d");
		$qry = "
			select 
				* 
			from 
				tblAdmin A LEFT OUTER JOIN tblAdminAuth B ON A.mb_level=B.tl_level
			where 
			mb_id ='" . mysql_real_escape_string($adm_mem_id) . "' 
				and mb_password='" . mysql_real_escape_string($adm_mem_pwd) . "'
		";
		$rst = $this -> DB ->execSqlOneRow($qry);
		return $rst;

	}
}
?>