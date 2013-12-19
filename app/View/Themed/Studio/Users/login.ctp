<?php

$data = array(
		'result' => $result,
		'msg' => $msg,
		'mail' => $mail
	);
$json_value = json_encode($data);


header( 'Content-Type: text/javascript; charset=utf-8' );
echo $json_value;

?>