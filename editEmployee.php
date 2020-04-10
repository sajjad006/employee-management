<?php
	session_start();
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Admin') {
		header('Location:index.php');
		exit();
	}
	else{

		include_once 'includes/dbConn.php';

		if (isset($_SESSION['error'])) {
			$error=$_SESSION['error'];
			
			if ($error=='empty') {
				?><script type="text/javascript">alert('Please fill in all the fields marked as *');</script><?php
			}
			elseif ($error=='validate') {
				?><script type="text/javascript">alert('Improper Name, Designation or Address');</script><?php
			}
			elseif ($error=='mobile') {
				?><script type="text/javascript">alert('Invalid mobile number');</script><?php
			}
			elseif ($error=='email') {
				?><script type="text/javascript">alert('Invalid email address(s)');</script><?php
			}
			elseif ($error=='file') {
				?><script type="text/javascript">alert('Please upload all the files');</script><?php
			}
			elseif ($error=='db') {
				?><script type="text/javascript">alert('Unable to connect to database.');</script><?php
			}

			$_SESSION['error']="";
		}	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EDIT EMPLOYEE | CREATIVE TECHNOTEX PVT. LTD.</title>
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
		fieldset{
			width: 40%;
			height: 600px;
			margin: 40px;
			display: inline-block;
			float: left;
		}
		body{
			margin: 0;padding: 0;
			font-family: : Arial, Helvetica, sans-serif;
		}
		button{
			background-color: #ca67f9;width: 150px;page-break-after: 10px;
		}
		@media screen and (max-width: 700px){
			fieldset{
				margin-left: 10px;width: 80%;height: auto;
			}
		}
	</style>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php

	if (isset($_GET['id'])) {
		$id=htmlspecialchars($_GET['id']);
		$empID=$id;
	}
	elseif(isset($_GET['update'])){?>
		<script type="text/javascript">
			<?php 
			$update=$_GET['update'];
			if ($update=='success') {
				?>
				if (confirm("Employee Updated Successfully !")) {
					window.location.replace('adminIndex.php');
				}
				else{
					window.location.replace('adminIndex.php');	
				}
				<?php
			}
		
			?>	
		</script>
		<?php
	}
	else{
		header('Location:adminIndex.php');
		exit();
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
			$first_name=$row['E_First_Name'];$middle_name=$row['E_Middle_Name'];$last_name=$row['E_Last_Name'];
			$gender=$row['E_Gender'];
			$sdwo=$row['E_SDWO'];
			$dob=$row['E_DOB'];
			$doj=$row['E_DOJ'];
			$office=$row['E_Placement'];
			$designation=$row['E_Designation'];
			$type=$row['E_Type'];
			$pf=$row['E_PF_Code'];
			$esi=$row['E_ESI_Code'];
			
			$address_line_1=$row['E_ALine1'];$address_line_2=$row['E_ALine2'];
			$po=$row['E_PO'];$ps=$row['E_PS'];$city=$row['E_City'];$state=$row['E_State'];$pincode=$row['E_Pincode'];
			
			$p_address_line_1=$row['E_P_ALine1'];$p_address_line_2=$row['E_P_ALine2'];
			$p_po=$row['E_P_PO'];$p_ps=$row['E_P_PS'];$p_city=$row['E_P_City'];$p_state=$row['E_P_State'];$p_pincode=$row['E_P_Pincode'];
			
			$contact=$row['E_Contact_Number'];$workEmail=$row['E_Work_Email'];$personalEmail=$row['E_Personal_Email'];
			
			$emergencyHomeName=$row['E_Emergeny_HomeName'];$emergencyHomeMobile=$row['E_Emergency_HomeMobile'];
			
			$emergencyOfficeName=$row['E_Emergeny_OfficeName'];$emergencyOfficeMobile=$row['E_Emergency_OfficeMobile'];
			
			$imagePath=$row['E_Image'];
			$status=$row['E_Status'];
			$blood=$row['E_BloodGroup'];
			$idExpiry=$row['E_IDValidity'];
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
</head>
<body>
	
	<?php include_once 'includes/nav.php'; ?>
	<h1 align="center">EDIT EMPLOYEE</h1>
	<p align="center">SELECT IMAGES ONLY IF YOU WANT TO CHANGE THEM</p>
	<img  src="includes/<?php echo $imagePath; ?>" style="margin-left: auto;margin-right: auto;display: block;width: 100px;height: 100px;">
	
	<form method="POST" action="includes/editEmployee_process.php" enctype="multipart/form-data">
		
		<fieldset>
			<legend><b>Employee Personal Details:</b></legend>
			<br>

			<input type="hidden" name="id" value="<?php echo $empID; ?>">

			<label>Employee First Name:</label>
			<input type="text" name="emp_first_name" value="<?php echo $first_name; ?>">
			<br>

			<label>Employee Middle Name:</label>
			<input type="text" name="emp_middle_name" value="<?php echo $middle_name ?>">
			<br>

			<label>Employee Last Name:</label>
			<input type="text" name="emp_last_name" value="<?php echo $last_name ?>">
			<br>

			<label>Gender</label>
				<select name="gender">
				<?php
					echo "<option value='$gender' selected>$gender</option>";
				?>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
				</select>
			<br>

			<label>Blood Group</label>
				<select name="blood">
				<?php
					echo "<option value='$blood' selected>$blood</option>";
				?>
					<option value="A+">A+</option>
					<option value="A-">A-</option>
					<option value="B+">B+</option>
					<option value="B-">B-</option>
					<option value="AB+">AB+</option>
					<option value="AB-">AB-</option>
					<option value="O+">O+</option>
					<option value="O-">O-</option>	
					<option value="NA">NA</option>
				</select>
			<br>

			<label>Input Employee Image:</label>
			<input type="file" name="img" accept="image/*">
		 	<br>

			<label>Son/Daughter/Wife of:</label>
			<input type="text" name="sdwo" value="<?php echo $sdwo ?>">
			
			<br>

			<label>Date of Birth:</label>
			<input type="date" name="date" value="<?php echo $dob ?>">
			<br>
		</fieldset>

		<fieldset>
			<legend>Employee Contact Details</legend>
			<br>
			<label>Contact Number:</label>
			<input type="text" name="Contact" value="<?php echo $contact ?>">
			<br>

			<label>Work Email:</label>
			<input type="email" name="work_email" value="<?php echo $workEmail ?>">
			<br>

			<label>Personal Email:</label>
			<input type="email" name="Personal_Email" value="<?php echo $personalEmail ?>">
			<br>

			<label>Emergency Contact Home:</label><br>
				<label>Name:</label>	
				<input type="name" name="Emergency_HomeName" value="<?php echo $emergencyHomeName ?>">
				<br>

				<label>Mobile:</label>
				<input type="name" name="Emergency_HomeMobile" value="<?php echo $emergencyHomeMobile ?>">
			<br>	

			<label>Emergency Contact Office:</label><br>
				<label>Name:</label>	
				<input type="name" name="Emergency_OfficeName" value="<?php echo $emergencyOfficeName ?>">
				<br>

				<label>Mobile:</label>
				<input type="name" name="Emergency_OfficeMobile" value="<?php echo $emergencyOfficeMobile ?>">
			<br>	
		</fieldset>

		<fieldset>
			<legend>Employee Present Address Details:</legend>
			<br>

			<label>Address Line 1:</label>
			<input type="text" name="address_line_1[]" value="<?php echo $address_line_1; ?>">
			<br>
			
			<label>Address Line 2:</label>
			<input type="text" name="address_line_2[]" value="<?php echo $address_line_2 ?>">
			<br>
			
			<label>Post Office:</label>
			<input type="text" name="PO[]" value="<?php echo $po ?>">
			<br>
			
			<label>Police Station:</label>
			<input type="text" name="PS[]" value="<?php echo $ps ?>">
			<br>

			<label>City:</label>
			<input type="text" name="City[]" value="<?php echo $city ?>">
			<br>

			<label>State:</label>
			<select name="State[]">
				<?php
					echo "<option value='$state' selected>$state</option>";
				?>
				<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
				<option value="Andhra Pradesh">Andhra Pradesh</option>
				<option value="Arunachal Pradesh">Arunachal Pradesh</option>
				<option value="Assam">Assam</option>
				<option value="Bihar">Bihar</option>
				<option value="Chhattisgarh">Chhattisgarh</option>
				<option value="Chandigarh">Chandigarh</option>
				<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
				<option value="Daman and Diu">Daman and Diu</option>
				<option value="Delhi">Delhi</option>
				<option value="Goa">Goa</option>
				<option value="Gujarat">Gujarat</option>
				<option value="Haryana">Haryana</option>
				<option value="Himachal Pradesh">Himachal Pradesh</option>
				<option value="Jammu and Kashmir">Jammu and Kashmir</option>
				<option value="Jharkhand">Jharkhand</option>
				<option value="Karnataka">Karnataka</option>
				<option value="Kerala">Kerala</option>
				<option value="Lakshadeep">Lakshadeep</option>
				<option value="Madya Pradesh">Madya Pradesh</option>
				<option value="Maharashtra">Maharashtra</option>
				<option value="Manipur">Manipur</option>
				<option value="Meghalaya">Meghalaya</option>
				<option value="Mizoram">Mizoram</option>
				<option value="Nagaland">Nagaland</option>
				<option value="Orissa">Orissa</option>
				<option value="Pondicherry">Pondicherry</option>
				<option value="Punjab">Punjab</option>
				<option value="Rajasthan">Rajasthan</option>
				<option value="Sikkim">Sikkim</option>
				<option value="Tamil Nadu">Tamil Nadu</option>
				<option value="Telengana">Telengana</option>
				<option value="Tripura">Tripura</option>
				<option value="Uttar Pradesh">Uttar Pradesh</option>
				<option value="Uttarakhand">Uttarakhand</option>
				<option value="West Bengal">West Bengal</option>
			</select>
			<br>
			
			<label>Pincode:</label>
			<input type="text" name="Pincode[]" value="<?php echo $pincode ?>"><br> 
		</fieldset>

		<fieldset>
			<legend>Employee Permenant Address Details:</legend>
			<br>

			<label>Address Line 1:</label>
			<input type="text" name="address_line_1[]" value="<?php echo $p_address_line_1; ?>">
			<br>
			
			<label>Address Line 2:</label>
			<input type="text" name="address_line_2[]" value="<?php echo $p_address_line_2 ?>">
			<br>
			
			<label>Post Office:</label>
			<input type="text" name="PO[]" value="<?php echo $p_po ?>">
			<br>
			
			<label>Police Station:</label>
			<input type="text" name="PS[]" value="<?php echo $p_ps ?>">
			<br>

			<label>City:</label>
			<input type="text" name="City[]" value="<?php echo $p_city ?>">
			<br>

			<label>State:</label>
			<select name="State[]">
				<?php
					echo "<option value='$state' selected>$p_state</option>";
				?>
				<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
				<option value="Andhra Pradesh">Andhra Pradesh</option>
				<option value="Arunachal Pradesh">Arunachal Pradesh</option>
				<option value="Assam">Assam</option>
				<option value="Bihar">Bihar</option>
				<option value="Chhattisgarh">Chhattisgarh</option>
				<option value="Chandigarh">Chandigarh</option>
				<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
				<option value="Daman and Diu">Daman and Diu</option>
				<option value="Delhi">Delhi</option>
				<option value="Goa">Goa</option>
				<option value="Gujarat">Gujarat</option>
				<option value="Haryana">Haryana</option>
				<option value="Himachal Pradesh">Himachal Pradesh</option>
				<option value="Jammu and Kashmir">Jammu and Kashmir</option>
				<option value="Jharkhand">Jharkhand</option>
				<option value="Karnataka">Karnataka</option>
				<option value="Kerala">Kerala</option>
				<option value="Lakshadeep">Lakshadeep</option>
				<option value="Madya Pradesh">Madya Pradesh</option>
				<option value="Maharashtra">Maharashtra</option>
				<option value="Manipur">Manipur</option>
				<option value="Meghalaya">Meghalaya</option>
				<option value="Mizoram">Mizoram</option>
				<option value="Nagaland">Nagaland</option>
				<option value="Orissa">Orissa</option>
				<option value="Pondicherry">Pondicherry</option>
				<option value="Punjab">Punjab</option>
				<option value="Rajasthan">Rajasthan</option>
				<option value="Sikkim">Sikkim</option>
				<option value="Tamil Nadu">Tamil Nadu</option>
				<option value="Telengana">Telengana</option>
				<option value="Tripura">Tripura</option>
				<option value="Uttar Pradesh">Uttar Pradesh</option>
				<option value="Uttarakhand">Uttarakhand</option>
				<option value="West Bengal">West Bengal</option>
			</select>
			<br>
			
			<label>Pincode:</label>
			<input type="text" name="Pincode[]" value="<?php echo $p_pincode ?>"><br> 
		</fieldset>

		<fieldset style="height: 450px;">
			<legend>Employee Job Details</legend>
			<label>Placed At:</label>
			<select name="placement">
				<?php
					echo "<option value='$office' selected>$office</option>";
				?>
				<option value="Registered Office">Registered Office</option>
				<option value="LPG SBU">LPG SBU</option>
				<option value="Factory">Factory</option>
				<option value="Sales Office">Sales Office</option>
				<option value="Mr. Wok">Mr. Wok</option>
				<option value="Construction Site">Construction Site</option><!--Construction site dropdown to be added later with the help of JS-->
			</select>	
			<br>

			<label>Designation:</label>
			<input type="name" name="Designation"  value="<?php echo $designation ?>">
			<br>

			<label>Date of Joining:</label>
			<input type="date" name="DOJ" required value="<?php echo $doj; ?>">
			<br>

			<label>Employee Type:</label>
			<select name="emp_type">
				<?php
					echo "<option value='$type' selected>$type</option>";
				?>
				<option value="Temporary">Temporary</option>
				<option value="Contractual">Contractual</option>
				<option value="Permanent">Permanent</option>
				<option value="Writtners">Writtners</option>
			</select>
			<br>

			<label>PF Code:</label>
			<input type="text" name="PF_Code"  value="<?php echo $pf ?>">
			<br>

			<label>ESI Code:</label>
			<input type="text" name="ESI_Code"  value="<?php echo $esi ?>">
			<br>
		</fieldset>
		
		<fieldset style="height: 450px;">
			<legend>Bank Details</legend>	

			<label>Bank Name:</label>
			<input type="text" name="bank"  value="<?php echo $bankName; ?>">

			<label>Bank Branch:</label>
			<input type="text" name="branch"  value="<?php echo $bankBranch; ?>">

			<label>Bank IFSC Code:</label>
			<input type="text" name="ifsc"  value="<?php echo $bankIFSC; ?>">

			<label>Bank Account Number:</label>
			<input type="text" name="accountNumber"  value="<?php echo $bankAccount; ?>">

			<label>Upload Image of Cancelled Check/ Passbook First Page</label><br>
			<input type="file" name="passbook" accept="image/*">
		</fieldset>
	
		<fieldset style="display: block;float: none;">		
			<legend>Personal Documents</legend>

			<label>Aadhar Card Number:</label>
			<input type="text" name="aadharNumber" value="<?php echo $aadharNumber ?>">

			<label>Upload Image: Aadhar Card(Front)</label>
			<input type="file" name="adharFront" accept="image/*">
		 	
			
			<label>Upload Image: Aadhar Card(Back)</label>
			<input type="file" name="adharBack" accept="image/*">
		

			<label>Voter ID Card Number:</label>
			<input type="text" name="voterNumber"  value="<?php echo $voterID; ?>">

			<label>Upload Image: Voter ID Card(Front)</label>
			<input type="file" name="voterFront" accept="image/*">
			
			<label>Upload Image: Voter ID Card(Back)</label>
			<input type="file" name="voterBack" accept="image/*">
			
			<label>PAN Card Number:</label>
			<input type="text" name="panNumber"  value="<?php echo $panNumber; ?>">
			
			<label>Upload Image: PAN Card(Front)</label>
			<input type="file" name="panImage" accept="image/*">
			
		</fieldset>		

		<center><input type="submit" name="submit" value="EDIT EMPLOYEE" style="display: block;float: none;"></center>

	</form>
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>