<?php
	include_once("../../_init.php");
	include_once($GP -> INC_ADM_PATH."/head.php");	
	
	include_once($GP -> CLS."/class.hold.php");
	$C_Hold  	= new Hold;
	
	$args = "";
	$args['ts_idx'] 	= $_GET['ts_idx'];
	$rst = $C_Hold ->Slide_Info($args);
	
	if($rst) {
		extract($rst);
		$ts_content  = $C_Func->dec_contents_edit($ts_content);				

	}
?>
<body>
<div class="Wrap_layer"><!--// 전체를 감싸는 Wrap -->
	<div class="boxContent_layer">
		<div class="boxContentHeader">
			<span class="boxTopNav"><strong>메인 슬라이드 수정</strong></span>
		</div>
		<form name="base_form" id="base_form" method="POST" action="?" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" value="SLIDE_MODI" />
		<input type="hidden" name="ts_idx" id="ts_idx" value="<?=$_GET['ts_idx']?>" />
		<input type="hidden" name="before_image_main" id="before_image_main" value="<?=$ts_img?>" />
		<input type="hidden" name="before_image_main_m" id="before_image_main_m" value="<?=$ts_m_img?>" />
        <input type="hidden" name="before_image_main_t" id="before_image_main_t" value="<?=$ts_t_img?>" />
        <input type="hidden" name="before_image_main2" id="before_image_main2" value="<?=$ts_img2?>" />
		<input type="hidden" name="before_image_main_m2" id="before_image_main_m2" value="<?=$ts_m_img2?>" />
        <input type="hidden" name="before_image_main_t2" id="before_image_main_t2" value="<?=$ts_t_img2?>" />
		<div class="boxContentBody">			
			<div class="boxMemberInfoTable_layer">				
				<div class="layerTable">
					<table class="table table-bordered">
						<tbody>							          							
							<tr>
								<th><span>*</span>제목</th>
								<td colspan="5">
									<input type="text" class="input_text" size="70" name="ts_title" id="ts_title" value="<?=$ts_title?>" />
								</td>
							</tr>
							<tr>
								<th><span>*</span>노출여부</th>
								<td colspan="5">
									<input type="radio" name="ts_show" id="ts_show" value="Y" <? if($ts_show == "Y"){ echo "checked";}?> />노출
									<input type="radio" name="ts_show" id="ts_show" value="N" <? if($ts_show == "N"){ echo "checked";}?> />비노출
								</td>
							</tr>	
						<tr>
							<th><span>*</span>이미지<br> (550 X 360)</th>
							<td>
								<input type="file" name="ts_img" id="ts_img" size="30">
								<?
									if($ts_img != "") {
										echo  "<br>" . $ts_img;
								?>
									<a href="#" onClick="img_del('<?=$ts_img;?>','<?=$_GET['ts_idx']?>','W')">(X)</a>
								<? } ?>
							</td>                      
                            <th><span>*</span>링크1</th>
                            <td>
                                <input type="text" name="ts_link" id="ts_link" size="60" class="input_text" value="<?=$ts_link?>">
                            </td>
						</tr>					
						</tbody>
					</table>
				</div>				
				<div class="btnWrap">
					<span class="btnRight">
						<button id="img_submit" class="btnSearch ">수정</button>
						<button id="img_cancel" class="btnSearch ">취소</button>
					</span>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
</body>
</html>
<script type="text/javascript">


	function img_del(image, idx, type)
	{
		if(!confirm("삭제하시겠습니까?")) return;

		$.ajax({
			type: "POST",
			url: "./proc/slide_proc.php",
			data: "mode=SLIDE_IMGDEL&ts_idx=" + idx + "&file=" + image + "&type=" + type,
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

	$(document).ready(function(){	
														 
		$('#img_cancel').click(function(){
				parent.modalclose();				
		});	
		
		
		$('#img_submit').click(function(){
			
			if($('#ts_descrition').val() == '') {
				alert('소제목을 입력하세요');
				$('#ts_descrition').focus();
				return false;
			}		
			
			if($('#ts_title').val() == '') {
				alert('제목을 입력하세요');
				$('#ts_title').focus();
				return false;
			}	
			
			if($('#ts_content').val() == '') {
				alert('내용을 입력하세요');
				$('#ts_content').focus();
				return false;
			}
			
			
			$('#base_form').attr('action','./proc/hold_proc.php');
			$('#base_form').submit();
			return false;
		});					
	
	});
</script>