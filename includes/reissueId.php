<?php
	session_start();
	if (empty($_SESSION['utype']) || empty($_SESSION['uname']) || empty($_SESSION['pass']) || $_SESSION['utype'] !== 'Admin') {
		header('Location:../index.php');
		exit();
	}
	else{
		if (empty($_GET['id'])) {
			header("Location;../adminIndex.php");
			exit();
		}
		else{
			include_once 'dbConn.php';
			$id=htmlspecialchars($_GET['id']);
			$sql="SELECT * FROM employee_job_details WHERE E_EmpID='$id'";
			$result=mysqli_query($conn, $sql);
			$resultCheck=mysqli_num_rows($result);
			if ($resultCheck<=0) {
				header('Location:../adminIndex.php');
				exit();
			}
			else{
				$row=mysqli_fetch_assoc($result);
				$type=$row['E_Type'];
				$expiry=$row['E_IDValidity'];
				if ($type=='Permanent') {
					$expiryDate = date('Y-m-d', strtotime($expiry. ' + 5 years'));
				}
				else{
					$expiryDate = date('Y-m-d', strtotime($expiry. ' + 1 years'));	
				}
				$sql="UPDATE employee_job_details SET E_IDValidity='$expiryDate' WHERE E_EmpID='$id'";
				mysqli_query($conn,$sql);
				header('Location:../empDetails.php?id='.$id);
				exit();
			}
		}
	}
?>