<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$eventID = $_POST['eventID'];
  $eventName = addslashes($_POST['eventName']);
	$eventComment = addslashes($_POST['eventComment']);
  $eventType = $_POST['eventType'];

	$response = $intel->setEventSetting($eventID, $eventName, $eventComment, $eventType);

	echo json_encode($response);

?>
