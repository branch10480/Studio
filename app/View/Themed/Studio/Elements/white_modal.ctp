<script>
/* --------------------------------------------------------------------------

main

-------------------------------------------------------------------------- */


$(function () {
	// 初期動作
	before();

	// モーダルウィンドウを実装
	setModal('#gnav01');
	setModal('#gnav02');
	setModal('#gnav03');

	// ログイン認証処理設定
	setAuth();
});


/* --------------------------------------------------------------------------

定義関数

-------------------------------------------------------------------------- */


/**
* まとめページの遷移
*/
function summaryNext(event) {
	event.preventDefault();

	// 勉強時間入力欄生成
	makeStudytimeInputArea();

	// 勉強時間入力欄の生成
	$('#summary01').fadeTo(300, 0, function () {
		$(this).hide();
		$('#summary02').fadeTo(200, 1);
		doCentering();
	});
}
function summaryReturn(event) {
	event.preventDefault();
	$('#summary02').fadeTo(300, 0, function () {
		$(this).hide();
		$('#summary01').fadeTo(200, 1);
		doCentering();
	});
}
function makeStudytimeInputArea() {
	// 初期化
	$('#summaryForm > ul').html('');
	$.ajax({
		url: '<?php echo rootUrl; ?>summary/getTargetData/',
		type: 'POST',
		dataType: 'json',
		data: {}
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		// 入力欄生成
		for (var i=0; i<data.length; i++) {
			var tagStr = '\
						<li>\
							<dl class="clearfix">\
								<dt>\
									<h5><span>' + data[i]['Target']['name'] + '</span></h5>\
									<select class="studyTime">';
			for (var j=0; j<13; j = j+0.5) {
				tagStr += '<option value="' + j + '">' + sprintf('%.1f', j) + 'h</option>\n';
			}
			tagStr +=				'</select>\
									<input type="hidden" value="' + data[i]['Target']['id'] + '" class="qCode">\
								</dt>\
								<dd>\
									<svg width="370" height="100" viewBox="0 0 370 100">￥\
										<!-- code -->\
										<g class="graphBG" stroke="#bcb699" stroke-dasharray="2">\
											<line x1="90" y1="0" x2="90" y2="100" />\
											<line x1="140" y1="0" x2="140" y2="100" />\
											<line x1="190" y1="0" x2="190" y2="100" />\
											<line x1="240" y1="0" x2="240" y2="100" />\
											<line x1="290" y1="0" x2="290" y2="100" />\
											<line x1="340" y1="0" x2="340" y2="100" />\
										</g>\
										<g class="graphLabel" text-anchor="end" font-family="Helvetica, Arial, sans-serif" font-size="13px">\
											<text x="80" y="30" font-weight="bold">今日</text>\
											<text x="80" y="70" fill="#bcb699">昨日</text>\
										</g>\
										<g class="praphBar" fill="#c9c3a5" stroke="#bcb699">\
											<rect x="90" y="15" fill="#41c3e9" stroke="#2abfe8" width="0" height="25" class="todayBar" rx="2"></rect>\
											<rect x="90" y="55" width="0" height="25" class="yesterdayBar" rx="2"></rect>\
											<rect x="90" y="125" fill="#41c3e9" width="0" height="25" class="bar3" rx="2"></rect>\
										</g>\
									</svg>\
								</dd>\
							</dl>\
						</li>';
			$('#summaryForm > ul').append(tagStr);

			// グラフ描画処理を設定
			setBarchart();
		}
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
function setBarchart() {
	graphAnimate();
}


/**
* モーダルウィンドウ動作
*/
function before() {
	doCentering();
	$('#white_modal').hide();
	$('#summary02').hide();
}
/* モーダルウィンドウの動作 */
function setModal(elmId) {
	// 引数が入っているか確認
	if (elmId === null) {
		return;
	}

	var modal = $('#white_modal');
	$(elmId).click(function(event) {
		event.preventDefault();
		$('#postText').val('');
		$('#postFile').replaceWith('<input id="postFile" type="file" enctype="multipart/form-data" name="up_img">');
		switchWindow(elmId);
		modal.css('z-index', 200).fadeTo(300, 1, function() {
			$('#postText').focus();
		});
		doCentering();

	});
	$('.bg').click(function(event) {
		modal.fadeTo(100, 0, function() {
			$(this).css('z-index', -1);
		})
	});

	// リサイズ時の中央寄せ
	$(window).resize(function(event) {
		doCentering();
	});
}
/* モーダルウィンドウのコンテンツ切り替え */
function switchWindow(elmId) {
	// 引数が入っているか確認
	if (elmId === null) {
		return;
	}

	$('#white_modal .box').hide();

	// 切り替え処理
	switch (elmId) {
		case '#gnav01':
			// 投稿ウィンドウを表示
			$('#postWindow').show();
			break;
		case '#gnav02':
			// ToDoリストを表示
			$('#summary02').hide();
			$('#summary01').show().css('opacity', 1);
			$('#todoWindow').show();
			$('.summary_show').hide();
			$('.todo_show').show();
			$('#summaryWindow').show();
			break;
		case '#gnav03':
			// ToDoリストを表示
			$('.summary_show').show();
			$('.todo_show').hide();
			$('#summaryWindow').show();
			break;
	}
}
/* センタリングセットを実行 */
function doCentering() {
	modalCentering('#postWindow');
	// modalCentering('#todoWindow');
	modalCentering('#summaryWindow');
}
/* センタリング */
function modalCentering(idName) {
	var idOrClass = idName || '.box';
	var boxW = $(idOrClass).outerWidth();
	var boxH = $(idOrClass).outerHeight();
	var winSize = getWindowSize();

	var leftPosition = Math.floor(winSize.winWidth / 2) - Math.floor(boxW / 2);
	var topPosition = (winSize.winHeight / 2) - (boxH / 2);
	$(idOrClass).css({
		'top': topPosition + 'px',
		'left': leftPosition + 'px'
	});
}
/* ウィンドウサイズ取得 */
function getWindowSize() {
	var winWidth = $(window).width();
	var winHeight = $(window).height();
	return {
		'winWidth': winWidth,
		'winHeight': winHeight
	};
}


/**
* Ajaxによるログイン認証処理
*/
function setAuth () {
	$('#loginForm').submit(function(event) {
		event.preventDefault();

		// エラーメッセージの初期化
		$('#modalMsg').html('');

		// バリデーションの実行
		var valResult = authValidate();
		if (!valResult.result) {
			var msgStr = '';
			// エラーメッセージ結合処理
			msgStr = valResult.msg;
			// エラーメッセージ出力
			$('#modalMsg').html(msgStr).css({
				'color': 'red',
				'font-size': '12px'
			});
		} else {
			// Ajaxログイン認証 f()
			ajaxAuth();
		}
	});
}
/* バリデーション実行 */
function authValidate () {
	var email = $('#modalEmail').val();
	var pass = $('#modalPass').val();
	var flg = true;
	var msg = '';
	var resultObj;

	// 未入力チェック
	if (email === '' || pass === '') {
		flg = false;
		msg = '※ 未入力項目があります。';
	} else {
		// メールアドレス有効性チェック
		// if (!email.match(/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/)) {
		// 	flg = false;
		// 	msg = '※ メールアドレスが正しくありません。';
		// }
	}

	resultObj = {
		result: flg,
		msg: msg
	};
	return resultObj;
}



</script>


<div id="white_modal">
	<div class="wrapper">
		<div class="bg"></div>
		<!-- 投稿 -->
		<div id="postWindow" class="box">
			<h3><span>投稿する</span></h3>
			<form action="<?php echo rootUrl; ?>timeline/post/" method="post" id="postForm">
				<textarea name="postText" id="postText" cols="30" rows="10"></textarea>
				<div class="btnArea">
					<input id="postFile" type="file" enctype="multipart/form-data" name="up_img">
					<input type="submit" value="投稿">
				</div>
			</form>
		</div>
		<!-- 今日のまとめ -->
		<div id="summaryWindow" class="box">
			<!-- 今日のまとめ 1 -->
			<section id="summary01">
				<h3 class="summary_show"><span>今日のまとめをします 1/2</span></h3>
				<p class="summary_show">やり残しはありませんか？</p>
				<div id="todoWindow">
					<script type="text/javascript" src="<?php echo rootUrl; ?>js/todo/"></script>
					<h3 class="todo_show"><span>ToDoリスト</span></h3>
					<dl>
						<dt>
							<h4>応用情報</h4>
							<div class="addBtn"><a href="#">&nbsp;</a></div>
						</dt>
						<dd class="complete">
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dd class="complete">
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dd>
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dd>
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dt>
							<h4>センター試験</h4>
							<div class="addBtn"><a href="#">&nbsp;</a></div>
						</dt>
						<dd class="complete">
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dd class="complete">
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dd>
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
						<dd>
							<p>応用情報の参考書を20ページ分終わらせる</p>
						</dd>
					</dl>
				</div>
				<div class="btnArea summary_show"><a onclick="summaryNext(event);" href="#">次へ</a></div>
			</section>
			<!-- 今日のまとめ 2 -->
			<section id="summary02">
				<script type="text/javascript" src="<?php echo rootUrl; ?>js/summary/"></script>
				<h3><span>今日のまとめをします 2/2</span></h3>
				<form action="#" method="post" id="summaryForm">
					<h4>勉強時間</h4>
					<ul>
						<li>
							<dl class="clearfix">
								<dt>
									<h5><span>応用情報技術者</span></h5>
									<select class="studyTime">
										<option value="0">0h</option>
										<option value="0.5">0.5h</option>
										<option value="1.0">1.0h</option>
										<option value="1.5">1.5h</option>
										<option value="2.0">2.0h</option>
										<option value="2.5">2.5h</option>
										<option value="3.0">3.0h</option>
									</select>
									<input type="hidden" value="1" class="qCode">
								</dt>
								<dd>
									<p>SVGグラフエリア</p>
								</dd>
							</dl>
						</li>
						<li>
							<dl class="clearfix">
								<dt>
									<h5><span>基本情報技術者</span></h5>
									<select class="studyTime">
										<option value="0">0h</option>
										<option value="0.5">0.5h</option>
										<option value="1.0">1.0h</option>
										<option value="1.5">1.5h</option>
										<option value="2.0">2.0h</option>
										<option value="2.5">2.5h</option>
										<option value="3.0">3.0h</option>
									</select>
									<input type="hidden" value="2" class="qCode">
								</dt>
								<dd>
									<p>SVGグラフエリア</p>
								</dd>
							</dl>
						</li>
					</ul>
					<textarea id="summaryText" rows="5"></textarea>
					<div class="btnArea">
						<a onclick="summaryReturn(event);" href="#">戻る</a>
						<input type="submit" value="今日の勉強を終える">
					</div>
				</form>
			</section>
		</div>
		<!-- ToDoリスト -->
		<!-- お疲れ様 -->
	</div>
</div>