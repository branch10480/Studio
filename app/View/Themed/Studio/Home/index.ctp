<?php
	// このページ限定のCSS,JS
	$this->Html->script(array('drawPieChart', 'jquery.glide.min'), array('inline' => false));
	$this->Html->css(array('pieChart', 'glide'), null, array('inline' => false));
?>
<script>
	$(function() {
		$('.slider').glide({
			arrowRightText: '&nbsp;',
			arrowLeftText: '&nbsp;',
			autoplay: 10000
		});
	})
</script>
<section id="mainVisual">
	<div class="slider">
		<ul class="slides">
			<li class="slide"><?php echo $this->Html->image('mainvisual01.jpg', array('alt' => 'スライド01', 'style' => 'width: 100%;')); ?></li>
			<li class="slide"><?php echo $this->Html->image('mainvisual02.jpg', array('alt' => 'スライド02', 'style' => 'width: 100%;')); ?></li>
			<li class="slide"><?php echo $this->Html->image('mainvisual03.jpg', array('alt' => 'スライド03', 'style' => 'width: 100%;')); ?></li>
			<li class="slide"><?php echo $this->Html->image('mainvisual04.jpg', array('alt' => 'スライド04', 'style' => 'width: 100%;')); ?></li>
		</ul>
	</div>
</section>
