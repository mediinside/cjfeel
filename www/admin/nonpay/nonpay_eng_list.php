<?php
	include_once("../../_init.php");
	include_once($GP -> INC_ADM_PATH."/head.php");
	
	include_once($GP->CLS."class.list.php");
	include_once($GP->CLS."class.nonpay.php");
	include_once($GP->CLS."class.button.php");
	$C_ListClass 	= new ListClass;
	$C_Nonpay 	= new Nonpay;
	$C_Button 		= new Button;
	
	$args = array();
	$args['show_row'] = 15;
    $args['pagetype'] = "admin";
    $args['np_lang'] = "eng";
	$data = "";
	$data = $C_Nonpay->NonPay_List(array_merge($_GET,$_POST,$args));
	
	$data_list 		= $data['data'];
	$page_link 		= $data['page_info']['link'];
	$page_search 	= $data['page_info']['search'];
	$totalcount 	= $data['page_info']['total'];
	
	$totalpages 	= $data['page_info']['totalpages'];
	$nowPage 		= $data['page_info']['page'];
	$totalcount_l 	= number_format($totalcount,0);
	
	$data_list_cnt 	= count($data_list);
	
	
	$cate1_select = $C_Func -> makeSelect_Normal('cate1', $GP -> NONPAY_CATE_TYPE1, $cate1, '', '::선택::');
	$cate2_select = $C_Func -> makeSelect_Normal('cate2', $GP -> NONPAY_CATE_TYPE1_1, $_GET['cate2'], ' title="카테고리2"', '::선택::');
?>
<body>
<div class="Wrap"><!--// 전체를 감싸는 Wrap -->
		<? include_once($GP -> INC_ADM_PATH."/header.php"); ?>
		<div class="boxContentBody">
			<div class="boxSearch">
			<? //include_once($GP -> INC_ADM_PATH."/inc.mem_search.php"); ?>										
			<form name="base_form" id="base_form" method="GET">
			<ul>				
				
					<strong class="tit">등록일</strong>
					<span><input type="text" name="s_date" id="s_date" value="<?=$_GET['s_date']?>" class="input_text" size="13"></span>
					<span>~</span>
					<span><input type="text" name="e_date" id="e_date" value="<?=$_GET['e_date']?>" class="input_text" size="13" /></span>
				
				<li>
					<strong class="tit">카테고리</strong>
					<span>
					<?=$cate1_select?>
					<?
						if($_GET['cate1'] == 1) {
							echo $cate2_select;
						}
					?>
					</span> ※카테고리 "행위"선택시 검색 버튼을 한번 눌러주세요.
				</li>	
				<li>
					<strong class="tit">검색조건</strong>
					<span>
					<select name="search_key" id="search_key">
						<option value="">:: 선택 ::</option>
						<option value="np_item" <? if($_GET['search_key'] == "np_item"){ echo "selected";}?> >명칭</option>
						<option value="np_code" <? if($_GET['search_key'] == "np_code"){ echo "selected";}?> >코드</option>
					</select>
					</span>
					<span><input type="text" name="search_content" id="search_content" value="<?=$_GET['search_content']?>" class="input_text" size="16" /></span>
					<span><button id="search_submit" class="btnSearch ">검색</button></span>
				</li>
			</ul>
			</form>
			</div>
		</div>		
		<div class="btnWrap">
		<button onClick="layerPop('ifm_reg','./nonpay_eng_reg.php', '100%', 600)"; class="btnSearch btnRight">비급여 등록</button>
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
							<col style="width:101px;" />
						</colgroup>
						<thead>
							<tr>
								<th>No</th>
								<th>카테고리</th>
								<th>분류</th>
								<th>명칭</th>
								<th>코드</th>
								<th>비용</th>
								<th>등록일</th>
								<th>수정/삭제</th>
							</tr>
						</thead>
						<tbody>
							<?
								$dummy = 1;
								for ($i = 0 ; $i < $data_list_cnt ; $i++) {
									$np_idx 			= $data_list[$i]['np_idx'];
									$cate1 			= $data_list[$i]['cate1'];
									$cate2 			= $data_list[$i]['cate2'];
									$np_item 			= $data_list[$i]['np_item'];
									$np_bunru 		= $data_list[$i]['np_bunru'];
									$np_code 		= $data_list[$i]['np_code'];
									$np_gubun 		= $data_list[$i]['np_gubun'];
									$np_price 		= $data_list[$i]['np_price'];
									$np_regdate 	= $data_list[$i]['np_regdate'];
									
									$edit_btn = $C_Button -> getButtonDesign('type2','수정',0,"layerPop('ifm_reg','./nonpay_eng_edit.php?np_idx=" . $np_idx. "', '100%', 600)", 50,'');	
									$edit_btn .= $C_Button -> getButtonDesign('type2','삭제',0,"nonpay_delete('" . $np_idx. "')", 50,'');							
								?>
								<tr>
									<td><?=$data['page_info']['start_num']--?></td>
									<td>
										<?
											echo $GP -> NONPAY_CATE_TYPE1[$cate1];

											if($cate1 == 1) {
												if($cate2 != '') { echo ">" . $GP -> NONPAY_CATE_TYPE1_1[$cate2]; }
											}
										?>
									</td>
									<td><?=$np_bunru?></td>
									<td><?=$np_item?></td>
									<td><?=$np_code?></td>
									<td><?=number_format($np_price)?></td>				
									<td><?=$np_regdate?></td>
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

			if($.trim($('#search_content').val()) != '')
			{
				if($('#search_key option:selected').val() == '')
				{
					alert('검색조건을 선택하세요');
					return false;
				}
			}

			if($('#search_key option:selected').val() != '')
			{
				if($.trim($('#search_content').val()) == '')
				{
					alert('검색내용을 입력하세요');
					$('#search_content').focus();
					return false;
				}
			}


			$('#base_form').submit();
			return false;
		});

	});

	function nonpay_delete(np_idx)
	{
		if(!confirm("삭제하시겠습니까?")) return;

		$.ajax({
			type: "POST",
			url: "./proc/nonpay_proc.php",
			data: "mode=NONPAY_DEL&np_idx=" + np_idx,
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