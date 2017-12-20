<?php

class intel{

	private $request_url = 'http://dp.5204p.infra-host.com/';
	private $ext_url01 = 'api/config/v1/';
	private $ext_url02 = 'api/v1/';
	private $ext_url03 = 'api/admin/v1/';
	private $user = 'ZooAdmin';
	private $pass = 'pa55w03d';
	private $ch;
	private $response;

	private $validSensorIDs = array(
		'SENS_FLOWWORKS_RAINFALL',
		'SENS_RAIN_RG',
		'SENS_WATER_LEVEL_KINGSPAN'
	);

	function __construct(){

	}

	function getValidSensors($sensorList) {

		$validSensors = array();

		$sensorListArray = array_map('trim', explode(',', $sensorList));

		foreach ($sensorListArray as $sensorID) {
			if (in_array($sensorID, $this->validSensorIDs)) {
				$validSensors[] = $sensorID;
			}
		}

		// keep the white space bewtween sensor IDs...
		return implode(', ', $validSensors);

	}

	function getSensorType($sensorID) {

    $sensorType = 'UNKNOWN';

    if ($sensorID === 'SENS_FLOWWORKS_RAINFALL' || $sensorID === 'SENS_RAIN_RG') {
      $sensorType = 'RAINFALL';
    } else if ($sensorID === 'SENS_WATER_LEVEL_KINGSPAN') {
      $sensorType = 'RIVER_LEVEL';
    }

    return $sensorType;

  }

	function startCURL($url, $exturl, $query_string = false){
		if ($exturl == 1){
			$callURL = $this->request_url.$this->ext_url01.$url.'/';
		}
		if ($exturl == 2) {
			$callURL = $this->request_url.$this->ext_url02.$url.'/';
		}
		if ($exturl == 3) {
			$callURL = $this->request_url.$this->ext_url03.$url.'/';
		}
		if ($query_string){
			$callURL = $callURL.'?'.$query_string;
		}
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		$res = $this->getResponse($this->ch);
		return $res;
	}

	function getResponse() {

		$this->response = json_decode(curl_exec($this->ch));
		curl_close($this->ch);

		return $this->response;

	}

	function getOwner(){
		$ret = $this->startCURL('ownuser', 1);
		return $ret;
	}

	function getGroups(){
		$ret = $this->startCURL('groups', 1);
		return $ret;
	}

	function getDevices($group_id){
		$ret = $this->startCURL('devices/'.$group_id, 2);
		foreach ($ret as $device) {
			// determine the preferred display name for each device...
			$device->displayName = ($device->deviceName === '' ? $device->deviceNameOrig : $device->deviceName);
		}
		return $ret;
	}

	function getDevice($group_id, $device_id){
		$ret = $this->startCURL('devices/'.$group_id.'/'.$device_id, 2);
		foreach ($ret as $device) {
			// determine the preferred display name for each device...
			$device->displayName = ($device->deviceName === '' ? $device->deviceNameOrig : $device->deviceName);
		}
		return $ret;
	}

	function getSensorData($group_id, $device_id, $sensor_id, $start = false, $end = false, $downsample = false){
		if(!$start && !$end && !$downsample){
			$ret = $this->startCURL('sensordata/'.$group_id.'/'.$device_id.'/'.$sensor_id, 2);
		}
		else{
			if($start && !$end && !$downsample){	//?start=2015/10/08-14:00:00
				$query_string = 'start='.$start;
			}
			if($start && $end && !$downsample){		//?start=2015/10/08-14:00:00&end=2015/10/25-21:00:00'
				$query_string = 'start='.$start.'&end='.$end;
			}
			if($start && $end && $downsample){	//?start=2015/10/08-14:00:00&end=2015/10/25-21:00:00&downsample=60000s
				$query_string = 'start='.$start.'&end='.$end.'&downsample='.$downsample;
			}
			$ret = $this->startCURL('sensordata/'.$group_id.'/'.$device_id.'/'.$sensor_id, 2, $query_string);
		}
		return $ret;
	}

	function getAlerts($groupID, $deviceID) {
		$ret = $this->startCURL('alerts/'.$groupID.'/'.$deviceID, 2);
		return $ret;
	}

	function getAlertSettings($groupID, $deviceID) {
		$ret = $this->startCURL('alertsettings/'.$groupID.'/'.$deviceID, 1);
		return $ret;
	}

