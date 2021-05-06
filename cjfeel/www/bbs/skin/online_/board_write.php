<script type="text/javascript" src="<?=$GP -> JS_SMART_PATH?>/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$GP -> JS_PATH?>/admin/jquery.base64.js"></script>
<form name="frm_Board" id="frm_Board" action="<?=$get_par;?>" method="post" enctype="multipart/form-data">
<input type="hidden" class="chk" value="Y" id="jb_secret_check" name="jb_secret_check" />
<input type="hidden" id="jb_owner_id" name="jb_owner_id" value="<?=$jb_mb_id?>" />
<? if($check_gubun !='') {?>
 <div class="terms">
		<div class="panel">
				<? include_once $GP -> HOME ."/member/agree2.txt";?>
		</div>
		<div class="agreement">
				<label class="privacy"><input type="radio" class="none" value="Y" name="o_agree" id="o_agree" /><span>동의합니다</span></label>
				<label class="privacy"><input type="radio" class="none" value="N" name="o_agree" id="o_agree" /><span>동의 하지 않습니다</span></label>
				<span class="remarks">* 고객님은 동의를 거부할 수 있습니다. 다만 동의를 거부할 경우 해당서비스 이용이 제한됩니다.</span>
		</div>
	</div>
 <? } ?>
  <table class="board-write">
        <caption>공지사항 내용 작성</caption>
        <colgroup>
            <col>
            <col>
        </colgroup>
        <tbody>
        <tr>
          <th scope="row">제목</th>
          <td><input type="text" class="i_text full" title="제목 입력" placeholder="제목을 입력해 주세요." autocomplete="off" id="jb_title" name="jb_title" /></td>
        </tr>
        <tr>
          <th scope="row">작성자</th>
          <td><input type="text" class="i_text full" title="작성자 입력" placeholder="작성자를 입력해 주세요."id="jb_name" name="jb_name" value="<?=$check_name?>" /></td>
        </tr>
         <tr>
         <? $jb_email_p = explode("@",$_SESSION['suseremail']);?>
            <th scope="row">이메일</th>
            <td>
                <input type="text" class="i_text" title="이메일 입력" placeholder="이메일" id="jb_email1" name="jb_email1" value="<?=$jb_email_p[0]?>" autocomplete="off" />
                <span class="empty">@</span>
                 <input type="text" class="i_text" title="이메일 입력" placeholder="이메일" id="jb_email2" name="jb_email2" value="<?=$jb_email_p[1]?>" autocomplete="off" />
                <? echo $sel_email= $C_Func -> makeSelect('email_sel', $GP->EMAIL, $email_sel,"title='도메인 선택' ",'직접선택');?>
            </td>
        </tr>
     <? if($check_level >= 9){?>
        <tr>
          <th scope="row">노출여부</th>
          <td>
          	<select name="jb_show" id="jb_show">
              <option value="B" <? if($jb_show == "B") { echo "selected"; }?>>게시</option>
              <option value="A" <? if($jb_show == "A") { echo "selected"; }?>>비게시</option>              
            </select>
          </td>
        </tr>
        <? } ?>
         <tr>
          <th scope="row">첨부파일</th>
          <td class="files">
           <?php
						//첨부파일의 숫자는 $i의 범위로 조정하면 된다.
						for($i=0; $i<1; $i++) {
						?>
						<div  class="inputFile">
              <input type="text" class="i_text" placeholder="첨부파일" readonly />
              <label class="fileBtn">
                <input type="file" title="파일선택" name="jb_file[]" />
                <span class="btn btn-small">파일선택</span>
              </label>
            </div>
						<? } ?>
          </td>
        </tr>
        <?php
        //회원일 경우 비밀번호를 입력할 필요가 없다.
        if(empty($check_id)) {
        ?>
        <tr>
          <th scope="row">비밀번호</th>
          <td><input type="text" class="i_text" title="비밀번호 입력" placeholder="비밀번호" id="jb_password" name="jb_password" />
          <p class="explain">분실시 글 조회가 불가능 합니다.</p></td>
        </tr>
        <?php
        } else {
          $password_key=md5($check_id);	
          $tm=explode(" ",microtime());
          $jb_password=$password_key . $tm[1];
          echo ("<input type=\"hidden\" name=\"jb_password\" value=\"${jb_password}\">");
        }
        ?>
        <tr>
          <th scope="row">본문</th>
          <td>
            <textarea name="jb_content" id="jb_content" style="display:none"></textarea>
            <textarea name="ir1" id="ir1" style="width:100%; height:300px; min-width:280px; display:none;"></textarea>
          </td>
        </tr>      
         <? if($check_level < 9) {?>
            <tr>
              <th scope="row">자동입력방지</th>
              <td>
                <img src="<?=$GP -> IMG_PATH?>/zmSpamFree/zmSpamFree.php?zsfimg=<?php echo time();?>" id="zsfImg" alt="아래 새로고침을 클릭해 주세요." style="vertical-align:middle;" />
                <input type="text" class="i_text" title="자동입력방지 숫자 입력" style="width:60px;" name="zsfCode" id="zsfCode" />
                <a href="#;" class="btn btn-gray btn-small" onclick="document.getElementById('zsfImg').src='<?=$GP -> IMG_PATH?>/zmSpamFree/zmSpamFree.php?re&zsfimg=' + new Date().getTime(); return false;"><span>새로고침</span></a>
              </td>
            </tr>
            <? } ?>
      </tbody>
    </table>
  <div class="btn-group right">
    <a href="#;" id="img_submit" class="btn btn-middle btn-default"><span>등록</span></a>
    <a href="javascript:history.go(-1);" class="btn btn-gray"><span>취소</span></a>
  </div>
  <input type="hidden" name="jb_bruse_check" value="Y" checked>
  <input type="hidden" name="img_full_name" id="img_full_name" />
  <input type="hidden" name="upfolder" id="upfolder" value="jb_<?=$jb_code?>" />
