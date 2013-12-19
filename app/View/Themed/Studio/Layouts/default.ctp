<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo siteName . $title_for_layout; ?></title>
<?php
	echo $this->Html->css(array(
			'common',
			'topcoat-desktop-light',
			'modal',
			'layout'
		));
	echo $this->Html->script(array(
			'jquery-1.10.2.min',
			'jquery.easing.1.3',
			'jquery.cookie',
			'raphael-min',
			'piechart',
			'barchart',
			'sprintf',
			'common'
		));
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
<script src="<?php echo rootUrl . 'js/post/'; ?>" type="text/javascript" charset="utf-8"></script>
</head>
<body>





<?php echo $this->element('white_modal'); ?>





<?php echo $this->element('header'); ?>





<?php echo $this->Session->flash(); ?>
<div id="conWrapper" class="clearfix">
	<nav id="gnav">
		<ul class="clearfix">
			<li id="gnav01"><a href="#"><p>投稿する</p></a></li>
			<li id="gnav02"><a href="#"><p>ToDoリスト</p></a></li>
			<li id="gnav03"><a href="#"><p>今日のまとめをする</p></a></li>
			<li id="gnav04"><a href="<?php echo rootUrl . 'home/fsearch/'; ?>"><p>勉強仲間を探す</p></a></li>
		</ul>
	</nav>
	<div><?php echo $this->fetch('content'); ?></div>
</div>





<?php echo $this->element('footer'); ?>





<!-- GoogleAnalyticsコード挿入 -->





</body>
</html>