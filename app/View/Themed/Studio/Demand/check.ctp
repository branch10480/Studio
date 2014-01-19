<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section>
	<h1>資格追加の申請</h1>
	<table>
		<tr>
			<th>資格名</th>
			<td><?php echo $qname; ?></td>
		</tr>
	</table>
	<div class="btnArea">
		<a href="<?php echo controllerURL; ?>">戻る</a>
		<a href="<?php echo controllerURL . 'comp/'; ?>">申請を完了する</a>
	</div>
</section>