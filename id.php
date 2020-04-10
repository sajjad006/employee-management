<?php
	session_start();
	if (empty($_SESSION['uname']) || empty($_SESSION['pass']) || empty($_SESSION['utype']) || $_SESSION['utype'] !== 'Admin') {
		header('Location:index.php');
		exit();
	}
	else{
		include_once 'includes/dbConn.php';
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>BULK ID GENERATION | CREATIVE TECHNOTEX PVT LTD</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		table, th, td{
			text-align: center;
			padding: 20px;
			border: 1px solid black;border-collapse: collapse;
		}
		th, td{
			width: 200px;
		}
		tr:nth-child(even){
			background-color: #dae0ea;
		}
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
		#generate{
			margin: 40px;background-color: yellow;width: 200px;height: 40px;
		}
		@media screen and (max-width: 600px) {

			table, th, td{
				width: 90%;
				padding: 10px 0px 10px 0px;
			}
		}
	</style>

	<script type="text/javascript">

		function checkAll(ele) {
			var checkboxes = document.getElementsByTagName('input');
		    if (ele.checked) {
		        for (var i = 0; i < checkboxes.length; i++) {
		            if (checkboxes[i].type == 'checkbox') {
		                checkboxes[i].checked = true;
		            }
		        }
		    } else {
		        for (var i = 0; i < checkboxes.length; i++) {
		            console.log(i)
		            if (checkboxes[i].type == 'checkbox') {
		                checkboxes[i].checked = false;
		            }
		        }
		    }
		}

	</script>
</head>
<body>
	
	<?php include_once 'includes/nav.php'; ?>
	
	<?php
		$sql="SELECT * FROM employee_personal_details INNER JOIN employee_job_details ON employee_personal_details.E_EmpID=employee_job_details.E_EmpID WHERE employee_job_details.E_Status='Active' ORDER BY employee_personal_details.E_EmpID ASC";
		$result=mysqli_query($conn,$sql);
		$resultCheck=mysqli_num_rows($result);
		if ($resultCheck<=0) {
			echo "<p><b>Sorry you do not have any employees</b></p>";
			exit();
		}
		else{
			echo "<p align='center'><b>Select the name(s) of the employee(s) to generate ID card:</b></p>";
			?>

			<center>
				<label><u><b>Select all :</b></u></label>
				<input type="checkbox" name="all" onchange="checkAll(this)">
			</center>

			<form method="POST" action="idDisplay2.php">
				<center>
					<table>
						<tr>
							<th>Employee ID.</th>
							<th>Employee Name</th>
							<th>Generate</th>
						</tr>
						<?php
							while ($row=mysqli_fetch_assoc($result)) {
								$employee_id=$row['E_EmpID'];
								$name=$row['E_First_Name']." ".$row['E_Middle_Name']." ".$row['E_Last_Name'];

								$sql2="SELECT * FROM userinfo WHERE Username='$employee_id'";
								$result2=mysqli_query($conn,$sql2);
								$row2=mysqli_fetch_assoc($result2);
								$status=$row2['ProfileStatus'];
								if ($status=='Approved') {?>
									<tr>
										<td><?php echo $row['E_EmpID']; ?></td>
										<td><?php echo $name; ?></td>
										<td><input style="margin-left: auto;margin-right: auto;display: block;" type="checkbox" name="id[]" value="<?php echo $row['E_EmpID'] ?>"></td>
									</tr>
									<?php
								}	
							}
						?>
					</table>

					<input id="generate" type="submit" name="submit" value="GENERATE">
				</center>
			</form>	
			<?php
		}
	?>	
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>