<script type="text/javascript" src="<?=$GP -> JS_PATH?>/admin/jquery.base64.js"></script>
<form name="frm_comment" id="frm_comment" action="<?=$get_c_par;?>" method="post">
<?php
  //회원일 경우 비밀번호를 입력할 필요가 없다.
  if(empty($_SESSION['suserid']) || empty($jbc_password))
  {
  ?>
<div class="replyText guest">
  <p class="guestInput">
    <label>이름 : <input type="text" name="jbc_name" id="jbc_name" size="18" maxlength="30" value="<?=$check_name;?>" class="txtInput"></label>  		
		<label>비밀번호 : <input type="password" name="jbc_password" id="jbc_password" size="18" maxlength="50" class="txtInput"></label>
  </p>
  <?php
  }
  else
  {
echo "<div class=\"replyText\">";
		echo ("<input type=\"hidden\" name=\"jbc_name\" id=\"jbc_name\"  value=\"${jbc_name}\">");		   
    echo ("<input type=\"hidden\" name=\"jbc_password\" id=\"jbc_password\" value=\"${jbc_password}\">");
  }
  ?>
   <div class="reply-text">
  <textarea rows="5" cols="20" name="jbc_content" id="jbc_content"><?=$jbc_content;?></textarea>
  <div class="btn-group center">
    <a href="javascript:;" class="btn btn-middle btn-default"  id="comment_modi_submit"><span>수정</span></a> 
		<a href="javascript:history.go(-1);" class="btn btn-middle btn-default"><span>취소</span></a>
	</div>   
   </div>
</div>
 
</form>
<script type="text/javascript">
	$(document).ready(function() {		
		$('#comment_modi_submit').click(function() {
			var t = $.base64Encode($('#jbc_content').val()); 
			$('#jbc_content').val(t);			
			
			if ( $('#jbc_content').val() == "") {
				alert('내용을 입력하세요.');
				$('#jbc_content').focus();
				return false;
			}
			
			$('#frm_comment').submit();
			return false;
		});		
	});
</script>
