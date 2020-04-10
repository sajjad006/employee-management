<?php

if (isset($_POST['submit'])) {
	include_once 'dbConn.php';
	include_once 'sms.php';

	function fileProcess($fileName,$destinaton,$i)
	{
		$fileDestination='';
		if(!empty($_FILES[$fileName]['name'][$i])){
			$image = $_FILES[$fileName]['tmp_name'][$i];
			$name=$_FILES[$fileName]['name'][$i];
			$allowed = array('jpeg','jpg','png');
			$fExt=explode('.', $name);
			$fActExt=strtolower(end($fExt));
			if (in_array($fActExt, $allowed)) {
				$fileNewName=uniqid('',true).".".$fActExt;
				$fileDestination=$destinaton.$fileNewName;
				move_uploaded_file($image, $fileDestination);
			}	
			else{
				$fileDestination='upload/default-image.png';
			}
		}	
		else{
			$fileDestination='upload/default-image.png';
		}
		return $fileDestination;
	}
	function randomPassword() {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	if (!empty($_FILES['csv'])) {
		$file = $_FILES['csv']['tmp_name'];
		$name=$_FILES['csv']['name'];
		$fExt=explode('.', $name);
		$fActExt=strtolower(end($fExt));

		if ($fActExt=='csv') {
			$data=fopen($file, "r");
			
			$c=0;
			while(!feof($data)) {
				$row=fgets($data);
				$rowArray=explode(',', $row);
				
				
				$first_name=htmlspecialchars($rowArray[0]);
				$middle_name=htmlspecialchars($rowArray[1]);
				$last_name=htmlspecialchars($rowArray[2]);
				$gender=htmlspecialchars($rowArray[3]);
				$sdwo=htmlspecialchars($rowArray[4]);
				$DOB=htmlspecialchars($rowArray[5]);$DOB=date('Y-m-d',strtotime($DOB));
				$bloodGroup=htmlspecialchars($rowArray[6]);

				$address_line1=htmlspecialchars($rowArray[7]);
				$address_line2=htmlspecialchars($rowArray[8]);
				$PO=htmlspecialchars($rowArray[9]);
				$PS=htmlspecialchars($rowArray[10]);
				$city=htmlspecialchars($rowArray[11]);
				$state=htmlspecialchars($rowArray[12]);
				$pincode=htmlspecialchars($rowArray[13]);

				$p_address_line1=htmlspecialchars($rowArray[14]);
				$p_address_line2=htmlspecialchars($rowArray[15]);
				$p_PO=htmlspecialchars($rowArray[16]);
				$p_PS=htmlspecialchars($rowArray[17]);
				$p_city=htmlspecialchars($rowArray[18]);
				$p_state=htmlspecialchars($rowArray[19]);
				$p_pincode=htmlspecialchars($rowArray[20]);


				$contactNumber=htmlspecialchars($rowArray[21]);
				$Work_Email=htmlspecialchars($rowArray[22]);
				$Personal_Email=htmlspecialchars($rowArray[23]);
				$Emergency_HomeName=htmlspecialchars($rowArray[24]);
				$Emergency_HomeMobile=htmlspecialchars($rowArray[25]);
				$Emergency_OfficeName=htmlspecialchars($rowArray[26]);
				$Emergency_OfficeMobile=htmlspecialchars($rowArray[27]);

				$placement=htmlspecialchars($rowArray[28]);
				$designation=htmlspecialchars($rowArray[29]);
				$doj=htmlspecialchars($rowArray[30]);$doj=date('Y-m-d',strtotime($doj));
				$type=htmlspecialchars($rowArray[31]);
				$pf=htmlspecialchars($rowArray[32]);
				$esi=htmlspecialchars($rowArray[33]);

				$aadharNumber=htmlspecialchars($rowArray[34]);
				$voterNumber=htmlspecialchars($rowArray[35]);
				$panNumber=htmlspecialchars($rowArray[36]);
				
				$bank=htmlspecialchars($rowArray[37]);
				$branch=htmlspecialchars($rowArray[38]);
				$ifsc=htmlspecialchars($rowArray[39]);
				$accountNumber=htmlspecialchars($rowArray[40]);

				$fileDestination=fileProcess('image','upload/EmployeeImage/',$c);
				$adharFront='upload/default-image.png';
				$adharBack='upload/default-image.png';
				$voterFront='upload/default-image.png';
				$voterBack='upload/default-image.png';
				$panImage='upload/default-image.png';
				$passbook='upload/default-image.png';

				$rand=mt_rand(100,999);
				$emp_ID=strtoupper(substr($first_name, 0,3).substr($last_name, 0,3).$rand);	
			
				if ($type=='Permanent') {
					$expiryDate = date('Y-m-d', strtotime($doj. ' + 5 years'));
				}
				elseif ($type=='Temporary' || $type=='Contractual' || $type=='Writtners') {
					$expiryDate = date('Y-m-d', strtotime($doj. ' + 1 years'));
				}

				$rand=mt_rand(100,909);
				$emp_ID=strtoupper(substr($first_name, 0,3).substr($last_name, 0,3).$rand);
				$profileStatus="Approved";
				$status='Active';
				$usertype='Employee';
				$password=randomPassword();
				$hashed_password=password_hash($password, PASSWORD_DEFAULT);

				$sql="INSERT INTO `employee_personal_documents` (`E_EmpID`, `E_Aadhar_Number`, `E_Aadhar_Front`, `E_Aadhar_Back`, `E_VoterID`, `E_Voter_Front`, `E_Voter_Back`, `E_PAN_Card`, `E_PAN_Image`) VALUES ('$emp_ID', '$aadharNumber', '$adharFront', '$adharBack', '$voterNumber', '$voterFront', '$voterBack', '$panNumber','$panImage');";
				mysqli_query($conn,$sql);

				$sql="INSERT INTO `employee_bank_details` (`E_EmpID`, `E_Bank_Name`, `E_Bank_Branch`, `E_Bank_IFSC`, `E_Bank_Account_Number`, `E_Bank_Image`) VALUES ('$emp_ID', '$bank', '$branch', '$ifsc', '$accountNumber', '$passbook');";
				mysqli_query($conn,$sql);

				$sql="INSERT INTO `employee_personal_details` (`E_EmpID`, `E_First_Name`, `E_Middle_Name`, `E_Last_Name`, `E_Gender`, `E_Image`, `E_SDWO`, `E_DOB`, `E_BloodGroup`) VALUES ('$emp_ID', '$first_name', '$middle_name', '$last_name', '$gender', '$fileDestination', '$sdwo', '$DOB', '$bloodGroup');";
				mysqli_query($conn,$sql);

				$sql="INSERT INTO `employee_address_details` (`E_EmpID`, `E_ALine1`, `E_ALine2`, `E_PO`, `E_PS`, `E_City`, `E_State`, `E_Pincode`, `E_P_ALine1`, `E_P_ALine2`, `E_P_PO`, `E_P_PS`, `E_P_City`, `E_P_State`, `E_P_Pincode`) VALUES ('$emp_ID', '$address_line1', '$address_line2', '$PO', '$PS', '$city', '$state', '$pincode', '$p_address_line1', '$p_address_line2', '$p_PO', '$p_PS', '$p_city', '$p_state', '$p_pincode');";
				mysqli_query($conn,$sql);

				
				$sql="INSERT INTO `employee_contact_details` (`E_EmpID`, `E_Contact_Number`, `E_Work_Email`, `E_Personal_Email`, `E_Emergeny_HomeName`, `E_Emergency_HomeMobile`, `E_Emergeny_OfficeName`, `E_Emergency_OfficeMobile`) VALUES ('$emp_ID', '$contactNumber', '$Work_Email', '$Personal_Email', '$Emergency_HomeName', '$Emergency_HomeMobile', '$Emergency_OfficeName', '$Emergency_OfficeMobile');";
				mysqli_query($conn,$sql);

				$sql="INSERT INTO `employee_job_details` (`E_EmpID`, `E_Designation`, `E_DOJ`, `E_Type`, `E_PF_Code`, `E_ESI_Code`, `E_Placement`, `E_Status`, `E_IDValidity`) VALUES ('$emp_ID','$designation', '$doj', '$type', '$pf', '$esi', '$placement','$status','$expiryDate');";
				mysqli_query($conn,$sql);
				
				$sql="INSERT INTO userinfo (Username, Password, Usertype, ProfileStatus) VALUES('$emp_ID','$hashed_password','$usertype','$profileStatus')";
				mysqli_query($conn,$sql);
				
				sendSMS($emp_ID,$password,$contactNumber,$first_name);

				$c++;
			}
			fclose($data);
			header('Location:../addEmployee.php?add=success');
			exit();
		}
		else{
			$_SESSION['error']='csv';
			?>
				<script type="text/javascript">history.go(-1);</script>
			<?php
			exit();
		}
	}
	else{
		header('Location:../addEmployee.php');
		exit();
	}
}
else{
	header('Location:../adminIndex.php');
	exit();
}


?>