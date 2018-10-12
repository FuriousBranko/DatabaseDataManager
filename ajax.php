<?php
	require('Database.class.php');

	if(isset($_POST['key'])) {

		$db = Database::connect();

		// this key create table
		if($_POST['key'] == 'getExistingData') {

			exit($db->getExistingData($_POST['start'], $_POST['limit']));

		}
		// this key is used on insert button for creating new record
		if($_POST['key'] == 'insertRow') {

			$data = [
				'countryName' => $_POST['countryName'],
				'shortDesc' => $_POST['shortDesc'],
				'longDesc' => $_POST['longDesc'],
				'rowID' => $_POST['rowID']
			];

			exit($db->insertRow($data));
		}

		if($_POST['key'] == 'editRow') {

			$data = [
				'countryName' => $_POST['countryName'],
				'shortDesc' => $_POST['shortDesc'],
				'longDesc' => $_POST['longDesc'],
				'rowID' => $_POST['rowID']
			];

			exit($db->editRow($data));
		}
		// 
		if($_POST['key'] == 'readRow') {
			exit($db->readRow($_POST['rowID']));
		}

		if($_POST['key'] == 'deleteRow') {
			exit($db->deleteRow($_POST['rowID']));
		}

	}