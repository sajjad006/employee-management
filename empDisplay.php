<?php
	session_start();
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Admin') {
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
	<title>EMPLOYEE DISPLAY | CREATIVE TECHNOTEX PVT LTD</title>
	<style type="text/css">
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
		.div{
			box-sizing: border-box;
			border: 1px solid black;
			width: 30%;
			padding: 20px;
			float: left;
			margin: 5px;
			height: 220px;
			page-break-inside: avoid;
		}
		.div:hover{
			background-color: #ca67f9;
		}
		@media screen and (max-width: 600px) {
			.div{
				display: block;float: none;width: 100%;margin: 5px 0 5px 0;
			}
		}
		@media print{
			.non-printable{
				display: none;
			}
		}
		
	</style>
	<link rel="stylesheet" type="text/css" href="includes/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php include_once 'includes/nav.php'; ?>
	
	<div class="non-printable">
		<h1 style="display: inline-block;">EMPLOYEE DETAILS</h1>
		
		<form class="example" action="searchresult.php">
		  	<input type="text" placeholder="Search.." name="search" autocomplete="off">
		  	<button type="submit"><i class="fa fa-search"></i></button>
		</form>
			
	</div>

	<?php

		$sql="SELECT employee_personal_details.*,employee_job_details.* FROM employee_personal_details INNER JOIN employee_job_details ON employee_personal_details.E_EmpID=employee_job_details.E_EmpID ORDER BY `employee_personal_details`.`E_EmpID` ASC";

		$result=mysqli_query($conn, $sql);
		$resultCheck=mysqli_num_rows($result);
		
		if ($resultCheck==0) {
			echo "<h2>Sorry currently you do not have any employees";
		}
		else{
			while ($row=mysqli_fetch_assoc($result)) {
				$employee_id=$row['E_EmpID'];
				$id = $row['UniqueID'];	
				$name=$row['E_First_Name'].' '.$row['E_Middle_Name'].' '.$row['E_Last_Name'];
				$office=$row['E_Placement'];
				$designation=$row['E_Designation'];
				$imgPath='includes/'.$row['E_Image'];
				
				$sql="SELECT * FROM userinfo WHERE Username='$employee_id'";
				$result2=mysqli_query($conn,$sql);
				$row2=mysqli_fetch_assoc($result2);
				$profileStatus=$row2['ProfileStatus'];

				if ($profileStatus=='Approved' || $profileStatus=='Updated') {?>
				<a style="text-decoration: none;color: black;" href="empDetails.php?id=<?php echo $employee_id; ?>">
					<div class="div">
						<img src="<?php echo $imgPath; ?>" width="100" height="100" style="float: right;margin-top: 20px;border: 2px solid black;">
						<p><b>Employee ID:</b><?php echo $id; ?></p>
						<p><b>Name : </b><?php echo $name; ?></p>
						<p><b>Office : </b><?php echo $office; ?></p>
						<p><b>Designation : </b><?php echo $designation; ?></p>
						<a href="empDetails.php?id=<?php echo $employee_id; ?>" class="non-printable">VIEW MORE</a>
						<?php
							if ($profileStatus=='Updated') {
								?>
								<button onclick="window.location.replace('includes/approve.php?id=<?php echo $employee_id ?>&result=approve')">APPROVE</button>
								<button onclick="window.location.replace('includes/approve.php?id=<?php echo $employee_id ?>&result=reject')">REJECT</button>
								<?php
							}
						?>
						
					</div>
				</a>
					<?php
				}
			}
		}
	?>
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>