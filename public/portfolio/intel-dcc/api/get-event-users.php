<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$eventID = $_POST['eventID'];
	$response = $intel->getEventUsers($eventID);

	echo json_encode($response);

?>
