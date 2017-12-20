<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$groupID = $_POST['groupID'];
	$deviceID = $_POST['deviceID'];

	$response = $intel->getDevice($groupID, $deviceID);

	echo json_encode($response);

?>
