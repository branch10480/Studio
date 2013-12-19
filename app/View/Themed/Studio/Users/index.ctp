<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section id="myData">
	<div class="wrapper">
		<ul class="clearfix">
			<li class="graphArea">
				<div id="piechart"></div>
				<div class="circle">
					<svg width="260" height="260" viewBox="0 0 260 260" xmlns="http://www.w3.org/2000/svg">
						<circle cx="130" cy="130" r="110" style="fill:#fff;" />
					</svg>
				</div>
				<div class="textArea">
					<p>8.0 h</p>
					<h5>今日の勉強時間</h5>
				</div>
			</li>
			<li>
				<h3>昨日の反省</h3>
				<p class="regretArea">
					昨日は勉強量はそこまで多くなかった。<br />今日はもっと勉強時間を確保したい。
				</p>
				<div class="btnArea">
					<a class="topcoat-button--large--cta" href="#">勉強する</a>
					<a class="topcoat-button--large" href="#">一日を終える</a>
				</div>
			</li>
		</ul>
	</div>
</section>
<section id="friendsData">
	<ul class="clearfix">
		<li id="friend01">
			<div class="piechart"></div>
			<div class="circle">
				<svg width="220" height="220" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
					<circle cx="110" cy="110" r="90" style="fill:#fff;" />
				</svg>
			</div>
			<div class="textArea">
				<p>3.0 h</p>
				<a href="#"><?php echo $this->Html->image('friend00001.jpg', array('alt' => '友達1')); ?></a>
			</div>
		</li>
		<li id="friend02">
			<div class="piechart"></div>
			<div class="circle">
				<svg width="220" height="220" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
					<circle cx="110" cy="110" r="90" style="fill:#fff;" />
				</svg>
			</div>
			<div class="textArea">
				<p>3.0 h</p>
				<a href="#"><?php echo $this->Html->image('friend00002.jpg', array('alt' => '友達2')); ?></a>
			</div>
		</li>
		<li id="friend03">
			<div class="piechart"></div>
			<div class="circle">
				<svg width="220" height="220" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
					<circle cx="110" cy="110" r="90" style="fill:#fff;" />
				</svg>
			</div>
			<div class="textArea">
				<p>3.0 h</p>
				<a href="#"><?php echo $this->Html->image('friend00003.jpg', array('alt' => '友達3')); ?></a>
			</div>
		</li>
		<li id="friend04">
			<div class="piechart"></div>
			<div class="circle">
				<svg width="220" height="220" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
					<circle cx="110" cy="110" r="90" style="fill:#fff;" />
				</svg>
			</div>
			<div class="textArea">
				<p>3.0 h</p>
				<a href="#"><?php echo $this->Html->image('friend00004.jpg', array('alt' => '友達4')); ?></a>
			</div>
		</li>
	</ul>
</section>
