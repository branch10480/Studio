<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<script>


/**
* main
*/
var submitFlg = false;


$(function () {
	// 初期動作
	before();

	// submitボタン処理
	$('.submit').click(function(event) {
		event.preventDefault();
		$('#newaccountMailForm').submit();
	});;

	// ログイン認証処理設定
	setCheckRepetition();
});



/**
* Ajaxによるログイン認証処理
*/

function setCheckRepetition () {
	$('#newaccountMailForm').submit(function(event) {
		if (!submitFlg) {
			event.preventDefault();

			// メールアドレス有効性チェック
			if (!$('#newaccountMail').val().match(/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/)) {
				$('#newaccountMsg').html('※ メールアドレスが正しくありません。').css({'color': 'red', 'font-size': '12px'});
				return;
			} else {
				checkRepetition();
			}

			// エラーメッセージの初期化
			$('#newaccountMsg').html('');
		}
	});
}
/* バリデーション実行 */
function newaccountValidate () {
	var email = $('#newaccountMail').val();
	var flg = true;
	var msg = [];
	var strMsg;
	var resultObj;

	// 未入力チェック
	if (email === '') {
		flg = false;
		msg[msg.length] = '※ 未入力項目があります。';
	} else {
		// メールアドレス有効性チェック
		if (!email.match(/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/)) {
			flg = false;
			msg[msg.length] = '※ メールアドレスが正しくありません。';
		}
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
				submitFlg = true;
				$('#newaccountMailForm').submit();
			}
		}
	})
	.error(function (data, textStatus) {
		alert('error');
		alert(textStatus);
	});
}


</script>
<section id="newaccount" class="newacc1">
	<div id="smallHeader">
		<h1>新規会員登録</h1>
	</div>
	<?php echo $this->Html->image('img_newaccbar1.png', array('width' => '1000', 'alt' => '1. メールアドレス入力')); ?>
	<section>
		<hr />
		<h2><span>メールアドレスをご入力ください</span></h2>
		<div id="contents">
			<?php echo $this->Form->create('Account', array('id' => 'newaccountMailForm')); ?>
			<h3>メールアドレスを入力</h3>
			<?php echo $this->Form->text('Account.mailaddress', array('id' => 'newaccountMail', 'type' => 'email')); ?>
			<p id="newaccountMsg"></p>
			<ul>
				<li>※ 携帯メールアドレスでも登録できます。</li>
				<li>※ ドメイン指定受信を設定されている方は「info.studio@gmail.com」<br />　を受信できるように指定ください。</li>
			</ul>
			<div class="btnArea"><a class="submit" href="#"><span>次へ</span></a></div>
			<?php echo $this->Form->end(); ?>
		</div>
	</section>
</section>