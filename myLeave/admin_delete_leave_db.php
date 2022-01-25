<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}
		$leave_type = $_GET['leave_type'];
		$sql1 = "DELETE FROM leave_types WHERE LEAVE_TYPE = '$leave_type'";
		mysqli_query($conn, $sql1) or die (mysqli_error());

		$sql2 = "DELETE FROM leave_requests WHERE LEAVE_TYPE = '$leave_type'";
		mysqli_query($conn, $sql2) or die (mysqli_error());

		$sql3 = "DELETE FROM leave_statistics WHERE LEAVE_TYPE = '$leave_type'";
		mysqli_query($conn, $sql3) or die (mysqli_error());

		echo "<script>
				alert(\"Delete Leave Type: " . $leave_type . "\");
				window.location=\"admin_delete_leave.php\";
			  </script>";
?>
