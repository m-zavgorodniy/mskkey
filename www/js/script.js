$(function() {
	/* sticky header */
	$(window).scroll(stick_header).resize(stick_header);
	
	function stick_header() {
		if (document.body.scrollWidth > document.body.clientWidth) {
			$('body').removeClass('header-fixed');
			$('header').css("width", "auto");
			return;
		}

//	   $(".header-menu-submenu").removeClass("active");
		if ($(window).scrollTop() > 178) {
		   $('body').addClass('header-fixed');
		   setTimeout("$('.header').addClass('active')", 0);
		}
		else {
		   $('body').removeClass('header-fixed');
		   $('.header').removeClass('active');
		}
	   $('header').css("width", $('header').parent().width() + "px");
	}

	/* menu */
	$(".header-menu-item.w-submenu").children("a").click(function(event) {
		var $submenu = $(this).next(".header-menu-submenu");
		if ($submenu.is(".active")) {
			$submenu.removeClass("active");
		} else {
			$(".header-menu-submenu").removeClass("active");
			$submenu.toggleClass("active");
		}
		event.stopPropagation()
		return false;
	});
	$(".header-menu-submenu").click(function(event) {
		event.stopPropagation()
	});
	$(document).click(function() {
		$(".header-menu-submenu").removeClass("active");
	});
	
	/* property details bookmarks */
	$("#bookmarks_gallery").click(function() {
		$("#detail_gallery_gallery").show();
		if ($("#detail_gallery_video iframe").length) {
			$("#detail_gallery_video iframe").attr("src", "");
		} else {
			try {$("#detail_gallery_video video")[0].pause()} catch(e) {}
		}
		$("#detail_gallery_video").hide();

		$(".detail-gallery-bookmarks-item").removeClass("detail-gallery-bookmarks-item-active");
		$(this).addClass("detail-gallery-bookmarks-item-active");
	});
	$("#bookmarks_video").click(function() {
		$("#detail_gallery_gallery").hide();
		if ($("#detail_gallery_video iframe").length) {
			$iframe = $("#detail_gallery_video iframe");
			$iframe.attr("src", $iframe.attr("data-src"));
		}
		$("#detail_gallery_video").show();

		$(".detail-gallery-bookmarks-item").removeClass("detail-gallery-bookmarks-item-active");
		$(this).addClass("detail-gallery-bookmarks-item-active");
	});

	$(".detail-gallery-zoom").click(function() {
		$.fancybox($('.flex-active-slide img').data('src-big'), {helpers: {
			overlay: {
				locked: false
			}
		}});
		return false;	
	});

	$(".detail-folded-control").click(function() {
		$(".detail-folded-body", $(this).closest(".detail-folded").toggleClass("open")).slideToggle();
		return false;
	});

	/* misc */
	var hm_html = '<a href="maxxyyiltxxyyo:inxxyyfxxyyo_atmsxxyykkeyxxyy.rxxyyu">inxxyyfxxyyo_atmsxxyykkeyxxyy.rxxyyu</a>';
	$("#hm").html(hm_html.split('xxyy').join('').split('_at').join('@'));

	$(".form-validate").submit(function() {
		var res = true;
		$(".required", this).each(function() {
			var $input = $(this);
			if ("" === $input.val() || $input.is(":checkbox") && !$input.is(":checked")) {
				res = false;
				$input.addClass("form-input-invalid");
			} else {
				$input.removeClass("form-input-invalid");
			}
		});
		var $required_either = $(".required-either", this);
		var res_either = true;
		$required_either.each(function() {
			res_either = false;
			var $input = $(this);
			if ("" !== $input.val()) {
				res_either = true;
				$required_either.removeClass("form-input-invalid");
				return false;
			} else {
				$required_either.addClass("form-input-invalid");
			}
		});
		$("[name='email']", this).each(function() {
			var $input = $(this);
			var re = /\S+@\S+\.\S+/;
			if ("" !== $input.val() && !re.test($input.val())) {
				res = false;
				$input.addClass("form-input-invalid");
			} else if (res) {
				$input.removeClass("form-input-invalid");
			}
		});
		return res && res_either;
	});
	
	/* flex slider */
	$('.detail-gallery-thumbs').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 173,
		itemMargin: 5,
		asNavFor: '.detail-gallery-view'
	});
	$('.detail-gallery-view').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: ".detail-gallery-thumbs"
	});
	$(".detail-gallery-view img").on("load error", function() {
		$(this).parent().addClass("loaded");
	});

	/* scroll to an ancor and open the block if folded */
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: (target.offset().top - 100)
				}, 1000);

				if ($(target).is(".detail-folded:not(.open)")) {
					$(".detail-folded-body", $(target).addClass("open")).slideDown();
				}
				return false;
			}
		}
	});

});
