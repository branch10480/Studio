<?php
	// このページ限定のCSS,JS
	$this->Html->script('createProfile', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newaccount" class="newacc5">
	<div id="smallHeader">
		<h1>新規会員登録</h1>
	</div>
	<?php echo $this->Html->image('img_newaccbar5.png', array('width' => '1000', 'alt' => '1. 会員登録完了')); ?>
	<section>
		<hr />
		<h2><span>会員登録が完了しました</span></h2>
		<div id="contents" class="clearfix">
			<div class="left">
				<dl>
					<dt><?php echo $this->Html->image('ico_man.gif', array('width' => '100')); ?></dt>
					<dd>
						<ul>
							<li><?php echo $name; ?></li>
							<li><?php echo $mail; ?></li>
							<li><?php echo +$sex === 0 ? '男' : '女'; ?></li>
							<li><?php echo $birthday; ?></li>
							<li><?php echo $introduction; ?></li>
						</ul>
					</dd>
				</dl>
			</div>
			<section class="right">
				<h3>おめでとうございます。<br />会員登録が完了いたしました。</h3>
				<p>この度は会員登録ありがとうございます。<br />さっそくログインして始めましょう！</p>
				<div class="btnArea"><a href="<?php echo $autologinURL; ?>">ログインして始める</a></div>
			</section>
		</div>
	</section>
</section>