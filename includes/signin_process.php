<?php

	session_start();
	if (isset($_POST['submit'])) {
		include_once("dbConn.php");
		$uinput=htmlspecialchars($_POST['username']);
		$password=htmlspecialchars($_POST['password']);
		if (empty($uinput) || empty($password)) {
			header("Location:../index.php?error=empty");
			exit();
		}
		else{
			$stmt=$conn->prepare("SELECT * FROM employee_job_details WHERE E_EmpID=?");
			$stmt->bind_param("s",$uinput);
			$stmt->execute();
			$result = $stmt->get_result();
			/**$sql="SELECT * FROM employee_job_details WHERE E_EmpID='$uinput'";**/
			if($result){
				$row=mysqli_fetch_assoc($result);
				$status=$row['E_Status'];
				if ($status=='Deactivated') {
					header('Location:../index.php?error=invalid');
					exit();
				}
				else{
					$hashPwd="";$username="";$mobno="";$email="";$usertype="";
					$sql="SELECT * FROM userinfo WHERE Username='$uinput'";
					$result=mysqli_query($conn, $sql);
					$resultCheck=mysqli_num_rows($result);
					if ($resultCheck>0) {
						$row=mysqli_fetch_assoc($result); 
						$hashPwd=$row['Password'];
						$username=$row['Username'];
						$usertype=$row['Usertype'];
						$profileStatus=$row['ProfileStatus'];

						if (password_verify($password, $hashPwd)) {
							$passCheck=true;
						}
						else{
							$passCheck=false;
						}

						if ($passCheck==false) {
							header("Location:../index.php?error=invalid");
							exit();
						}
						else if ($passCheck==true) {
							$_SESSION['uname']=htmlspecialchars($username);
							$_SESSION['pass']=htmlspecialchars($password);
							$_SESSION['utype']=htmlspecialchars($usertype);
							$_SESSION['profile']=htmlspecialchars($profileStatus);

							if ($usertype=='Employee') {
								header('Location:../employeeIndex.php');
								exit();
							}
							elseif ($usertype=='Admin') {
								header('Location:../adminIndex.php');
								exit();
							}
							else{
								header('Location:../index.php?error=invalid');
								exit();
							}
						}
					}
					else{
						header("Location:../index.php?error=invalid");
						exit();
					}
				}
			}
			else{
				header('Location:../index.php?error=invalid');
				exit();
			}
		}
	}
	else{
		header("Location:../index.php");
		exit();
	}
?>