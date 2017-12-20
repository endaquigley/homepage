<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$groupID = $_POST['groupID'];
	$deviceID = $_POST['deviceID'];
	$sensorID = $_POST['sensorID'];
	$alertType = $_POST['alertType'];
	$comment = $_POST['comment'];
	$value1 = $_POST['value1'];
	$duration1 = $_POST['duration1'];
	$value2 = $_POST['value2'];
	$duration2 = $_POST['duration2'];
	$value3 = $_POST['value3'];
	$duration3 = $_POST['duration3'];
	$value4 = $_POST['value4'];
	$duration4 = $_POST['duration4'];

	$response = $intel->setAlertSettings(
		$groupID,
		$deviceID,
		$sensorID,
		$alertType,
		$comment,
		$value1,
		$duration1,
		$value2,
		$duration2,
		$value3,
		$duration3,
		$value4,
		$duration4
	);

	echo json_encode($response);

?>
