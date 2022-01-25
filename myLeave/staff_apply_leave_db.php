<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}

	$staff_id = $_SESSION['user_id'];
	$staff_firstName = $_SESSION['user_firstName'];
	$staff_lastName = $_SESSION['user_lastName'];
	$leave_type = $_POST['leave_type'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$total_days = $_POST['days_requested'];
	$status = "Pending";
			
	$sql1 = "SELECT * FROM leave_statistics WHERE STAFF_ID = '$staff_id' AND LEAVE_TYPE = '$leave_type'";
	$result1 = mysqli_query($conn, $sql1) or die (mysqli_error());

	foreach($result1 as $row1)
	{
		$maximum_leave = $row1['MAX_LEAVE'];
		$leave_taken = $row1['LEAVE_TAKEN'];
	}

	$total = $leave_taken + $total_days;
	$leave_balance = $maximum_leave - $leave_taken;

	if($total_days > $maximum_leave)
	{
		echo "<script>
				alert('Total Days Requested Exceed Maximum Leaves !\nOnly " . $maximum_leave . " Days Allowed For " . $leave_type . " !'); 
				window.location=\"staff_apply_leave.php\";
			  </script>";
	}
	if($total > $maximum_leave)
	{
		echo "<script>
				alert('" . $leave_taken . " Leaves Have Been Taken For " . $leave_type . " ! \nNow Only " . $leave_balance . " Days Available !'); 
				window.location=\"staff_apply_leave.php\";
			  </script>";
	}
	else
	{
		$sql5 = "SELECT START_DATE, END_DATE FROM leave_requests WHERE '$start_date' BETWEEN START_DATE AND END_DATE AND STAFF_ID = '$staff_id'";
		$result5 = mysqli_query($conn, $sql5) or die(mysqli_error());
			
		$sql6 = "SELECT START_DATE, END_DATE FROM leave_requests WHERE '$end_date' BETWEEN START_DATE AND END_DATE AND STAFF_ID = '$staff_id'";
		$result6 = mysqli_query($conn, $sql6) or die(mysqli_error());
		
		if(mysqli_num_rows($result5) == 0 && mysqli_num_rows($result6) == 0)
		{
				
			$sql7 = "INSERT INTO leave_requests VALUES ('$staff_id', '$leave_type', '$start_date', '$end_date', '$total_days', '".date("Y-m-d")."', '$status')";
			mysqli_query($conn, $sql7) or die (mysqli_error());
				
			echo "<script>
					alert(\"Leave Application Submitted !\"); 
					window.location=\"staff_apply_leave.php\";
				  </script>";
		}
		else
		{
			echo "<script>
					alert(\"Leave For These Days Has Been Taken !\");
					window.location=\"staff_apply_leave.php\";
				  </script>";
		}
	}
?>