<?php

	if(isset($_POST['key'])) {

		$conn = new mysqli('localhost', 'root', '', 'tablemanager');

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
								<th id="country_'.$data['id'].'">'.$data['countryName'].'</th>
								<th>
									<input type="button" class="btn btn-primary" value="Edit">
									<input type="button" class="btn" value="View">
									<input type="button" class="btn btn-danger" value="Delete">
								</th>
							</tr>
					';

				}
				exit($response);
			}
			exit('reachedMax');
		}

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

	}