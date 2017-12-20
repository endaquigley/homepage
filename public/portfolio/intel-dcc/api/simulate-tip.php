<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

  $deviceID = $_GET['deviceID'];
  $sensorID = $_GET['sensorID'];

	$value = '0.2';
	$timestamp = time() * 1000;

	$response = $intel->simulateTip($deviceID, $sensorID, $timestamp, $value);

	echo json_encode($response);

?>
