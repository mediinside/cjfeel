<?php
	include_once("../../_init.php");	
	
	include_once($GP->CLS."class.list.php");
	include_once($GP -> CLS."/class.online.php");	
	include_once($GP->CLS."class.button.php");	
	$C_ListClass 	= new ListClass;
	$C_Online 	= new Online;
	$C_Button 		= new Button;
	
	
//error_reporting(E_ALL);

//ini_set("display_errors", 1);
	
	$excelHanArr = array(
		"예약일" => "tor_rs_date",
		"예약시간" => "tor_rs_time",
		"문의내용" => "tor_rs_content",
		"초/재진" => "tor_rs_exam",
		"작성자" => "tor_rs_name",
		"연락처" => "tor_rs_phone",
		"구주소" => "mb_address1",
		"구상세주소" => "mb_address2",
		"신주소" => "mb_load_address1",
		"신상세주소" => "mb_load_address2",
		"예약상태" => "tor_rs_type",
		"등록일" => "tor_regdate",
		"처리일자" => "tor_rs_result_date",
		"처리내용" => "tor_rs_result_content"
	);
	
	$args = array();
	$args['show_row'] = 10;
	$args['excel_file']		= $_GET['excel_file'];
	$args['excel']				= $excelHanArr;
	$args['pagetype'] = "admin";
	$data = "";
	$data = $C_Online->Online_Reserve_List(array_merge($_GET,$_POST,$args));
	
	$data_list 		= $data['data'];
	$page_link 		= $data['page_info']['link'];
	$page_search 	= $data['page_info']['search'];
	$totalcount 	= $data['page_info']['total'];
	
	$totalpages 	= $data['page_info']['totalpages'];
	$nowPage 		= $data['page_info']['page'];
	$totalcount_l 	= number_format($totalcount,0);
	
	$data_list_cnt 	= count($data_list);

	$get_par = "page=" . $nowPage . "&s_date=" . $_GET['s_date'] . "&e_date=" . $_GET['e_date'] . "&search_key=" . $_GET['search_key']. "&search_content=" . $_GET['search_content'];
	
	
	
	
	
	$excelDown_btn			= $C_Button -> getButtonDesign('type2','EXCEL',0, '', 50,'');	//엑셀출력버튼
	
	include_once($GP -> INC_ADM_PATH."/head.php");
