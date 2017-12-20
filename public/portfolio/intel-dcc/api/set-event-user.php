<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$eventID = $_POST['eventID'];
	$userID = $_POST['userID'];

	$response = $intel->setEventUser($eventID, $userID);

	echo json_encode($response);

?>
