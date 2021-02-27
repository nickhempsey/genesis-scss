AOS.init();

jQuery(document).ready(function($) {

	// Add loaded so we can pull the loading spinner.
	setTimeout(function() {
		$("body").addClass("loaded");
	}, 500);


	// Init tooltips
	if($('[data-toggle="tooltip"]').length !== 0) {
		$('[data-toggle="tooltip"]').tooltip();
	}

	// Init Toasts
	if($('.toast').length !== 0) {
		$('.toast').toast();
	}

	// On header scroll add scrolled so we can change the look.
	function headerScrolled() {
		if ($(window).scrollTop() >= 75) {
			$('.site-header').addClass('scrolled');
			$('body').addClass('scrolled');
		} else {
			$('.site-header').removeClass('scrolled');
			$('body').removeClass('scrolled');
		}
	}

	headerScrolled();

	$(window).scroll(function(){
	headerScrolled();
	});

	$('.wp-block-group.d-flex').find('.wp-block-group__inner-container').addClass('d-flex align-items-center');

});
