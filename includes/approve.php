<?php
	//This page is used for approving the profile status of an employee after he/she updates her profile.
	session_start();
	include_once 'dbConn.php';
	include_once 'sms.php';
	
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Admin') {
		header('Location:../index.phps');
		exit();
	}
	else{
		if (empty($_GET['id']) || empty($_GET['result'])) {
			header('Location:../empDisplay.php');
			exit();
		}
		else{
			$id=htmlspecialchars($_GET['id']);
			$result=htmlspecialchars($_GET['result']);
			
			$sql="";
			if ($result=='approve') {
				$sql="UPDATE userinfo SET ProfileStatus='Approved' WHERE Username='$id';UPDATE employee_job_details SET E_Status='Active' WHERE E_EmpID='$id'";
				mysqli_multi_query($conn,$sql);
				sendApproveSMS($id);
				
			}
			elseif($result=='reject'){
				$sql="UPDATE userinfo SET ProfileStatus='Rejected' WHERE Username='$id';UPDATE employee_job_details SET E_Status='Deactivated' WHERE E_EmpID='$id'";
				mysqli_multi_query($conn,$sql);
				sendRejectSMS($id);
			}
			else{
				header('Location:../empDisplay.php');
				exit();
			}

			header('Location:../empDetails.php');
			exit();
		}
	}
?>	