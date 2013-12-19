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

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');

$loginoOrOut = '';		// ログイン、ログアウトボタン
$userName = '';			// ユーザ名
if ($this->Session->check('Auth.User')) {
	$loginoOrOut = '<a href="http://' . env('HTTP_HOST')
 . DS . 'Studio' . DS . 'users' . DS . 'logout' . '">ログアウト</a>';
 	$userName = $this->Session->read('Auth.User.f_mailaddress');
} else {
	$loginoOrOut = '<a id="loginBtn" href="http://' . env('HTTP_HOST')
 . DS . 'Studio' . DS . 'users' . DS . 'login' . '">ログイン</a>';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $this->Html->charset(); ?>
<title>Studio<?php echo $title_for_layout; ?></title>
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
			'common'
		));
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body>




<?php echo $this->element('modal'); ?>




<div id="container">
	<header>
		<div class="clearfix">
			<div class="left logo"><a href="<?php echo 'http://' . env('HTTP_HOST') . DS . 'Studio' . DS; ?>">Studio</a></div>
			<nav class="center"></nav>
			<div class="right">
				<ul class="clearfix">
					<li>
						<?php echo $loginoOrOut; ?>
					</li>
					<li>
						<a href="#">
							<dl class="clearfix">
								<dt></dt>
								<dd><?php echo $userName; ?></dd>
							</dl>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</header>


	<div id="invitationNav">
		<h2>さぁ、あなたも登録をして始めましょう！</h2>
		<p><a href="<?php echo rootUrl . 'users/new_account/' ?>">新規会員登録はコチラ</a></p>
	</div>





	<article>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</article>





<?php echo $this->element('footer'); ?>

</div>





</body>
</html>