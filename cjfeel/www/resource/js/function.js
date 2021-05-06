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
	var swiper = new Swiper('#main-news .swiper-container', {
		loop: true,
		speed: 600,
		autoplay: {
			delay: 3500,
			disableOnInteraction: false,
		},
		slidesPerView: 1.5,
		spaceBetween: 70,
		slidesPerGroup: 1,
		centeredSlides: true,
		// navigation: {
		// 	nextEl: '#main-news .swiper-button-next',
		// 	prevEl: '#main-news .swiper-button-prev',
		// },
	});

	//서브배너 이미지 경로
	var dep1Idx = $('body').data('dep1');
	var dep2Idx = $('body').data('dep2');
	var dep3Idx = $('body').data('dep3');
	$("#sub-bnnr > img").attr('src', '/resource/images/sub-bnnr0' + (dep1Idx+1)+'.png').addClass('mb-hide');
	if ($("#sub-bnnr > img.mb-hide").length > 0) {
		$("#sub-bnnr").prepend(
			"<img class='mb-show' src=''>"
		)
		$("#sub-bnnr > img.mb-show").attr('src', '/resource/images/sub-bnnr0' + (dep1Idx + 1) + '-m.png');
	}

	if ($('#location').length > 0) {
		var dep1btn = $("#gnb > ul > li").eq(dep1Idx).find('> a').text();
		var dep2btn = $("#gnb > ul > li").eq(dep1Idx).find('.sub-menu li').eq(dep2Idx).find('> a').text();
		var dep1menu = $("#gnb > ul > li").clone();
		var dep2menu = $("#gnb > ul > li").eq(dep1Idx).find('.sub-menu li').clone();
		$('#location .locDepth1 button').text(dep1btn);
		$('#location .locDepth1 ul').append(dep1menu);
		$('#location .locDepth2 button').text(dep2btn);
		$('#location .locDepth2 ul').append(dep2menu);
		$('#location .locDepth1 ul .sub-menu').remove();

		$('#sub-menu' + dep2Idx).addClass('on').find('li').eq(dep3Idx).addClass('on');
	}

	//햄버거 버튼
	$(".menu-button").on("click", function () {
		$(this).toggleClass("cross");
		$('#gnb, #header_info').toggleClass("on");
		$('.mobile-bg').toggleClass("on");
		$('#gnb>ul>li>a').on("click", function () {
			$(this).parent('li').toggleClass('on').siblings().removeClass('on');
			return false;
		});
	});
	$('.mobile-bg').on("click",function(){
		$(".menu-button").removeClass("cross");
		$('#gnb, #header_info').removeClass("on");
		$('.mobile-bg').removeClass("on");
		$('#gnb.on>ul>li').removeClass("on");
	});
	
	
});