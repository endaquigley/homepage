<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();
	$response = array();

	$owner = $intel->getOwner();
	$groups = $intel->getGroups();

	foreach ($groups as $group) {

    $tempGroup = new stdClass();

    $tempGroup->data = $group;
    $tempGroup->devices = array();

		$groupDevices = $intel->getDevices($group->groupId);

		foreach ($groupDevices as $groupDevice) {

			// returns a list of valid sensors for this device...
			$groupDevice->sensorList = $intel->getValidSensors($groupDevice->sensorList);

			if (empty($groupDevice->sensorList) === false) {

				$device = new stdClass();
				$device->data = $groupDevice;

				$tempGroup->devices[] = $device;

			}

		}

    if (empty($tempGroup->devices) === false) {
      $response[] = $tempGroup;
    }

	}

	echo json_encode($response);

?>
