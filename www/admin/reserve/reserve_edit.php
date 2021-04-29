<?php
	include_once("../../_init.php");
	include_once($GP -> INC_ADM_PATH."/head.php");		
	include_once($GP -> CLS."/class.reserve2.php");
	$C_Reserve2 	= new Reserve2;
	
	$args = '';
	$args['tr_idx'] = $_GET['tr_idx'];
	$data = $C_Reserve2 -> Reserve_Detail($args);   
	
	if($data) {
		extract($data);
			$tr_content = $C_Func->dec_contents_edit($tr_content);
	}
	
	$sel_result = $C_Func ->makeSelect("tr_result", $GP -> QNA_RESULT, $tr_result , "class='select_type1'", "::: 선택 :::");		
?>

<body>
<div class="Wrap_layer"><!--// 전체를 감싸는 Wrap -->
	<div class="boxContent_layer">
		<div class="boxContentHeader">
			<span class="boxTopNav"><strong>퀵상담 처리</strong></span>
		</div>
		<form name="base_form" id="base_form" method="POST" action="?" enctype="multipart/form-data">
    <input type="hidden" name="mode" id="mode" value="RESERVE_MODI" />
    <input type="hidden" name="tr_idx" id="tr_idx" value="<?=$_GET['tr_idx']?>" />
		<div class="boxContentBody">
			<div class="boxMemberInfoTable_layer">				
				<table class="table table-bordered">
        	<colgroup>
          	<col style="width:15%" />
            <col />
          </colgroup>
			<tbody>		
			<tr>
                <th scope="row"><span class="star">*</span>성명</th>
                <td >
                   <?=$tr_name?>
                </td>
            </tr>    
            <tr class="row">
                <th scope="row"><span class="star">*</span>관심부위</th>
                <td >
                    <?=$tr_gubun?>
                </td>
            </tr>                   
            <tr class="row">
                <th scope="row"><span class="star">*</span>핸드폰</th>
                <td >
                    <?=$tr_mobile?>
                </td>
            </tr> 
            <tr class="row">
                <th scope="row"><span class="star">*</span>통화가능한시간</th>
                <td >
                    <?=$tr_time?>
                </td>
            </tr>         
            <tr class="row">
                <th scope="row"><span class="star">*</span>신청일자</th>
                <td><?=$tr_reg_date?></td>
            </tr>
            <tr class="row">
                <th scope="row"><span class="star">*</span>문의내용</th>
                <td >
                    <?=$tr_content?>
                </td>
            </tr>    
            <tr class="row">
                <th scope="row"><span class="star">*</span>처리상태</th>
                <td><?=$sel_result?></td>
            </tr>
            <tr class="row">
                <th scope="row"><span class="star">*</span>처리내용</th>
                <td>
                  <textarea name="tr_result_con" id="tr_result_con" style="visibility:hidden; width:0px; height:0px;"></textarea>
                  <textarea name="ir1" id="ir1" style="width:100%; height:300px; min-width:280px; display:none;"><?=$tr_result_con?></textarea>
                </td>
            </tr>
            <tr class="row">
                <th scope="row"><span class="star">*</span>처리일자</th>
                <td><input type="text" class="input_text" size="20" name="tr_rt_date" id="tr_rt_date" value="<?=$tr_rt_date?>" /></td>
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
<style>
	.error { color:#F00;}
</style>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=$GP -> JS_SMART_PATH?>/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$GP -> JS_PATH?>/jquery.base64.js"></script>
<script type="text/javascript">

	var oEditors = [];
		nhn.husky.EZCreator.createInIFrame({
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
		callDatePick('tr_rt_date');
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
			$('#tr_result_con').val(con);	
			
			if($('#tr_result_con').val() == '' || $('#tr_result_con').val() == '<br>'){				
				return false;
			}else{			
				var t = $.base64Encode($('#ir1').val());		
				$('#tr_result_con').val(t);
				return true;
			}
														         	
    	}, jQuery.validator.messages.checkinput);	
					
		$('#base_form').validate({
			rules: {	
				tr_result: { required: true},				
				tr_result_con: { checkinput: true},
				tr_rt_date: { required: true}
			},
			messages: {	
				tr_result: { required: "처리상태를 선택하세요" },
				tr_result_con: { checkinput: "처리내용을 입력하세요" }	,
				tr_rt_date: { required: "처리일자를 입력하세요" }			
			},
			errorPlacement: function(error, element) {
				var er = element.attr("name");
				error.insertAfter(element);
			},
			submitHandler: function(frm) {
			if (!confirm("처리하시겠습니까?")) return false;                
				frm.action = './proc/reserve_proc.php';
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