?>
<body>
<div class="Wrap"><!--// 전체를 감싸는 Wrap -->
		<? include_once($GP -> INC_ADM_PATH."/header.php"); ?>
		<div class="boxContentBody">
			<div class="boxSearch">									
			<form name="base_form" id="base_form" method="GET">
			<ul>				
				
					<span style="padding-right:42px; line-height:24px;">등록일</span>
					<span><input type="text" name="s_date" id="s_date" value="<?=$_GET['s_date']?>" class="input_text" size="20"></span>
					<span>~</span>
					<span><input type="text" name="e_date" id="e_date" value="<?=$_GET['e_date']?>" class="input_text" size="20" /></span>
											
				<li>
					<span style="padding-right:31px;">검색조건</span>
					<span>
					<select name="search_key" id="search_key">
						<option value="M.mb_name" <? if($_GET['search_key'] == "M.mb_name"){ echo "selected";}?>>성명</option>
						<option value="M.mb_mobile" <? if($_GET['search_key'] == "M.mb_mobile"){ echo "selected";}?>>핸드폰</option>
						<option value="M.mb_email" <? if($_GET['search_key'] == "M.mb_email"){ echo "selected";}?>>이메일</option>
					</select>
					</span>
					<span><input type="text" name="search_content" id="search_content" value="<?=$_GET['search_content']?>" class="input_text" size="30" /></span>
					<span><button id="search_submit" class="btnSearch ">검색</button></span>
					<span><?=$excelDown_btn?></span>
				</li>
			</ul>
			</form>
			</div>
		</div>

		<div id="BoardHead" class="boxBoardHead">				
				<div class="boxMemberBoard">
					<table>
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">예약일</th>
								<th scope="col">예약시간</th>
								<th scope="col">초/재진</th>
                                <th scope="col">성별</th>
                                <th scope="col">생년월일</th>
								<th scope="col">작성자</th>
								<th scope="col">연락처</th>                
								<th scope="col">상태</th>
								<th scope="col">등록일</th>
								<th scope="col">수정/삭제</th>			
							</tr>
						</thead>
						<tbody>
							<?
								$dummy = 1;
								for ($i = 0 ; $i < $data_list_cnt ; $i++) {
									$tor_idx 			= $data_list[$i]['tor_idx'];
									$mb_name		= $data_list[$i]['mb_name'];
									$mb_mobile 	= $data_list[$i]['mb_mobile'];	
									$tor_rs_exam 	= $data_list[$i]['tor_rs_exam'];	
									$tor_rs_doc 		= $data_list[$i]['tor_rs_doc'];	
									$tor_rs_content	= strip_tags($data_list[$i]['tor_rs_content']);
									$tor_rs_content = $C_Func->strcut_utf8($tor_rs_content, 50, false, "...");										
									$tor_rs_phone	= $data_list[$i]['tor_rs_phone'];									
									$tor_rs_name	= $data_list[$i]['tor_rs_name'];
									$tor_rs_type		= $data_list[$i]['tor_rs_type'];
									$tor_mb_code	= $data_list[$i]['tor_mb_code'];
									$tor_rs_date		= $data_list[$i]['tor_rs_date'];
									$tor_rs_time		= $data_list[$i]['tor_rs_time'];
									$tor_rs_sms		= $data_list[$i]['tor_rs_sms'];
									$dr_name		= $data_list[$i]['dr_name'];
									$dr_position		= $data_list[$i]['dr_position'];
									$mb_address1  = $data_list[$i]['mb_address1'];
									$mb_address2  = $data_list[$i]['mb_address2'];	
									$tor_rs_birth  = $data_list[$i]['tor_rs_birth'];	
									$tor_rs_gender  = $data_list[$i]['tor_rs_gender'];
																	
									$tor_regdate 	= date("Y.m.d", strtotime($data_list[$i]['tor_regdate']));		
									
									
									$send_btn = "";
									$edit_btn = "";
									if($tor_rs_type == "Y" && $tor_rs_sms != 'Y') {
										$send_btn = $C_Button -> getButtonDesign('type2','확정문자',0,"send_sms('" . $tor_idx ."', '" . $tor_rs_name. "')", 70,'');	 
									}
									
									if($tor_rs_type == "Y" && $tor_rs_sms == 'Y') {
										$send_btn = $C_Button -> getButtonDesign('type2','문자발송완료',0,"", 90,'');	 
									}
									
									$edit_btn = $C_Button -> getButtonDesign('type2','처리',0,"layerPop('ifm_reg','./online_reserve_edit.php?tor_idx=" . $tor_idx. "', '100%', 700)", 50,'');	
									$edit_btn .= " ". $C_Button -> getButtonDesign('type2','삭제',0,"reserve_del('" . $tor_idx. "')", 50,'');									
								?>
									<tr>
										<td><?=$data['page_info']['start_num']--?></td>										
										<td><?=$tor_rs_date?></td>
										<td><?=$tor_rs_time?></td>
										<td><? if($tor_rs_exam == 'N') { echo "초진";}else{ echo "재진";} ?></td>
                                        <td><? if($tor_rs_gender == 'M') { echo "남";}else{ echo "여";} ?></td>
                                        <td><?=$tor_rs_birth?></td>	
										<td><?=$tor_rs_name?></td>	
										<td><?=$tor_rs_phone?></td>	                    
										<td><?=$GP -> RESERVE_RESULT[$tor_rs_type]?></td>	
										<td><?=$tor_regdate?></td>	
										<td><?=$edit_btn?></td>
									</tr>
									<?
									$dummy++;
								}
							?>							
						</tbody>
					</table>
				</div>			
			</div>
			<ul class="boxBoardPaging">
				<?=$page_link?>
			</ul>
		</div>
		<? include_once($GP -> INC_ADM_PATH."/footer.php"); ?>
	</div>
</div><!-- 전체를 감싸는 Wrap //-->
</body>
</html>
<script type="text/javascript">

	$(document).ready(function(){														 
	
		callDatePick('s_date');
		callDatePick('e_date');

		$('#search_submit').click(function(){		
			$('#base_form').submit();
			return false;
		});
		
		//엑셀 출력
		$('#webForm').click(function(){
				var string = $("#base_form").serialize();
				location.href = "?excel_file=예약리스트" + "&" + string;
				return false;
		});

	});
	
	function send_sms(tor_idx, name) {
		if(!confirm( name + " 고객님에게 확정문자를 보내시겠습니까?")) return;

		$.ajax({
			type: "POST",
			url: "./proc/online_proc.php",
			data: "mode=ONLINE_RESERVE_SMS&tor_idx=" + tor_idx,
			dataType: "json",
			success: function(json) {					
				var result = json.msg;
				
				if(result == "true") {
					alert("메세지가 발송되었습니다");
					window.location.reload(true);
				}else{
					
					var error = json.error;
					
					if(error == "pwd_fail")
					{
						alert("SMS 아이디 또는 패스워드가 일치하지 않습니다."); 
					}						  
					else if(error == "num_fail")
					{
						alert("SMS 남은 발송건수가 부족합니다. 충전해주세요"); 	  
					}
					else{
						alert("메세지가 발송이 실패하였습니다. 관리자에게 문의하세요. 에러 코드 : " + error);						
					}
					return false;							
				}
			},
			error: function(xhr, status, error) { alert(error); }
		});
	}

	function reserve_del(tor_idx)
	{
		if(!confirm("삭제하시겠습니까?")) return;

		$.ajax({
			type: "POST",
			url: "./proc/online_proc.php",
			data: "mode=ONLINE_RESERVE_DEL&tor_idx=" + tor_idx,
			dataType: "text",
			success: function(msg) {

				if($.trim(msg) == "true") {
					alert("삭제되었습니다");
					window.location.reload();
					return false;
				}else{
					alert('삭제에 실패하였습니다.');
					return;
				}
			},
			error: function(xhr, status, error) { alert(error); }
		});
	}
</script>