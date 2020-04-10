<?php
	session_start();
	
	if (empty($_POST['id']) && empty($_GET['id'])) {
		header('Location:adminIndex.php');
		exit();
	}
	
	function generateID($id)
	{
		include 'includes/dbConn.php';
		$sql="SELECT employee_personal_details.*,employee_job_details.*,employee_contact_details.*, employee_address_details.* FROM employee_personal_details INNER JOIN employee_job_details ON employee_personal_details.E_EmpID=employee_job_details.E_EmpID INNER JOIN employee_contact_details ON employee_personal_details.E_EmpID=employee_contact_details.E_EmpID INNER JOIN employee_address_details ON employee_personal_details.E_EmpID=employee_address_details.E_EmpID WHERE employee_personal_details.E_EmpID='$id'";

		$result=mysqli_query($conn, $sql);
		$resultCheck=mysqli_num_rows($result);
		
		if ($resultCheck<=0) {
			echo "Sorry this employee does not exists";
			exit();
		}
		else{
			while ($row=mysqli_fetch_assoc($result)) {
				$id=$row['E_EmpID'];
				$emp=$row['UniqueID'];
				$address=$row['E_ALine1']." ".$row['E_ALine2']." ".$row['E_City']." ".$row['E_PS']." ".$row['E_Pincode']." ".$row['E_State'];
				$contact=$row['E_Contact_Number'];
				$emergencyMobileHome=$row['E_Emergency_HomeMobile'];
				$emergencyMobileOffice=$row['E_Emergency_OfficeMobile'];
				$imgPath=$row['E_Image'];
				$office=$row['E_Placement'];
				$gender=$row['E_Gender'];
				$blood=$row['E_BloodGroup'];
				$expiryDate=$row['E_IDValidity'];
				$expiryDate=date_format(date_create($expiryDate),'d-m-Y');

				$name=$row['E_First_Name'].'  '.$row['E_Middle_Name'].'  '.$row['E_Last_Name'];
				$name=strtoupper($name);
				
				$sql2="SELECT * FROM offices WHERE Name='$office'";
				if($result2=mysqli_query($conn,$sql2)){
					$row2=mysqli_fetch_assoc($result2);
					$officeAddress=$row2['Address'];
					$officePhone=$row2['Phone'];
					$officeEmail=$row2['Email'];
				} 
			}
			?>
				<div class="page">
				<div class="page2" style="background-image: url(images/idFront.jpeg) !important">
					<?php
					if ($office=='LPG SBU') {
						?>
						<img src="images/cr.png" height="46px" width="90px" style="margin-left: 10px;">
						<img src="images/in.png" height="46px" width="90px" style="margin-left: 10px;">
						<?php
					}
					else{
						?>
						<img src="images/cr.png" class="center" height="50px" width="100px">
						<?php
					}
					?>
					<img src="includes/<?php echo $imgPath; ?>" class="center" style="border-radius: 25cm;width: 100px;height: 100px;margin-top: 10px;">

					<p align="center" style="font-size: 0.8em;"><b><?php echo $name; ?></b></p>
					
					<div style="margin-left: 20px;margin-top: 20px;">
						<p class="details"><label>ID</label>:<?php echo $emp; ?></p>
						<p class="details"><label>Blood</label>:<?php echo $blood; ?></p>
						<p class="details"><label>Mobile</label>:<?php echo $contact; ?></p>
						<p class="details"><label>Emergency 1</label>:<?php echo $emergencyMobileOffice ?></p>
						<p class="details"><label>Emergency 2</label>:<?php echo $emergencyMobileHome ?></p>
					</div>
				</div>
				</div>
				
				<div class="page">
				<div class="page2" style="margin-right: 10px;font-size: 0.6em;background-image: url(images/idBack.jpg);position: relative;">
					<p style="margin-left: 10px;"><b>Residence:</b><br><?php echo $address; ?></p>

					<img class="center" src="http://api.qrserver.com/v1/create-qr-code/?data=192.168.43.250/Creative/empDetails.php?id=<?php echo $id; ?>&size=60x60">

					<p align="center">Valid Upto:<?php echo $expiryDate; ?></p>
					<img src="images/signature.png" width="124" height="56" class="center">

					<p style="position: absolute;bottom: 0;margin-left: 10px;">
						<b><?php echo $office; ?></b>
						<br>
						<?php echo $officeAddress; ?>
						<br>
						<i class="fas fa-phone"></i> <?php echo $officePhone; ?>
						<br>
						<i class="far fa-envelope"></i> <?php echo $officeEmail; ?>
						<br>
					</p>
				</div>
				</div>
			<?php
		}
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>ID CARD | CREATIVE TECHNOTEX PVT LTD</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style type="text/css">
		.center{
			display: block;margin-left: auto;margin-right: auto;
		}
		.details{
			margin: 4px;
			font-size: 0.7em;
		}
		.page{
			border: 4px solid black;width: 210px;height: 370px;float: left;margin: 5px;page-break-inside: avoid;
		}
		.page2{
			width: 208px;height: 320px;margin-top: 49px;page-break-inside: avoid;margin-left: 1px;
		}
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
		label{
			font-weight: bold;display: inline-block;width: 70px;
		}
		.print-btn{
			margin: 20px 0 20px 0;
			padding: 10px;
			background-color: red;
			color: white;
		}
		@media print{
			*{
				-webkit-print-color-adjust: exact !important; /*Chrome, Safari */
    			color-adjust: exact !important;
			}
			.non-printable{
				display: none;
			}
		}
	</style>
</head>
<body>
	<?php 
		include_once 'includes/nav.php'; 
		include 'includes/dbConn.php';
	?>

	<center>
		<button class="non-printable print-btn" onclick="window.print()"><b><i class="fas fa-file-pdf fa-2x"></i> SAVE AS PDF</b></button>	
	</center>
	
	<?php			
		if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || empty($_SESSION['profile'])) {
			header('Location:index.php');
			exit();
		}
		if (isset($_GET['id'])) {
			$id=htmlspecialchars($_GET['id']);
		
			$sql="SELECT * FROM userinfo WHERE Username='$id'";
			$result2=mysqli_query($conn,$sql);
			$row2=mysqli_fetch_assoc($result2);
			$profileStatus=$row2['ProfileStatus'];

			if ($_SESSION['utype'] == 'Employee') {
				if ($profileStatus !== 'Approved') {
					echo "<h1>Your profile has not been approved or updated.</h1>";
					exit();
				}
				$empID=$_SESSION['uname'];
				if ($empID!==$id) {
					header('Location:employeeIndex.php');
					exit();
				}
				else{
					generateID($id);
				}
			}
			elseif ($_SESSION['utype']=='Admin') {
				$sql="SELECT * FROM userinfo WHERE Username='$id'";
				$result=mysqli_query($conn,$sql);
				$row=mysqli_fetch_assoc($result);
				$status=$row['ProfileStatus'];
				if ($status=='Approved') {
					generateID($id);	
				}
				else{
					echo "<h1>Profile of this employee has not yet been updated or approved.</h1>";
					exit();
				}
			}
		}
		else if(isset($_POST['id'])){
			$length=count($_POST['id']);
			for ($i=0; $i < $length; $i++) { 
				$id=$_POST['id'][$i];
				generateID($id);
			}	
		}
		else{
			header('Location:id.php');
			exit();
		}
	?>
	<br>
</body>
</html>