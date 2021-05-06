<?php
	include_once("../../_init.php");	
	
	include_once($GP->CLS."class.list.php");
	include_once($GP -> CLS."/class.reserve2.php");	
	include_once($GP->CLS."class.button.php");
	$C_ListClass 	= new ListClass;
	$C_Reserve2 	= new Reserve2;
	$C_Button 		= new Button;
	
	$excelHanArr = array(
		"이름" => "tr_name",
		"전화" => "tr_mobile",
		"나이" => "tr_age",
		"등록일" => "tr_reg_date"
	);
	
	$args = array();
	$args['show_row'] = 10;
	$args['pagetype'] = "admin";
	$data = "";
	$args['excel_file']		= $_GET['excel_file'];
	$args['excel']			= $excelHanArr;
	$data = $C_Reserve2->Reserve_List2(array_merge($_GET,$_POST,$args));
	
	$data_list 		= $data['data'];
	$page_link 		= $data['page_info']['link'];
	$page_search 	= $data['page_info']['search'];
	$totalcount 	= $data['page_info']['total'];
	
	$totalpages 	= $data['page_info']['totalpages'];
	$nowPage 		= $data['page_info']['page'];
	$totalcount_l 	= number_format($totalcount,0);
	
	$data_list_cnt 	= count($data_list);
	
	include_once($GP -> INC_ADM_PATH."/head.php");
 
?>
<body>
<div class="Wrap"><!--// 전체를 감싸는 Wrap -->
		<? include_once($GP -> INC_ADM_PATH."/header.php"); ?>
		<div class="boxContentBody">
			<div class="boxSearch">
			<? include_once($GP -> INC_ADM_PATH."/inc.mem_search.php"); ?>										
			<form name="base_form" id="base_form" method="GET">
			<ul>				
				<li>
					<strong class="tit">등록일</strong>
					<span><input type="text" name="s_date" id="s_date" value="<?=$_GET['s_date']?>" class="input_text" size="20"></span>
					<span>~</span>
					<span><input type="text" name="e_date" id="e_date" value="<?=$_GET['e_date']?>" class="input_text" size="20" /></span>
				
				</li>
				<li>
					<strong class="tit">검색조건</strong>
					<span>
					<select name="search_key" id="search_key">
						<option value="tr_name" <? if($_GET['search_key'] == "tr_name"){ echo "selected";}?>>성명</option>
						<option value="tr_mobile" <? if($_GET['search_key'] == "tr_mobile"){ echo "selected";}?>>핸드폰</option>
					</select>
					</span>
					<span><input type="text" name="search_content" id="search_content" value="<?=$_GET['search_content']?>" class="input_text" size="30" /></span>
					<span><button id="search_submit" class="btnSearch ">검색</button></span>
                    <span><input type="button" id="excel_btn" value="EXCEL" /></span>
                    <!--span><input type="button" id="edit_btn" value="선택 처리" /></span>
                    <span><input type="button" id="del_btn" value="선택 삭제" /></span-->
				</li>
			</ul>
			</form>
			</div>
		</div>

		<div id="BoardHead" class="boxBoardHead">				
				<div class="boxMemberBoard">
					<table>
						<colgroup>
							<col />
							<col />
							<col />
							<col />
							<col />
							<col />
							<col />
							<col style="width:150px;"/>
						</colgroup>
						<thead>
							<tr>
								<th>No</th>
								<th>관심부위</th>
								<th>이름</th>
								<th>연락처</th>
								<th>통화가능한시간</th>
								<th>상태</th>
								<th>등록일자</th>
								<th>수정/삭제</th>
							</tr>
						</thead>
						<tbody>
							<?
							$dummy = 1;
							for ($i = 0 ; $i < $data_list_cnt ; $i++) {
								$tr_idx 		= $data_list[$i]['tr_idx'];
								$tr_name	= $data_list[$i]['tr_name'];
								$tr_gubun		= $data_list[$i]['tr_gubun'];
								$tr_time		= $data_list[$i]['tr_time'];
								$tr_content		= $data_list[$i]['tr_content'];
								$tr_mobile 	= $data_list[$i]['tr_mobile'];
								$tr_result 	= $data_list[$i]['tr_result'];
								$tr_reg_date 	= date("Y.m.d", strtotime($data_list[$i]['tr_reg_date']));							
								
								$edit_btn = $C_Button -> getButtonDesign('type2','처리',0,"layerPop('ifm_reg','./reserve_edit.php?tr_idx=" . $tr_idx. "', '100%', 750)", 50,'');	
								$edit_btn .= $C_Button -> getButtonDesign('type2','삭제',0,"reserve_del('" . $tr_idx. "')", 50,'');
								
							?>
									<tr>
                                    	
										<td><?=$data['page_info']['start_num']--?></td>
										<td><?=$tr_gubun?></td>
										<td><?=$tr_name?></td>	
                                        <td><?=$tr_mobile?></td>
                                        <td><?=$tr_time?></td>										
										<td><?=$GP -> QNA_RESULT[$tr_result]?></td>
										<td><?=$tr_reg_date?></td>
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

		$('#search_submit').click(function(){		
			$('#base_form').submit();
			return false;
		});

	});

	function reserve_del(tr_idx)
	{
		if(!confirm("삭제하시겠습니까?")) return;

		$.ajax({
			type: "POST",
			url: "./proc/reserve_proc.php",
			data: "mode=RESERVE_DEL&tr_idx=" + tr_idx,
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
	
	//엑셀 출력
		$('#excel_btn').click(function(){
				var string = $("#base_form").serialize();
				location.href = "?excel_file=reserve" + "&" + string;
				return false;
		});

	
	$('#del_btn').click(function(){
			if(!confirm("선택하신 회원들을 삭제하시겠습니까?")) return;

			var num = "";
			$("input:checkbox[name=ck_num]").each(function(){
				if($(this).prop('checked') == true) {
					num += $(this).val()  + ",";
				}
			});
			num = num.slice(0,-1);

			if(num == "") {
				alert("삭제할 사람을 체크해주세요");
				return false;
			}
			
			$("#ajaxloading")
			.css("position","absolute")
			.css("z-index","10001")
			.css("top","50%")
			.css("left","50%")
			.css("margin",$("#ajaxloading").height()/2*-1+" 0 0 "+$("#ajaxloading").width()/2*-1);

			$.ajax({
				type: "POST",
				url: "./proc/reserve_proc.php",
				data: "mode=USER_DEL&arr_idx=" + num,
				dataType: "text",
				beforeSend : function(){
					$("#ajaxloading").html("<img src='/admin/img/common/ajax-loader.gif'/>");
					$('.boxBoardHead').hide();
				},
				success: function(msg) {
					$("#ajaxloading").empty();
					$('.boxBoardHead').show();
					if($.trim(msg) == "true") {
						alert("처리 되었습니다");
						window.location.reload();
						return false;
					}else{
						alert('처리에 실패하였습니다.');
						return;
					}
				},
				error: function(xhr, status, error) { alert(error); }
			});
		});

	$('#edit_btn').click(function(){			
			if(!confirm("처리완료 하시겠습니까?")) return;

			var num = "";
			$("input:checkbox[name=ck_num]").each(function(){
				if($(this).prop('checked') == true) {
					num += $(this).val()  + ",";
				}
			});
			num = num.slice(0,-1);

			if(num == "") {
				alert("처리할 사람을 체크해주세요");
				return false;
			}
			
			$('#mode').val("HUEMAIL_SEND");
			$('#arr_idx').val(num);
			$('#frm_email').attr('action','./proc/humem_proc.php');
			$('#frm_email').submit();
			return false;
	});
	
</script>
	
	