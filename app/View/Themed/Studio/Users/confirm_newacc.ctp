<?php
	// このページ限定のCSS,JS
	$this->Html->script('createProfile', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="newaccount" class="newacc3">
	<div id="smallHeader">
		<h1>新規会員登録</h1>
	</div>
	<?php echo $this->Html->image('img_newaccbar4.png', array('width' => '1000', 'alt' => '4. 確認')); ?>
	<section>
		<hr />
		<h2><span>以下の内容で登録します。間違いはありませんか？</span></h2>
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
					<dd><?php echo $name; ?></dd>
					<dt>パスワード</dt>
					<dd><?php echo $pass; ?></dd>
					<dt>メールアドレス</dt>
					<dd><?php echo $email; ?></dd>
					<dt>性別</dt>
					<dd><?php echo +$sex === 0 ? '男' : '女'; ?></dd>
					<dt>生年月日</dt>
					<dd><?php echo $birthday; ?></dd>
					<dt>自己紹介</dt>
					<dd><?php echo $introduction; ?></dd>
					<dd class="btnArea">
						<a href="<?php echo $returnURL; ?>">戻る</a>
						<a href="<?php echo $nextURL; ?>">会員登録を完了</a>
					</dd>
				</dl>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</section>
</section>