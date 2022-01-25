<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(isset($_POST['login']))
	{
		$user_id = $_POST['id'];
		$user_pass = $_POST['password'];
		$sql1 = "SELECT * FROM staff WHERE STAFF_ID = '$user_id' AND STAFF_PASS = '$user_pass'";
		$result1 = mysqli_query($conn, $sql1);
		$sql2 = "SELECT * FROM admin WHERE ADMIN_ID = '$user_id' AND ADMIN_PASS = '$user_pass'";
		$result2 = mysqli_query($conn, $sql2);

		if(mysqli_num_rows($result1) > 0)
		{
			foreach($result1 as $row1)
			{
				$first_name = $row1['FIRST_NAME'];
				$last_name = $row1['LAST_NAME'];
				$user_type = $row1['STAFF_TYPE'];
				$user_dept = $row1['STAFF_DEPT'];
				$db_pass = $row1['STAFF_PASS'];
			}

			if((!(strcmp($db_pass, $user_pass))) && $user_type == "Staff")
			{
				session_start();
				$_SESSION['sid'] = session_id();
				$_SESSION['user_id'] = $user_id;
				$_SESSION['user_firstName'] = $first_name;
				$_SESSION['user_lastName'] = $last_name;
				$_SESSION['user_type'] = $user_type;
				$_SESSION['user_dept'] = $user_dept;
				$_SESSION['user_password'] = $db_password;

				header("Location: staff_homepage.php");
			}
			else
			{
				echo "<script>
						 alert(\"Incorrect ID or Password !\"); window.location=\"login.php\";
				      </script>";
			}
		}
		elseif(mysqli_num_rows($result2) > 0)
		{
			foreach($result2 as $row2)
			{
				$first_name = $row2['FIRST_NAME'];
				$last_name = $row2['LAST_NAME'];
				$user_type = $row2['ADMIN_TYPE'];
				$user_dept = $row2['ADMIN_DEPT'];
				$db_pass = $row2['ADMIN_PASS'];
			}

			if((!(strcmp($db_pass, $user_pass))) && $user_type == "Admin")
			{
				session_start();
				$_SESSION['sid'] = session_id();
				$_SESSION['user_id'] = $user_id;
				$_SESSION['user_firstName'] = $first_name;
				$_SESSION['user_lastName'] = $last_name;
				$_SESSION['user_type'] = $user_type;
				$_SESSION['user_dept'] = $user_dept;
				$_SESSION['user_password'] = $db_password;

				header("Location: admin_homepage.php");
			}
			else
			{
				echo "<script>
					 	alert(\"Incorrect ID or Password !\"); window.location=\"login.php\";
				      </script>";
			}
		}
		else
		{
			echo "<script>
					alert(\"Incorrect ID or Password !\"); window.location=\"login.php\";
				  </script>";
		}
	}
?>

<html>
<head>
	<script> window.history.forward(); </script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Leave Management</title>
<style>
body{
	margin: 0;
	padding: 0;
    background: url(coffee.jpg);
    background-size: cover;
    background-position: center;
    font-family: sans-serif;
}

.avatar{
    width: 100px;
    height: 100px;
    border-radius: 50%;
    position: absolute;
    top: -50px;
    left: calc(50% - 50px);
}

img.logo{
	position: absolute;
	max-width: 80%;
	top: 50px;
}
img.logo:empty{
	top: 15%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	-moz-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	-o-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
}
@media screen and (orientation: portrait) {
  img.logo { max-width: 90%; }
}

@media screen and (orientation: landscape) {
  img.logo { max-height: 90%; }
}

h1{
    margin: 0;
    padding: 0 0 20px;
    text-align: center;
    font-size: 22px;
}

.loginbox{
    width: 320px;
    height: 420px;
    background: #000;
    background-color: rgba(10,10,10,.68);
    color: #fff;
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%,-50%);
    box-sizing: border-box;
	border-radius: 20px;
    padding: 70px 30px;
	margin-top: 70px;
}
.loginbox p{
    margin: 0;
    padding: 0;
    font-weight: bold;
}
.loginbox input{
    width: 100%;
    margin-bottom: 20px;
}
.loginbox input[type="text"], input[type="password"]
{
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
}
.loginbox input[type="submit"]
{
    border: none;
    outline: none;
    height: 40px;
    background: #fb2525;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
}
.loginbox input[type="submit"]:hover
{
    cursor: pointer;
    background: #ffc107;
    color: #000;
}
.loginbox input[type="checkbox"]{
	width: 20px;
	margin-left: -2px;
}
.loginbox a{
    text-decoration: none;
    font-size: 12px;
    line-height: 20px;
    color: darkgrey;
}
.loginbox a:hover{
    color: #ffc107;
}
</style>
</head>

<body>
	<img src="logo.png" class="logo" alt="logo">
	<div class="loginbox">
    <img src="avatar.png" class="avatar" alt="avatar">
        <h1>Login</h1>
        <form method="post">
            <p>ID</p>
            <input type="text" name="id" placeholder="Enter ID" pattern=".{10}" title="Maximum 10 characters" required>
            <p>Password</p>
            <input type="password" name="password" id="myPassword" placeholder="Enter Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Minimum eight characters, at least one uppercase letter, one number and one special character" required>
			<input type="checkbox" onclick="showPassword()">Show password
            <input type="submit" name="login" value="Login">
            <a href="password.php">Lost your password?</a><br>
        </form>
    </div>
<script>
function showPassword()
{
  var x = document.getElementById("myPassword");
  if (x.type === "password")
  {
    x.type = "text";
  }
  else
  {
    x.type = "password";
  }
}
</script>
</body>
</html>
