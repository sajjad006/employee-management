<?php
	session_start();
	if (isset($_POST['submit'])) {

		include_once 'dbConn.php';

		$id=htmlspecialchars($_SESSION['uname']);
		$OTP=htmlspecialchars($_POST['otp']);
		$password=htmlspecialchars($_POST['password']);
		$password_repeat=htmlspecialchars($_POST['password_repeat']);

		if (empty($OTP) || empty($password) || empty($password_repeat)) {
			$_SESSION['error']='empty';?>
			<script type="text/javascript">history.go(-1);</script><?php
			exit();
		}
		else{
			if ($password!==$password_repeat) {
				$_SESSION['error']='passsword';?>
				<script type="text/javascript">history.go(-1);</script><?php
				exit();
			}	
			else{
				if (strlen($password)<6) {
					echo "true";
					$_SESSION['error']='length';?>
					<script type="text/javascript">history.go(-1);</script><?php
					exit();
				}
				else{
					$currentTime=date("U");
					$sql="SELECT * FROM reset_password WHERE E_EmpID='$id' AND ExpiryTime>=$currentTime";
					$result=mysqli_query($conn,$sql);
					$resultCheck=mysqli_num_rows($result);
					if ($resultCheck<=0) {
						$_SESSION['error']='expired';?>
						<script type="text/javascript">history.go(-1);</script><?php
						exit();
					}
					else{
						$row=mysqli_fetch_assoc($result);
						$hashedOTP=$row['OTP'];

						if (!password_verify($OTP, $hashedOTP)) {
							$_SESSION['error']='otp';?>
							<script type="text/javascript">history.go(-1);</script><?php
							exit();
						}
						else{
							$hashedPassword=password_hash($password_repeat, PASSWORD_DEFAULT);
							$sql="UPDATE userinfo SET Password='$hashedPassword' WHERE Username='$id'";
							if (mysqli_query($conn,$sql)) {
								header('Location:../changePassword.php?change=success');
								exit();
							}
							else{
								$_SESSION['error']='db';?>
								<script type="text/javascript">history.go(-1);</script><?php
								exit();
							}

						}
					}
				}	
			}
		}
	}
	else{
		?><script type="text/javascript">history.go(-1);</script><?php
		exit();
	}
?>