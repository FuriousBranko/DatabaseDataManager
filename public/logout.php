<?php 
include_once __DIR__ . '/../config/init.php';

session_destroy();

header("Location: index.php");

?>