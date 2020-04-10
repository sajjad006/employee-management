<?php
	function message($message,$mobile)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms?country=91&sender=&route=&mobiles=&authkey=&encrypt=&message=&flash=&unicode=&schtime=&afterminutes=&response=&campaign=",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{ \"sender\": \"CTPLHO\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$mobile\" ] } ] }",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTPHEADER => array(
		    "authkey: 270338A3NK04BVdYqU5ca1ff8e",
		    "content-type: application/json"
		  ),
		));

		/*$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
*/
		/**if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}**/
	}

	if (isset($_GET['id']) && isset($_GET['mobile'])) {
		$id=htmlspecialchars($_GET['id']);
		$mobile=htmlspecialchars($_GET['mobile']);
		sendOTP($mobile,$id);
	}

	function sendOTP($mobile,$id)
	{
		include 'dbConn.php';
		$OTP=mt_rand(100000,999999);
		$expiry=date("U")+300;

		$hashedOTP=password_hash($OTP, PASSWORD_DEFAULT);

		$sql="DELETE FROM reset_password WHERE E_EmpID='$id'";
		if (mysqli_query($conn,$sql)) {
		
			if ($stmt=$conn->prepare("INSERT INTO reset_password (E_EmpID, OTP, ExpiryTime) VALUES (?,?,?)")) {
				
				$stmt->bind_param("sss",$id,$hashedOTP,$expiry);
				$stmt->execute();
				$stmt->close();
				
				$message="Hi! Use this OTP -".$OTP." to reset your password of creativeett.tk. It's valid for 5 mins only.";

				message($message,$mobile);
				
				header('Location:../changePassword.php?otp=success');
				exit();
			}
		}	
	}

	function sendSMS($username,$password,$mobile,$firstName)
	{
		$message="Hi ".$firstName." your account of creativett.tk has been created and you can view and update the same with your Userid-".$username." and password- ".$password;

		message($message,$mobile);
	}

	function sendEmployeeAddNotification($empID,$firstName)
	{
		$message="Hi Admin, ".$firstName." with employee ID ".$empID." has updated his/her profile and is pending for approval. Please visit www.creativett.tk and approve ".$firstName."'s profile.";

		message($message,'9830483502');
	}

	function sendApproveSMS($id){
		include 'dbConn.php';
		$sql="SELECT * FROM employee_contact_details WHERE E_EmpID='$id'";
		$result=mysqli_query($conn,$sql);
		$resultCheck=mysqli_num_rows($result);
		if ($resultCheck<=0) {
			header('Location:../empDisplay.php');
			exit();
		}
		else{
			$row=mysqli_fetch_assoc($result);
			$mobile=$row['E_Contact_Number'];
			$message="Hi your employee details of Emp. Id ".$id." has been approved. Your id card will be issued shortly.";
			message($message,$mobile);
		}
	}

	function sendRejectSMS($id){
		include 'dbConn.php';
		$sql="SELECT * FROM employee_contact_details WHERE E_EmpID='$id'";
		$result=mysqli_query($conn,$sql);
		$resultCheck=mysqli_num_rows($result);
		if ($resultCheck<=0) {
			header('Location:../empDisplay.php');
			exit();
		}
		else{
			$row=mysqli_fetch_assoc($result);
			$mobile=$row['E_Contact_Number'];
			$message="Hi your employee request for creativett.tk with Emp. Id ".$id." has been rejected please contact admin for more details.";
			message($message,$mobile);
		}
	}
?>