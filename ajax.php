<?php
	/*
	Ajax has been used when :
		- Want to read data from table
		- Want to edit data in table
		- Want to delete data in table
	 */
	if(isset($_POST['key'])) {

		$conn = new mysqli('localhost', 'root', '', 'tablemanager');

		// this key create table
		if($_POST['key'] == 'getExistingData') {

			$start = $conn->real_escape_string($_POST['start']);
			$limit = $conn->real_escape_string($_POST['limit']);

			$sql = $conn->query("SELECT id, countryName FROM country LIMIT $start, $limit");

			if($sql->num_rows) {
				$response = "";
				while($data = $sql->fetch_assoc())
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
				exit($response);
			}
			exit('reachedMax');
		}
		// this key is used on insert button for creating new record
		if($_POST['key'] == 'insertRow') {

			$countryName = $conn->real_escape_string($_POST['countryName']);
			$shortDesc   = $conn->real_escape_string($_POST['shortDesc']);
			$longDesc    = $conn->real_escape_string($_POST['longDesc']);

			$sql = "SELECT countryName FROM country WHERE countryName = '$countryName'";
			$result = $conn->query($sql);

			if($result->num_rows) {
				exit("Country with this name already exists");
			} else {

				$sql = "INSERT INTO country (countryName, shortDesc, longDesc) VALUES ('$countryName', '$shortDesc', '$longDesc')";
			
				if($conn->query($sql)) {
					exit('success');
				} else {
					exit(false);
				}
			}
		}

		if($_POST['key'] == 'editRow') {

			$countryName = $conn->real_escape_string($_POST['countryName']);
			$shortDesc   = $conn->real_escape_string($_POST['shortDesc']);
			$longDesc    = $conn->real_escape_string($_POST['longDesc']);
			$rowID       = $conn->real_escape_string($_POST['rowID']);

			$sql = "UPDATE country SET countryName = '$countryName', longDesc = '$longDesc', shortDesc = '$shortDesc' WHERE id = '$rowID' ";
		
			if($conn->query($sql)) {
				exit('success');
			} else {
				exit(false);
			}
		}
		// 
		if($_POST['key'] == 'readRow') {

			$rowID   = $conn->real_escape_string($_POST['rowID']);

			$sql = "SELECT countryName, shortDesc, longDesc FROM country WHERE id='$rowID'";
			$result = $conn->query($sql);

			if($result->num_rows) {
				$data = $result->fetch_assoc();

				$jsonResult = [
					'rowID' => $rowID,
					'countryName' => $data['countryName'],
					'shortDesc' => $data['shortDesc'],
					'longDesc' => $data['longDesc']
				];

				exit(json_encode($jsonResult));
			}
		}

		if($_POST['key'] == 'deleteRow') {

			$rowID = $conn->real_escape_string($_POST['rowID']);

			$sql = "DELETE FROM country WHERE id = '$rowID'";

			$result = $conn->query($sql);

			if($result) {
				exit($result);
			}

		}

	}