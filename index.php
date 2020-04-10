<!DOCTYPE html>
<html>
<head>
	<title>SIGN IN | CREATIVE TECHNOTEX PVT LTD</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		body{
			font-family: Arial, Helvetica, sans-serif;
			background-image: url(images/background2.jpg);
			color: #ffffff;
		}
		input[type='text'],input[type='password']{
			padding: 5px;
			font-size: 1em;
			display: inline-block;
		}
		label{
			display: inline-block;font-size: 1.5em;
		}
		#submit{
			background-color: #ca67f9;width: 200px;height: 40px;color: #ffffff;
		}
	</style>
</head>
<body>
	<center>
	<h1 style="margin-top: 10%;">SIGN IN </h1> 
	
	<div>
		<?php
		$error="";
		if (isset($_GET['error'])) {
			$error=htmlspecialchars($_GET['error']);
		}
		
		if ($error=="empty") {
			echo '<b><p style="color:red;">Please fill in all the fields</p></b>';
		}
		else if($error=="invalid"){
			echo '<b><p style="color:red;">Invalid username or password</p></b>';
		}
		if(isset($_GET['reset'])){
            if($_GET['reset']=='success'){
                echo '<b><p style="color:red;">Successfully changed your password</p></b>';    
            }
            else if($_GET['reset']=="failure"){
                echo '<b><p style="color:red;">Sorry couldnot change your password! Plese try again.</p></b>';
            }
        }
		?>
			<form action="includes/signin_process.php" method="POST">
				<div style="">
					<label>USERNAME:</label>
					<input type="text" name="username" autocomplete="off"><br>
					<label>PASSWORD:</label>
					<input type="password" name="password"><br><br><br>
					<input id="submit" type="submit" name="submit" value="SIGN IN">		
				</div>
			</form>
		</center>	
	</div>
	<?php include_once 'includes/footer.php'; ?>
</body>
</html>