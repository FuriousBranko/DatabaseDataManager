<?php
	require_once __DIR__ . '/Database.class.php';
	require_once __DIR__ . '/Session.class.php';
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if(isset($_POST['key'])) {

		$db = Database::connect();

		if($_POST['key'] == 'getExistingData') {
			$user = Session::get('user');
			exit($db->getExistingData($_POST['start'], $_POST['limit'], $user));
		}

		if($_POST['key'] == 'insertRow' || $_POST['key'] == 'editRow') {

			$data = [
				'countryName' => $_POST['countryName'],
				'shortDesc' => $_POST['shortDesc'],
				'longDesc' => $_POST['longDesc'],
				'rowID' => $_POST['rowID']
			];

			if($_POST['key'] == 'insertRow') {
				exit($db->insertRow($data));
			} else {
				exit($db->editRow($data));
			}
		}

		if($_POST['key'] == 'readRow') {
			exit($db->readRow($_POST['rowID']));
		}

		if($_POST['key'] == 'deleteRow') {
			exit($db->deleteRow($_POST['rowID']));
		}

	}