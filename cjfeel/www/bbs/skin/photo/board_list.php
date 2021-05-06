		<form id="search_form" class="board-search" name="search_form" method="get" action="?">
				 <input type="hidden" name="jb_code" id="jb_code" value="<?=$jb_code?>" />
				<fieldset>
					<legend>게시물 검색</legend>
                    <select title="검색어 분류" name="search_key" id="search_key"  class="search-scope">
                        <option value="jb_title" <?php if($_GET['search_key']=="jb_title") echo " selected";?>>제목</option>
                        <option value="jb_content" <?php if($_GET['search_key']=="jb_content") echo " selected";?>>내용</option>
                        <option value="jb_all" <?php if($_GET['search_key']=="jb_all") echo " selected";?>>제목+내용</option>
                    
                      </select>
                      <input type="text" class="txt search-input" title="검색어 입력" placeholder="키워드를 입력하세요." name="search_keyword" id="search_keyword" value="<?=$_GET['search_keyword']?>" />
					<a href="#;" class="search-btn" id="search_submit"><span>검색</span></a>
				</fieldset>
			</form>	

 <ul class="photo-list video">
        <?php include $GP -> INC_PATH . "/action/photo_list.inc.php"; ?>		
  </ul>

    <div class="pagination"><?=$page_link?></div>
    <div class="btn-group right">
    <?php
    if($_GET['search_key'] && $_GET['search_keyword']) {
        echo "<a href=\"javascript:;\" class=\"btn btn-default\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}'\" title='목록'><strong>목록</strong></a>";
    }
    ?>

    <?php
    //쓰기권한
    if($check_level >= $db_config_data['jba_write_level']) {
        echo "<a class='btn btn-default' href=\"#\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}&jb_mode=twrite'\" title='글쓰기'><strong>글쓰기</strong></a>";
    } else {
    //	echo "<a class='btn btn_middle' id='twrite_btn' title='글쓰기'><strong>글쓰기</strong></a>";
    }
    ?>
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
});
</script>
