
/*
 jquery.piechart

 @author kaminaly@SHIFTBRAIN
 @version 0.0.1
 @update 2011/08/02
 @use jQuery, Raphael

 working IE6
-----------------------------------------------------------------*/
(function(jQuery){

	jQuery.fn.piechart = function(options) {

		if(Object.prototype.toString.call(options) != "[object Array]") options = [options];

		var _default = {
			size: 300,
			ease: "<>",//cubic-bezier(0.75, 1.569, 0.29, -0.52)
			time: 3000,
			data: [1,1,1,1],
			color: []//"#c1f193", "#ffffcf", "#86c8f2", "#f5aac2"
		};

		return this.each(function(index){
			$(this).html("");
			var _options = options[index] ? jQuery.extend(_default, options[index]) : _default,
				raphael = Raphael(this, _options.size, _options.size),
				radius = _options.size * 0.5 - 2,
				param = {"stroke-opacity": 0},
				num = _options.data.length,
				paths = [], data = [],
				total = 0,
				i = 0;

			raphael.customAttributes.arc = function (total, value) {
					var degree = 360 / total * value,
						radian = (90 - degree) * Math.PI / 180,
						x = radius * Math.cos(radian),
						y = radius * Math.sin(radian),
						path;
					if (value / total > 0.9999) {
							path = [["M", radius, radius],
								["L", radius, 0],
								["A", radius, radius, 0, 1, 1, radius * 0.9999, 0],
								["Z"]];
					} else {
							path = [["M", radius, radius],
								["L", radius, 0],
								["A", radius, radius, 0, (degree > 180 ? 1 :0), 1, radius + x, radius - y],
								["Z"]];
					}
					return {path: path};
			}

			i = num;
			while(i--){
				var color = _options.color[i] ? _options.color[i] : getColor();
				paths[i] = raphael.path().attr(param).attr({arc: [10, 0], fill: color});
			}

			for(i = 0; i<num; i++){
				data[i] = total + _options.data[i];
				total += _options.data[i];
			}

			for(i = 0; i<num; i++){
				paths[i].animate({arc:[total, data[i]]}, _options.time, _options.ease);
			}
		});

		function getColor(){
			var color = (Math.random() * 0xFFFFFF >> 0).toString(16);
			while(color.length < 6){
				color = "0" + color;
			}
			return "#" + color;
		}
	}

})(jQuery);