<?php
	// このページ限定のCSS,JS
	$this->Html->script('createProfile', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newaccount" class="newacc0">
	<div id="smallHeader">
		<h1>新規会員登録</h1>
	</div>
	<?php echo $this->Html->image('img_newaccbar0.png', array('width' => '1000', 'alt' => '0. 利用規約の確認')); ?>
	<section>
		<hr />
		<h2><span>利用規約をご確認ください</span></h2>
		<div id="contents" class="clearfix">
			<div class="left">
				<ul>
					<li><em>1. </em>当サイトでは勉強量を<br />　自分以外のユーザに公開いたします</li>
					<li><em>2. </em>当サイトでは実名によるご利用を<br />　　お願い致しております。</li>
				</ul>
				<div class="btnArea"><a href="<?php echo $nextURL; ?>"><span>規約に同意して登録開始する</span></a></div>
				<p>※上記規約に同意していただける方のみ、<br />　ボタンを押して登録をお願い致します。</p>
			</div>
			<div class="right">
				<?php echo $this->Html->image('img_useragreement.jpg', array('width' => '500', 'alt' => '')); ?>
			</div>
		</div>
	</section>
</section>