<!DOCTYPE html>
<html>
<head>
	<?php require __DIR__ . "/../config/init.php"; ?>
	<title>Database manager</title>
</head>
<body>
	<?php 
		if(isset($_POST['login'])) {
			Validation::LogIn($_POST['username'], $_POST['password']);
		}

		if(Session::exist('user')){
			include_once __DIR__ . "/table.php";
		} else {
			include_once __DIR__ . "/login.php";
		}
	?>

</body>

<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<?php 
	if(Session::exist('user')) {
		echo '<script type="text/javascript">';
		include_once 'js/table.js';
		echo '</script>';
	}
?>
