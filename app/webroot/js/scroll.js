// scroll.js
var scr = {
	elmToTop: '',
	scrTop: '',
	alreadyDispFlg: true
};

$(function () {
	// 初期化
	scr.elmToTop = $('#scrollToTop');
	scr.elmToTop.hide();

	$(window).scroll(function(event) {
		scr.scrTop = $(window).scrollTop();

		if (scr.elmToTop.length === 0) return;

		if (+scr.scrTop > 400 && scr.alreadyDispFlg) {
			scr.elmToTop.stop().fadeTo(100, 1);
			scr.alreadyDispFlg = false;
		}
		if (+scr.scrTop < 400 && !scr.alreadyDispFlg) {
			scr.elmToTop.stop().fadeTo(200, 0, function(){ $(this).hide(); });
			scr.alreadyDispFlg = true;
		}
	});

	scr.elmToTop.click(function(event) {
		// Smooth scroll
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0},
			400, 'swing', function() {});
	});
});