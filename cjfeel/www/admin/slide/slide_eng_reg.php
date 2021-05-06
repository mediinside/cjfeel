<?php
	include_once("../../_init.php");
	include_once($GP -> INC_ADM_PATH."/head.php");	
?>
<body>
<div class="Wrap_layer"><!--// 전체를 감싸는 Wrap -->
	<div class="boxContent_layer">
		<div class="boxContentHeader">
			<span class="boxTopNav"><strong>메인 슬라이드 등록</strong></span>
		</div>
		<form name="base_form" id="base_form" method="POST" action="?" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" value="SLIDE_REG" />
        <input type="hidden" name="ts_gubun" value="eng" />
		<div class="boxContentBody">			
			<div class="boxMemberInfoTable_layer">				
				<div class="layerTable">
					<table class="table table-bordered">
						<tbody> 							          							
							<tr>
								<th><span>*</span>제목</th>
								<td colspan="5">
									<input type="text" class="input_text" size="70" name="ts_title" id="ts_title" />
								</td>
							</tr>
							<tr>
								<th><span>*</span>노출여부</th>
								<td colspan="5">
									<label>
										<input type="radio" name="ts_show" id="ts_show" value="Y" checked/> 노출
									</label>
									<label>
										<input type="radio" name="ts_show" id="ts_show" value="N"  /> 비노출
									</label>
								</td>
							</tr>	
							<tr>
								<th><span>*</span>이미지<br> (550 X 360)</th>
								<td>
									<input type="file" name="ts_img" id="ts_img" size="30" class="input_text">
								</td>
                                <th><span>*</span>링크1</th>
								<td>
									<input type="text" name="ts_link" id="ts_link" size="60" class="input_text">
								</td>
							</tr>
						</tbody>
					</table>
				</div>				
				<div class="btnWrap">
					<span class="btnRight">
						<button id="img_submit" class="btnSearch ">등록</button>
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
			
			
			if($('#ts_img').val() == '') {
				alert('이미지를 선택하세요');
				$('#ts_img').focus();
				return false;
			}
			
			
			$('#base_form').attr('action','./proc/slide_proc.php');
			$('#base_form').submit();
			return false;
		});					
	
	});
</script>