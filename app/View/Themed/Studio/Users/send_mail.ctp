<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newaccount" class="newacc2">
	<div id="smallHeader">
		<h1>新規会員登録</h1>
	</div>
	<?php echo $this->Html->image('img_newaccbar2.png', array('width' => '1000', 'alt' => '1. メールアドレス入力')); ?>
	<section>
		<hr />
		<h2><span>メールの送信が完了しました</span></h2>
		<div id="contents">
			<h3>登録はまだ完了していません</h3>
			<p>ご指定のメールアドレスに仮登録メールを送信しました。<br />お手数ですがメールボックスをご確認ください、記載の確認 URL をクリックし、登録を続けてください。</p>
			<a class="toNewAcc3" href="<?php echo $url; ?>"><?php echo $url; ?></a>
		</div>
	</section>
</section>