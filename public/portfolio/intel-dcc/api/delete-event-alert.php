<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$eventID = $_POST['eventID'];
	$groupID = $_POST['groupID'];
	$deviceID = $_POST['deviceID'];
	$sensorID = $_POST['sensorID'];
	$alertLevel = $_POST['alertLevel'];

	// determine the proper alert type for this sensor...
	$alertType = ($intel->getSensorType($sensorID) === 'RAINFALL' ? 'Rainfall' : 'Threshold');

	$response = $intel->deleteEventAlert($eventID, $groupID, $deviceID, $sensorID, $alertType, $alertLevel);

	echo json_encode($response);

?>