	function setAlertSettings($groupID, $deviceID, $sensorID, $alertType, $comment, $value1, $duration1, $value2, $duration2, $value3, $duration3, $value4, $duration4) {

		$url = 'alertsettings/'. $groupID;
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$fields = array(
			'groupId' => $groupID,
			'deviceId' => $deviceID,
			'sensorId' => $sensorID,
			'alertType' => $alertType,
			'comment' => $comment,
			'value1' => $value1,
			'duration1' => $duration1,
			'value2' => $value2,
			'duration2' => $duration2,
			'value3' => $value3,
			'duration3' => $duration3,
			'value4' => $value4,
			'duration4' => $duration4,
		);

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		curl_setopt($this->ch, CURLOPT_POST, count($fields));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function simulateTip($deviceID, $sensorID, $timestamp, $value) {

		$url = 'fwUpload?timeStamp='. $timestamp .'&sensor='. $sensorID .'&value='. $value .'&deviceId='. $deviceID;
		$callURL = $this->request_url . $this->ext_url01 . $url;

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_URL, $callURL);

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function getActiveEvents() {

		return null;

	}

	function getEventSettings() {

		$ret = $this->startCURL('eventsettings/', 1);
		return $ret;

	}

	function setEventSetting($eventID, $eventName, $eventComment, $eventType) {

		$url = 'eventsetting';
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$fields = array(
			'eventName' => $eventName,
			'eventComment' => $eventComment,
			'eventType' => $eventType
		);

		if (empty($eventID) === false) {
			$fields['id'] = $eventID;
		}

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		curl_setopt($this->ch, CURLOPT_POST, count($fields));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function deleteEventSettings($eventID) {

		$url = 'eventsettings/'. $eventID;
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($this->ch, CURLOPT_URL, $callURL);

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function getEventAlerts($eventID) {

		$ret = $this->startCURL('eventalerts/'. $eventID, 1);
		return $ret;

	}

	function setEventAlert($eventID, $groupID, $deviceID, $sensorID, $alertType, $alertLevel) {

		$url = 'eventalerts/'. $eventID;
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$fields = array(
			'eventSettingsId' => $eventID,
			'groupId' => $groupID,
			'deviceId' => $deviceID,
			'sensorId' => $sensorID,
			'alertType' => $alertType,
			'level' => $alertLevel
		);

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		curl_setopt($this->ch, CURLOPT_POST, count($fields));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function deleteEventAlert($eventID, $groupID, $deviceID, $sensorID, $alertType, $alertLevel) {

		$url = 'eventalerts/'. $eventID . '/' . $groupID. '/' . $deviceID. '/' . $sensorID. '/' . $alertType. '/' . $alertLevel;
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($this->ch, CURLOPT_URL, $callURL);

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function getEventUsers($eventID) {

		$ret = $this->startCURL('eventusers/'. $eventID, 1);
		return $ret;

	}

	function setEventUser($eventID, $userID) {

		$url = 'eventusers/'. $eventID;
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$fields = array(
			'eventSettingsId' => $eventID,
			'userId' => $userID
		);

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		curl_setopt($this->ch, CURLOPT_POST, count($fields));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function deleteEventUser($eventID, $userID) {

		$url = 'eventusers/'. $eventID . '/' . $userID;
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($this->ch, CURLOPT_URL, $callURL);

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function getUsers() {

		$ret = $this->startCURL('allusers', 3);
		return $ret;

	}

	function setUser($userID, $username, $firstname, $lastname, $email, $mobile, $role, $commPrefs, $password) {

		$url = 'allusers/';
		$callURL = $this->request_url . $this->ext_url03 . $url . '/';

		if (empty($userID) === false) {
			$callURL .= $userID .'/';
		}

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$fields = array(
			'userName' => $username,
			'firstName' => $firstname,
			'lastName' => $lastname,
			'email' => $email,
			'mobile' => $mobile,
			'role' => $role,
			'prefs' => $commPrefs
		);

		if (empty($password) === false) {
			$fields['password'] = $password;
		} else if (empty($userID)) {
			$fields['password'] = 'password';
		}

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		curl_setopt($this->ch, CURLOPT_POST, count($fields));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function deleteUser($userID) {

		$url = 'allusers/'. $userID;
		$callURL = $this->request_url . $this->ext_url03 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->pass);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($this->ch, CURLOPT_URL, $callURL);

		$res = $this->getResponse($this->ch);

		return $res;

	}

	function authenticateUser($username = '', $password='') {

		$url = 'ownuser/';
		$callURL = $this->request_url . $this->ext_url01 . $url . '/';

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_USERPWD, $username.':'.$password);
		curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($this->ch, CURLOPT_URL, $callURL);
		$res = $this->getResponse($this->ch);

		return $res;

	}

}


?>
