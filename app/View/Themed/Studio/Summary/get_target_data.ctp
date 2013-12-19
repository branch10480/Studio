<?php
	// このページ限定のCSS,JS
	// $this->Html->script('drawPieChart', array('inline' => false));
	// $this->Html->css('pieChart', null, array('inline' => false));


// $data = array(
// 		'mailaddress' => $mailaddress,
// 		'text' => $text
// 	);
$data = $result;
$json_value = json_encode($data);


header('Content-Type: text/javascript; charset=utf-8');
echo $json_value;
?>