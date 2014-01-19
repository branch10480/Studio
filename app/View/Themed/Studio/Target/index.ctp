<?php
	// このページ限定のCSS,JS
	// $this->Html->script('drawPieChart', array('inline' => false));
	// $this->Html->css('pieChart', null, array('inline' => false));
?>
<script type="text/javascript" src="<?php echo rootUrl . 'js/newTarget/'; ?>"></script>
<article id="home_top" class="clearfix">
	<div id="tSearchArea">
		<form action="#" method="post" id="targetForm">
			<input type="text" id="txtTsearch">
			<input type="submit" id="submitFsearch" value="">
		</form>
		<ul id="searchResult">
			<!-- <li>
				<p>資格</p>
				<a href="#">クリックして登録完了！</a>
			</li>
			<li>
				<p>資格</p>
				<a href="#">クリックして登録完了！</a>
			</li> -->
			<li class="default">
				こちらに検索候補が出てきます
			</li>
		</ul>
	</div>
	<div id="myTargetArea">
		<h1>あなたの目指す資格</h1>
		<ul>
			<li>
				<p>応用情報技術者試験</p>
				<a href="#">&times;</a>
			</li>
			<li>
				<p>愛知県立一宮高等学校</p>
				<a href="#">&times;</a>
			</li>
			<li>
				<p>基本情報技術者試験</p>
				<a href="#">&times;</a>
			</li>
		</ul>
		<aside>
			<h2>資格が見つかりませんか？</h2>
			<p>お探しの資格が見つからない場合は我々にお知らせください。<br />迅速に対応致します。</p>
			<a href="<?php echo rootUrl . 'demand/'; ?>">資格の追加申請はコチラ</a>
		</aside>
	</div>
</article>

