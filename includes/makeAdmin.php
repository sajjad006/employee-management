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
			$sql="SELECT * FROM employee_personal_details WHERE E_EmpID='$id'";
			$result=mysqli_query($conn, $sql);
			$resultCheck=mysqli_num_rows($result);
			if ($resultCheck<=0) {
				header('Location:../adminIndex.php');
				exit();
			}
			else{
				$sql="UPDATE userinfo SET Usertype='Admin' WHERE Username='$id'";
				mysqli_query($conn,$sql);
				header('Location:../empDetails.php?id='.$id);
				exit();
			}
		}
	}
?>