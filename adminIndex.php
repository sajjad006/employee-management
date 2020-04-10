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
	<title>ADMIN | CREATIVE TECHNOTEX PVT LTD</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		table,tr{
			border: 1px solid black;
			border-collapse: collapse;
		}
		tr:nth-child(even){
			background-color: red;
		}
		.notification{
			float: left;width: 25%;padding: 20px;height: 400px;overflow: auto;border: 1px solid black;
		}
		@media screen and (max-width: 700px){
			.notification{
				box-sizing: border-box;
				width: 100%;
			}
		}
	</style>
</head>
<body>
	<?php include_once 'includes/nav.php'; ?>
	
	<img src="images/creative.png" height="100px" width="200px" style="margin-left: auto;margin-right: auto;display: block;">

	<div class="notification">
		<h1>Notifications</h1>
		<?php
			$today=date('y-m-d');
			$upto=$expiryDate = date('Y-m-d', strtotime($today. ' + 2 months'));
			
			$sql="SELECT employee_job_details.*, employee_personal_details.* FROM employee_job_details INNER JOIN employee_personal_details ON employee_job_details.E_EmpID=employee_personal_details.E_EmpID WHERE E_IDValidity<'$upto' AND E_Status='Active'";

			$result=mysqli_query($conn,$sql);
			$resultCheck=mysqli_num_rows($result);
			if ($resultCheck<=0) {
				echo "<b>No Alerts/Notifications</b>";
			}
			else{
				while ($row=mysqli_fetch_assoc($result)) {
					$name=$row['E_First_Name'].' '.$row['E_Middle_Name'].' '.$row['E_Last_Name'];
					$idExpiry=$row['E_IDValidity'];
					$imagePath=$row['E_Image'];	
					$id=$row['E_EmpID'];
					?>
					
					<table>
						<tr>
							<td><img width="100px" height="100px" style="float: left;" src="includes/<?php echo $imagePath; ?>"></td>
							<td><p style="float: left;width: 90%;"><?php echo $name." 's ID card is going to expire/has expired on " . $idExpiry . ". Please reissue it. <a href='empDetails.php?id=$id'>KNOW MORE</a> ";?></p></td>
						</tr>
					</table>
					<?php
				}
			}
		?>
	</div>
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>