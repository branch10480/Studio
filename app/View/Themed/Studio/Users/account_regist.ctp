<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newAccountSendMail">
	<h1>アカウント本登録完了</h1>
	<dl>
		<dt>メールアドレス</dt>
		<dd><?php echo $mailaddress; ?></dd>
	</dl>
</section>