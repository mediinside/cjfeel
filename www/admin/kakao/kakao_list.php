<?php
	include_once("../../_init.php");	
	
	include_once($GP->CLS."class.list.php");
	include_once($GP -> CLS."/class.kakao.php");	
	include_once($GP->CLS."class.button.php");
	$C_ListClass 	= new ListClass;
	$C_Kakao 	= new Kakao;
	$C_Button 		= new Button;
	
	$args = array();
	$args['show_row'] = 10;
	$args['pagetype'] = "admin";
	$data = "";
	$data = $C_Kakao->Kakao_List(array_merge($_GET,$_POST,$args));
	
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
						<option value="M.mb_name" <? if($_GET['search_key'] == "M.mb_name"){ echo "selected";}?>>성명</option>
						<option value="M.mb_mobile" <? if($_GET['search_key'] == "M.mb_mobile"){ echo "selected";}?>>핸드폰</option>
						<option value="M.mb_email" <? if($_GET['search_key'] == "M.mb_email"){ echo "selected";}?>>이메일</option>
					</select>
					</span>
					<span><input type="text" name="search_content" id="search_content" value="<?=$_GET['search_content']?>" class="input_text" size="30" /></span>
					<span><button id="search_submit" class="btnSearch ">검색</button></span>
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
                                <th scope="col">작성자</th>
								<th scope="col">연락처</th>
                                <th scope="col">카카오ID</th>
								<th scope="col">상태</th>
								<th scope="col">등록일</th>
								<th scope="col">처리/삭제</th>	
							</tr>
						</thead>
						<tbody>
							<?
							$dummy = 1;
							for ($i = 0 ; $i < $data_list_cnt ; $i++) {
								$tkk_idx 		= $data_list[$i]['tkk_idx'];
								$tkk_name		= $data_list[$i]['tkk_name'];
								$tkk_mobile 	= $data_list[$i]['tkk_mobile'];
								$tkk_type 		= $data_list[$i]['tkk_type'];
								$tkk_id 		= $data_list[$i]['tkk_id'];
								$tkk_result 		= $data_list[$i]['tkk_result'];
								$tkk_regdate 	= date("Y.m.d", strtotime($data_list[$i]['tkk_regdate']));							
								
								$edit_btn = $C_Button -> getButtonDesign('type2','처리',0,"layerPop('ifm_reg','./kakao_edit.php?tkk_idx=" . $tkk_idx. "', '100%', 750)", 50,'');	
								$edit_btn .= $C_Button -> getButtonDesign('type2','삭제',0,"kakao_del('" . $tkk_idx. "')", 50,'');
								
							?>
									<tr>
										<td><?=$data['page_info']['start_num']--?></td>
                                        <td><?=$tkk_name?></td>	
										<td><?=$tkk_mobile?></td>
                                        <td><?=$tkk_id?></td>									
										<td><?=$GP -> QNA_RESULT[$tkk_result]?></td>
										<td><?=$tkk_regdate?></td>
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

	function kakao_del(tkk_idx)
	{
		if(!confirm("삭제하시겠습니까?")) return;

		$.ajax({
			type: "POST",
			url: "./proc/kakao_proc.php",
			data: "mode=Kakao_DEL&tkk_idx=" + tkk_idx,
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
	
	