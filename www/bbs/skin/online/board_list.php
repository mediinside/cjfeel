	
    <div class="search">
        <form id="search_form" name="search_form" method="get" action="?">
            <input type="hidden" name="jb_code" id="jb_code" value="<?=$jb_code?>" />
            <input type="hidden" name="search_key" id="search_key" value="jb_all" /> 					
            <input type="text" placeholder="검색어를 입력하세요." name="search_keyword" id="search_keyword" value="<?=$_GET['search_keyword']?>">
            <button><img src="/resource/images/search-gray.png" alt="검색" id="search_submit" ></button>
        </form>
    </div>
    
    <div class="s-inner">
        <div id="btn-box" class="right">
        <?php
            if($_GET['search_key'] && $_GET['search_keyword']) {
                echo "<a href=\"javascript:;\" class=\"btn0\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}'\" title='목록'><span>목록</span></a>";
            }       
            //쓰기권한
            if($check_level >= $db_config_data['jba_write_level']) {
                echo "<a class='btn bg-green' href=\"#\" onclick=\"javascript:location.href='${index_page}?jb_code=${jb_code}&jb_mode=twrite'\" title='글쓰기'><span>글쓰기</span></a>";
            } else {
            	echo "<a class='btn bg-green' id='twrite_btn' title='글쓰기'><strong>글쓰기</strong></a>";
            }
        ?>          
        </div>
        <!-- 게시판 목록 -->
        <div class="tableType-01 green no-border">
            <table class="list">
                <colgroup>
                    <col style="width:120px">
                    <col>
                    <col class="admin" style="width:180px">
                    <col style="width:180px">
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>제목</th>
                        <th class="admin">작성자</th>
                        <th>날짜</th>
                    </tr>
                </thead>
                <tbody>
            <?php include $GP -> INC_PATH . "/${skin_dir}/board_list_inc.php";	?>
                 </tbody>
            </table>
        </div>
        <!-- //end tableType -->
        <div class="pagination">
            <?=$page_link?>														
        </div>
        </div>
    </section>
    <!-- //end #container -->

    
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