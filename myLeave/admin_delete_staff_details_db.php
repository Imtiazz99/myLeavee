<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}
	$staff_id = $_SESSION['staff_id'];
	$sql1 = "DELETE FROM staff WHERE STAFF_ID = '$staff_id'";
	mysqli_query($conn, $sql1) or die (mysqli_error());

	$sql2 = "DELETE FROM leave_requests WHERE STAFF_ID = '$staff_id'";
	mysqli_query($conn, $sql2) or die (mysqli_error());

	$sql3 = "DELETE FROM leave_statistics WHERE STAFF_ID = '$staff_id'";
	mysqli_query($conn, $sql3) or die (mysqli_error());

	echo "<script>
			alert(\"Staff Deleted !\");
			window.location=\"admin_delete_staff.php\";
		  </script>";
?> 