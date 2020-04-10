<?php
	session_start();
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Employee' || empty($_SESSION['profile'])) {
		header('Location:index.php');
		exit();
	}
	else{
		include_once 'includes/nav.php';
		include_once 'includes/dbConn.php';

		$employee_id=$_SESSION['uname'];
		$sql="SELECT * FROM userinfo WHERE Username='$employee_id'";
		$result=mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		$profileStatus=$row['ProfileStatus'];
		$firstname=$row['FirstName'];
		$lastname=$row['LastName'];
		$mobile=$row['Mobile'];
	
		if ($profileStatus=='Updated' || $profileStatus=='Approved') {
			echo "<h1>Your profile has already been updated</h1>";
			exit();
		}
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
				?><script type="text/javascript">alert('Please upload all the files');</script><?php
			}

			$_SESSION['error']="";
		}	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>UPDATE PROFILE | CREATIVE TECHNOTEX PVT. LTD.</title>
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
			background-color: #ca67f9;width: 200px;padding: 10px;
		}
		@media screen and (max-width: 700px){
			fieldset{
				margin-left: 10px;width: 80%;height: auto;
			}
		}
	</style>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script type="text/javascript">
		<?php 
			if (isset($_GET['add'])) {
				$add=$_GET['add'];
				if ($add=='success') {
					?>
					if (confirm("Profile Updated Successfully !")) {
						window.location.replace('employeeIndex.php');
					}
					else{
						window.location.replace('employeeIndex.php');	
					}
					<?php
				}
			}
		?>	
	</script>
</head>
<body>
	
	<h1 align="center">EMPLOYEE PROFILE UPDATE</h1>
	<form method="POST" action="includes/updateProfile_process.php" enctype="multipart/form-data">
		
		<fieldset>
				<legend><b>Employee Personal Details:</b></legend>
				<br>

				<label>Employee First Name: *</label>
				<input type="text" name="emp_first_name" style="background-color: #b4bbc6;" required readonly value="<?php echo $firstname; ?>">
				<br>

				<label>Employee Middle Name:</label>
				<input type="text" name="emp_middle_name">
				<br>

				<label>Employee Last Name:</label>
				<input type="text" name="emp_last_name" style="background-color: #b4bbc6;" readonly value="<?php echo $lastname; ?>">
				<br>

				<label>Gender: *</label>
				<select name="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>	
				</select>
				<br>

				<label>Blood Group</label>
				<select name="blood">
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

				<label>Input Employee Image: *</label>
				<input type="file" name="img" required accept="image/*">
				<br>

				<label>Son/Daughter/Wife of:</label>
				<input type="text" name="sdwo">
				
				<br>

				<label>Date of Birth:</label>
				<input type="date" name="date">
				<br>
			</fieldset>

			<fieldset>
				<legend>Employee Contact Details</legend>
				<br>
				<label>Contact Number: *</label>
				<input type="text" name="Contact" readonly style="background-color: #b4bbc6;" value="<?php echo $mobile; ?>">
				<br>

				<label>Work Email:</label>
				<input type="email" name="work_email">
				<br>

				<label>Personal Email:</label>
				<input type="email" name="Personal_Email">
				<br>

				<label>Emergency Contact Home:</label><br>
					<label>Name:</label>	
					<input type="name" name="Emergency_HomeName">
					<br>

					<label>Mobile:</label>
					<input type="name" name="Emergency_HomeMobile">
				<br>	

				<label>Emergency Contact Office:</label><br>
					<label>Name:</label>	
					<input type="name" name="Emergency_OfficeName">
					<br>

					<label>Mobile:</label>
					<input type="name" name="Emergency_OfficeMobile">
				<br>	
			</fieldset>
	<?php
		for ($i=1; $i < 3; $i++) { 
			?>
			<fieldset>
				<?php
					if ($i==1) {
						?>
						<legend>Employee Present Address Details:</legend>
						<br>
						<?php
					}
					else{
						?>
						<legend>Employee Permanent Address Details:</legend>
						<br>
						<?php
					}
				?>
				

				<label>Address Line 1:</label>
				<input type="text" name="address_line_1[]" placeholder="Address Line 1">
				<br>
				
				<label>Address Line 2:</label>
				<input type="text" name="address_line_2[]" placeholder="Address Line 2">
				<br>
				
				<label>Post Office:</label>
				<input type="text" name="PO[]" placeholder="Post Office">
				<br>
				
				<label>Police Station:</label>
				<input type="text" name="PS[]" placeholder="Police Station">
				<br>

				<label>City:</label>
				<input type="text" name="City[]" placeholder="City">
				<br>

				<label>State:</label>
				<select name="State[]">
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
				<input type="text" name="Pincode[]" placeholder="Pincode"><br> 
			</fieldset>
			<?php
		}
			?>

			<fieldset style="height: 450px;">
				<legend>Employee Job Details</legend>
				<label>Placed At:</label>
				<select name="placement">
					<option value="Registered Office">Registered Office</option>
					<option value="LPG SBU">LPG SBU</option>
					<option value="Factory">Factory</option>
					<option value="Sales Office">Sales Office</option>
					<option value="Mr. Wok">Mr. Wok</option>
					<option value="Construction Site">Construction Site</option><!--Construction site dropdown to be added later with the help of JS-->
				</select>	
				<br>

				<label>Designation:</label>
				<input type="name" name="Designation">
				<br>

				<label>Date of Joining:</label>
				<input type="date" name="DOJ" required>
				<br>

				<label>Employee Type:</label>
				<select name="emp_type">
					<option value="Temporary">Temporary</option>
					<option value="Contractual">Contractual</option>
					<option value="Permanent">Permanent</option>
					<option value="Writtners">Writtners</option>
				</select>
				<br>

				<label>UIN:</label>
				<input type="text" name="PF_Code">
				<br>

				<label>ESI Code:</label>
				<input type="text" name="ESI_Code">
				<br>
			</fieldset>
			
			<fieldset style="height: 450px;">
				<legend>Bank Details</legend>	

				<label>Bank Name:</label>
				<input type="text" name="bank">

				<label>Bank Branch:</label>
				<input type="text" name="branch">

				<label>Bank IFSC Code:</label>
				<input type="text" name="ifsc">

				<label>Bank Account Number:</label>
				<input type="text" name="accountNumber">

				<label>Upload Image of Cancelled Check/ Passbook First Page</label>
				<input type="file" name="passbook" accept="image/*">
			</fieldset>
			
			<fieldset style="display: block;float: none;">		
				<legend>Personal Documents</legend>

				<label>Aadhar Card Number:</label>
				<input type="text" name="aadharNumber">

				<label>Upload Image: Aadhar Card(Front)</label>
				<input type="file" name="adharFront" accept="image/*">

				<label>Upload Image: Aadhar Card(Back)</label>
				<input type="file" name="adharBack" accept="image/*">

				<label>Voter ID Card Number:</label>
				<input type="text" name="voterNumber">

				<label>Upload Image: Voter ID Card(Front)</label>
				<input type="file" name="voterFront" accept="image/*">

				<label>Upload Image: Voter ID Card(Back)</label>
				<input type="file" name="voterBack" accept="image/*">
				
				<label>PAN Card Number:</label>
				<input type="text" name="panNumber">
				
				<label>Upload Image: PAN Card(Front)</label>
				<input type="file" name="panImage" accept="image/*">
				
			</fieldset>

			<center><input type="submit" name="submit" value="UPDATE PROFILE" style="display: block;float: none;"></center>
			
	</form>
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>