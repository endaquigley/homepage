<?php

	header('Content-Type: application/json');
	require(dirname( __FILE__ ) . '/intel.php');

	$intel = new intel();

	$groupID = $_POST['groupID'];
  $deviceID = $_POST['deviceID'];
  $sensorID = $_POST['sensorID'];
	$period = $_POST['period'];
	$interval = $_POST['interval'];
	$fromTimestamp = $_POST['fromTimestamp'];
	$toTimestamp = $_POST['toTimestamp'];

	$sensorData = array(
		'unit' => '',
		'data' => array(),
		'description' => '',
		'sensorID' => $sensorID
	);

	$periods = array(
		'3h' => array(
			'title' => 'last 3 hours',
			'minutes' => 180
		),
		'24h'=> array(
			'title' => 'today',
			'minutes' => 1440
		),
		'48h' => array(
			'title' => 'last 48 hours',
			'minutes' => 2880
		),
		'7d' => array(
			'title' => 'last 7 days',
			'minutes' => 10080
		),
		'custom' => array(
			'title' => 'custom period',
			'minutes' => 0
		)
	);

	$intervals = array(
		'raw' => array(
			'title' => 'Raw',
			'minutes' => 2,
			'downsample' => false
		),
		'5m' => array(
			'title' => '5 min',
			'minutes' => 5,
			'downsample' => '300s'
		),
		'15m' => array(
			'title' => '15 min',
			'minutes' => 15,
			'downsample' => '900s'
		),
		'24h' => array(
			'title' => 'Hourly total',
			'minutes' => 60,
			'downsample' => '3600s'
		)
	);

	$dateTimeNow = getDateTime(0)->format('Y/m/d-H:i:s');
	$dateTimePast = getDateTime($periods[$period]['minutes'])->format('Y/m/d-H:i:s');

	if ($period === 'custom') {

		$fromTimestamp = intval($fromTimestamp);
		$toTimestamp = intval($toTimestamp);

		$date = new DateTime('now', new DateTimeZone('Europe/Dublin'));

		$date->setTimestamp($fromTimestamp);
		$dateTimePast = $date->format('Y/m/d-00:00:00');

		$date->setTimestamp($toTimestamp);
		$dateTimeNow = $date->format('Y/m/d-23:59:59');

		// calculate total number of minutes between the custom dates...
		$periods[$period]['minutes'] = minutesBetweenTimestamps($fromTimestamp, $toTimestamp);

	}

	$minutes = $intervals[$interval]['minutes'];
	$repeat = $periods[$period]['minutes'] / $minutes;
	$aggregate = ($interval === 'raw' ? false : true);

  if ($intel->getSensorType($sensorID) === 'RAINFALL') {

		$downsample = $intervals[$interval]['downsample'];

    $filterData = $intel->getSensorData($groupID, $deviceID, $sensorID, $dateTimePast, $dateTimeNow, $downsample);
		$sensorData['data'] = missingSensorData($period, $interval, $toTimestamp, $minutes, $repeat, $filterData, $aggregate);
		$sensorData['description'] = $intervals[$interval]['title'] .' rainfall (mm) - '. $periods[$period]['title'];
		$sensorData['unit'] = 'mm';

  } else if ($intel->getSensorType($sensorID) === 'RIVER_LEVEL') {

		$filterData = $intel->getSensorData($groupID, $deviceID, $sensorID, $dateTimePast, $dateTimeNow);
		$sensorData['data'] = missingSensorData($period, $interval, $toTimestamp, $minutes, $repeat, $filterData, $aggregate);
		$sensorData['description'] = $intervals[$interval]['title'] .' river level (m) - '. $periods[$period]['title'];
		$sensorData['unit'] = 'm';

	}

	echo json_encode($sensorData);

	function getDateTime($subtract) {

		$date = new DateTime('now', new DateTimeZone('Europe/Dublin'));
		$date->sub(new DateInterval('PT'. $subtract .'M'));
		return $date;

	}

	function minutesBetweenTimestamps($fromTimestamp, $toTimestamp) {
		return abs(intval(($fromTimestamp - $toTimestamp) / 60));
	}

	function missingSensorData($period, $interval, $toTimestamp, $minutes, $repeat, $sensorData, $aggregate = false) {

		$return = array();
		$minutesOffset = 0;

		if ($interval === 'raw' || $interval === '24h') {
			$minutesOffset = getDateTime(0)->format('i');
		}

		if ($period === 'custom') {

			$now = new DateTime('now', new DateTimeZone('Europe/Dublin'));
			$minutesOffset = $minutesOffset + minutesBetweenTimestamps($now->getTimestamp(), $toTimestamp);

		}

		$sensorData = (empty($sensorData) || is_array($sensorData) === false ? null : $sensorData[0]);

		for ($i = 0; $i <= $repeat; $i++) {

			$sensorValue = 0;

			$currentDateTime = getDateTime(($minutes * $i) + $minutesOffset)->format('U');
			$previousDateTime = getDateTime(($minutes * $i) + $minutes + $minutesOffset)->format('U');

			if ($sensorData !== null) {
				foreach ($sensorData->dps as $key => $value) {

					if ($key >= $previousDateTime && $key < $currentDateTime ) {
						$sensorValue = ($aggregate === true ? $sensorValue + $value : $value);
					}
				}
			}

			// return the full list of values to the frontend application...
			$return[] = array('date' => $currentDateTime, 'value' => $sensorValue);

		}

		return array_reverse($return);

	}

?>
