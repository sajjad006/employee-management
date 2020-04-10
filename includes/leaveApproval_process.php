<?php
	session_start();
	if (isset($_GET['result'])) {
		include_once 'dbConn.php';
		if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Admin') {
			header('Location:../index.php');
			exit();
		}
		else{
			if (empty($_GET['id'])) {
				header('Location:../adminIndex.php');
				exit();
			}
			else{
				$id=htmlspecialchars($_GET['id']);
				$result=htmlspecialchars($_GET['result']);
				if ($result=='a') {
					$sql="UPDATE leaves SET Status='Confirmed' WHERE ID='$id'";
					if (mysqli_query($conn,$sql)) {
						header('Location:../leaveApproval.php?approve=success');
						exit();
					}
					else{
						header('Location:../leaveApproval.php?approve=failure');
						exit();
					}
				}
				elseif ($result=='r') {
					$sql="UPDATE leaves SET Status='Rejected' WHERE ID='$id'";
					if (mysqli_query($conn,$sql)) {
						header('Location:../leaveApproval.php?reject=success');
						exit();
					}
					else{
						header('Location:../leaveApproval.php?reject=failure');
						exit();
					}
				}
				else{
					header('../leaveApproval.php');
					exit();
				}
			}
		}
	}
	else{
		header('../adminIndex.php');
		exit();
	}
?>