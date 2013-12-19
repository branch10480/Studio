<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<script>


/**
* main
*/


$(function () {
	// 初期動作
	before();

	// ログイン認証処理設定
	setCheckRepetition();

	$('#newaccountMail').blur(function(event) {
		// メールアドレス有効性チェック
		if (!$('#newaccountMail').val().match(/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/)) {
			$('#newaccountMsg').html('※ メールアドレスが正しくありません。').css({'color': 'red', 'font-size': '12px'});
		} else {
			checkRepetition();
		}
	});
});



/**
* Ajaxによるログイン認証処理
*/

function setCheckRepetition () {
	$('#newaccountForm').submit(function(event) {
		var elmFlg = $('#newaccountForm .hdFlg');
		if (elmFlg.val() === '0') {
			event.preventDefault();

			// エラーメッセージの初期化
			$('#newaccountMsg').html('');

			// バリデーションの実行
			var valResult = newaccountValidate();
			if (!valResult.result) {
				var msgStr = '';
				// エラーメッセージ結合処理
				msgStr = valResult.msg;
				// エラーメッセージ出力
				$('#newaccountMsg').html(msgStr).css({
					'color': 'red',
					'font-size': '12px'
				});
			} else {
				// Ajaxログイン認証 f()
				alert('ok');
				elmFlg.val('1');
				$(this).submit();
			}
		}
	});
}
/* バリデーション実行 */
function newaccountValidate () {
	var email = $('#newaccountMail').val();
	var pass = $('#newaccountPass').val();
	var flg = true;
	var msg = [];
	var strMsg;
	var resultObj;

	// 未入力チェック
	if (email === '' || pass === '') {
		flg = false;
		msg[msg.length] = '※ 未入力項目があります。';
	} else {
		// メールアドレス有効性チェック
		if (!email.match(/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/)) {
			flg = false;
			msg[msg.length] = '※ メールアドレスが正しくありません。';
		}
		// パスワード有効性チェック
		if (!pass.match(/^.{6,30}$/)) {
			flg = false;
			msg[msg.length] = '※ 6文字以上30文字以下で入力してください。';		}
	}

	// 警告文結合処理
	for (var i = 0; i < msg.length; i++) {
		if (i === 0) {
			strMsg = msg[0];
		} else {
			strMsg += '<br />' + msg[i];
		}
	}

	resultObj = {
		result: flg,
		msg: strMsg
	};
	return resultObj;
}
/* Ajaxメールアドレス重複チェック */
function checkRepetition () {
	$.ajax({
		url: '/Studio/users/mailaddress_exists/',
		type: 'POST',
		dataType: 'json',
		data: {
			mail: $('#newaccountMail').val()
		}
	})
	.success(function (data) {
		if (data['result'] === 'false') {
			$('#newaccountMsg').html(data['msg']).css({'color': 'red', 'font-size': '12px'});
		} else {
			$('#newaccountMsg').html(data['msg']).css({'color': 'green', 'font-size': '12px'});
		}
	})
	.error(function (data, textStatus) {
		alert('error');
		alert(textStatus);
	});
}


</script>
<section id="newaccount">
	<h1>新規会員登録</h1>
	<?php echo $this->Form->create('Account', array('id' => 'newaccountForm')); ?>
	<dl>
		<dt>メールアドレス</dt>
		<dd><?php echo $this->Form->text('Account.mailaddress', array('id' => 'newaccountMail')); ?></dd>
		<dt>パスワード</dt>
		<dd><?php echo $this->Form->password('Account.pass', array('id' => 'newaccountPass')); ?></dd>
		<dd><p id="newaccountMsg"></p></dd>
	</dl>
	<input type="hidden" value="0" class="hdFlg" />
	<?php echo $this->Form->end('送信'); ?>
</section>