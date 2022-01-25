<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}
	$leave_type = $_POST['leave_type'];
	$no_of_days = $_POST['noofdays'];

	$sql1 = "UPDATE leave_types SET NO_OF_DAYS = '$no_of_days' WHERE LEAVE_TYPE = '$leave_type'";
	mysqli_query($conn, $sql1) or die (mysqli_error());

	echo "<script>
			alert(\"Leave Updated !\");
			window.location=\"admin_delete_leave.php\";
		  </script>";
?>
