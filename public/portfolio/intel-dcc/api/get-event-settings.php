<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = new stdClass();

	$eventID = $_POST['eventID'];
	$events = $intel->getEventSettings();

	foreach ($events as $event) {
		if ($event->id === $eventID) {
			$response = $event;
		}
	}

	if (empty($response) === false) {

		$response->alerts = $intel->getEventAlerts($eventID);

		foreach ($response->alerts as $alert) {

			$device = $intel->getDevice($alert->groupId, $alert->deviceId);
			$alert->displayName = $device[0]->displayName;

		}

		$response->users = $intel->getEventUsers($eventID);

	}

	echo json_encode($response);

?>
