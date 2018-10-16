<?php

class Database {

	private static 	$_connection;
	private $_database,
			$_count  = 0, // number of fetched rows
			$_errors = null,
			$_result = null; // Object or array with fetched results

	private function __construct() 
	{
			return $this->_database = new mysqli('localhost', 'root', '', 'tablemanager');
	}

	public static function connect() 
	{
		if(!isset(self::$_connection)) {
			self::$_connection = new Database();
		}
		return self::$_connection;
	}

	public function getExistingData($start, $limit)
	{
		$start = $this->escape($start);
		$limit = $this->escape($limit);

		$sql = "SELECT id, countryName FROM country LIMIT $start, $limit";
		$result = $this->_database->query($sql);

		if($result->num_rows) {
			$response = "";
			while($data = $result->fetch_assoc())
			{
				$response.= '
					<tr>
						<th>'.$data['id'].'</th>
						<td id="country_'.$data['id'].'">'.$data['countryName'].'</td>
						<td>
							<input type="button" onclick="readOrEdit('.$data['id'].')" data-toggle="modal" data-target="#modalReadEdit" class="btn btn-primary" value="Edit">
							<input type="button" onclick="readOrEdit('.$data['id'].',1)" data-toggle="modal" data-target="#modalReadEdit" class="btn" value="View">
							<input type="button" onclick="deleteRow('.$data['id'].')" id="deleteRow" class="btn btn-danger" value="Delete">
						</td>
					</tr>
				';
			}
			return $response;
		}
		return 'reachedMax';
	}

	public function readRow($rowID)
	{
		$rowID   = $this->escape($rowID);

		$sql = "SELECT countryName, shortDesc, longDesc FROM country WHERE id='$rowID'";
		$result = $this->_database->query($sql);

		if($result->num_rows) {
			$data = $result->fetch_assoc();

			$jsonResult = [
				'rowID' => $rowID,
				'countryName' => $data['countryName'],
				'shortDesc' => $data['shortDesc'],
				'longDesc' => $data['longDesc']
			];

			return json_encode($jsonResult);
		}	
	}

	public function insertRow($data)
	{
		foreach ($data as $key => $value) {
			$$key = $this->escape($value);
		}

		$sql = "SELECT countryName FROM country WHERE countryName = '$countryName'";
		$result = $this->_database->query($sql);

		if($result->num_rows) {
			exit("Country with this name already exists");
		} else {

			$sql = "INSERT INTO country (countryName, shortDesc, longDesc) VALUES ('$countryName', '$shortDesc', '$longDesc')";
			
			if($this->_database->query($sql)) {
				return 'success';
			} else {
				return false;
			}
		}
	}

	public function editRow($data)
	{
		foreach ($data as $key => $value) {
			$$key = $this->escape($value);
		}

		$sql = "UPDATE country 
				SET countryName = '$countryName', shortDesc = '$shortDesc', longDesc = '$longDesc'
				WHERE id = '$rowID'";
			
		if($this->_database->query($sql)) {
			return 'success';
		} else {
			return print_r($this);
		}
	}

	public function deleteRow($rowID)
	{
		$rowID = $this->escape($rowID);

		$sql = "DELETE FROM country WHERE id = '$rowID'";

		if($this->_database->query($sql)) {
			return 'success';
		} else {
			return print_r($this);
		}
	}	

	protected function escape($string)
	{
		return $this->_database->real_escape_string($string);
	}
}


