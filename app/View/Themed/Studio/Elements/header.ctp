<?php


$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');

$loginOrOut = '';		// ログイン、ログアウトボタン
$id = '';
$userName = '';			// ユーザ名
if ($this->Session->check('Auth')) {
	$loginOrOut = '<a id="logoutBtn" href="' . rootUrl . 'users' . DS . 'logout' . DS . '">ログアウト</a>';
	$id = $this->Session->read('Auth.id');
 	$userName = $this->Session->read('Auth.name');
 	$img_ext = $this->Session->read('Auth.img_ext');
} else {
	$loginOrOut = '<a id="loginBtn" href="http://' . env('HTTP_HOST')
 . DS . 'Studio' . DS . 'users' . DS . 'login' . '">ログイン</a>';
}



/**
* Gnavのcurrent表示
*/
$gnavCurr00 = '';
$gnavCurr01 = '';
$gnavCurr02 = '';
if (isset($pageId)) {
	switch ($pageId) {
		case 0:
			// タイムライン
			$gnavCurr00 = ' class="current"';
			break;
		case 1:
			// 勉強時間
			$gnavCurr01 = ' class="current"';
			break;
		case 2:
			// 目標
			$gnavCurr02 = ' class="current"';
			break;

		default:
			break;
	}
}


?>
<header>
	<div class="clearfix">
		<div class="left logo"><a href="<?php echo homeUrl; ?>"><?php echo $this->Html->image('logo_02.png', array('width' => '81', 'alt' => 'Studio')); ?></a></div>
		<nav id="topNav" class="center">
			<ul class="clearfix">
				<li><a<?php echo $gnavCurr00; ?> href="<?php echo homeUrl; ?>">タイムライン</a></li>
				<li><a<?php echo $gnavCurr01; ?> href="<?php echo rootUrl; ?>studylog/">勉強の記録</a></li>
				<li><a<?php echo $gnavCurr02; ?> href="<?php echo rootUrl; ?>target/">目標設定</a></li>
			</ul>
		</nav>
		<div class="right">
			<ul class="clearfix">
				<li>
					<?php echo $loginOrOut; ?>
				</li>
				<li>
					<a class="profile" href="<?php echo rootUrl . 'users/profile/'; ?>">
						<dl class="clearfix">
							<dt><img src="<?php echo rootUrl; ?>img/profile/<?php echo $id . $img_ext; ?>" alt="<?php echo $userName; ?>" width="30" /></dt>
							<dd><?php echo $userName; ?></dd>
						</dl>
					</a>
				</li>
			</ul>
		</div>
	</div>
</header>