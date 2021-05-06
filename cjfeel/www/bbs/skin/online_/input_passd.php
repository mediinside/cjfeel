<div class="section">
	<form name="frm_pass" id="frm_pass" action="<?=$get_par;?>" method="post">
		<div class="board-write">
			<table>
				<caption>게시물 작성</caption>
				<colgroup>
					<col />
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row"><label for="input_passd">비밀번호</label></th>
						<td><input type="password" name="input_passd" id="input_passd" size=25 maxlength=30 class="i_text" /></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="btn-group center">
			<a href="#;" id="pass_submit" class="btn btn-middle btn-default"><span>확인</span></a>
			<a href="javascript:history.go(-1);" class="btn btn-middle"><span>취소</span></a>
		</div>
	</form>
</div>


<script type="text/javascript">
	
	$(document).ready(function(){
		
		$('#pass_submit').click(function(){
			
			if($('#input_passd').val() == '') {
				alert("비밀번호를 입력하세요");
				$('#input_passd').focus();
				return false;
			}
			
			$('#frm_pass').submit();
			return false;
		});		
	});
	
</script>