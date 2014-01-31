<?php
	// このページ限定のCSS,JS
	$this->Html->script(array('scroll'), array('inline' => false));
	// $this->Html->css(array('pieChart', 'glide'), null, array('inline' => false));
?>

<script src="<?php echo rootUrl . 'js/timeline/'; ?>" type="text/javascript" charset="utf-8"></script>
<article id="home_top" class="clearfix">
	<div id="timeline">
		<ul>
			<!-- <li>
				<dl>
					<dt><?php echo $this->Html->image('img_imaeda01.png', array('alt' => '今枝稔晴', 'width' => '75', 'height' => '75')); ?></dt>
					<dd>
						<h2>今枝稔晴</h2>
						<p>今日は10時間の目標達成です。<br />明日もこの調子で頑張ろうと思います！</p>
						<ul class="communicateBtnArea">
							<li class="btnComment"><span>コメントする</span></li>
							<li class="btnSupport"><span>ファイト！</span></li>
						</ul>
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt><?php echo $this->Html->image('img_suzuki02.png', array('alt' => '鈴木一郎', 'width' => '75', 'height' => '75')); ?></dt>
					<dd>
						<h2>鈴木一郎</h2>
						<p>今日は10時間の目標達成です。<br />明日もこの調子で頑張ろうと思います！</p>
						<?php echo $this->Html->image('img_sample01.jpg', array('alt' => 'サンプルイメージ', 'width' => '400')); ?>
						<ul class="communicateBtnArea">
							<li class="btnComment"><span>コメントする</span></li>
							<li class="btnSupport"><span>ファイト！</span></li>
						</ul>
						<div class="commentArea">
							<ul>
								<li>
									<dl>
										<dt><?php echo $this->Html->image('img_imaeda01.png', array('alt' => '今枝稔晴', 'width' => '48', 'height' => '48')); ?></dt>
										<dd>
											<h3>今枝稔晴</h3>
											<p>コメントです<br />コメントです</p>
										</dd>
									</dl>
								</li>
								<li>
									<dl>
										<dt><?php echo $this->Html->image('img_imaeda01.png', array('alt' => '今枝稔晴', 'width' => '48', 'height' => '48')); ?></dt>
										<dd>
											<h3>今枝稔晴</h3>
											<p>コメントです<br />コメントです</p>
										</dd>
									</dl>
								</li>
							</ul>
						</div>
					</dd>
				</dl>
			</li> -->
		</ul>
	</div>
	<div id="friend_now">
		<aside>
			<ul>
				<!-- <li>
					<dl class="clearfix">
						<dt>応用情報技術者試験まで</dt>
						<dd>あと<strong>６０</strong>日</dd>
					</dl>
				</li> -->
			</ul>
		</aside>
		<h1>あなたがフォローしている人達</h1>
		<ul>
			<li>
				<div class="container">
					<h2>山田太郎さん</h2>
					<dl>
						<dt><?php echo $this->Html->image('img_suzuki02.png', array('alt' => '鈴木一郎', 'width' => '48', 'height' => '48')); ?></dt>
						<dd>
							<div class="graphArea">
								<h3>昨日の勉強時間</h3>
								<!-- グラフ描画部 -->
							</div>
						</dd>
					</dl>
					<ul class="reflection clearfix">
						<li>最新の投稿</li>
						<li class="current">昨日の反省</li>
					</ul>
				</div>
				<p>昨日は途中で居眠りしてしまった。<br />明日は勉強時間を有効に使いたい。</p>
			</li>
			<li>
				<div class="container">
					<h2>山田太郎さん</h2>
					<dl>
						<dt><?php echo $this->Html->image('img_suzuki02.png', array('alt' => '鈴木一郎', 'width' => '48', 'height' => '48')); ?></dt>
						<dd>
							<div class="graphArea">
								<h3>昨日の勉強時間</h3>
								<!-- グラフ描画部 -->
							</div>
						</dd>
					</dl>
					<ul class="reflection clearfix">
						<li>最新の投稿</li>
						<li class="current">昨日の反省</li>
					</ul>
				</div>
				<p>昨日は途中で居眠りしてしまった。<br />明日は勉強時間を有効に使いたい。</p>
			</li>
			<li>
				<div class="container">
					<h2>山田太郎さん</h2>
					<dl>
						<dt><?php echo $this->Html->image('img_suzuki02.png', array('alt' => '鈴木一郎', 'width' => '48', 'height' => '48')); ?></dt>
						<dd>
							<div class="graphArea">
								<h3>昨日の勉強時間</h3>
								<!-- グラフ描画部 -->
							</div>
						</dd>
					</dl>
					<ul class="reflection clearfix">
						<li>最新の投稿</li>
						<li class="current">昨日の反省</li>
					</ul>
				</div>
				<p>昨日は途中で居眠りしてしまった。<br />明日は勉強時間を有効に使いたい。</p>
			</li>
		</ul>
	</div>
</article>
<a id="scrollToTop" href="#"><?php echo $this->Html->image('ico_totop.png', array('alt' => 'トップへ', 'width' => '63', 'height' => '63')); ?><br />トップへ</a>
