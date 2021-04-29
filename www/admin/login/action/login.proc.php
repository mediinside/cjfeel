<?php
include_once("../../../_init.php");
include_once($GP -> CLS."/class.login.php");
include_once($GP -> CLS."/class.EnDecryptText.php");

$C_Login = new Login();
$EnDecryptText = new EnDecryptText(); 

if($_GET['mode'] == "logout"){	
	$_SESSION['adminid'] = "";
	$_SESSION['suserid'] = "";
	$_SESSION['susername'] = "";
	$_SESSION['suserphone'] = "";
	$_SESSION['suseremail'] = "";
	$_SESSION['suserlevel'] = "";
	$_SESSION['adminhpidx'] = "";
	$C_Func->go_replace("/admin/login/");
	exit();
}

switch($_POST['mode']){
	case 'login':
		$args = "";
		$args['adm_mem_id'] = $_POST['loginAdminId'];
		
		$rst = $C_Login -> AdminLoginInfoCheck($args);
		
	//	echo $C_Func -> encrypt_md5($_POST['loginAdminpw'],  $GP -> PASS);
	//	exit;
		if($rst['mb_type'] == 1){
			$args['adm_mem_id'] = $_POST['loginAdminId'];
			$args['adm_mem_pwd'] = $C_Func -> encrypt_md5($_POST['loginAdminpw'],  $GP -> PASS);	
			$rst = $C_Login -> AdminLoginInfoCheck2($args);

			if($rst){
				$_SESSION['adminid'] = $rst['mb_id'];
				$_SESSION['suserid'] = $rst['mb_id'];
				$_SESSION['susername'] = $rst['mb_name'];
				$_SESSION['suserphone'] = $rst['mb_phone'];
			//	$_SESSION['susermobile'] = $rst['mb_mobile'];
				$_SESSION['suseremail'] = $rst['mb_email'];
				$_SESSION['suserlevel'] = $rst['mb_level'];
				$_SESSION['adminfld'] = $rst['tl_folder'];
				$_SESSION['adminfldsub'] = $rst['tl_folder_sub'];
				$_SESSION['adminbbs'] = $rst['tl_bbs'];
				
				//마지막 로그인 날짜, 마지막 로그인 아이피, 로그인 누적횟수 수정
				$args = '';
				$args['mb_email'] = $_POST['login_id'];
				$args['mb_lastlogin_date'] = date('Y-m-d H:i:s');
				$args['mb_lastlogin_ip'] 	 = $_SERVER['REMOTE_ADDR'];
				$result = $C_Login -> Mem_Login_history($args);
			
				if(strlen($_POST['bakurl']) > 5){		
					$C_Func->go_replace(urldecode($_POST['bakurl']));
				}else{
					$C_Func->go_replace("/admin/bbs/bbs_list.php?m_tab=2");
				}
			}else{
				$C_Func->put_msg_and_back("아이디나 패스워드를 확인해주세요");
				exit();
			}		
		
		}
	
		//기존패스워드
	//	$pwd = $C_Func -> decrypt_md5($rst['loginAdminpw'],  $GP -> PASS);	
		
		if($rst) {
				$pwd = $EnDecryptText->Encrypt_Text($GP -> PASS.$_POST["loginAdminpw"]);
				$rpwd = $EnDecryptText -> Decrypt_Text($pwd);	
				$r2pwd = $EnDecryptText -> Decrypt_Text($rst["mb_password"]);
				$wrong_cnt = $rst["mb_wrong_login"];
				if($wrong_cnt < 5) {
					if($rpwd == $r2pwd){
						$_SESSION['adminid'] = $rst['mb_id'];
						$_SESSION['suserid'] = $rst['mb_id'];
						$_SESSION['susername'] = $rst['mb_name'];
						$_SESSION['suserphone'] = $rst['mb_phone'];
						$_SESSION['suseremail'] = $rst['mb_email'];
						$_SESSION['suserlevel'] = $rst['mb_level'];
						$_SESSION['adminfld'] = $rst['tl_folder'];
						$_SESSION['adminfldsub'] = $rst['tl_folder_sub'];
						$_SESSION['adminbbs'] = $rst['tl_bbs'];
						
						//로그인 시도 리셋
						$args['adm_mem_id'] = $_POST['loginAdminId'];
						$rst = $C_Login -> AdminOkLogin($args);
						
						//마지막 로그인 날짜, 마지막 로그인 아이피, 로그인 누적횟수 수정
						
						$browser = $C_Func->ckBrowser();  //브라우저 정보
						$os = $C_Func->ckOs(); //OS 정보
						$args = '';
						$args["s_ID"] =  $_POST['loginAdminId'];
						$args["s_StatusIP"] =  $_SERVER['REMOTE_ADDR'];
						$args["s_Browser"]  =  $browser;
						$args["s_OS"] =  $os;
						$args['s_Agent'] = $_SERVER['HTTP_USER_AGENT'];
						//아이피 등록일 브라우져 OS 브라우져버젼 
						
						/**/
						
						$result = $C_Login -> Mem_Admin_Login_history($args);
					
						if(strlen($_POST['bakurl']) > 5){		
							$C_Func->go_replace(urldecode($_POST['bakurl']));
						}else{
							$C_Func->go_replace("/admin/bbs/bbs_list.php?m_tab=2");
						}
					}else{
						$args = "";
						$args['adm_mem_id'] = $_POST['loginAdminId'];
						$rst = $C_Login -> AdminWrongLogin($args);
						$C_Func->put_msg_and_back("패스워드를 확인해주세요");
						exit();
					}	
				}else{
					$C_Func->put_msg_and_back("잘못된 비밀번호를 5번 입력 하셨습니다. 관리자에게 문의해 주세요");
					exit();
				}
		}else{
			$C_Func->put_msg_and_back("아이디를 확인해주세요");
			exit();			
		}
	break;
}

?>
