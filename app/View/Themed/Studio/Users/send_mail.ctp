<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newAccountSendMail">
	<h1>メールを送信しました</h1>
	<a href="<?php echo $url; ?>"><?php echo $url; ?></a>
</section>