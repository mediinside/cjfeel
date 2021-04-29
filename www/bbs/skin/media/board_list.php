	<form id="search_form" class="board-search" name="search_form" method="get" action="?">
				 <input type="hidden" name="jb_code" id="jb_code" value="<?=$jb_code?>" />
                 <input type="hidden" name="search_key" id="search_key" value="jb_all" /> 
				<fieldset>
					<legend>게시물 검색</legend>
                      <input type="text" class="txt search-input" title="검색어 입력" placeholder="키워드를 입력하세요." name="search_keyword" id="search_keyword" value="<?=$_GET['search_keyword']?>" />
					<a href="#;" class="search-btn" id="search_submit"><span>검색</span></a>
				</fieldset>
			</form>	
			
			<table class="board-list">
				<caption>공지사항 리스트</caption>
				<colgroup>
					<col width="170px">
					<col width="*">
					<col width="170px">
				</colgroup>
				<thead>
					<tr>
						<th><span>번호</span></th>
						<th><span>제목</span></th>
						<th><span>작성일</span></th>
					</tr>

				</thead>
				<tbody>
					<?php include $GP -> INC_PATH . "/action/media_list.inc.php"; ?>
				</tbody>
			</table>
			
			 <div class="btn-group">
            <div class="btn-rt">

			<?php
			if($_GET['search_key'] && $_GET['search_keyword']) {
				echo "<a href=\"javascript:;\" class=\"btn btn-middle btn-default\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}'\" title='목록'><span>목록</span></a>";
			}
			?>

			<?php
			//쓰기권한
			if($check_level >= $db_config_data['jba_write_level']) {
				echo "<a class='btn btn-middle btn-default' href=\"#\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}&jb_mode=twrite'\" title='글쓰기'><span>글쓰기</span></a>";
			} else {
			//	echo "<a class='btn btn_middle' id='twrite_btn' title='글쓰기'><strong>글쓰기</strong></a>";
			}
			?>
            </div>
        </div>
		<div class="pagination">
			<?=$page_link?>
        </div>

<script type="text/javascript">
$(document).ready(function(){
	$('#search_submit').click(function(){
		$('#search_form').submit();
		return false;
	});

	$('#page_row').change(function(){
		var val = $(this).val();
		location.href="?dep1=<?=$_GET['dep1']?>&dep2=<?=$_GET['dep2']?>&search_key=<?=$_GET['search_key']?>&search_keyword=<?=$_GET['search_keyword']?>&page=<?=$_GET['page']?>&page_row=" + val;
	});
	
	$('#twrite_btn').click(function(){	
		alert("로그인 후 이용가능 합니다.");
		location.href ='/member/login.html?reurl=/community/page03.html';
	});
});
</script>
