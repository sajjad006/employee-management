<?php
	session_start();
	if (isset($_POST['submit'])) {
		include_once 'dbConn.php';
		include 'sms.php';

		$first_name=htmlspecialchars($_POST['emp_first_name']);
		$middle_name=htmlspecialchars($_POST['emp_middle_name']);
		$last_name=htmlspecialchars($_POST['emp_last_name']);
		$gender=htmlspecialchars($_POST['gender']);
		$sdwo=htmlspecialchars($_POST['sdwo']);
		$DOB=htmlspecialchars($_POST['date']);
		$bloodGroup=htmlspecialchars($_POST['blood']);

		$address_line1=htmlspecialchars($_POST['address_line_1'][0]);
		$address_line2=htmlspecialchars($_POST['address_line_2'][0]);
		$PO=htmlspecialchars($_POST['PO'][0]);
		$PS=htmlspecialchars($_POST['PS'][0]);
		$city=htmlspecialchars($_POST['City'][0]);
		$state=htmlspecialchars($_POST['State'][0]);
		$pincode=htmlspecialchars($_POST['Pincode'][0]);

		$p_address_line1=htmlspecialchars($_POST['address_line_1'][1]);
		$p_address_line2=htmlspecialchars($_POST['address_line_2'][1]);
		$p_PO=htmlspecialchars($_POST['PO'][1]);
		$p_PS=htmlspecialchars($_POST['PS'][1]);
		$p_city=htmlspecialchars($_POST['City'][1]);
		$p_state=htmlspecialchars($_POST['State'][1]);
		$p_pincode=htmlspecialchars($_POST['Pincode'][1]);

		$contactNumber=htmlspecialchars($_POST['Contact']);
		$Work_Email=htmlspecialchars($_POST['work_email']);
		$Personal_Email=htmlspecialchars($_POST['Personal_Email']);
		$Emergency_HomeName=htmlspecialchars($_POST['Emergency_HomeName']);
		$Emergency_HomeMobile=htmlspecialchars($_POST['Emergency_HomeMobile']);
		$Emergency_OfficeName=htmlspecialchars($_POST['Emergency_OfficeName']);
		$Emergency_OfficeMobile=htmlspecialchars($_POST['Emergency_OfficeMobile']);

		$placement=htmlspecialchars($_POST['placement']);
		$designation=htmlspecialchars($_POST['Designation']);
		$doj=htmlspecialchars($_POST['DOJ']);
		$type=htmlspecialchars($_POST['emp_type']);
		$pf=htmlspecialchars($_POST['PF_Code']);
		$esi=htmlspecialchars($_POST['ESI_Code']);

		$aadharNumber=htmlspecialchars($_POST['aadharNumber']);
		$voterNumber=htmlspecialchars($_POST['voterNumber']);
		$panNumber=htmlspecialchars($_POST['panNumber']);

		$bank=htmlspecialchars($_POST['bank']);
		$branch=htmlspecialchars($_POST['branch']);
		$ifsc=htmlspecialchars($_POST['ifsc']);
		$accountNumber=htmlspecialchars($_POST['accountNumber']);

		if ($type=='Permanent') {
			$expiryDate = date('Y-m-d', strtotime($doj. ' + 5 years'));
		}
		elseif ($type=='Temporary' || $type=='Contractual' || $type=='Writtners') {
			$expiryDate = date('Y-m-d', strtotime($doj. ' + 1 years'));
		}
		

		function validate($data)
		{
			return(preg_match("/^[A-Za-z ]*$/", $data));
		}

		function fileProcess($fileName,$destinaton)
		{
			$fileDestination='';
			if(!empty($_FILES[$fileName]['name'])){
				$image = $_FILES[$fileName]['tmp_name'];
				$name=$_FILES[$fileName]['name'];
				$allowed = array('jpeg','jpg','png');
				$fExt=explode('.', $name);
				$fActExt=strtolower(end($fExt));
				if (in_array($fActExt, $allowed)) {
					$fileNewName=uniqid('',true).".".$fActExt;
					$fileDestination=$destinaton.$fileNewName;
					move_uploaded_file($image, $fileDestination);
				}	
				else{
					$_SESSION['error']='file';
					?>
						<script type="text/javascript">history.go(-1);</script>
					<?php
					exit();
				}
			}	
			else{
				$fileDestination='upload/default-image.png';
			}
			return $fileDestination;
		}
	
		if (empty($first_name) || empty($gender) || empty($contactNumber)) {
			$_SESSION['error']='empty';
			?>
				<script type="text/javascript">history.go(-1);</script>
			<?php
			exit();
		}
		else{
			if (!validate($first_name) || !validate($middle_name) || !validate($last_name) || !validate($sdwo) || !validate($city) || !validate($Emergency_OfficeName) || !validate($Emergency_HomeName)) {
				$_SESSION['error']='validate';
				?>
					<script type="text/javascript">history.go(-1);</script>
				<?php
				exit();
			}
			else{
				if (strlen($contactNumber) >10 || strlen($Emergency_HomeMobile) > 10 ||  strlen($Emergency_OfficeMobile) > 10) {
					$_SESSION['error']='mobile';
					?>
						<script type="text/javascript">history.go(-1);</script>
					<?php
					exit();
				}
				else{
				
					$fileDestination=fileProcess('img','upload/EmployeeImage/');
					$adharFront=fileProcess('adharFront','upload/AadharImage/');
					$adharBack=fileProcess('adharBack','upload/AadharImage/');
					$voterFront=fileProcess('voterFront','upload/VoterImage/');
					$voterBack=fileProcess('voterBack','upload/VoterImage/');
					$panImage=fileProcess('panImage','upload/PanImage/');
					$passbook=fileProcess('passbook','upload/BankImage/');

					$YOJ=substr($doj, 0,4);
					$emp_ID=htmlspecialchars($_SESSION['uname']);
					$password=$_SESSION['password'];

					if($stmt=$conn->prepare("INSERT INTO `employee_personal_details` (`E_EmpID`, `E_First_Name`, `E_Middle_Name`, `E_Last_Name`, `E_Gender`, `E_Image`, `E_SDWO`, `E_DOB`, `E_BloodGroup`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")){
						$stmt->bind_param("sssssssss",$emp_ID, $first_name, $middle_name, $last_name, $gender, $fileDestination, $sdwo, $DOB, $bloodGroup);
						$stmt->execute();
						$stmt->close();

						if ($stmt=$conn->prepare("INSERT INTO employee_address_details(E_EmpID, E_ALine1, E_ALine2, E_PO, E_PS, E_City, E_State, E_Pincode, E_P_ALine1, E_P_ALine2, E_P_PO, E_P_PS, E_P_City, E_P_State, E_P_Pincode) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
							$stmt->bind_param("sssssssssssssss",$emp_ID, $address_line1, $address_line2, $PO, $PS, $city, $state, $pincode, $p_address_line1, $p_address_line2, $p_PO, $p_PS, $p_city, $p_state, $p_pincode);
							$stmt->execute();
							$stmt->close();

							if ($stmt=$conn->prepare("INSERT INTO `employee_contact_details` (`E_EmpID`, `E_Contact_Number`, `E_Work_Email`, `E_Personal_Email`, `E_Emergeny_HomeName`, `E_Emergency_HomeMobile`, `E_Emergeny_OfficeName`, `E_Emergency_OfficeMobile`) VALUES (?,?,?,?,?,?,?,?);")) {
								$stmt->bind_param("ssssssss",$emp_ID, $contactNumber, $Work_Email, $Personal_Email, $Emergency_HomeName, $Emergency_HomeMobile, $Emergency_OfficeName, $Emergency_OfficeMobile);
								$stmt->execute();
								$stmt->close();

								$status='Pending';
								if ($stmt=$conn->prepare("INSERT INTO employee_job_details(E_EmpID, E_Designation, E_DOJ, E_Type, E_PF_Code, E_ESI_Code, E_Placement, E_Status, E_IDValidity) VALUES(?,?,?,?,?,?,?,?,?)")) {
								
									$stmt->bind_param("sssssssss",$emp_ID,$designation, $doj, $type, $pf, $esi, $placement,$status,$expiryDate);
									$stmt->execute();
									$stmt->close();
									
									$usertype='Employee';
									
									if ($stmt=$conn->prepare("INSERT INTO employee_personal_documents (E_EmpID, E_Aadhar_Number, E_Aadhar_Front, E_Aadhar_Back, E_VoterID, E_Voter_Front, E_Voter_Back, E_PAN_Card, E_PAN_Image) VALUES (?,?,?,?,?,?,?,?,?)")) {
									
										$stmt->bind_param("sssssssss",$emp_ID, $aadharNumber, $adharFront, $adharBack, $voterNumber, $voterFront, $voterBack, $panNumber,$panImage);
										$stmt->execute();
										$stmt->close();

										if ($stmt=$conn->prepare("INSERT INTO employee_bank_details (E_EmpID, E_Bank_Name, E_Bank_Branch, E_Bank_IFSC, E_Bank_Account_Number, E_Bank_Image) VALUES (?,?,?,?,?,?)")) {
											$stmt->bind_param("ssssss",$emp_ID, $bank,$branch,$ifsc,$accountNumber,$passbook);
											$stmt->execute();
											$stmt->close();

											$sql="UPDATE userinfo SET ProfileStatus='Updated' WHERE Username='$emp_ID'";
											if (mysqli_query($conn,$sql)) {
												sendEmployeeAddNotification($emp_ID,$first_name);

												header('Location:../updateProfile.php?add=success');
												exit();
											}
											else{
												$_SESSION['error']='db';
												?>
													<script type="text/javascript">history.go(-1);</script>
												<?php
												exit();
											}
										}
										else{
											$_SESSION['error']='db';
											?>
												<script type="text/javascript">history.go(-1);</script>
											<?php
											exit();
										}
									}
									else{
										$_SESSION['error']='db';
										?>
											<script type="text/javascript">history.go(-1);</script>
										<?php
										exit();
									}
								}
								else{
									$_SESSION['error']='db';
									?>
										<script type="text/javascript">history.go(-1);</script>
									<?php
									exit();
								}
							}
							else{
								$_SESSION['error']='db';
								?>
									<script type="text/javascript">history.go(-1);</script>
								<?php
								exit();
							}
						}
						else{
							$_SESSION['error']='db';
							?>
								<script type="text/javascript">history.go(-1);</script>
							<?php
							exit();
						}
					}
					else{
						$_SESSION['error']='db';
						?>
							<script type="text/javascript">history.go(-1);</script>
						<?php
						exit();
					}
				}	
			}
		}
	}
	else{
		header('Location:../updateProfile.php?error=user');
		exit();
	}
?>