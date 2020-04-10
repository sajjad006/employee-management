<?php
	session_start();
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Employee') {
		header('Location:index.php');
		exit();
	}
	else{
		include_once 'includes/dbConn.php';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EMPLOYEE | CREATIVE TECHNOTEX PVT LTD</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style type="text/css">
		.user{
			border: 1px solid black;
			width: 300px;
			height: 100px;
			text-decoration: none;color: black;
			font-size: 1.2em;
			border-radius: 10px;
		}
		.a{
			text-decoration: none;display: inline-block;
		}
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
	</style>
</head>
<body>
	<?php include_once 'includes/nav.php'; ?>
	<br>
	<a href="empDetails.php?id=<?php echo $_SESSION['uname'] ?>" class="a">
	<div class="user" style="background-color: #7bc4fc;">
		<i class="fas fa-arrow-right fa-2x" style="float: right;margin-top: 40px;"></i>
		<i class="fas fa-user fa-4x" style="float: right;margin: 20px;"></i>
		<p style="margin-left: 20px;">My profile</p>
	</div>
	</a>



	<?php include_once 'includes/footer.php'; ?>
</body>
</html>