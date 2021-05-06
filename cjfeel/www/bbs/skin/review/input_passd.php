<div id="sub-bnnr">
	<img src="/resource/images/notice-bnnr01.png" alt="">
	<h2>
		<small>커뮤니티</small>
		<span>온라인 상담</span>
	</h2>
</div>
<div id="container-box" class="sub">
	<section class="container">
		<?php include_once $GP -> INC_WWW . "/location.php"; ?>
		<div id="member-box">
			<h3 class="mem-tit">
				<img src="/resource/images/rabit.png" alt="" width="100">
				<span>비밀번호를 입력해주세요!</span>
				<small>LAPIN OBSTETRICS AND GYNECOLOGY</small>
			</h3>
			<form name="frm_pass" id="frm_pass" action="<?=$get_par;?>" method="post">
				<p class="passSection">
					<input class="form-control" type="password" name="input_passd" id="input_passd" size=25 maxlength=30 placeholder="비밀번호 입력">
				</p>
				<div id="btn-box">
					<a href="javascript:;" id="pass_submit" class="btn bg-pink">확인</a>
					<a href="javascript:history.go(-1);"  class="btn bg-red">취소</a>
				</div>
			</form>
		</div>
		<!-- //end #member-box -->
	</section>	
</div>
<style>
	.passSection {
		margin-top:30px;
	}
	.form-control {
		display: block;
		width: 100%;
		max-width:610px;
		height: 70px;
		margin:0 auto 8px;
		padding: 5px 15px;
		font-size: 20px;
		line-height: 1.5;
		text-align: left;
		color: #444;
		background-image: none;
		border: 1px solid #ccc;
		outline: none;
		box-sizing: border-box;
		box-shadow: none;
		-webkit-transition: border-color ease-in-out 0.15s, -webkit-box-shadow ease-in-out 0.15s;
		-o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
		transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
		vertical-align: middle;
	}
</style>
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