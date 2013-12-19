<script>


/**
* main
*/


$(function () {
	// 初期動作
	before();

	var modal = $('#modal');
	modal.hide();
	$('#loginBtn').click(function(event) {
		event.preventDefault();
		modal.css('z-index', 200).fadeTo(200, 1, function() {
			$('#modalEmail').focus();
		});

	});
	$('.bg').click(function(event) {
		modal.fadeTo(100, 0, function() {
			$(this).css('z-index', -1);
		})
	});

	// リサイズ時の中央寄せ
	$(window).resize(function(event) {
		modalCentering();
	});

	// ログイン認証処理設定
	setAuth();
});


/**
* モーダルウィンドウ動作
*/


/* 初期動作 */
function before() {
	modalCentering();
}
/* センタリング */
function modalCentering() {
	var boxW = $('.box').outerWidth();
	var boxH = $('.box').outerHeight();
	var winSize = getWindowSize();

	var leftPosition = Math.floor(winSize.winWidth / 2) - Math.floor(boxW / 2);
	var topPosition = (winSize.winHeight / 2) - (boxH / 2);
	$('.box').css({
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
		if (+$('#submitFlg').val() !== 0) {
			return;
		}
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
/* Ajaxログイン認証 */
function ajaxAuth () {
	$.ajax({
		url: '/Studio/users/login/',
		type: 'POST',
		dataType: 'json',
		data: {
			id: $('#modalEmail').val(),
			pass: $('#modalPass').val()
		}
	})
	.success(function (data) {
		if (data['result'] === 'false') {
			$('#modalMsg').html(data['msg']).css({'color': 'red', 'font-size': '12px'});
		} else {
			// ログイン成功時にリダイレクト
			$('#submitFlg').val('1');
			$('#loginForm').submit();
		}
	})
	.error(function (data, textStatus) {
		alert('error');
		alert(textStatus);
	});
}


</script>
<div id="modal">
	<div class="wrapper">
		<div class="bg"></div>
		<div class="box">
			<form id="loginForm" action="<?php echo rootUrl . 'users/login_comp/'; ?>" method="post">
				<h3>ログイン</h3>
				<dl>
					<dt>メールアドレス</dt>
					<dd><input type="text" id="modalEmail" name="loginEmail" /></dd>
					<dt>パスワード</dt>
					<dd><input type="password" id="modalPass" /></dd>
					<dd><p id="modalMsg"></p></dd>
				</dl>
				<input type="submit" id="btnLogin" value="ログイン" />
				<input type="hidden" id="submitFlg" value="0" />
			</form>
		</div>
	</div>
</div>