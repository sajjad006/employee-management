<?php
	session_start();
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype'])) {
		header('Location:index.php');
		exit();
	}
	else{
		include_once 'includes/nav.php';
		include_once 'includes/dbConn.php';
		include_once 'includes/sms.php';

		$username=$_SESSION['uname'];
		$sql="SELECT * FROM userinfo WHERE Username='$username'";
		$result2=mysqli_query($conn,$sql);
		$row2=mysqli_fetch_assoc($result2);
		$profileStatus=$row2['ProfileStatus'];
		if ($profileStatus=='Pending') {
			echo "<h1>You cannot change your password without updating your profile.<h1>";
			exit();
		}

		$id=htmlspecialchars($_SESSION['uname']);
		$sql="SELECT * FROM employee_contact_details WHERE E_EmpID='$id'";
		if($result=mysqli_query($conn,$sql)){
			$row=mysqli_fetch_assoc($result);
			$mobile=$row['E_Contact_Number'];
		}
	}	
	if (isset($_SESSION['error'])) {
		$error=$_SESSION['error'];
		if ($error=='empty') {
			?><script type="text/javascript">alert('Please fill in all the fields.');</script><?php
		}
		elseif ($error=='password') {
			?><script type="text/javascript">alert('The passwords do not match. Please check.');</script><?php
		}
		elseif ($error=='expired') {
			?><script type="text/javascript">alert('Your request OTP has expired');</script><?php
		}
		elseif ($error=='otp') {
			?><script type="text/javascript">alert('Invalid OTP');</script><?php
		}
		elseif ($error=='db') {
			?><script type="text/javascript">alert('Unable to connect to database');</script><?php
		}
		elseif ($error=='length') {
			?><script type="text/javascript">alert('Password should be atleast six characters long.');</script><?php
		}

		$_SESSION['error']="";
	}?>

	<script type="text/javascript">
	<?php
		if (isset($_GET['change'])) {
			$change=$_GET['change'];
			if ($change=='success') {
				?>
				if (confirm("Successfully changed your password")) {
					window.location.replace('index.php');
				}
				else{
					window.location.replace('index.php');	
				}
				<?php
			}
		}
		if (isset($_GET['otp'])) {
			$change=$_GET['otp'];
			if ($change=='success') {
				?>
				if (confirm("Successfully sent your otp")) {
					window.location.replace('changePassword.php');
				}
				else{
					if (confirm("Sorry could not send your otp")) {
						window.location.replace('changePassword.php');	
					}
				}
				<?php
			}
		}
	?>	
	</script>

<!DOCTYPE html>
<html>
<head>
	<title>CHANGE PASSWORD | CREATIVE TECHNOTEX PVT LTD</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		label{
			display: block;
			width: 300px;
		}
		input, select{
			width: 250px;
			padding: 5px;
			margin: 5px;
			border-radius: 25cm;
			margin-bottom: 20px;
		}
	</style>
</head>
<body>
	<center>
		<h1>RESET PASSWORD</h1>
		<button onclick="window.location.replace('includes/sms.php?id=<?php echo $id ?>&mobile=<?php echo $mobile ?>')">SEND OTP</button><br>
		<form method="POST" action="includes/changePassword_process.php">  
			<input autocomplete="off" type="text" name="otp" placeholder="ENTER OTP"><br>
			<input autocomplete="off" type="password" name="password" placeholder="NEW PASSWORD"><br>
			<input autocomplete="off" type="password" name="password_repeat" placeholder="REPEAT NEW PASSWORD"><br>
			<input autocomplete="off" type="submit" name="submit" value="CHANGE PASSWORD">
		</form>
		
	</center>	
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>