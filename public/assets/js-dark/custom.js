(function($) {
	"use strict";
	
	// ______________Horizontal-menu
	$("a[data-theme]").click(function() {
		$("head link#theme").attr("href", $(this).data("theme"));
		$(this).toggleClass('active').siblings().removeClass('active');
	});
	$("a[data-effect]").click(function() {
		$("head link#effect").attr("href", $(this).data("effect"));
		$(this).toggleClass('active').siblings().removeClass('active');
	});
	
	
	// ______________Cover Image
	$(".cover-image").each(function() {
		var attr = $(this).attr('data-image-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background', 'url(' + attr + ') center center');
		}
	});
	
	// ______________Ms Menu Trigger
	if ($('#ms-menu-trigger')[0]) {
		$('body').on('click', '#ms-menu-trigger', function() {
			$('.ms-menu').toggleClass('toggled');
		});
	}
	
	 // ______________Headerfixed
	$(window).on("scroll", function(e){
		if ($(window).scrollTop() >= 66) {
			$('header').addClass('fixed-header');
		}
		else {
			$('.header').removeClass('fixed-header');
		}
    });
	
	
	// ______________Full screen
	$(document).on("click", "#fullscreen-button", function toggleFullScreen() {
		if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
			if (document.documentElement.requestFullScreen) {
				document.documentElement.requestFullScreen();
			} else if (document.documentElement.mozRequestFullScreen) {
				document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullScreen) {
				document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
			} else if (document.documentElement.msRequestFullscreen) {
				document.documentElement.msRequestFullscreen();
			}
		} else {
			if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
	})
	//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	// ______________ PAGE LOADING
	$(window).on("load", function(e) {
		$("#global-loader").fadeOut("slow");
	})
	
	// ______________ BACK TO TOP BUTTON
	$(window).on("scroll", function(e) {
		if ($(this).scrollTop() > 0) {
			$('#back-to-top').fadeIn('slow');
		} else {
			$('#back-to-top').fadeOut('slow');
		}
	});
	$(document).on("click", "#back-to-top", function(e) {
		$("html, body").animate({
			scrollTop: 0
		}, 600);
		return false;
	});
	
	// ______________ Star Rating
	var ratingOptions = {
		selectors: {
			starsSelector: '.rating-stars',
			starSelector: '.rating-star',
			starActiveClass: 'is--active',
			starHoverClass: 'is--hover',
			starNoHoverClass: 'is--no-hover',
			targetFormElementSelector: '.rating-value'
		}
	};
	$(".rating-stars").ratingStars(ratingOptions);
	
	// ______________ mCustomScrollbar
	$(".vscroll").mCustomScrollbar();
	$(".imagescroll").mCustomScrollbar({
		axis: "x",
		theme: "dark-3",
		advanced: {
			autoExpandHorizontalScroll: true
		}
	});
	$(".app-sidebar").mCustomScrollbar({
		theme: "minimal",
		autoHideScrollbar: true,
		scrollbarPosition: "outside"
	});
	$(".scroll-1").mCustomScrollbar({
		theme: "dark"
	});
	$(".scroll-widget").mCustomScrollbar({
		theme: "minimal",
		autoHideScrollbar: true,
		scrollbarPosition: "outside"
	});
	
	$(".first-sidemenu").mCustomScrollbar({
		theme: "minimal",
		autoHideScrollbar: true,
		scrollbarPosition: "outside"
	});
	
	$(".second-sidemenu").mCustomScrollbar({
		theme: "minimal",
		autoHideScrollbar: true,
		scrollbarPosition: "outside"
	});
	//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	// ______________ Chart-Circle
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function() {
			let $this = $(this);
			$this.circleProgress({
				fill: {
					color: $this.attr('data-color')
				},
				size: $this.height(),
				startAngle: -Math.PI / 4 * 2,
				emptyFill: '#30204c',
				lineCap: 'round'
			});
		});
	}
	
	const DIV_CARD = 'div.card';
	// ______________ Tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// ______________ Popover
	$('[data-toggle="popover"]').popover({
		html: true
	});
	
	// ______________ Card Remove
	$(document).on('click', '[data-toggle="card-remove"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});
	
	// ______________ Card Collapse
	$(document).on('click', '[data-toggle="card-collapse"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	
	// ______________ Card Fullscreen
	$(document).on('click', '[data-toggle="card-fullscreen"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	
	// ______________GlobalSearch
	$(document).on("click", "[data-toggle='search']", function(e) {
		var body = $("body");

		if(body.hasClass('search-gone')) {
			body.addClass('search-gone');
			body.removeClass('search-show');
		}else{
			body.removeClass('search-gone');
			body.addClass('search-show');
		}
	});
	var toggleSidebar = function() {
		var w = $(window);
		if(w.outerWidth() <= 1024) {
			$("body").addClass("sidebar-gone");
			$(document).off("click", "body").on("click", "body", function(e) {
				if($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
					$("body").removeClass("sidebar-show");
					$("body").addClass("sidebar-gone");
					$("body").removeClass("search-show");
				}
			});
		}else{
			$("body").removeClass("sidebar-gone");
		}
	}
	toggleSidebar();
	$(window).resize(toggleSidebar);
	
	
	// ______________Active Class
	$(".app-sidebar .toggle-menu.side-menu a").each(function() {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) {
			$(this).addClass("active");
			$(this).parent().addClass("active"); // add active to li of the current link
			$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
})(jQuery);