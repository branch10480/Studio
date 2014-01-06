<?php
	// このページ限定のCSS,JS
	$this->Html->script('createProfile', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newaccount" class="newacc3">
	<div id="smallHeader">
		<h1>新規会員登録</h1>
	</div>
	<?php echo $this->Html->image('img_newaccbar3.png', array('width' => '1000', 'alt' => '1. メールアドレス入力')); ?>
	<section>
		<hr />
		<h2><span>プロフィールを作成します</span></h2>
		<div id="contents" class="clearfix">
			<div class="left">
				<div id="iconArea">
					<?php echo $this->Html->image('ico_man.gif', array('width' => '100')); ?>
					<p id="animP">画像を選択</p>
				</div>
			</div>
			<div class="right">
				<?php echo $this->Form->create('Account', array('id' => 'newAccProfile')); ?>
				<dl>
					<dt>名前</dt>
					<dd><?php echo $this->Form->text('Account.mailaddress', array('id' => 'newaccountMail', 'class' => 'txtBox', 'type' => 'text')); ?></dd>
					<dt>パスワード</dt>
					<dd><?php echo $this->Form->text('Account.pass', array('id' => 'newaccountMail', 'class' => 'txtBox', 'type' => 'password')); ?></dd>
					<dt>パスワード(確認)</dt>
					<dd><input type="password" id="checkPass" name="checkPass" /></dd>
					<dt>メールアドレス</dt>
					<dd>sample@gmail.com</dd>
					<dt>性別</dt>
					<dd>
						<?php echo $this->Form->radio('Account.sex', array('0' => '男性', '1' => '女性'), array('legend' => false)); ?>
					</dd>
					<dt>自己紹介</dt>
					<dd><?php echo $this->Form->textarea('Account.introduction', array('cols' => 40, 'rows' => 10)); ?></dd>
					<dd class="btnArea"><a href="#">次へ</a></dd>
				</dl>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</section>
</section>