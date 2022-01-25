<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}
	$staff_id = $_SESSION['staff_id'];
	$status = $_POST['approveReject'];
	$days_requested = $_POST['daysRequested'];
	$leave_type = $_POST['leaveType'];
	$leave_applied = $_POST['dateApplied'];
	$start_date = $_POST['startDate'];
	$end_date = $_POST['endDate'];

	$sql1 = "UPDATE leave_requests SET LEAVE_STATUS = '$status' WHERE STAFF_ID = '$staff_id' AND LEAVE_TYPE = '$leave_type' AND DATE_APPLIED = '$leave_applied' AND START_DATE = '$start_date' AND END_DATE = '$end_date'";
	mysqli_query($conn, $sql1);
	
	if($status == "Approved")
	{
		$sql2 = "SELECT * FROM leave_statistics WHERE STAFF_ID = '$staff_id' AND LEAVE_TYPE = '$leave_type' limit 1";
		$result2 = mysqli_query($conn, $sql2) or die (mysqli_error());
		
		foreach($result2 as $row2)
		{
			$max_leave = $row2['MAX_LEAVE'];
			$leave_taken = $row2['LEAVE_TAKEN'];
		}
			
		$days_requested = $days_requested + $leave_taken;
		if($days_requested < $max_leave)
		{
			$sql3 = "UPDATE leave_statistics SET LEAVE_TAKEN = '$days_requested' WHERE STAFF_ID = '$staff_id' AND LEAVE_TYPE = '$leave_type'";
			mysqli_query($conn, $sql3);
		}
		elseif($days_requested >= $max_leave)
		{
			$days_requested = $max_leave;
			$sql3 = "UPDATE leave_statistics SET LEAVE_TAKEN = '$days_requested' WHERE STAFF_ID = '$staff_id' AND LEAVE_TYPE = '$leave_type'";
			mysqli_query($conn, $sql3);
		}

	}

	echo "<script>
			alert(\"Leave ".$status.".\");
			window.location=\"admin_homepage.php\";
		  </script>";
?>