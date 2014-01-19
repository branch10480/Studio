<?php
	// このページ限定のCSS,JS
	$this->Html->script('drawPieChart', array('inline' => false));
	$this->Html->css('pieChart', null, array('inline' => false));
?>
<section>
	<?php echo $this->Form->create('Demand', array('id' => 'formContact')); ?>
	<h1>資格追加の申請</h1>
	<table>
		<tr>
			<th>資格名</th>
			<td><?php echo $this->Form->text('Demand.qname', array('id' => 'qname', 'type' => 'text', 'value' => $qname)); ?></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" value="確認画面へ" /></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
</section>