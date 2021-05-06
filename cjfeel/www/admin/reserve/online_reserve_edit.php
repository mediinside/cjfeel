<?php
	include_once("../../_init.php");
	include_once($GP -> INC_ADM_PATH."/head.php");	
	include_once($GP -> INC_ADM_PATH."inc.adm_auth.php");
	include_once($GP -> CLS."/class.online.php");
	$C_Online 		= new Online;
	
	$args = '';
	$args['tor_idx'] = $_GET['tor_idx'];
	$data = $C_Online->Online_Reserve_Detail($args);   
	
	if($data) {
		extract($data);
		
		$tor_rs_content = $C_Func->dec_contents_edit($tor_rs_content);
		
	}
	
	$sel_result = $C_Func ->makeSelect("tor_rs_type", $GP -> RESERVE_RESULT, $tor_rs_type , "class='select_type1'", "::: 선택 :::");	
	//$cn_select = $C_Func -> makeSelect_Normal('tor_rs_clinic', $GP -> CLINIC_TYPE, $dr_clinic, '', '::선택::');	
	
	
?>

<body>
<div class="Wrap_layer"><!--// 전체를 감싸는 Wrap -->
	<div class="boxContent_layer">
		<div class="boxContentHeader">
			<span class="boxTopNav"><strong>온라인  예약 처리</strong></span>
		</div>
		 <form name="base_form" id="base_form" method="POST" action="?" enctype="multipart/form-data">
            <input type="hidden" name="mode" id="mode" value="ONLINE_RESERVE_MODI" />
            <input type="hidden" name="tor_idx" id="tor_idx" value="<?=$_GET['tor_idx']?>" />
		<div class="boxContentBody">
			<div class="boxMemberInfoTable_layer">				
				<table class="table table-bordered">
					<tbody>		
						<tr class="first">
								<th width="15%"><span class="star">*</span>이메일</th>
								<td width="85%">
										<?=$mb_email?>
								</td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>초/재진</th>
								<td >
									 <? if($tor_rs_exam == 'N') { echo "재진";}else{ echo "초진";} ?>
								</td>
						</tr>    
						<tr class="row">
								<th scope="row"><span class="star">*</span>성명</th>
								<td >
									 <?=$tor_rs_name?>
								</td>
						</tr>                    
						<tr class="row">
								<th scope="row"><span class="star">*</span>핸드폰</th>
								<td >
										<?=$tor_rs_phone?>
								</td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>문의내용</th>
								<td >
										<?=$tor_rs_content?>
								</td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>예약일자</th>
								<td >
										<input type="text" class="input_text" size="25" name="tor_rs_date" id="tor_rs_date" value="<?=$tor_rs_date?>" />
								</td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>예약시간</th>
								<td >
										<input type="text" class="input_text" size="25" name="tor_rs_time" id="tor_rs_time" value="<?=$tor_rs_time?>" />
								</td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>신청일자</th>
								<td><?=$tor_regdate?></td>
						</tr>
						<!-- tr class="row">
								<th scope="row"><span class="star">*</span>진료과목</th>
								<td><?=$cn_select?></td>
						</tr -->
						
						
						
						<tr class="row">
								<th scope="row"><span class="star">*</span>처리상태</th>
								<td><?=$sel_result?></td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>처리내용</th>
								<td>
									<input type="hidden" name="tor_rs_result_content" id="tor_rs_result_content" />
									<textarea name="ir1" id="ir1" style="width:100%; height:300px; min-width:280px; display:none;"><?=$tor_rs_result_content?></textarea>
								</td>
						</tr>
						<tr class="row">
								<th scope="row"><span class="star">*</span>처리일자</th>
								<td><input type="text" class="input_text" size="20" name="tor_rs_result_date" id="tor_rs_result_date" value="<?=$tor_rs_result_date?>" /></td>
						</tr>
					</tbody>
				</table><div style="margin-top:5px; text-align:center;">
				<button id="img_submit" class="btnSearch ">답변</button>
				<button id="img_cancel" class="btnSearch ">취소</button>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
</body>
</html>
<script src="/admin/js/jquery.alphanumeric.js" type="text/javascript"></script>
<script type="text/javascript" src="/admin/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=$GP -> JS_SMART_PATH?>/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$GP -> JS_PATH?>/jquery.base64.js"></script>
<script type="text/javascript">

	var oEditors = [];
		nhn.husky.EZCreator.createInIFrame   ({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/bbs/smarteditor/SmartEditor2Skin1.html",
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
			//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
			fOnBeforeUnload : function(){
				//alert("완료!");
			}
		}, //boolean
		fOnAppLoad : function(){
			//예제 코드
			//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);  
		},
		fCreator: "createSEditor2"
	});

	$(function() {
		callDatePick('tor_rs_result_date');
		callDatePick('tor_rs_date');
	});
	

	$(document).ready(function(){	
		
		$('#img_submit').click(function(){		
			$('#base_form').submit();
			return false;
		});
		
		$('#img_cancel').click(function(){
				parent.modalclose();				
		});
		
		$.validator.addMethod("checkinput", function(value, element) { 
			
			oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);			
			var con	= $('#ir1').val();
			
			$('#tor_rs_result_content').val(con);	
			
			if($('#tor_rs_result_content').val() == '' || $('#tor_rs_result_content').val() == '<br>'){				
				return false;
			}else{			
				var t = $.base64Encode($('#ir1').val());		
				$('#tor_rs_result_content').val(t);
				return true;
			}
														         	
    }, jQuery.validator.messages.checkinput);	
					
		$('#base_form').validate({
			ignore: "",
			rules: {	
				tor_rs_type: { required: true},				
				tor_rs_result_content: { checkinput: true},
				tor_rs_result_date: { required: true}
			},
			messages: {	
				tor_rs_type: { required: "처리상태를 선택하세요" },
				tor_rs_result_content: { checkinput: "처리내용을 입력하세요" }	,
				tor_rs_result_date: { required: "처리일자를 입력하세요" }			
			},
			errorPlacement: function(error, element) {
				var er = element.attr("name");
				error.insertAfter(element);
			},
			submitHandler: function(frm) {
			if (!confirm("처리하시겠습니까?")) return false;                
				frm.action = './proc/online_proc.php';
				frm.submit(); //통과시 전송
				return true;
			},

			success: function(element) {
			//
			}
		
		});
		
	});
	
	function callDatePick (id) {	
		var dates = $( "#" + id ).datepicker({
			prevText: '이전 달',
			nextText: '다음 달',
			monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNames: ['일','월','화','수','목','금','토'],
			dayNamesShort: ['일','월','화','수','목','금','토'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			dateFormat: 'yy-mm-dd',
			showMonthAfterYear: true,
			yearSuffix: '년'	  
		});
	}
</script>

