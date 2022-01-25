<?php
	$databaseHost = 'localhost';
	$databaseName = 'MyLeaveDB';
	$databaseUsername = 'root';
	$databasePassword =	'';

	$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die ("Connection Failed !");
?>