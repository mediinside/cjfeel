<!-- 게시물 보기 -->
<div class="board-view">
 <h4 class="subject"><?=$jb_title?></h4>
  <dl class="info">
    <dt>작성일</dt><dd><?=$jb_reg_date?></dd>
    <dt>구분</dt><dd><?=$jb_etc1?></dd>
    <!--dt>첨부파일</dt><dd>
		<?php								
		if($file_cnt > 0)
		{
			for($i=0; $i<$file_cnt; $i++)
			{
				if($ex_jb_file_name[$i])
				{		
					$code_file = $GP->UP_IMG_SMARTEDITOR. "jb_${jb_code}/${ex_jb_file_code[$i]}";							
					echo "<a href=\"/bbs/download.php?downview=1&file=" . $code_file . "&name=" . $ex_jb_file_name[$i] . " \">$ex_jb_file_name[$i]</a>";							
					if($i < ($file_cnt-1))
						echo ", ";
				}	 
			}
		} 
		?>
    </dd-->
  </dl> 
  <div class="contents">
  	<?php								
			if($file_cnt > 0) {
				for($i=0; $i<$file_cnt; $i++)	{
					if($ex_jb_file_name[$i]) {
						//파일의 확장자
						$file_ext = substr( strrchr($ex_jb_file_name[$i], "."),1); 
						$file_ext = strtolower($file_ext);	//확장자를 소문자로...
						
						if ($file_ext=="gif" || $file_ext=="jpg" || $file_ext=="png" || $file_ext=="bmp") {										
							echo "<a href='" . $GP->UP_IMG_SMARTEDITOR_URL ."jb_${jb_code}/${ex_jb_file_code[$i]}' target='_blank'>";
							echo "<img src=\"" . $GP->UP_IMG_SMARTEDITOR_URL ."jb_" . $jb_code . "/" . $ex_jb_file_code[$i] ."\" class='imgResponsive'>";
							echo "</a>";
						}
					}	 
				}
			}
		?>
    <?=$content?>
  </div>
  <div class="btn-group">
    <div class="btn-lt">
      <?php
				//글목록버튼
				echo "<a href=\"#\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}&${search_key}&search_keyword=${search_keyword}&page=${page}'\" class=\"btn btn-middle btn-default\" title='목록'><span>목록</span></a>";	
				?>
   </div>
    <div class="btn-rt">
      <?
			//답변권한
			//if($check_level >= $db_config_data['jba_reply_level'])
					//echo "<a href=\"#\" onclick=\"javascript:location.href='${get_par}&jb_mode=treply'\" class=\"btnM btnAnswer \" title=\"답글\">답글</a> ";			
			//수정(쓰기권한이 있어야 수정 가능)
			if($check_level >= 9 || $check_id == $jb_mb_id)
					echo "<a href=\"#\" onclick=\"javascript:location.href='${get_par}&jb_mode=tmodify'\" class=\"btn btn-middle btn-default \" title=\"수정\"><span>수정</span></a> ";
			//삭제권한(쓰기권한이 있어야 삭제 가능)
			if($check_level >= 9 || $check_id == $jb_mb_id)
					echo "<a href=\"#\" onclick=\"javascript:location.href='${get_par}&jb_mode=tdelete'\" class=\"btn btn-middle \" title=\"삭제\"><span>삭제</span></a> ";								
			//쓰기권한
			if($check_level >= $db_config_data['jba_write_level'])
					//echo "<a href=\"#\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}&jb_mode=twrite'\" class=\"btn btn_middle btn_gray \" title=\"쓰기\"><span>쓰기</span></a>";						
			?>
    </div>
  </div>
<?php
if($be_idx == '') {
	$get_par1 = "javascript:void(0)";
	$be_content = "이전 게시물이 없습니다";
}
if($af_idx == '') {
	$get_par2 = "javascript:void(0)";
	$af_content = "다음 게시물이 없습니다";
}
?>
	<ul class="board-view-list">
		<li>
			<a href="<?=$get_par1?>"><strong>이전</strong><span><?=$be_content?></span></a>
		</li>
		<li>
			<a href="<?=$get_par2?>"><strong>다음</strong><span><?=$af_content?></span></a>
		</li>
	</ul>
	<!--
	<?php if($be_idx != "" && $af_idx != '') { ?>
	<ul class="board_view_pager">
		<?php if($be_idx != '') { ?>
		<li>
			<a href="<?=$get_par1?>"><strong>이전</strong><span><?=$be_content?></span></a>
		</li>
		<?php }?>
		<?php if($af_idx != '') { ?>
		<li>
			<a href="<?=$get_par2?>"><strong>다음</strong><span><?=$af_content?></span></a>
		</li>
		<?php }?>
	</ul>
	<?php }?>
	-->
</div>
<!-- //게시물 보기 -->
<!-- 댓글 -->
<?
//if($jb_order >= 100 && $db_config_data['jba_comment_use'] == 'Y'  && $check_level >= $db_config_data['jba_comment_level']) {	
?>
<!--div class="reply_section">
  <? 	include $GP -> INC_PATH . "/action/comment.inc.php"; ?>
</div-->
<?
//} //end_of_if($jb_order >= 100)
?>
<!-- //댓글 -->
