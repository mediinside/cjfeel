<?php
	include_once("../../_init.php");
	include_once($GP -> INC_ADM_PATH."/head.php");	
	include_once($GP -> INC_ADM_PATH."inc.adm_auth.php");
	include_once($GP -> CLS."/class.member.php");
	$C_Member 	= new Member;
	
	$args = "";
	$args['mb_code'] = $_GET['mb_code'];
	$data = $C_Member->Mem_Info($args);
	
	if($data) {
		extract($data);
		
		$arr_post = explode("-", $mb_zip_code);
		$m_post1 = $arr_post[0];
		$m_post2 = $arr_post[1];
		
		$arr_mobile = explode("-", $mb_mobile);
		$m_mobile1 = $arr_mobile[0];
		$m_mobile2 = $arr_mobile[1];
		$m_mobile3 = $arr_mobile[2];				

		$mobile_select = $C_Func -> makeSelect('m_mobile1', $GP -> MOBILE, $m_mobile1, '', '::선택::');		
	}
?>

<body>
<div class="Wrap_layer"><!--// 전체를 감싸는 Wrap -->
	<div class="boxContent_layer">
		<div class="boxContentHeader">
			<span class="boxTopNav"><strong>회원정보 수정</strong></span>
		</div>
		<form name="base_form" id="base_form" method="POST" action="?" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" value="MEM_MODI" />
		<input type="hidden" name="mb_code" id="mb_code" value="<?=$_GET['mb_code']?>" />
		<div class="boxContentBody">
			<div class="boxMemberInfoTable_layer">
				<div class="layerTable">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th width="15%"><span>*</span>회원명</th>
							<td width="85%">
								<input type="text" class="input_text" size="25" name="mb_name" id="mb_name" value="<?=$mb_name?>" />
							</td>
						</tr>
						<tr>
							<th><span>*</span>이메일</th>
							<td>
								<input type="text" class="input_text" size="25" name="mb_email" id="mb_email" value="<?=$mb_email?>" />
							</td>
						</tr>
                          <tr>
							<th><span>*</span>EMAIL 수신</th>
							<td>
								<input type="radio" name="mb_email_flag" value="Y" <? if($mb_email_flag == 'Y'){ echo "checked"; } ?> />동의
								<input type="radio" name="mb_email_flag" value="N" <? if($mb_email_flag == 'N'){ echo "checked"; } ?> />거부
							</td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="btnWrap">
				<button id="img_submit" class="btnSearch ">수정</button>
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
<script type="text/javascript">

	$(document).ready(function(){	
														 
		   
								   
		
		
		$('#img_submit').click(function(){					
			$('#base_form').submit();
			return false;
		});
		
		$('#img_cancel').click(function(){
				parent.modalclose();				
		});
		
		$.validator.addMethod("emailcheck", function(value, element) {
			var val = value;
			return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(val);
		
		}, jQuery.validator.messages.emailcheck);
					
		$('#base_form').validate({
			rules: {	
				mb_name: { required: true},				
				mb_email: { required: true, emailcheck:true}
					
			},
			messages: {	
				mb_name: { required: "회원명을 입력하세요" },
				mb_email: { required: "이메일을 입력하세요", emailcheck:"올바른 이메일을 입력하세요" }		
				
			},
			onkeyup:false,
			onclick:false,
			onfocusout:false,			
			showErrors: function(errorMap, errorList) {
				if(!$.isEmptyObject(errorList)){
		      var caption = $(errorList[0].element).attr('caption') || $(errorList[0].element).attr('name');
					alert(errorList[0].message);
				}
			},
			submitHandler: function(frm) {
			if (!confirm("수정하시겠습니까?")) return false;                
				frm.action = './proc/mem_proc.php';
				frm.submit(); //통과시 전송
				return true;
			},

			success: function(element) {
			//
			}
		
		});
		
	});
</script>

