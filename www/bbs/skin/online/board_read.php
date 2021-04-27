<div class="cont-tit" style="opacity: 0;display: none;">
				<h3>글읽기</h3>
			</div>
			<div class="s-inner" style="margin-top: 100px;">
				<div class="tableType-01 green no-border">
					<table width="100%" class="viewType">
						<caption style="display:none;">공지사항 상세</caption>
						<colgroup>
							<col width="33.33%">
							<col width="33.33%">
							<col width="33.33%">
						</colgroup>
						<tbody>
							<tr>
								<th scope="row" colspan="3"><?=$jb_title?></th>
							</tr>
							<tr>
								<td><span class="tit">작성자</span> <strong class="mg-l10"><?=$jb_name?></strong></td>
								<td><span class="tit">조회수</span> <strong class="mg-l10"><?=$jb_see?></strong></td>
								<td><span class="tit">작성일</span> <strong class="mg-l10"><?=$jb_reg_date?></strong></td>
							</tr>
							<?php if($jb_homepage) {?>
							<!--tr>
								<td style="text-align:left;" colspan="3">
                                <span class="tit">링크</span> <?=$jb_homepage?>									
								</td>
							</tr-->
							<?}?>		
							<tr>
								<td style="text-align:left;" colspan="3">
									<div class="viewCont">
										<?=$content?>
									</div>
								</td>
							</tr>
													
							<?php if($file_cnt > 0) {?>
							<tr>
                                <td style="text-align:left;" colspan="3">
									<div class="viewFile">
							<?
							for($i=0; $i<$file_cnt; $i++)	{
										if($ex_jb_file_name[$i]) {
											//파일의 확장자
											
											$file_ext = substr( strrchr($ex_jb_file_name[$i], "."),1); 
											$file_ext = strtolower($file_ext);	//확장자를 소문자로...                                               	
											
											/*if ($file_ext=="gif" || $file_ext=="jpg" || $file_ext=="png" || $file_ext=="bmp") {	
																			
												echo "<a  class='file'  href='" . $GP->UP_IMG_SMARTEDITOR_URL ."jb_${jb_code}/${ex_jb_file_code[$i]}' target='_blank'>";
												echo "<img src=\"" . $GP->UP_IMG_SMARTEDITOR_URL ."jb_" . $jb_code . "/" . $ex_jb_file_code[$i] ."\" class='imgResponsive'>";
												echo "</a>";
											}
											else{*/
												$code_file = $GP->UP_IMG_SMARTEDITOR. "jb_${jb_code}/${ex_jb_file_code[$i]}";
												echo "<p><img src='/resource/images/down-02.png' alt=''>&nbsp;<a class='file' href=\"/bbs/download.php?downview=1&file=" . $code_file . "&name=" . $ex_jb_file_name[$i] . " \">$ex_jb_file_name[$i]</a></p>";

											//}
										}	 
									}
							?>
									</div>
								</td>
							</tr>
							<?}?>
									

						</tbody>
					</table>
					<div id="btn-box" class="right">
						<a href="<?=$get_par1?>" class="btn bg-green">이전글</a>
                        <a href="<?=$get_par2?>" class="btn bg-green">다음글</a>
                        <?if($check_level >= 9 ) {
                            $onclick4 = "onclick=\"javascript:location.href='${get_par}&jb_mode=treply'\"";
                        ?>
                        <a href='#none' <?=$onclick4?> class='btn bg-lightgreen'>답글</a>
                        <?}?>
                        <?if($check_level >= $db_config_data['jba_write_level']) { ?>
                        
						<a href="#none" onclick="javascript:location.href='<?=$get_par?>&jb_mode=tdelete'"  class="btn bg-gray" title="삭제">삭제</a>
						<a href="#\" onclick="javascript:location.href='<?=$get_par?>&jb_mode=tmodify'"  class="btn bg-pink" title="수정">수정</a>
						<?}?>
						<a href="<?=$index_page?>?jb_code=<?=$jb_code?>&<?=$search_key?>&search_keyword=<?=$search_keyword?>&page=<?=$page?>" class="btn bg-orange">목록</a>
					</div>

					<div class="viewComment">
						<ul>
						<?php
					//공지글은 댓글 달수 없게... 2007-07-28
					if($jb_order >= 100 && $db_config_data['jba_comment_use'] == 'Y') {	
							echo "
								<div class=\"viewComment\">
									<ul>
							";
						#댓글 관련 스킨
						include $GP -> INC_PATH . "/action/comment.inc.php";		
							
							echo "</ul></div>";
					} //end_of_if($jb_order >= 100)
					?>			
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- //end #container -->