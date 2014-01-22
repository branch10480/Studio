<?php

class JsController extends AppController {



	// public $components = array('DebugKit.Toolbar');	// コントローラーの処理を拡張するcomponentを指定
	// public $uses = array('Account');				// 使用するモデル
	public $components = array('RequestHandler', 'MyAuth');
	public $loginId;



	public function beforeFilter() {
		$this->layout = 'js';
		define('controllerURL', rootUrl . 'users/');
		header('Content-Type: text/javascript; charset=utf-8');
		$this->render('index');
		$this->loginId = $this->Session->read('Auth.id');
	}


	public function timeline() {
		?>
/* --------------------------------------------------------------------------

グローバル変数 ▼

-------------------------------------------------------------------------- */
/**
* タイムライン処理
*/
var maxPostId_ = 0;



$(function () {
	// ライムライン取得
	getTimelineData();
	setTimeout('startInsertPosts()', 1000);
	getFriendStudydata();
	setCountdownCal();
});



/**
* タイムライン制御
*/

function getTimelineData () {
	var maxPostId = maxPostId_;
	$.ajax({
		url: '<?php echo rootUrl; ?>timeline/getTimelineData/',
		type: 'POST',
		dataType: 'json',
		data: {
			id: '<?php echo $this->Session->read('Auth.mailaddress'); ?>',
			max_postid: +maxPostId
		}
	})
	.success(function (data) {
		// タイムライン表示処理
		writePosts(data);
	})
	.error(function (data, textStatus) {
		console.log(textStatus);
	});
}
/* タイムライン表示 */
function writePosts(data) {
	// コメントを読み込む記事のidが入る配列
	var postidArr = [];


	// 投稿一つにつき実行
	for (var i=0; i<data.length; i++) {

		// タイムラインの書き込み処理
		var timelineRecord = '\
			<li id="post' + data[i]['Post']['id'] + '">\
				<dl>\
					<dt><img src=\"<?php echo rootUrl . "img/profile/" ?>' + data[i]['Account']['id'] + '.jpg" alt="' + data[i]['Account']['name'] + '" width="75" height="75" /></dt>\
					<dd>\
						<h2><a href="<?php echo rootUrl ?>users/profile/' + data[i]['Account']['id'] + '">' + data[i]['Account']['name'] + '</a></h2>\
						<p>' + data[i]['Post']['text'].replace('\n', '<br />') + '</p>\
						';
		if (data[i]['Post']['img_ext'] !== null) {
			timelineRecord += '<img src="<?php echo rootUrl . "img/images/"; ?>' + data[i]['Post']['id'] + data[i]['Post']['img_ext'] + '" alt="" />';
		}
		timelineRecord += '\
						<ul class="communicateBtnArea">\
							<li class="btnComment"><span>コメントする</span></li>\
							<li class="btnSupport"><span>ファイト！</span></li>\
						</ul>\
						<ul class="qualifications"></ul>\
					</dd>\
				</dl>\
			</li>\
		';

		$('#timeline > ul').append(timelineRecord);

		// 資格情報取得
		$.ajax({
			url: '<?php echo rootUrl; ?>timeline/getTargetData/',
			type: 'POST',
			dataType: 'json',
			data: {
				account_id: data[i]['Account']['id'],
				post_id: data[i]['Post']['id']
			}
		})
		.done(function(recvData) {
			console.log("success");
			// 資格挿入処理
			var elmQualification = $('#post' + recvData[0] + ' .qualifications');
			elmQualification.html('');
			for (var i=0; i<recvData[1].length; i++) {
				elmQualification.append('<li>' + recvData[1][i]['Target']['name'] + '</li>');
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});


		postidArr[postidArr.length] = +data[i]['Post']['id'];
	}
	console.log(postidArr);

	// 取得したpost_id の最大値を取得してグローバル変数に格納
	var max;
	for (var i=0, l=postidArr.length; i<l; i++) {
		var n = postidArr[i];
		if (n != null && !isNaN(n)) {
			if (max) {
			    max = Math.max(max, n);
			} else {
			    max = n;
			}
		}
	}
	maxPostId_ = max;


	// -------------- ▲ コメントを除くタイムラインが生成可能になった ------------

	// コメント読み込み処理 - Ajax
	readComment(postidArr);

}
/* コメント読み込み */
function readComment(postidArr) {
	$.ajax({
		url: '<?php echo rootUrl ?>timeline/getComment/',
		type: 'POST',
		dataType: 'json',
		data: {
			post_id: postidArr
		}
	})
	.done(function(data) {
		console.log(data);

		// コメント表示処理
		showComments(data);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
/* 投稿挿入開始処理 */
function startInsertPosts() {
	var basePostId = maxPostId_;
	$.ajax({
		url: '<?php echo rootUrl; ?>timeline/getTimelineData/',
		type: 'POST',
		dataType: 'json',
		data: {
			id: '<?php echo $this->Session->read('Auth.mailaddress'); ?>',
			max_postid: +basePostId
		}
	})
	.success(function (data) {
		// タイムライン表示処理
		console.log(data);

		// 取得したデータが無ければ抜ける
		if (data.length === 0) {
			return;
		}

		// 投稿一つにつき実行
		var postidArr = [];
		for (var i=0; i<data.length; i++) {
			postidArr[postidArr.length] = +data[i]['Post']['id'];
		}
		// 取得したpost_id の最大値を取得してグローバル変数に格納
		var max;
		for (var i=0, l=postidArr.length; i<l; i++) {
			var n = postidArr[i];
			if (n != null && !isNaN(n)) {
				if (max) {
				    max = Math.max(max, n);
				} else {
				    max = n;
				}
			}
		}
		maxPostId_ = max;
		insertPosts(data);
	})
	.error(function (data, textStatus) {
		console.log('error');
		console.log(textStatus);
	});

	setTimeout('startInsertPosts()', 5000);
}
/* 投稿挿入処理 */
function insertPosts(data) {
		if (data.length === 0) {
			return;
		}

		for (var i=0; i<data.length; i++) {

			// タイムラインの書き込み処理
			var timelineRecord = '\
				<li id="post' + data[i]['Post']['id'] + '" class="fadein" id="post' + data[i]['Post']['id'] + '">\
					<dl>\
						<dt><img src=\"<?php echo rootUrl . "img/profile/" ?>' + data[i]['Account']['id'] + '.jpg" alt="' + data[i]['Account']['name'] + '" width="75" height="75" /></dt>\
						<dd>\
							<h2>' + data[i]['Account']['name'] + '</h2>\
							<p>' + data[i]['Post']['text'].replace('\n', '<br />') + '</p>\
							';
			if (data[i]['Post']['img_ext'] !== null) {
				timelineRecord += '<img src="<?php echo rootUrl . "img/images/"; ?>' + data[i]['Post']['id'] + data[i]['Post']['img_ext'] + '" alt="" />';
			}
			timelineRecord += '\
							<ul class="communicateBtnArea">\
								<li class="btnComment"><span>コメントする</span></li>\
								<li class="btnSupport"><span>ファイト！</span></li>\
							</ul>\
							<ul class="qualifications"></ul>\
						</dd>\
					</dl>\
				</li>\
			';

			$('#timeline > ul').prepend(timelineRecord);

			// 資格情報取得
			$.ajax({
				url: '<?php echo rootUrl; ?>timeline/getTargetData/',
				type: 'POST',
				dataType: 'json',
				data: {
					account_id: data[i]['Account']['id'],
					post_id: data[i]['Post']['id']
				}
			})
			.done(function(recvData) {
				console.log("success");
				// 資格挿入処理]
				var elmQualification = $('#post' + recvData[0] + ' .qualifications');
				elmQualification.html('');
				for (var i=0; i<recvData[1].length; i++) {
					elmQualification.append('<li>' + recvData[1][i]['Target']['name'] + '</li>');
				}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}
}
/* コメント表示処理 */
function showComments(data) {
	for (var i=0; i<data[0].length; i++) {
		// コメントエリアフィールドの作成
		if ($('#post' + data[0][i]['Comment']['post_id'] + ' > dl > dd > .commentArea').length === 0) {
			var baseTag = '\
							<div class="commentArea">\
								<ul>\
								</ul>\
							</div>\
			';
			$('#post' + data[0][i]['Comment']['post_id'] + ' > dl > dd').append(baseTag);
		}

		// コメント欄挿入
		var commentStr = '\
								<li>\
									<dl>\
										<dt><img src=\"<?php echo rootUrl . "img/profile/"; ?>' + data[0][i]['Account']['id'] + '.jpg\" alt=\"' + data[0][i]['Account']['name'] + '" width="48" height="48" /></dt>\
										<dd>\
											<h3>' + data[0][i]['Account']['name'] + '</h3>\
											<p>' + data[0][i]['Comment']['text'] + '</p>\
										</dd>\
									</dl>\
								</li>\
		';
		$('#post' + data[0][i]['Comment']['post_id'] + ' .commentArea ul').append(commentStr);
	}
}



/**
* 友達の勉強情報表示
*/
function getFriendStudydata() {
	var date = new Date();
	var yesterday = new Date(date.getFullYear(), date.getMonth(), date.getDate()-1);
	$('#friend_now > ul').html('');
	$.ajax({
		url: '<?php echo rootUrl; ?>timeline/getFriendData/',
		type: 'POST',
		dataType: 'json',
		data: {
			year: yesterday.getFullYear(),
			month: yesterday.getMonth()+1,
			day: yesterday.getDate()
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		// 友達の勉強状況表示
		var reflection = '';
		for (var i=0; i<data.length; i++) {
			showFriendStudyData(data[i]['Friend']['account_id']);
		}
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function showFriendStudyData( friend_id_ ) {
	var friendId = friend_id_ || false;
	if (!friendId) return;

	var date = new Date();
	var yesterday = new Date(date.getFullYear(), date.getMonth(), date.getDate()-1);

	// 勉強時間を計算してグラフとして表示
	$.ajax({
		url: '<?php echo rootUrl; ?>timeline/getStudytime/',
		type: 'POST',
		dataType: 'json',
		data: {
			year: yesterday.getFullYear(),
			month: yesterday.getMonth()+1,
			day: yesterday.getDate(),
			friend_id: friendId
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		var friendName = data[0][0]['Account']['name'];
		var friend_id = data[0][0]['Account']['id'];
		var img_ext = data[0][0]['Account']['img_ext'];
		var reflection = '';
		var elmFriendnow = $('#friend_now > ul');
		// 勉強時間の足し込み
		var sumStudytime = 0;
		if (data[1].length !== 0) {
			for (var i=0; i<data[1].length; i++) {
				reflection = data[1][i]['Studylog']['text'];
				sumStudytime = sumStudytime + +data[1][i]['Studytime']['time'];
			}
			if (reflection === '') reflection = '昨日の感想・反省はありません。';
		} else {
			reflection = '昨日の感想・反省はありません。';
		}
		sumStudytime = sumStudytime/60;
		// 友達の勉強時間を表示
		var tagStr = '\
			<li class="fadeFast" id="friend' + friendId + '">\
				<div class="container">\
					<h2><a href="<?php echo rootUrl; ?>users/profile/' + friend_id + '">' + friendName + '</a></h2>\
					<dl>\
						<dt><img src="<?php echo rootUrl; ?>img/profile/' + friend_id + img_ext + '" alt="' + friendName + '" width="48" /></dt>\
						<dd>\
							<div class="graphArea">\
								<h3>昨日の勉強時間</h3>\
									<svg width="160" height="50" viewBox="0 0 160 50">\
										<!-- code -->\
										<g class="graphBG" stroke="#bcb699">\
											<line x1="32" y1="3" x2="32" y2="30" />\
											<!-- <line x1="140" y1="0" x2="140" y2="100" />\
											<line x1="190" y1="0" x2="190" y2="100" />\
											<line x1="240" y1="0" x2="240" y2="100" />\
											<line x1="290" y1="0" x2="290" y2="100" />\
											<line x1="340" y1="0" x2="340" y2="100" /> -->\
										</g>\
										<g class="graphLabel" text-anchor="end" font-family="Helvetica, Arial, sans-serif" font-size="11px">\
											<text x="22" y="21" font-weight="bold">昨日</text>\
										</g>\
										<g class="graphBar" fill="#c9c3a5" stroke="#bcb699">\
											<rect class="studyGraphBar" x="32" y="7" fill="#41c3e9" stroke="#2abfe8" width="95" height="20" class="todayBar" rx="2"></rect>\
										</g>\
										<g text-anchor="start" font-family="Helvetica, Arial, sans-serif" font-size="11px">\
											<text class="studytimeText" x="37" y="21" font-weight="normal">' + sprintf('%.1f', sumStudytime) + 'h</text>\
										</g>\
									</svg>\
							</div>\
						</dd>\
					</dl>\
					<ul class="reflection clearfix">\
						<li>最新の投稿</li>\
						<li class="current">昨日の反省</li>\
					</ul>\
				</div>\
				<p>' + reflection + '</p>\
			</li>';
		elmFriendnow.append(tagStr);
		graphAnimate( $('#friend' + friendId).find('.studyGraphBar'), sumStudytime*90/12, 1 );
		graphTextAnimate( $('#friend' + friendId).find('.studytimeText'), sumStudytime*90/12, 1 );
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}



/**
* 試験まであと何日カレンダー
*/
function setCountdownCal() {
	$.ajax({
		url: '<?php echo rootUrl; ?>target/getMyTargetCountdown/',
		type: 'POST',
		dataType: 'json',
		data: {
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		var tagStr = '';
		for (var i=0; i<data.length; i++) {
			tagStr += '\
					<li>\
						<dl class="clearfix">\
							<dt>' + data[i]['Target']['name'] + 'まで</dt>\
							<dd>あと<strong>' + data[i][0]['days'] + '</strong>日</dd>\
						</dl>\
					</li>\
				';
		}

		$('#friend_now aside ul').html(tagStr);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}
// --------------------------------------------------------------------------
<?php
	}



	/**
	* 投稿処理
	*/
	function post() {
		?>
/* --------------------------------------------------------------------------

JS関数 ▼

-------------------------------------------------------------------------- */
$(function () {
	$('#postForm').submit(function(event) {
		event.preventDefault();
		var callbacks_ = {
				'begin'   : function(){},
				'success'  : function(){},
				'error'   : function(){},
				'complete': function () {
								// モーダルをしまう
								$('#white_modal').fadeTo(100, 0, function() {
									$(this).css('z-index', -1);
								})
							}
		};
		ajax_submit($(this), callbacks_);
	});
})


/* フォームをajax送信（ファイルアップロード対応）
-------------------------------------------------------------------------------*/
function ajax_submit(form_, callbacks_) {
	// フォームの指定が無ければ即時返却
	if( $.trim( form_ ).length <= 0 ) return;

	// コールバックのデフォルト値を設定
	var defaults = {
	 'begin'   : function(){},
	 'success'  : function(){},
	 'error'   : function(){},
	 'complete'  : function(){}
	};
	// デフォルト値とマージ
	var callbacks = $.extend( defaults, callbacks_ );

	// 開始コールバックを起動
	callbacks['begin']();

	// フォームオブジェクトを取得
	var $form_obj  = $(form_);

	// フォームのデータを元にFormDataオブジェクトを作成
	var form_data  = new FormData( $form_obj[0] );

	// フォームのアクションを取得
	var action   = $form_obj.attr("action");

	// フォームのメソッドを取得
	var method   = $form_obj.attr("method");

	// 非同期通信
	$.ajax({
		url   : action,
		type  : method,
		processData : false,
		contentType : false,
		data  : form_data,
		enctype  : 'multipart/form-data',
		dataType : 'Json',
		success: function( result ){
			// 成功コールバックを起動
			callbacks['success'](result);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
		 // 失敗コールバックを起動
		 callbacks['error'](XMLHttpRequest, textStatus, errorThrown);
		},
		complete : function( result ){
		 // 完了コールバックを起動
		 callbacks['complete'](result);
		}
	});
}
		<?php
	}



	/**
	* 友達検索
	*/
	function Fsearch() {
		?>
/* --------------------------------------------------------------------------

メイン

-------------------------------------------------------------------------- */
var friendListPage = 0;
var year_;
var month_;
var ajaxGetStudylog = false;
var allowDrawFlg = false;
var elmGraphArea;
var initObj = {
	searchResult: '<p>ここに検索結果が表示されます</p>'
};
var profileArea;

$(function () {
	// 初期動作
	var date = new Date();
	year_ = date.getFullYear();
	month_ = date.getMonth();
	elmGraphArea = $('.graphArea');
	profileArea = $('#fsearch .profile');
	elmGraphArea.hide();
	profileArea.html(initObj.searchResult);

	// カレンダー動作設定
	setCal();
	setChangeCal();

	// タブの切り替え
	var searchbarSet = setSearchbarFunc();
	$('.tab li').click(function(event) {
		if ($(this).hasClass('current')) return;
		elmGraphArea.hide();
		$('.tab .current').removeClass('current');
		$(this).addClass('current');
		$('#fsearchArea .result').html('');
		profileArea.html(initObj.searchResult);
		searchbarSet();
	});


	// 検索開始
	$('#fsearchForm').submit(function(event) {
		event.preventDefault();

		if ($('#txtFsearch').css('color') === 'rgb(153, 153, 153)' || $('#txtFsearch').val() === '') {
			alert('キーワードを入力してください');
			return;
		}

		var keyword = $('#txtFsearch').val();
		// 名前検索か目標検索か判断
		var method = '';
		if ($('#fsearchArea ul li.current').attr('name') === 'name_search') {
			// 名前検索
			method = 'name_search';
		} else {
			// 目標検索
			method = 'target_search';
		}

		// 友達候補リストを取得、表示
		$.ajax({
			url: '<?php echo rootUrl; ?>fsearch/getMoreFriendData/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				page: friendListPage,
				keyword: keyword,
				method: method
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// 友達リストを表示
			insertMoreFriendData(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	// 検索バーの動作制御
	searchbarSet();
});


/* --------------------------------------------------------------------------

グラフ描画

-------------------------------------------------------------------------- */
/**
* 日付情報の更新
*/
function setCal() {
	// グローバル変数にアクセス
	var year = year_;
	var month = month_;

	// 曜日
	var dayArr = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
	var elmCal = $('#studyCal');
	var elmCalHeader = $('.calHeader');
	var date = new Date( year, month, 1 );

	// カレンダー見出し挿入
	elmCalHeader.html( year + '年 ' + (month+1) + '月' );

	// グラフ描画
	drawStudytimeGraph();
}
function setChangeCal() {
	$('#nextMonth').click(function(event) {
		event.preventDefault();

		if (month_ > 10) {
			month_ = 0;
			year_++;
		} else {
			month_++;
		}

		setCal();
	});

	$('#prevMonth').click(function(event) {
		event.preventDefault();
		if (month_ === 0) {
			month_ = 11;
			year_--;
		} else {
			month_--;
		}

		setCal();
	});
}
function daysInMonth(){
	return 32 - new Date( year_, month_, 32 ).getDate();
}
function drawStudytimeGraph() {
	if ($('.registerId').length === 0) return;

	// グラフのx軸の設定
	var dateData = [];
	dateData[dateData.length] = '日';
	for (var i=0; i<daysInMonth(); i++) {
		dateData[dateData.length] = i+1;
	}
	// グラフのy軸 - 勉強時間の設定
	var myStudytimeData = [];
	var friendStudytimeData = [];
	myStudytimeData[myStudytimeData.length] = '自分';
	friendStudytimeData[friendStudytimeData.length] = '相手';
	$.ajax({
			url: '<?php echo rootUrl; ?>studylog/getDoubleStudylog/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: year_,
				month: +month_+1,
				friend_id: $('.registerId').val(),
				dayCnt: daysInMonth()
			}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		for (var i=0; i<daysInMonth(); i++) {
			myStudytimeData[myStudytimeData.length] = 0;
			friendStudytimeData[friendStudytimeData.length] = 0
		}

		var dateStr = year_ + '-' + sprintf('%02d', +month_+1) + '-';
		for (var i=0; i<data[0].length; i++) {
			var day = +data[0][i]['Studylog']['date'].replace(dateStr, '');
			myStudytimeData[day] = sprintf('%.1f', data[0][i][0]['studytime']/60);
		}
		for (var i=0; i<data[1].length; i++) {
			var day = +data[1][i]['Studylog']['date'].replace(dateStr, '');
			friendStudytimeData[day] = sprintf('%.1f', data[1][i][0]['studytime']/60);
		}


		var chartdata51 = {

		"config": {
			// "title": "Option textColor",
			// "subTitle": "各文字列の色(データ値valColor以外)をまとめてcolor文字列で指定できます。",
			"type": "line",
			"bg": "#fff",
			// "xColor": "rgba(150,150,150,0.6)",
			"colorSet": ["rgba(190,190,190,0.9)", "rgba(0,150,250,0.9)"],
			"textColor": "#333",
			"useMarker": "arc",
			"useShadow": "no",
			"roundDigit": 1,
			"axisXLen": 12,
			"minY": 0,
			"maxY": 12,
			"paddingLeft": 35,
			"paddingRight": 50,
			"unit:str": "h",
			"paddingTop": 10
		},

		// "data": [
		// 	["日",1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
		// 	["今月",10,5.5,8,9,10,11,6,4,5,6,7,4,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
		// ]
		"data": [dateData, myStudytimeData, friendStudytimeData]
	};
	ccchart.init("hoge", chartdata51)

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}



/* --------------------------------------------------------------------------

検索部

-------------------------------------------------------------------------- */
function insertMoreFriendData( data ) {
	if (data.length === 0) {
		return;
	}

	var accountName = data[0]['Account']['name'];
	var tmpStr = '';
	var tmpQl = '';
	var elmResults = $('#fsearchArea .result');
	elmResults.html('');

	for (var i=0; i<data.length; i++) {

		tmpStr = '';
		tmpQl = '';
		tmpStr = '<li>\
				<dl class="clearfix">\
					<dt><img src="<?php echo rootUrl; ?>img/profile/' + data[i]['Account']['id'] + data[i]['Account']['img_ext'] + '" alt="' + data[i]['Account']['name'] + '" width="50" /></dt>\
					<dd>\
						<input type="hidden" value="' + data[i]['Account']['id'] + '" class="hdAccountId" />\
						<h2>' + data[i]['Account']['name'] + '</h2>\
						<ul>';

		while (accountName === data[i]['Account']['name']) {
			// 資格の結合処理
			tmpQl += '<li>' + data[i]['Target']['name'] + '</li>\n';

			// 添え字を進める
			i++;
			if (i >= data.length) {
				break;
			}
		}
		if (i<data.length) {
			accountName = data[i]['Account']['name'];
		}
		// 行き過ぎた添え字を一つ戻す
		i--;

		tmpStr += tmpQl + '\
		</ul>\
					</dd>\
				</dl>\
				<p>勉強記録(' + data[i]['Account']['studylog_count'] + ')</p>\
			</li>\n';

		// 挿入処理
		elmResults.append(tmpStr);
	}

	// クリックイベント処理を実装
	$('#fsearchArea .result > li').click(function(event) {
		getProfile( $(this).find('.hdAccountId').val(), $(this) );
		elmGraphArea.show().css('opacity', 1);
	});
}


/**
* プロフィール取得
*/
function getProfile( accountId, clickElm ) {
	if (accountId.length <= 0 || clickElm.length <= 0) return;

	$.ajax({
		url: '<?php echo rootUrl; ?>Fsearch/getProfile/',
		type: 'POST',
		dataType: 'JSON',
		data: {id: accountId}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);
		showProfile(data, clickElm);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}

/**
* プロフィール表示
*/
function showProfile( data, clickElm ) {
	if (data.length <= 0) return;

	var id = data['Account']['id'];
	var name 		= data['Account']['name'];
	var sex 		= data['Account']['sex'] === '0' ? '男' : '女';
	var qualifications = clickElm.find('ul').html();
	var intro 	= data['Account']['introduction'];
	var imgName = data['Account']['id'] + data['Account']['img_ext'];

	// 初期化
	profileArea.html('');
	var tagStr = '\
			<ul class="clearfix">\
				<li>\
					<img src="<?php echo rootUrl; ?>img/profile/' + imgName + '" alt="' + name + '" width="90" />\
					<a id="btnRegisterFriend" href="#" onclick="register(event, this);">仲間になる</a>\
					<input class="registerId" type="hidden" value="' + id + '" />\
				</li>\
				<li>\
					<dl>\
						<dt>名前</dt>\
						<dd>' + name + '</dd>\
						<dt>性別</dt>\
						<dd>' + sex + '</dd>\
						<dt>年齢</dt>\
						<dd>32才</dd>\
						<dt>資格</dt>\
						<dd>\
							<ul>' + qualifications + '</ul>\
						</dd>\
						<dt>自己紹介</dt>\
						<dd>\
							<p>' + intro + '</p>\
						</dd>\
					</dl>\
				</li>\
			</ul>';

	// プロフィールの挿入
	profileArea.html(tagStr);

	// 勉強時間比較グラフ表示処理
	drawStudytimeGraph();
}

/**
* 友達登録
*/
function register( event, clickElm ) {
	event.preventDefault();
	var newFriendId = $(clickElm).parent().find('.registerId').val();

	// 友達登録処理
	$.ajax({
		url: '<?php echo rootUrl; ?>Fsearch/registerFriend/',
		type: 'POST',
		dataType: 'JSON',
		data: {newFriendId: newFriendId}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);
		switch (data[0]) {
			case 'success':
				alert('登録が完了しました！');
				break;
			case 'duplicate':
				alert('既に友達登録されています。');
				break;
			default :
				alert('予期せぬエラーが発生しました。');
				break;
		}
	})
	.fail(function(XMLHttpRequest, textStatus, errorThrown) {
		console.log("error");
		console.log(textStatus);
		console.log(errorThrown);
	})
	.always(function() {
		console.log("complete");
	});

}


/* --------------------------------------------------------------------------

未入力チェックなど

-------------------------------------------------------------------------- */
function setSearchbarFunc() {
	var elmTxtFsearch = $('#txtFsearch');
	var defaultVal;

	function inner() {
		if ($('.tab li').first().hasClass('current')) {
			defaultVal = '例）センター試験';
		} else {
			defaultVal = '例）春太郎';
		}
		elmTxtFsearch.val(defaultVal).css('color', '#999');
		elmTxtFsearch.focus(function(event) {
			if ($(this).css('color') === 'rgb(153, 153, 153)') {
				elmTxtFsearch.val('').css('color', '#333');
			}
		});
		elmTxtFsearch.blur(function(event) {
			if ($(this).val() === '') {
				$(this).val(defaultVal).css('color', '#999');
			}
		});
	}

	return inner;
}
		<?php
	}



	/**
	* 勉強ログ制御
	*/
	public function studylog() {
		?>
/* --------------------------------------------------------------------------

メイン

-------------------------------------------------------------------------- */
var year_;
var month_;
var ajaxGetStudylog = false;


$(function () {
	// 初期動作
	var date = new Date();
	year_ = date.getFullYear();
	month_ = date.getMonth();

	$('#studylog .dispArea section').not('.default').hide();

	// カレンダー動作設定
	setCal();
	setChangeCal();
});



/* --------------------------------------------------------------------------

関数部

-------------------------------------------------------------------------- */
/**
* カレンダー制御
*/
function setCal() {
	// グローバル変数にアクセス
	var year = year_;
	var month = month_;

	// 曜日
	var dayArr = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
	var elmCal = $('#studyCal');
	var elmCalHeader = $('#studylog .calHeader');
	var date = new Date( year, month, 1 );

	// カレンダー見出し挿入
	elmCalHeader.html( year + '年 ' + (month+1) + '月' );

	// 曜日挿入
	elmCal.html('');
	var tagStr = '';
	for (var i=0; i<dayArr.length; i++) {
		tagStr += '\n<li class="' + dayArr[i] + '">' + dayArr[i] + '</li>';
	}
	elmCal.append(tagStr);

	// 日にち挿入
	tagStr = '';
	for (var i=0; i<date.getDay(); i++) {
		tagStr += '\n<li>&nbsp;</li>';
	}
	for (var i=0; i<daysInMonth(); i++) {
		tagStr += '\n<li class="' + dayArr[i%7] + '"><a class="' + (i+1) + '" href="#">' + (i+1) + '</a></li>';
	}
	elmCal.append(tagStr);

	// グラフ描画
	drawStudytimeGraph();
	// カレンダーの月を表示
	$('#GraphCalMonth').html((month_+1)+'月');

	// 勉強記録取得情報
	getStudylog();
}
function setChangeCal() {
	$('#nextMonth').click(function(event) {
		event.preventDefault();

		if (month_ > 10) {
			month_ = 0;
			year_++;
		} else {
			month_++;
		}

		setCal();
	});

	$('#prevMonth').click(function(event) {
		event.preventDefault();
		if (month_ === 0) {
			month_ = 11;
			year_--;
		} else {
			month_--;
		}

		setCal();
	});
}
function daysInMonth(){
	return 32 - new Date( year_, month_, 32 ).getDate();
}
function getStudylog() {
	if (ajaxGetStudylog) {
		ajaxGetStudylog.abort();
	}
	ajaxGetStudylog = $.ajax({
		url: '<?php echo rootUrl; ?>studylog/getStudylog/',
		type: 'POST',
		dataType: 'JSON',
		data: {
			year: year_,
			month: month_,
			dayCnt: daysInMonth()
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		// カレンダーに勉強記録の有無を表示
		for (var i=0; i<data.length; i++) {
			var dateArr = data[i]['Studylog']['date'].split('-');
			$('.' + +dateArr[2]).addClass('exists').attr('name', data[i]['Studylog']['id']);
		}
		// 日付に対してクリック時の処理を設定
		setClicklCal();
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}
function setClicklCal() {
	$('#studyCal li a').click(function(event) {
		event.preventDefault();

		$('#studylog .dispArea section').not('.default').css('opacity', 0).show().fadeTo(500, 1);
		$('#studylog .dispArea .default').hide();

		if (!$(this).hasClass('exists')) {
			return;
		}
		$('#studyCal li .current').removeClass('current');
		$(this).addClass('current');
		var id = $(this).attr('name');
		var day = +$(this).html();

		/* 勉強詳細取得 */
		$.ajax({
			url: '<?php echo rootUrl; ?>studylog/getStudylogDetail/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				id: id
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// 勉強記録詳細表示の準備
			if (data.length === 0) return;
			var date = data[0]['Studylog']['date'];
			var dateArr = date.split('-');
			var month = dateArr[1];
			var day = dateArr[2];
			var reflection = data[0]['Studylog']['text'];
			var targetName = [];
			var studytime = [];

			for (var i=0; i<data.length; i++) {
				targetName[targetName.length] = data[i]['Target']['name'];
				studytime[studytime.length] = data[i]['Studytime']['time'];
			}

			// 表示処理
			$('#reflectionHeader').html(month + '月' + day + '日の感想・反省');
			$('#reflectionText').html(reflection);
			var str = '';
			for (var i=0; i<targetName.length; i++) {
				str += '<li>\n';
				str += '<p>' + (+studytime[i]/60).toFixed(1) + 'h</p>\n';
				str += '<h3>' + targetName[i] + '</h3>\n';
				str += '</li>\n';
			}
			$('#reflectionStudyTime').html(str);

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});


		/* Todoリスト取得 */
		$.ajax({
			url: '<?php echo rootUrl; ?>todo/getTodo/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: year_,
				month: +month_ + 1,
				day: day
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// データ未取得の時は抜ける
			if (data.length === 0) {
				// 何もない表示
				$('#miniTodo').html('<p>この日のTodoリストはありません。</p>');
				return;
			}

			// Todoリスト表示
			var tagStr = '';
			for (var i=0; i<data.length; i++) {
				if ( i===0 ) {
					tagStr += '<dt>' + data[i]['Target']['name'] + '</dt>\
								<dd>\
									<ul>\n';
				}
				var classTag = '';
				if (data[i]['Todo']['done'] === '1') classTag = ' class="checked" ';

				tagStr += '<li' + classTag + '>' + data[i]['Todo']['text'] + '</li>\n';

				if ( i === data.length-1 ) {
					tagStr += '</ul>\
							</dd>\n';
					break;
				} else if (data[i]['Target']['id'] !== data[i+1]['Target']['id']) {
					tagStr += '</ul>\
							</dd>\
							<dt>' + data[i+1]['Target']['name'] + '</dt>\
							<dd>\
								<ul>\n';
				}
			}

			// タグの挿入
			$('#miniTodo').html(tagStr);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
}
function drawStudytimeGraph() {
	// グラフのx軸の設定
	var dateData = [];
	dateData[dateData.length] = '日';
	for (var i=0; i<daysInMonth(); i++) {
		dateData[dateData.length] = i+1;
	}
	// グラフのy軸 - 勉強時間の設定
	var studytimeData = [];
	studytimeData[studytimeData.length] = (+month_+1)+'月';
	$.ajax({
			url: '<?php echo rootUrl; ?>studylog/getMonthStudytime/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: year_,
				month: +month_ + 1
			}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		// 1ヶ月勉強していなかったときの処理
		// if (data.length === 0) {
			for (var i=0; i<daysInMonth(); i++) {
				studytimeData[studytimeData.length] = 0;
			}
		// }

		var dateStr = year_ + '-' + sprintf('%02d', +month_+1) + '-';
		for (var i=0; i<data.length; i++) {
			var day = +data[i]['Studylog']['date'].replace(dateStr, '');
			studytimeData[day] = sprintf('%.1f', data[i][0]['studytime']/60);
		}


		var chartdata51 = {

		"config": {
			// "title": "Option textColor",
			// "subTitle": "各文字列の色(データ値valColor以外)をまとめてcolor文字列で指定できます。",
			"type": "line",
			"bg": "#fff",
			// "xColor": "rgba(150,150,150,0.6)",
			"colorSet": ["rgba(0,150,250,0.9)"],
			"textColor": "#333",
			"useMarker": "arc",
			"useShadow": "no",
			"roundDigit": 1,
			"axisXLen": 12,
			"minY": 0,
			"maxY": 12,
			"paddingLeft": 35,
			"paddingRight": 50,
			"unit:str": "h",
			"paddingTop": 10
		},

		// "data": [
		// 	["日",1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
		// 	["今月",10,5.5,8,9,10,11,6,4,5,6,7,4,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
		// ]
		"data": [dateData, studytimeData]
	};
	ccchart.init("hoge", chartdata51)

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
		<?php
	}

	public function todo() {
		?>
/* --------------------------------------------------------------------------

メイン ▼

-------------------------------------------------------------------------- */
$(function () {
	createBaseTodo();
});



/* --------------------------------------------------------------------------

関数部 ▼

-------------------------------------------------------------------------- */
function createBaseTodo() {
	$.ajax({
		url: '<?php echo rootUrl; ?>timeline/getTargetData/',
		type: 'POST',
		dataType: 'JSON',
		data: {
			account_id: <?php echo $this->loginId; ?>
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data[1]);
		var targetData = data[1];
		console.log(targetData);

		// Todoリストの大枠を作成
		var elmTodo = $('#todoWindow dl');
		elmTodo.html('');
		for (var i=0; i<targetData.length; i++) {
			var tagStr = '<dt id="target' + targetData[i]['Target']['id'] + '">\
							<h4>' + targetData[i]['Target']['name'] + '</h4>\
							<div class="addBtn"><a href="#">&nbsp;</a></div>\
						</dt>';
			elmTodo.append(tagStr);

			// Todoリストの中身を作成
			createTodoList(targetData[i]['Target']['id']);
		}


		// プラスボタンが押された時の処理
		setPlusTodo();
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}
function createTodoList( target_id ) {
	// 今日のTodoを取得
	var date = new Date();
	$.ajax({
		url: '<?php echo rootUrl; ?>todo/getTodo/',
		type: 'POST',
		dataType: 'JSON',
		data: {
			year: date.getFullYear(),
			month: date.getMonth()+1,
			day: date.getDate(),
			target_id: target_id
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		// Todoリストにリストを挿入
		var tagStr = '';
		for (var i=0; i<data.length; i++) {
			var classTag = '';
			if (data[i]['Todo']['done'] === '1') {
				classTag = ' class="complete"';
			}
			tagStr += '\
				<dd id="todo' + data[i]['Todo']['id'] + '" ' + classTag + '>\
					<p>' + data[i]['Todo']['text'] + '</p>\
				</dd>\n';
		}
		$('#target' + target_id).after(tagStr);
		setCheckOrUncheck();

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function setPlusTodo() {
	// プラスを押された時の処理
	$('.addBtn').click(function(event) {
		event.preventDefault();
		var targetId = $(this).parent().attr('id').replace('target', '');
		var tagStr = '\
						<form id="newTodoForm" action="#" method="post">\
							<dd><input type="text" id="newTodo" /></dd>\
							<input id="newTodoSubmit" type="submit" value="" />\
						</form>\
						';
		$(this).parent().after(tagStr);
		$('#newTodo').focus();

		$('#newTodoForm').submit(function(event) {
			event.preventDefault();

			// Todo登録処理
			newTodoFix( targetId );
		});
	});
}
function newTodoFix( targetId_ ) {
	var targetId = targetId_ || false;
	if ( !targetId ) return;

	var todoText = $('#newTodo').val();
	var tagStr = '\
					<dd id="todoTmp"><p>' + todoText + '</p></dd>\
					';
	$('#newTodoForm').replaceWith(tagStr);

	// ダブルクリックしたときの挙動の設定
	setCheckOrUncheck();

	// DBに登録処理
	var date = new Date();
	var rand = Math.floor(Math.random()*1000000);
	$.ajax({
		url: '<?php echo rootUrl; ?>todo/registerTodo/',
		type: 'POST',
		dataType: 'JSON',
		data: {
			target_id: targetId,
			text: todoText,
			year: date.getFullYear(),
			month: date.getMonth()+1,
			day: date.getDate(),
			rand: rand
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);
		$('#todoTmp').attr('id', data[1][0]['Todo']['id']);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function setCheckOrUncheck() {
	$('#todoWindow dl dd').unbind().click(function(event) {

		var todo_id = $(this).attr('id').replace('todo', '');
		if ($(this).hasClass('complete')) {
			$(this).removeClass('complete');
			// チェックを外す処理
			checkOrUncheck( false, todo_id );
		} else {
			$(this).addClass('complete');
			// チェックを入れる処理
			checkOrUncheck( true, todo_id );
		}
	});

	// ダブルクリック時の挙動の設定
	setAlterTodo();
}
function checkOrUncheck( check_, todo_id_ ) {
	// check するのか uncheck するのかを判断
	var url = '';
	var todo_id = todo_id_;
	if ( check_ ) {
		url = '<?php echo rootUrl; ?>todo/check/';
	} else {
		url = '<?php echo rootUrl; ?>todo/uncheck/';
	}

	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'JSON',
		data: {id: todo_id}
	})
	.done(function() {
		console.log("success");
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function setAlterTodo() {
	$('#todoWindow dl dd').dblclick(function(event) {
		var todo_id = $(this).attr('id').replace('todo', '');
		var oldText = $(this).find('p').html();
		var tagStr = '\
						<form id="formAlterTodo" action="#" method="post">\
							<input id="txtAlter" type="text" value="" />\
							<input id="alterTodoSubmit" type="submit" value="" />\
						</form>\
						';
		$(this).find('p').replaceWith(tagStr);
		$('#txtAlter').focus();
		$('#txtAlter').val(oldText);

		// テキストボックスのクリックイベント伝播を止める
		$('#txtAlter').click(function(event) {
			event.stopPropagation();
		});

		// 編集完了時の処理
		$('#alterTodoSubmit').unbind().click(function(event) {
			event.preventDefault();
			event.stopPropagation();

			var text = $('#txtAlter').val();
			var pStr = '<p>' + text + '</p>';
			$(this).parent().replaceWith(pStr);

			setAlterTodo();

			// Todo変更処理
			$.ajax({
				url: '<?php echo rootUrl; ?>todo/alter/',
				type: 'POST',
				dataType: 'JSON',
				data: {
					todo_id: todo_id,
					text: text
				}
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});
	});
}
		<?php
	}



	public function summary() {
		?>
/* --------------------------------------------------------------------------

メイン ▼

-------------------------------------------------------------------------- */
$(function () {
	setBarchart();
	$('#summaryForm').submit(function(event) {
		event.preventDefault();

		// 勉強時間データの取得
		var dataArr = [];
		$('.studyTime').each(function() {
			var time = +$(this).val();
			var targetId = +$(this).parent().find('.qCode').val();
			dataArr[dataArr.length] = targetId + '-' + time;
		});
		var studytimeData = dataArr.join(',');

		// 感想・反省データの取得
		var reflection = $('#summaryText').val();

		// 今日のまとめデータの格納処理
		$.ajax({
			url: '<?php echo rootUrl; ?>summary/registerSummary/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				studytime_data: studytimeData,
				reflection: reflection
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
});



/* --------------------------------------------------------------------------

関数部 ▼

-------------------------------------------------------------------------- */
function setBarchart() {
	// 今日の日付を取得
	var date = new Date();
	var yesterday = new Date( date.getFullYear(), date.getMonth(), date.getDate()-1 );

	$('#summaryForm ul li').each(function() {
		var targetId = $(this).find('dt').find('.qCode').val();
		var thisElm = $(this);
		// 昨日の勉強データを取得、グラフ表示
		$.ajax({
			url: '<?php echo rootUrl; ?>summary/getStudytime/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: yesterday.getFullYear(),
				month: yesterday.getMonth()+1,
				day: yesterday.getDate(),
				target_id: targetId
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// 昨日の勉強時間が見当たらない場合
			if (data.length === 0) return;

			// グラフに表示
			graphAnimate(thisElm.find('.yesterdayBar'), data[0]['Studytime']['time']/3, 2);

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});


	// 今日の勉強データを取得、グラフ表示
	$('#summaryForm').find('.studyTime').each(function(index, el) {
		$(this).unbind().change(function(event) {
			graphAnimate($(this).parent().parent().find('.todayBar'), +$(this).val()*60/3, 2);
		});
	});
}
		<?php
	}



	public function newTarget() {
		?>
/* --------------------------------------------------------------------------

メイン ▼

-------------------------------------------------------------------------- */
$(function () {

	// 自分の目標を表示
	dispMyTargets();

	// 目標検索を設定
	setNewTargetSearch();

});



/* --------------------------------------------------------------------------

関数部 ▼

-------------------------------------------------------------------------- */
function setNewTargetSearch() {
	$('#targetForm').submit(function(event) {
		event.preventDefault();
		var keyword = $('#txtTsearch').val();

		$.ajax({
			url: '<?php echo rootUrl; ?>target/searchNewTargets/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				keyword: keyword
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// 検索結果を表示
			var tagStr = '';
			for (var i=0; i<data.length; i++) {
				tagStr += '\
					<li>\
						<p>' + data[i]['Target']['name'] + '</p>\
						<a href="#">クリックして登録完了！</a>\
						<input type="hidden" value="' + data[i]['Target']['id'] + '" />\
					</li>';
			}
			if (data.length === 0) tagStr = '\
				<li name="not" class="default">資格が見つかりませんでした<br />お探しの資格がない場合<a href="<?php echo rootUrl . "demand/"; ?>">コチラ</a>から申請ができます。</li>';
			$('#searchResult').html('').append(tagStr).find('li').click(function(event) {
				// 検索結果をクリックしたときの処理
				if ($(this).attr('name') === 'not') return;

				var targetId = $(this).find('input').val();
				var targetName = $(this).find('p').html();
				registerNewTarget(targetId);
				var tag = '\
				<li class="fadein">\
					<p>' + $(this).find('p').html() + '</p>\
					<a class="deleteBtn" href="#">&times;</a>\
					<input type="hidden" value="' + targetId + '" />\
				</li>';
				$('#myTargetArea ul').prepend(tag);
				$(this).replaceWith('');
				setDeleteBtn();
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	});

}
function dispMyTargets() {
	$.ajax({
			url: '<?php echo rootUrl; ?>target/getMyTarget/',
			type: 'POST',
			dataType: 'JSON',
			data: {}
	})
	.done(function(data) {
		console.log("success");

		// マイ目標を表示
		var tagStr = '';
		for (var i=0; i<data.length; i++) {
			tagStr += '\
				<li>\
					<p>' + data[i]['Target']['name'] + '</p>\
					<a class="deleteBtn" href="#">&times;</a>\
					<input type="hidden" value="' + data[i]['Target']['id'] + '" />\
				</li>';
		}
		$('#myTargetArea ul').hide().html('').append(tagStr).fadeTo(600, 1);;
		setDeleteBtn();
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}
function registerNewTarget( target_id_ ) {
	var targetId = target_id_ || false;
	if (!targetId) return;

	$.ajax({
			url: '<?php echo rootUrl; ?>target/registerNewTarget/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				target_id: targetId
			}
	})
	.done(function() {
		console.log("success");
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function setDeleteBtn() {
	$('.deleteBtn').unbind().click(function(event) {
		$(this).parent().fadeTo(500, 0, function () {
			$(this).replaceWith('')
		});
		event.preventDefault();
		var targetId = $(this).parent().find('input').val();

		$.ajax({
			url: '<?php echo rootUrl; ?>target/removeTarget/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				target_id: targetId
			}
		})
		.done(function(data) {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	});
}
		<?php
	}


	/**
	* プロフィールページ
	*/
	public function profile() {
		?>
/* --------------------------------------------------------------------------

メイン

-------------------------------------------------------------------------- */
var year_;
var month_;
var ajaxGetStudylog = false;
var elmStudyDetail;


$(function () {
	// 初期動作
	var date = new Date();
	year_ = date.getFullYear();
	month_ = date.getMonth();
	elmStudyDetail = $('#page_profile section.reflection > div');
	studyDetailInitialize();
	before();

	// カレンダー動作設定
	setCal();
	setChangeCal();
});



/* --------------------------------------------------------------------------

関数部

-------------------------------------------------------------------------- */
/**
* カレンダー制御
*/
function setCal() {
	// グローバル変数にアクセス
	var year = year_;
	var month = month_;

	// 曜日
	var dayArr = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
	var elmCal = $('#studyCal');
	var elmCalHeader = $('#page_profile .calHeader');
	var date = new Date( year, month, 1 );

	// カレンダー見出し挿入
	elmCalHeader.html( year + '年 ' + (month+1) + '月' );

	// 曜日挿入
	elmCal.html('');
	var tagStr = '';
	for (var i=0; i<dayArr.length; i++) {
		tagStr += '\n<li class="' + dayArr[i] + '">' + dayArr[i] + '</li>';
	}
	elmCal.append(tagStr);

	// 日にち挿入
	tagStr = '';
	for (var i=0; i<date.getDay(); i++) {
		tagStr += '\n<li>&nbsp;</li>';
	}
	for (var i=0; i<daysInMonth(); i++) {
		tagStr += '\n<li class="' + dayArr[i%7] + '"><a class="' + (i+1) + '" href="#">' + (i+1) + '</a></li>';
	}
	elmCal.append(tagStr);

	// グラフ描画
	drawStudytimeGraph();
	// カレンダーの月を表示
	$('#GraphCalMonth').html((month_+1)+'月');

	// 勉強記録取得情報
	getStudylog();
}
function setChangeCal() {
	$('#nextMonth').click(function(event) {
		event.preventDefault();

		// 勉強詳細エリア初期化
		studyDetailInitialize();

		if (month_ > 10) {
			month_ = 0;
			year_++;
		} else {
			month_++;
		}

		setCal();
	});

	$('#prevMonth').click(function(event) {
		event.preventDefault();

		// 勉強詳細エリア初期化
		studyDetailInitialize();

		if (month_ === 0) {
			month_ = 11;
			year_--;
		} else {
			month_--;
		}

		setCal();
	});
}
function daysInMonth(){
	return 32 - new Date( year_, month_, 32 ).getDate();
}
function getStudylog() {
	if (ajaxGetStudylog) {
		ajaxGetStudylog.abort();
	}
	ajaxGetStudylog = $.ajax({
		url: '<?php echo rootUrl; ?>studylog/getStudylog/',
		type: 'POST',
		dataType: 'JSON',
		data: {
			year: year_,
			month: month_,
			dayCnt: daysInMonth(),
			userid: $('#hd_userid').val()
		}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		// カレンダーに勉強記録の有無を表示
		for (var i=0; i<data.length; i++) {
			var dateArr = data[i]['Studylog']['date'].split('-');
			$('.' + +dateArr[2]).addClass('exists').attr('name', data[i]['Studylog']['id']);
		}
		// 日付に対してクリック時の処理を設定
		setClicklCal();
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

}
function setClicklCal() {
	$('#studyCal li a').click(function(event) {
		event.preventDefault();
		if (!$(this).hasClass('exists')) {
			return;
		}
		$('#studyCal li .current').removeClass('current');
		$(this).addClass('current');

		var id = $(this).attr('name');
		var day = +$(this).html();

		/* 勉強詳細取得 */
		$.ajax({
			url: '<?php echo rootUrl; ?>studylog/getStudylogDetail/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				id: id
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// 勉強記録詳細表示の準備
			if (data.length === 0) return;
			var date = data[0]['Studylog']['date'];
			var dateArr = date.split('-');
			var month = dateArr[1];
			var day = dateArr[2];
			var reflection = data[0]['Studylog']['text'];
			var targetName = [];
			var studytime = [];

			for (var i=0; i<data.length; i++) {
				targetName[targetName.length] = data[i]['Target']['name'];
				studytime[studytime.length] = data[i]['Studytime']['time'];
			}

			// 表示処理
			$('#detailHeader').html('<span><em id="month">' + +month + '</em>月<em id="date">' + +day + '</em>日 の勉強記録</span>');
			$('#reflectionText').html(reflection);
			var str = '';
			for (var i=0; i<targetName.length; i++) {
				str += '<li><section>\n';
				str += '<p>' + (+studytime[i]/60).toFixed(1) + 'h</p>\n';
				str += '<h4>' + targetName[i] + '</h4>\n';
				str += '</section></li>\n';
			}
			$('#reflectionStudyTime').html(str);
			elmStudyDetail.show();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});


		/* Todoリスト取得 */
		$.ajax({
			url: '<?php echo rootUrl; ?>todo/getTodo/',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: year_,
				month: +month_ + 1,
				day: day
			}
		})
		.done(function(data) {
			console.log("success");
			console.log(data);

			// データ未取得の時は抜ける
			if (data.length === 0) {
				// 何もない表示
				$('#miniTodo').html('');
				return;
			}

			// Todoリスト表示
			var tagStr = '';
			for (var i=0; i<data.length; i++) {
				if ( i===0 ) {
					tagStr += '<dt>' + data[i]['Target']['name'] + '</dt>\
								<dd>\
									<ul>\n';
				}
				var classTag = '';
				if (data[i]['Todo']['done'] === '1') classTag = ' class="checked" ';

				tagStr += '<li' + classTag + '>' + data[i]['Todo']['text'] + '</li>\n';

				if ( i === data.length-1 ) {
					tagStr += '</ul>\
							</dd>\n';
					break;
				} else if (data[i]['Target']['id'] !== data[i+1]['Target']['id']) {
					tagStr += '</ul>\
							</dd>\
							<dt>' + data[i+1]['Target']['name'] + '</dt>\
							<dd>\
								<ul>\n';
				}
			}

			// タグの挿入
			$('#miniTodo').html(tagStr);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
}
function drawStudytimeGraph() {
	// グラフのx軸の設定
	var dateData = [];
	dateData[dateData.length] = '日';
	for (var i=0; i<daysInMonth(); i++) {
		dateData[dateData.length] = i+1;
	}
	// グラフのy軸 - 勉強時間の設定
	var studytimeData = [];
	studytimeData[studytimeData.length] = (+month_+1)+'月';
	var url = '<?php echo rootUrl; ?>studylog/getMonthStudytime/';
	var data = {
				year: year_,
				month: +month_ + 1,
				userid: $('#hd_userid').val()
			};
	var ownProfileFlg = true;
	// 自分のプロフィールかどうかを判断
	if (+$('#hd_userid').val() !== <?php echo $_SESSION['Auth']['id']; ?>) {
		url = '<?php echo rootUrl; ?>studylog/getDoubleStudylog/';
		data.friend_id = $('#hd_userid').val();
		ownProfileFlg = false;
	}
	$.ajax({
			url: url,
			type: 'POST',
			dataType: 'JSON',
			data: data
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		if (ownProfileFlg) {
			// 自分のプロフィール表示
			for (var i=0; i<daysInMonth(); i++) {
				studytimeData[studytimeData.length] = 0;
			}

			var dateStr = year_ + '-' + sprintf('%02d', +month_+1) + '-';
			for (var i=0; i<data.length; i++) {
				var day = +data[i]['Studylog']['date'].replace(dateStr, '');
				studytimeData[day] = sprintf('%.1f', data[i][0]['studytime']/60);
			}


			var chartdata51 = {

				"config": {
					// "title": "Option textColor",
					// "subTitle": "各文字列の色(データ値valColor以外)をまとめてcolor文字列で指定できます。",
					"type": "line",
					"bg": "#fff",
					// "xColor": "rgba(150,150,150,0.6)",
					"colorSet": ["rgba(0,150,250,0.9)"],
					"textColor": "#333",
					"useMarker": "arc",
					"useShadow": "no",
					"roundDigit": 1,
					"axisXLen": 12,
					"minY": 0,
					"maxY": 12,
					"paddingLeft": 35,
					"paddingRight": 50,
					"unit:str": "h",
					"paddingTop": 10
				},

				// "data": [
				// 	["日",1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
				// 	["今月",10,5.5,8,9,10,11,6,4,5,6,7,4,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
				// ]
				"data": [dateData, studytimeData]
			};
			ccchart.init("hoge", chartdata51);
		} else {
			// 自分以外のプロフィール表示

			for (var i=0; i<daysInMonth(); i++) {
				dateData[dateData.length] = i+1;
			}
			// 勉強時間の設定
			var myStudytimeData = [];
			var friendStudytimeData = [];
			myStudytimeData[myStudytimeData.length] = '自分';
			friendStudytimeData[friendStudytimeData.length] = '相手';

			for (var i=0; i<daysInMonth(); i++) {
				myStudytimeData[myStudytimeData.length] = 0;
				friendStudytimeData[friendStudytimeData.length] = 0
			}

			var dateStr = year_ + '-' + sprintf('%02d', +month_+1) + '-';
			for (var i=0; i<data[0].length; i++) {
				var day = +data[0][i]['Studylog']['date'].replace(dateStr, '');
				myStudytimeData[day] = sprintf('%.1f', data[0][i][0]['studytime']/60);
			}
			for (var i=0; i<data[1].length; i++) {
				var day = +data[1][i]['Studylog']['date'].replace(dateStr, '');
				friendStudytimeData[day] = sprintf('%.1f', data[1][i][0]['studytime']/60);
			}


			var chartdata51 = {

				"config": {
					// "title": "Option textColor",
					// "subTitle": "各文字列の色(データ値valColor以外)をまとめてcolor文字列で指定できます。",
					"type": "line",
					"bg": "#fff",
					// "xColor": "rgba(150,150,150,0.6)",
					"colorSet": ["rgba(190,190,190,0.9)", "rgba(0,150,250,0.9)"],
					"textColor": "#333",
					"useMarker": "arc",
					"useShadow": "no",
					"roundDigit": 1,
					"axisXLen": 12,
					"minY": 0,
					"maxY": 12,
					"paddingLeft": 35,
					"paddingRight": 50,
					"unit:str": "h",
					"paddingTop": 10
				},

				// "data": [
				// 	["日",1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
				// 	["今月",10,5.5,8,9,10,11,6,4,5,6,7,4,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
				// ]
				"data": [dateData, myStudytimeData, friendStudytimeData]
			};
			ccchart.init("hoge", chartdata51);
		}



	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
/**
* 勉強詳細エリア初期化
*/
function studyDetailInitialize() {
	var initializingStr = '<span>以下に勉強記録が表示されます</span>';
	elmStudyDetail.hide();
	$('#detailHeader').html(initializingStr);

}
		<?php
	}
}
?>
