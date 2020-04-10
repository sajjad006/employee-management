<?php
	session_start();
	
	include_once 'includes/dbConn.php';
	if (isset($_SESSION['utype'])) {
		include_once 'includes/nav.php';
	}
	
	if (isset($_GET['id'])) {
		$empID=htmlspecialchars($_GET['id']);
		if (isset($_SESSION['utype']) && $_SESSION['utype']=='Employee') {
			if ($empID != $_SESSION['uname']) {
				header('Location:employeeIndex.php');
				exit();
			}
		}
	}
	else{
		header('Location:empDisplay.php');
		exit();
	}
	
	$sql="SELECT * FROM userinfo WHERE Username='$empID'";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$usertype_db=$row['Usertype'];
	$profileStatus=$row['ProfileStatus'];

	if ($profileStatus=='Pending') {
		echo "<h1>Your profile has not yet been updated.</h1>";
		exit();;
	}

	$sql="SELECT employee_personal_details.*,employee_job_details.*,employee_contact_details.*, employee_address_details.*, employee_bank_details.*, employee_personal_documents.* FROM employee_personal_details INNER JOIN employee_job_details ON employee_personal_details.E_EmpID=employee_job_details.E_EmpID INNER JOIN employee_contact_details ON employee_personal_details.E_EmpID=employee_contact_details.E_EmpID INNER JOIN employee_address_details ON employee_personal_details.E_EmpID=employee_address_details.E_EmpID INNER JOIN employee_bank_details ON employee_personal_details.E_EmpID=employee_bank_details.E_EmpID INNER JOIN employee_personal_documents ON employee_personal_details.E_EmpID=employee_personal_documents.E_EmpID WHERE employee_personal_details.E_EmpID='$empID'";

	$result=mysqli_query($conn,$sql);	
	$resultCheck=mysqli_num_rows($result);
	if ($resultCheck<=0) {
		echo "Sorry invalid employee! This employee does not exists!";
		exit();
	}
	else{
		while ($row=mysqli_fetch_assoc($result)) {
			$id=$row['UniqueID'];
			$name=$row['E_First_Name'].' '.$row['E_Middle_Name'].' '.$row['E_Last_Name'];
			$gender=$row['E_Gender'];
			$sdwo=$row['E_SDWO'];
			$dob=$row['E_DOB'];$dob = date("d-m-Y", strtotime($dob));
			$doj=$row['E_DOJ'];$doj = date("d-m-Y", strtotime($doj));
			$office=$row['E_Placement'];
			$designation=$row['E_Designation'];
			$type=$row['E_Type'];
			$pf=$row['E_PF_Code'];
			$esi=$row['E_ESI_Code'];
			$address=$row['E_ALine1']." ".$row['E_ALine2'];
			$po=$row['E_PO'];$ps=$row['E_PS'];$city=$row['E_City'];$state=$row['E_State'];$pincode=$row['E_Pincode'];
			$contact=$row['E_Contact_Number'];$workEmail=$row['E_Work_Email'];$personalEmail=$row['E_Personal_Email'];
			$emergencyHomeName=$row['E_Emergeny_HomeName'];$emergencyHomeMobile=$row['E_Emergency_HomeMobile'];
			$emergencyOfficeName=$row['E_Emergeny_OfficeName'];$emergencyOfficeMobile=$row['E_Emergency_OfficeMobile'];
			$imagePath=$row['E_Image'];
			$status=$row['E_Status'];
			$blood=$row['E_BloodGroup'];
			$idExpiry=$row['E_IDValidity'];$idEx = date("d-m-Y", strtotime($idExpiry));
			$bankName=$row['E_Bank_Name'];
			$bankBranch=$row['E_Bank_Branch'];
			$bankIFSC=$row['E_Bank_IFSC'];
			$bankAccount=$row['E_Bank_Account_Number'];
			$bankImage=$row['E_Bank_Image'];
			$aadharNumber=$row['E_Aadhar_Number'];$aadharFront=$row['E_Aadhar_Front'];$aadharBack=$row['E_Aadhar_Back'];
			$panNumber=$row['E_PAN_Card'];$panImage=$row['E_PAN_Image'];
			$voterID=$row['E_VoterID'];$voterFront=$row['E_Voter_Front'];$voterBack=$row['E_Voter_Back'];
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EMPLOYEE DETAILS | CREATIVE TECHNOTEX PVT LTD</title>
	<style type="text/css">
		body{
			font-family: Arial, Helvetica, sans-serif;
			margin: 0;padding: 0;
		}
		.details{
			display: block;
			box-sizing: border-box;
			float: left;
			width: 33%;
			height: 300px;
			padding: 20px;
			margin-bottom: 20px;
		}
		.actionbtn
		{
			width: 50%;
			background-color: green;
			color: white;
			padding: 10px;
			margin-bottom: 20px;
			float: left;
		}
		.parent-div{
			padding: 40px;
		}
		.details a{
			margin: 10px;text-decoration: none;background-color: red;padding: 5px;color: white;
		}
		@media screen and (max-width: 742px) {
 			.details{
 				float: none;
 				width: 100%;
 				margin: 0;
 			}
 			.details-small{
 				height: 200px;
 			}
		}
		@media print{
			#myTopnav, #actions{
				display: none;
			}
			.non-printable{
			    display:none;
			}
		}
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
		if ($profileStatus == 'Pending') {
			echo "<h1>Your profile has not yet been updated.</h1>";
			exit();
		}
		if (empty($_SESSION['utype'])) {
			?>
			<a href="http://www.creativett.com">
				<img src="images/cr.png" style="margin-left: auto;margin-right: auto;display: block;">
			</a>
			<?php
		}
	?>

	<h3>Employee Details : <?php echo $id."     ".$empID; ?></h3>
	
	<div id="error" style="display: none;">
		<p style="color: red;">This employee is no longer associated with us. The employee may have been terminated/retired. Please contact admin at 033 2427 4702/03 or info@creativett.com for more details !</p>
	</div>

	<div class="details">
		<img src="includes/<?php echo $imagePath; ?>" style="width: 50%;height: 100%;margin-left: auto;margin-right: auto;display: block;">
	</div>

	<div class="details" class="details-small">
		<h2>Personal Details:</h2>
		<p><b>Name : </b><?php echo $name; ?></p>
		<p><b>Gender : </b><?php echo $gender; ?></p>
		<p><b>S/D/W Of : </b><?php echo $sdwo; ?></p>
		<p><b>DOB : </b><?php echo $dob; ?></p>
		<p><b>Blood Group : </b><?php echo $blood; ?></p>
	</div>
	
	<div class="details" class="details-small" id="actions">
		<h2>Actions:</h2>
		<?php
			if ($profileStatus==='Approved') {?>
				<center>
					<button class="actionbtn" id="fire" onclick="window.location.replace('includes/fire.php?id=<?php echo $empID; ?>')">FIRE EMPLOYEE</button>
					
					<button class="actionbtn" id="idCard" onclick="window.location.replace('includes/reissueId.php?id=<?php echo $empID; ?>')">VALIDATE ID CARD</button>

					<button class="actionbtn" id="adminBtn" onclick="window.location.replace('idDisplay2.php?id=<?php echo $empID; ?>')">VIEW ID</button>

					<button class="actionbtn" id="edit" onclick="window.location.replace('editEmployee.php?id=<?php echo $empID; ?>')">EDIT PROFILE</button>
				
					<p style="display: none;color: red;" id="status">STATUS: DEACTIVATED</p>
					<p style="display: none;color: red;" id="expiry">ID CARD EXPIRED</p>
					
					<?php
						$date_now = date("Y-m-d");
						if ($date_now>$idExpiry) {
							?>
							<script type="text/javascript">
								document.getElementById('expiry').style.display='block';
								document.getElementById('expiry').style.margin='0';
							</script>
							<?php
						}
					?>

				</center>

				<?php
			}
			if ($profileStatus=='Updated') {?>
				<button class="generate" onclick="window.location.replace('includes/approve.php?id=<?php echo $empID; ?>&result=approve')">APPROVE</button>
				<button class="generate" style="background-color: red;" onclick="window.location.replace('includes/approve.php?id=<?php echo $empID; ?>&result=reject')">REJECT</button>
				<?php
			}
				?>	
	</div>


	<div class="details">
		<h2>Job Details:</h2>	
		<p><b>DOJ : </b><?php echo $doj; ?></p>
		<p><b>ID Expiry : </b><?php echo $idEx; ?></p>
		<p><b>Office : </b><?php echo $office; ?></p>
		<p><b>Designation : </b><?php echo $designation; ?></p>
		<p><b>Employee Type : </b><?php echo $type; ?></p>
		<p><b>UIN : </b><?php echo $pf; ?></p>
		<p><b>ESI Code : </b><?php echo $esi; ?></p>
	</div>

	<div class="details">
		<h2>Address:</h2>
		<p><b>Address : </b><?php echo $address; ?></p>
		<p><b>City : </b><?php echo $city; ?></p>
		<p><b>State : </b><?php echo $state; ?></p>
		<p><b>Pincode : </b><?php echo $pincode; ?></p>
		<p><b>Post Office : </b><?php echo $po; ?></p>
		<p><b>Police Station : </b><?php echo $ps; ?></p>
	</div>

	<div class="details">
		<h2>Contact:</h2>
		<p><b>Mobile Number : </b><?php echo $contact; ?></p>
		<p><b>Work Email : </b><?php echo $workEmail; ?></p>
		<p><b>Personal Email : </b><?php echo $personalEmail; ?></p>
		<p><b>Emergency Contact: </b></p>
		<p><b>HOME:</b><?php echo $emergencyHomeName."     ".$emergencyHomeMobile; ?></p>
		<p><b>OFFICE:</b><?php echo $emergencyOfficeName."     ".$emergencyOfficeMobile; ?></p>
	</div>

	<div class="details">
		<h2>Bank Details:</h2>
		<p><b>Bank Name : </b><?php echo $bankName ?></p>
		<p><b>Bank Branch : </b><?php echo $bankBranch ?></p>
		<p><b>Bank IFSC : </b><?php echo $bankIFSC ?></p>
		<p><b>Bank Account Number : </b><?php echo $bankAccount ?></p>
		<p class="non-printable"><b>Passbook/Cancelled Cheque Image : </b></p>
		<a class="non-printable" target="_blank" href="includes/<?php echo $bankImage ?>">IMAGE</a>
	</div>

	<div class="details">
		<h2>Personal Documents:</h2>
		<p><b>Aadhar Number : </b><?php echo $aadharNumber; ?></p>
		<p><b>Voter ID Number : </b><?php echo $voterID; ?></p>
		<p><b>Pan Number : </b><?php echo $panNumber; ?></p>
		<p class="non-printable"><b>Aadhar Card Image:</b><a target="_blank" href="includes/<?php echo $aadharFront ?>">FRONT</a><a target="_blank" href="includes/<?php echo $aadharBack ?>">BACK</a></p>
		<p class="non-printable"><b>Voter IDCard Image:</b><a target="_blank" href="includes/<?php echo $voterFront ?>">FRONT</a><a target="_blank" href="includes/<?php echo $voterBack ?>">BACK</a></p>
		<p class="non-printable"><b>Pan Card Image:</b><a target="_blank" href="includes/<?php echo $panImage; ?>">CLICK HERE</a></p>
	</div>
	
	<?php
		if (empty($_SESSION['utype'])) {
			?>
				<script type="text/javascript">
					document.getElementById('actions').style.display='none';
				</script>
			<?php
			if ($status == 'Deactivated') {
				?>
				<script type="text/javascript">
					document.getElementById('error').style.display='block';
					for (var i = 0; i < 8; i++) {
						document.getElementsByClassName('details')[i].style.visibility = 'hidden';
					}
				</script>
				<?php
			}
		}
		if (isset($_SESSION['utype']) && $_SESSION['utype']=='Employee') {
			?>
			<script type="text/javascript">
				document.getElementById('actions').style.display='none';
			</script>
			<?php
		}
		if ($status=='Deactivated') {
			?>
			<script type="text/javascript">
				/**document.getElementById('fire').style.display='none';**/
				document.getElementById('status').style.display='block';
				document.getElementById('fire').disabled='true';
				document.getElementById('fire').style.backgroundColor='grey';
				
				document.getElementById('adminBtn').disabled='true';
				document.getElementById('adminBtn').style.backgroundColor='grey';
				document.getElementById('idCard').disabled='true';
				document.getElementById('idCard').style.backgroundColor='grey';
				document.getElementById('edit').disabled='true';
				document.getElementById('edit').style.backgroundColor='grey';
			</script><?php
			
		}
		if ($usertype_db=='Admin') {
		?>
		<script type="text/javascript">
			document.getElementById('fire').disabled='true';
			document.getElementById('fire').style.backgroundColor='grey';
		</script>
		<?php
	}
	?>
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>