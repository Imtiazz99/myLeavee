<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}

	session_start();
	$staff_id = $_SESSION['staff_id'];
	$staff_firstName = $_POST['firstName'];
	$staff_lastName = $_POST['lastName'];
	$staff_dept = $_POST['department'];
	$staff_pass = $_POST['password'];
	$user_type = "Staff";

	$sql1 = "UPDATE staff SET FIRST_NAME = '$staff_firstName', LAST_NAME = '$staff_lastName', STAFF_DEPT = '$staff_dept', STAFF_PASS = '$staff_pass' WHERE STAFF_ID = '$staff_id'";
	mysqli_query($conn, $sql1) or die (mysqli_error());

	echo "<script>
			alert(\"Staff Updated !\");
			window.location=\"admin_update_staff.php\";
		  </script>";
?>
