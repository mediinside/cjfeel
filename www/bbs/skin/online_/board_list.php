		<form id="search_form" class="board-search" name="search_form" method="get" action="?">
				 <input type="hidden" name="jb_code" id="jb_code" value="<?=$jb_code?>" />
				<fieldset>
					<legend>게시물 검색</legend>
					<select title="검색어 분류" name="search_key" id="search_key"  class="search-scope">
                        <option value="jb_all" <?php if($_GET['search_key']=="jb_all") echo " selected";?>>제목+내용</option>
                        <option value="jb_name" <?php if($_GET['search_key']=="jb_name") echo " selected";?>>작성자</option>
                        
                    
                      </select>
                      <input type="text" class="txt search-input" title="검색어 입력" name="search_keyword" id="search_keyword" value="<?=$_GET['search_keyword']?>" />
					<a href="#;" class="search-btn" id="search_submit"><span>검색</span></a>
				</fieldset>
			</form>	
			
				<table class="board-list">
                    <caption>공지사항 리스트</caption>
					<thead>
						<tr>
							<th class="num">번호</th>
							<th class="subject">제목</th>
							<th class="name">작성자</th>
							<th class="date">작성일</th>
						</tr>
					</thead>
				<tbody>
					<?php include $GP -> INC_PATH . "/action/online_list.inc.php"; ?>
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
			
			if($check_level < 9  && $mpYN == "N"){
				echo "<a class='btn btn-default' href='/member/consult.html'>내 글 보기</a>";
			}
			
			//쓰기권한
			if($check_level >= $db_config_data['jba_write_level']) {
				echo "
				<a class='btn btn-middle btn-default' href=\"#\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}&jb_mode=twrite'\" title='글쓰기'><span>글쓰기</span></a>";
			} else {
				echo "<a class='btn btn-middle' id='twrite_btn' title='글쓰기'><span>글쓰기</span></a>";
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
		location.href ='/member/login.html?reurl=/center/page01.html';
	});
});
</script>
