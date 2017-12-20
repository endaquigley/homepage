<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$userID = $_POST['userID'];
	$response = $intel->deleteUser($userID);

	echo json_encode($response);

?>
