$(function () {
	$('#iconArea').hover(function() {
		$('#animP').animate({
			bottom: '0'},
			100, function() {
			/* stuff to do after animation is complete */
		});
	}, function() {
		$('#animP').animate({
			bottom: '-20px'},
			100, function() {
			/* stuff to do after animation is complete */
		});
	});;
});