<?php
	// このページ限定のCSS,JS
	$this->Html->script(array('drawPieChart', 'jquery.glide.min'), array('inline' => false));
	$this->Html->css(array('pieChart', 'glide'), null, array('inline' => false));
?>
<p>タイムライン</p>
