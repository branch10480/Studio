<?php
	// このページ限定のCSS,JS
	// $this->Html->script('drawPieChart', array('inline' => false));
	// $this->Html->css('pieChart', null, array('inline' => false));
?>
<div id="page_profile" class="clearfix">
	<div class="left">
		<dl id="profileHeader" class="clearfix">
			<dt><img src="<?php echo rootUrl; ?>img/profile/<?php echo $user_id . $user_img_ext ?>" alt="<?php echo $user_name ?>" width="50px"></dt>
			<dd>
				<h1><?php echo $user_name ?></h1>
				<p><a href="#">プロフィールを編集する &raquo;</a></p>
			</dd>
		</dl>
		<dl class="detail">
			<dt>性別</dt>
			<dd><?php echo $user_sex === '0' ? '男':'女'; ?></dd>
			<dt>年齢</dt>
			<dd><?php echo $age; ?>歳</dd>
			<dt>目標</dt>
			<dd class="targets">
				<ul>
					<?php
						for ($i=0; $i<count($targets); $i++) {
							echo '<li>' . $targets[$i]['Target']['name'] . '</li>';
						}
					?>
				</ul>
			</dd>
			<dt>自己紹介</dt>
			<dd><?php echo $user_introduction; ?></dd>
		</dl>
	</div>
	<div class="right">
		<section>
			<h2>勉強量の推移</h2>
			<script src="http://ccchart.com/js/ccchart.js" charset="utf-8"></script>
			<canvas width="1068" id="hoge" style="width: 534px"></canvas>
		</section>
		<!-- カレンダー -->
		<section class="cal">
			<div class="clearfix">
				<div><a id="prevMonth" href="#">←</a></div>
				<h1 id="prevMonth" class="calHeader">2013年 12月</h1>
				<div><a id="nextMonth" href="#">→</a></div>
			</div>
			<ul id="studyCal" class="clearfix">
				<li class="sun">sun</li>
				<li class="mon">mon</li>
				<li class="tue">tue</li>
				<li class="wed">wed</li>
				<li class="thu">thu</li>
				<li class="fri">fri</li>
				<li class="sat">sat</li>
				<li class="mon">&nbsp;</li>
				<li class="tue">&nbsp;</li>
				<li class="wed">&nbsp;</li>
				<li class="thu"><a href="#">1</a></li>
				<li class="fri"><a href="#">2</a></li>
				<li class="sat"><a href="#">3</a></li>
				<li class="sun"><a href="#">4</a></li>
				<li class="mon"><a href="#">5</a></li>
				<li class="tue"><a href="#">6</a></li>
				<li class="wed"><a href="#">7</a></li>
				<li class="thu"><a href="#">8</a></li>
				<li class="fri"><a href="#">9</a></li>
				<li class="sat"><a href="#">10</a></li>
				<li class="sun"><a href="#">11</a></li>
				<li class="mon"><a href="#">12</a></li>
				<li class="tue"><a href="#">13</a></li>
				<li class="wed"><a href="#">14</a></li>
				<li class="thu"><a href="#">15</a></li>
				<li class="fri"><a href="#">16</a></li>
				<li class="sat"><a href="#">17</a></li>
				<li class="sun"><a href="#">18</a></li>
				<li class="mon"><a href="#">19</a></li>
				<li class="tue"><a href="#">20</a></li>
				<li class="wed"><a href="#">21</a></li>
				<li class="thu"><a href="#">22</a></li>
				<li class="fri"><a href="#">23</a></li>
				<li class="sat current"><a href="#">24</a></li>
				<li class="sun"><a href="#">25</a></li>
				<li class="mon"><a href="#">26</a></li>
				<li class="tue"><a href="#">27</a></li>
				<li class="wed"><a href="#">28</a></li>
				<li class="thu"><a href="#">29</a></li>
				<li class="fri"><a href="#">30</a></li>
				<li class="sat"><a href="#">31</a></li>
			</ul>
		</section>
		<!-- 勉強記録詳細 -->
		<section class="reflection">
			<h2><span><em>11</em>月<em>19</em>日 の勉強記録</span></h2>
			<hr />
			<div class="clearfix">
				<section>
					<h3>感想・反省</h3>
					<p>今日は途中で居眠りしてしまった。<br />しかし起床後は効率よく学習を進めることができたので、これからは休憩を適度に入れて行こうと思う。</p>
					<ul class="clearfix">
						<li>
							<section>
								<p>10.0h</p>
								<h4>応用情報技術者試験</h4>
							</section>
						</li>
						<li>
							<section>
								<p>10.0h</p>
								<h4>応用情報技術者試験</h4>
							</section>
						</li>
						<li>
							<section>
								<p>10.0h</p>
								<h4>応用情報技術者試験</h4>
							</section>
						</li>
					</ul>
				</section>
				<section class="todo">
					<h3>ToDoリスト</h3>
					<dl>
						<dt>応用情報技術者試験</dt>
						<dd>
							<ul>
								<li class="checked">応用情報技術者の参考書を20ページ終わらせる</li>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
							</ul>
						</dd>
						<dt>応用情報技術者試験</dt>
						<dd>
							<ul>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
								<li>応用情報技術者の参考書を20ページ終わらせる</li>
							</ul>
						</dd>
					</dl>
				</section>
			</div>
		</section>
	</div>
</div>