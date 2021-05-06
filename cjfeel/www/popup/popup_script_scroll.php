<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/_init.php';
	include_once($GP -> CLS."/class.popup.php");
	$C_Popup 	= new Popup;
	
	$rst = $C_Popup->PopUp_Show();
?>
<style>
.notiPop {position:fixed;top:50%;left:50%;z-index:1000;width:450px;background:#fff;box-shadow:2px 2px 3px 3px rgba(0,0,0,.2);}
.slideNotiPop {transform:translate(-50%, -50%);-webkit-transform:translate(-50%, -50%);}
.notiPop .popCont {min-height:300px;}
.notiPop .popCont img {width: 100%;}
.notiPop .slide {position:relative;overflow:hidden;}
.notiPop .popBot {position:relative;padding:5px;background:#000;color:#fff;font-size:13px;}
.notiPop .popBot input {vertical-align:middle;}
.notiPop .popBot a {position:absolute;top:4px;right:8px;color:#fff;}
.notiPop .slidePage {position:absolute;right:0;bottom:10px;left:0;text-align:center;}
.notiPop .slidePage a {display:inline-block;width:15px;height:15px;margin: 0 3px;border-radius:50%;background:rgba(0,0,0, .4);font: 0/0 a;}
.notiPop .slidePage [class*="active"] {background: #000;}
.notiPop .slidePage .bx-pager-item {display: inline-block;}
</style>
<script type="text/javascript">
function getCookie( name ) {
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
				endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
		break;
	}
	return;
}
function setCookie( name, value, expiredays ) {
	var todayDate = new Date();
	todayDate = new Date(parseInt(todayDate.getTime() / 86400000) * 86400000 + 54000000);  
	if ( todayDate > new Date() ) {
		expiredays = expiredays - 1;
	}
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}
function closeWin(name, day) {
	var chk = document.getElementsByName(name)[0].checked;

	if(chk == true) setCookie(name, 'done' , day);

	document.getElementById(name).style.display = 'none';
}

var popSlideOn = false;
var popStr = '';
function slidePopSet(idx, text, day) {
	if(popStr.length > 0 && popSlideOn == false) {
		var slideLayerLayout = '<div id="divpop_'+idx+'" class="notiPop slideNotiPop"><div class="popCont slide"><ul class="swiper-wrapper"></ul><div class="slidePage"></div></div><div class="popBot"><label class="inputChk"><input name="divpop_'+idx+'" type="checkbox"> <span>이 창을 '+ text +' 열지 않습니다.</span></label><a href="javascript:closeWin(\'divpop_'+idx+'\', '+day+');">[닫기]</a></div></div>';
		$('body').append(slideLayerLayout);
		popSlideOn = true;

		$('.notiPop .swiper-wrapper').append(popStr);

		if(osVer !== 'ie8') {
			new Swiper('.notiPop .slide', {
				auto: true,
				loop: true,
				speed: 500,
				autoplay: { delay: 3000 },
				pagination: {
					el: '.notiPop .slidePage',
					clickable: true,
					renderBullet: function (index, className) {
						return '<a href="#" class="' + className + '">' + (index + 1) + '</a>';
					}
				}
			});
		} else {
			$('.notiPop ul').bxSlider({
				auto: true,
				speed: 500,
				pause: 3000,
				controls: false,
				pager: true,
				pagerSelector: '.notiPop .slidePage'
			});
		}
	}
}
$(function() {
	$(".notiPop").draggable();
});
</script>

<?php
for($i=0; $i<count($rst); $i++) {
	if($rst[$i]["pop_type2"] == 'W'){
		$pop_idx = $rst[$i]['pop_idx'];
		$le=$rst[$i]['pop_x_position'];
		$to=$rst[$i]['pop_y_position'];
		$wi=$rst[$i]['pop_width'];
		$he=$rst[$i]['pop_height'] + 25;
		
		if($wi < 150) $wi=150;
		if($he < 150) $he=150;
	
		if($rst[$i]['pop_scroll']=="Y")	{
			$scrollbars="yes";
			$wi += 16;
		}else{
			$scrollbars="no";
		}
		//echo "===pop_idx".$pop_idx."<br>";
?>
<script>
	if ( getCookie( "popup_<?=$rst[$i]['pop_idx'];?>" ) != "done" )	{
	window.open('/popup/popup_window.php?pop_idx=<?=$rst[$i]['pop_idx'];?>', 'popup_<?=$rst[$i]['pop_idx'];?>','left=<?=$le;?>,top=<?=$to;?>,width=<?=$wi;?>,height=<?=$he;?>,marginwidth=0,marginheight=0,resizable=1,scrollbars=<?=$scrollbars;?>');		
	}
</script>
<?php
	} else if($rst[$i]["pop_type2"] == 'L' || $rst[$i]["pop_type2"] == 'S') {
		$pop_idx			= $rst[$i]['pop_idx'];
		$pop_type			= $rst[$i]['pop_type'];
		$pop_type2			= $rst[$i]['pop_type2'];
		$pop_contents		= $rst[$i]['pop_contents'];
		$pop_file_name		= $rst[$i]['pop_file_name'];
		$pop_width			= $rst[$i]['pop_width'];
		$pop_height			= $rst[$i]['pop_height'];
		$pop_cookie			= $rst[$i]['pop_cookie'];
		$pop_link_url		= $rst[$i]['pop_link_url'];	
		$pop_x_position		= $rst[$i]['pop_x_position'];
		$pop_y_position		= $rst[$i]['pop_y_position'];
		
		$css_img_height = $pop_height-31;
	
		if($rst[$i]['pop_scroll']=="Y")	{
			$scrollbars="scroll";
		}else{
			$scrollbars="hidden";
		}
	
		//echo "===pop_idx".$pop_idx."<br>";
		//Text OR Image
		if ($pop_type=="T") {
				$pop_str = $C_Func->dec_contents_view($pop_contents);
				$pop_str = $pop_str;
		} else {
			$url = $GP -> UP_POPUP_URL .$pop_file_name;	
			//이미지 클릭시 이동할 페이지
			if($pop_link_url != "") {				
				$pop_link_url = str_replace('/','',$pop_link_url);
				$pop_link_url = str_replace('/','',$pop_link_url);				
				//$pop_str="<a href=\"javascript:move_page('${pop_link_url}')\"><img src='${url}' border='0' class='pop_img'></a>";
				$pop_str="<a href='" . $pop_link_url . "'><img src='${url}' alt='팝업'></a>";
			} else {
				$pop_str="<img src='${url}' alt=''>";		
			}
		}
	
		//닫기설정
		switch ($pop_cookie) {
			case "1" :		$cookie_text="하루동안";		break;
			case "7" :		$cookie_text="일주일동안";		break;
			case "30" :		$cookie_text="한달동안";		break;
			case "90" :		$cookie_text="영원히";			break;
			default :		$cookie_text="영원히";			break;
		
		}
		
	?>
	<?php if($rst[$i]["pop_type2"] == 'L') { ?>
		<div id="divpop_<?=$pop_idx?>" class="notiPop" style="top:<?=$pop_y_position?>px;left:<?=$pop_x_position?>px;overflow:<?=$scrollbars?>;">
			<div class="popCont"><?=$pop_str?></div>
			<div class="popBot">
				<label class="inputChk"><input name="divpop_<?=$pop_idx?>" type="checkbox"> <span>이 창을 <?=$cookie_text?> 열지 않습니다.</span></label>
				<a href="javascript:closeWin('divpop_<?=$pop_idx?>', <?=$pop_idx?>);">[닫기]</a>
			</div>
		</div>
	<? } else if($rst[$i]["pop_type2"] == 'S') { ?>
		<script>
			popStr += "<li class='swiper-slide'><?=$pop_str?></li>";
		</script>
	<? } ?>

	<?php if($i + 1 == count($rst)) {?>
		<script>
			slidePopSet('<?=$pop_idx?>', '<?=$cookie_text?>', '<?=$pop_cookie?>');
		</script>
	<?}?>
	<script>
		if ( getCookie('divpop_<?=$pop_idx?>') == 'done') {
			document.getElementById('divpop_<?=$pop_idx?>').style.display = 'none';
		}
	</script>
	<?}?>
	
	
<?}?>