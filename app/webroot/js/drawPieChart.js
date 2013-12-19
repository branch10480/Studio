$(function() {
	$("#piechart").piechart({
		size: "260",					// 直径
		ease: "<>",						// raphealのイージング文字列
		time: 1500,						// 表示までのミリ秒
		data: [70, 100 - 70],			// グラフのデータ
		color: ["#0099cc", "#eee"]		// 色
	});

	$("#friend01 .piechart").piechart({
		size: "220",					// 直径
		ease: "<>",						// raphealのイージング文字列
		time: 1500,						// 表示までのミリ秒
		data: [60, 100 - 60],			// グラフのデータ
		color: ["#0099cc", "#ddd"]		// 色
	});

	$("#friend02 .piechart").piechart({
		size: "220",					// 直径
		ease: "<>",						// raphealのイージング文字列
		time: 1500,						// 表示までのミリ秒
		data: [60, 100 - 60],			// グラフのデータ
		color: ["#0099cc", "#ddd"]		// 色
	});

	$("#friend03 .piechart").piechart({
		size: "220",					// 直径
		ease: "<>",						// raphealのイージング文字列
		time: 1500,						// 表示までのミリ秒
		data: [60, 100 - 60],			// グラフのデータ
		color: ["#0099cc", "#ddd"]		// 色
	});

	$("#friend04 .piechart").piechart({
		size: "220",					// 直径
		ease: "<>",						// raphealのイージング文字列
		time: 1500,						// 表示までのミリ秒
		data: [60, 100 - 60],			// グラフのデータ
		color: ["#0099cc", "#ddd"]		// 色
	});
});