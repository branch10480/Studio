function graphAnimate(element, maxSize, steps) {
	element.attr('width', 0);
	var intervalID = setInterval(function () {
		var currentW = +element.attr("width");
		if (currentW < maxSize) {
			element.attr("width", currentW + steps);
		} else {
			// グラフの幅が最大まで到達した場合
			clearInterval(intervalID);
		}
	}, 1);
}
function graphTextAnimate(element, maxSize, steps) {
	// element.attr('x', 0);
	var intervalID = setInterval(function () {
		var currentW = +element.attr("x");
		if (currentW < maxSize) {
			element.attr("x", currentW + steps);
		} else {
			// グラフの幅が最大まで到達した場合
			clearInterval(intervalID);
		}
	}, 1);
}
