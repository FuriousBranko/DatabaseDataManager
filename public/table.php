<!DOCTYPE html>
<html>
<head>
	<?php 
	require __DIR__ . "/../config/init.php";
	if(!Session::exist('user')) {
		header('Location: index.php');
	} else {
		$user = Session::get('user');
	}
	?>

	<title>Database manager</title>
</head>
<div class="container" style="margin-top: 30px;">

	<!-- Modal for edit/add -->
	<div class="modal fade" id="modalReadEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">

	      		<div class="modal-header">
		        	<h3 class="modal-title" id="modalTitle"></h3>
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          		<span aria-hidden="true">&times;</span>
		       		</button>
	      		</div>

	      		<div class="modal-body" id="modal-edit">
			        <label for="countryName">Country name</label>
			        <input type="text" class="form-control" name="countryName" id="countryName" placeholder="Country name: " required><br>
			        <label for="shortDesc">Short description</label>
			        <textarea class="form-control" name="shortDesc" id="shortDesc" placeholder="Short description: " required></textarea><br>
			        <label for="longDesc">Long description</label>
			        <textarea class="form-control" name="longDesc" id="longDesc" placeholder="Long description: " required></textarea>
			        <input type="hidden" id="currentRowID" value="0">
	      		</div>

	            <div class="modal-body" id="modal-view" style="display: none">
	                <h5> Short text </h5>
	                <div id="shortDescView"></div>
	                <br><br>
	                <h5> Long text </h5>
	                <div id="longDescView"></div>
	            </div>

		      	<div class="modal-footer">
		        	<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Close">
		        	<input type="button" class="btn btn-primary" value="Insert" id="actionButton" onclick="manageData('insertRow');">
	      		</div>

	    	</div>
	 	</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2>MySQL Data Manager</h2>
			<br><br>
			<?php
				if($user == 'admin') {
					echo '<input style="float:right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#modalReadEdit" id="addNew" value="Add new">';
				}
			?>
			<table class="table table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th>Country Name</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
						
				</tbody>
			</table>
		</div>
	</div>

</div>
</body>

<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<?php require __DIR__ . '/js/table.js';