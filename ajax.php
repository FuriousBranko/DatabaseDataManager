<?php
	require('Database.class.php');

	if(isset($_POST['key'])) {

		$db = Database::connect();


		if($_POST['key'] == 'getExistingData') {
			exit($db->getExistingData($_POST['start'], $_POST['limit']));
		}

		if($_POST['key'] == 'insertRow' || $_POST['key'] == 'editRow') {

			$data = [
				'countryName' => $_POST['countryName'],
				'shortDesc' => $_POST['shortDesc'],
				'longDesc' => $_POST['longDesc'],
				'rowID' => $_POST['rowID']
			];

			if($_POST['key'] == 'insertRow'){
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