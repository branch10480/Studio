<?php
	// このページ限定のCSS,JS
	$this->Html->script(array('drawPieChart', 'jquery.glide.min'), array('inline' => false));
	$this->Html->css(array('pieChart', 'glide'), null, array('inline' => false));
?>
<script type="text/javascript" src="<?php echo rootUrl . 'js/studylog/'; ?>"></script>
<article id="studylog" class="clearfix">
	<div class="selectArea">
		<section class="cal">
			<div class="clearfix">
				<div><a id="prevMonth" href="#">←</a></div>
				<h1 id="prevMonth" class="calHeader">2013年 12月</h1>
				<div><a id="nextMonth" href="#">→</a></div>
			</div>
			<!-- カレンダー -->
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
		<section class="study_time">
			<h1>勉強時間の推移</h1>
			<div id="GraphCalMonth">11月</div>
			<script src="http://ccchart.com/js/ccchart.js" charset="utf-8"></script>
			<canvas width="1068" id="hoge" style="width: 534px"></canvas>
		</section>
	</div>
	<div class="dispArea">
		<section class="default">
			<h2>勉強記録</h2>
			<p>色がついたカレンダーをクリックするとコチラに詳細が表示されます。</p>
		</section>
		<section class="reflection">
			<h2 id="reflectionHeader">&nbsp;</h2>
			<p id="reflectionText">&nbsp; </p>
			<ul id="reflectionStudyTime" class="clearfix">
				<li>
					<p>&nbsp; </p>
					<h3>&nbsp; </h3>
				</li>
			</ul>
		</section>
		<section class="todo">
			<h2>ToDoリスト</h2>
			<dl id="miniTodo">
				<dt>&nbsp;</dt>
				<dd>
					<ul>
						<li class="checked">&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
				</dd>
			</dl>
		</section>
	</div>
</article>
