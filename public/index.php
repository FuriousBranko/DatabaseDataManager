<!DOCTYPE html>
<html>
<head>
	<?php 
	require __DIR__ . "/../config/init.php";
	?>
	<title>Database manager</title>
</head>
<body>
<?php
	if(Validation::isLoggedIn()) {
		header("Location: table.php");
	} else { ?>
		<div class="container" style="margin-top: 30px;">
		 	<div class="col-md-6 offset-md-3">
				<form class="form-horizontal" role="form" method="POST" action="login.php">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" name="username" id="username" autocomplete="off" placeholder="Enter username" required autofocus>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
					</div>
					<button type="submit" name="login" class="btn btn-primary">Login</button>
			 	</form>
		  	</div>
		</div>
	<?php } ?>

</body>

<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>