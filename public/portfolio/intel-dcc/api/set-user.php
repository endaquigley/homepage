<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$userID = $_POST['userID'];
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$role = $_POST['role'];
	$commPrefs = $_POST['commPrefs'];
	$password = $_POST['password'];

	$response = $intel->setUser($userID, $username, $firstname, $lastname, $email, $mobile, $role, $commPrefs, $password);

	echo json_encode($response);

?>