</form>
<script type="text/javascript">
	

	var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/bbs/smarteditor/SmartEditor2Skin.html",
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

	$('#img_submit').click(function(){
		<? if($check_gubun !='') {?>
			if($('input:radio[name="o_agree"]:checked').val() != "Y" ) {
			alert("개인정보 처리방침에 동의시에 이용이 가능합니다.");
			return false;
		}
		<? } ?>	

		if($('#jb_title').val() == '')	{
			alert('제목을 입력하세요');
			$('#jb_title').focus();
			return false;
		}		
		
/*		if($('#jb_name').val() == '')	{
			alert('이름을 입력하세요');
			$('#jb_name').focus();
			return false;
		}
*/		
		if($('#jb_password').val() == '')	{
			alert('비밀번호를 입력하세요');
			$('#jb_password').focus();
			return false;
		}
		
/*		if($('#jb_email').val() == '' || !CheckEmail($('#jb_email').val()))	{
			alert('이메일을 정확히 입력하세요');
			$('#jb_email').focus();
			return false;
		}
*/	
		oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
	
		var con	= $('#ir1').val();
		
		
		$('#jb_content').val(con);		

		if($('#jb_content').val() == '' || $('#jb_content').val() == '<br> ')
		{
			alert('내용을 입력하세요');
			return false;
		}	
		var t = $.base64Encode($('#ir1').val());		
		$('#jb_content').val(t);
		
			
		<? if($check_level < 9) {?>	
			if($('#zsfCode').val() == '')	{
				alert('자동방지 입력키를 입력하세요');
				$('#zsfCode').focus();
				return false;
			}		
		<? } ?>
		
		
		$('#frm_Board').submit();
		return false;
		
	});
	

	function CheckEmail(str)
	{
		 var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
		 if (filter.test(str)) { return true; }
		 else { return false; }
	}

	function insertIMG(filename){
		var tname = document.getElementById('img_full_name').value;

		if(tname != "")
		{
			document.getElementById('img_full_name').value = tname + "," + filename;
		}
		else
		{
			document.getElementById('img_full_name').value = filename;
		}
	}
	
	$('#email_sel').change(function(){
			var val = $(this).val();
		
			if(val == "") {
				$('#jb_email2').val('');
			}else{
				$('#jb_email2').val(val);
			}
		
			});	

</script>
