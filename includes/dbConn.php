<?php
	
	$server='localhost';
	$userid='root';
	$password='';
	$dbName='creativetechnotexpvtltd';

	$conn=mysqli_connect($server, $userid, $password, $dbName);

	if (!$conn) {
		header('Location:../addEmployee.php');
		exit();
	}

?>