$(function(){
	//메인슬라이드
	var swiper = new Swiper('#main-bnnr .swiper-container', {
		effect: 'fade',
		loop: true,
		pagination: {
			el: '#main-bnnr .swiper-pagination',
			clickable: true,
		},
		speed: 1000,
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
		},
	});
	//메인 미들 슬라이드
	var swiper = new Swiper('#main-slide .swiper-container', {
		loop: true,
		pagination: {
			el: '#main-slide .swiper-pagination',
			type: 'fraction',
		},
		speed: 1000,
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
		},
		navigation: {
			nextEl: '#main-slide .swiper-button-next',
			prevEl: '#main-slide .swiper-button-prev',
		},
	});
	//서브 미들 슬라이드
	var swiper = new Swiper('#system .swiper-container', {
		loop: true,
		speed: 600,
		autoplay: {
			delay: 3500,
			disableOnInteraction: false,
		},
		touchRatio: 0,
		navigation: {
			nextEl: '#system .swiper-button-next',
			prevEl: '#system .swiper-button-prev',
		},
	});

	//로케이션
	var locIdx = $("#sub-bnnr").data('index')-1;
	$("#location li").eq(locIdx).addClass('on');

	//서브페이지 최하단 배너
	var pageText = $("#sub-bnnr .cont h2").text();
	$("#sub-bottom-bnnr .cont h2 em").text(pageText);

	//햄버거 버튼
	$(".menu-button").on("click", function (e) {
		$(this).toggleClass("cross");
		$('.nav-top, .nav-bottom, .mobile-bg').toggleClass("on");
		$('.nav-bottom.on .menu>li>a').click(function () { return false; });
		$('.nav-bottom.on .menu>li>a').on("click", function () {
			$(this).parent('li').toggleClass('on').siblings().removeClass('on');
		});
	});

	if ($('#location').length > 0) {
		var dep1Idx = $('body').data('dep1');
		var dep2Idx = $('body').data('dep2');
		var dep1btn = $("#gnb > ul > li").eq(dep1Idx).find('> a').text();
		var dep2btn = $("#gnb > ul > li").eq(dep1Idx).find('.sub-menu li').eq(dep2Idx).find('> a').text();
		var dep1menu = $("#gnb > ul > li").clone();
		var dep2menu = $("#gnb > ul > li").eq(dep1Idx).find('.sub-menu li').clone();
		$('#location .locDepth1 button').text(dep1btn);
		$('#location .locDepth1 ul').append(dep1menu);
		$('#location .locDepth2 button').text(dep2btn);
		$('#location .locDepth2 ul').append(dep2menu);
		$('#location .locDepth1 ul .sub-menu').remove();
	}
	
	
});