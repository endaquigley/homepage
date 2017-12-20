<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$response = $intel->getEventSettings();

	echo json_encode($response);

?>
