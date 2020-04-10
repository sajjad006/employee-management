<?php  ?>
<head>
<style type="text/css">
	body{
		margin: 0;padding: 0;
	}
	.topnav {
	  background-color: #ca67f9;
	  overflow: hidden;
	}

	/* Style the links inside the navigation bar */
	.topnav a {
	  float: left;
	  display: block;
	  color: white;
	  text-align: center;
	  padding: 14px 16px;
	  text-decoration: none;
	  font-size: 17px;
	}

	/* Change the color of links on hover */
	.topnav a:hover {
	  background-color: #ddd;
	  color: black;
	}

	/* Add an active class to highlight the current page */
	.active {
	  background-color: #4CAF50;
	  color: white;
	}

	/* Hide the link that should open and close the topnav on small screens */
	.topnav .icon {
	  display: none;
	}
	@media screen and (max-width: 600px) {
	  .topnav a:not(:first-child) {display: none;}
	  .topnav a.icon {
	    float: right;
	    display: block;
	  }
	}

	/* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
	@media screen and (max-width: 600px) {
	  .topnav.responsive {position: relative;}
	  .topnav.responsive a.icon {
	    position: absolute;
	    right: 0;
	    top: 0;
	  }
	  .topnav.responsive a {
	    float: none;
	    display: block;
	    text-align: left;
	  }
	}

	@media print{
		.non-printable{
			display: none;
		}
	}
</style>
<script type="text/javascript">
	function myFunction() {
	  var x = document.getElementById("myTopnav");
	  if (x.className === "topnav") {
	    x.className += " responsive";
	  } else {
	    x.className = "topnav";
	  }
	}
	
	window.onload = () => {
	   let bannerNode = document.querySelector('[alt="www.000webhost.com"]').parentNode.parentNode;
	   bannerNode.parentNode.removeChild(bannerNode);
	}

</script>
</head>	
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<div class="topnav non-printable" id="myTopnav">
	<?php
		if ($_SESSION['utype']=='Admin') {?>
			<a href="adminIndex.php"><i class="fa fa-home" aria-hidden="true"></i>  HOME</a>
		    <a href="addEmployee.php"><i class="fa fa-plus" aria-hidden="true"></i>  ADD EMPLOYEE</a>
		   	<a href="empDisplay.php"><i class="fa fa-search" aria-hidden="true"></i>  VIEW EMPLOYEE</a>
		    <a href="id.php"><i class="far fa-id-card"></i>  GENERATE ID CARD</a>
		    <a href="changePassword.php"><i class="fas fa-key"></i>  CHANGE PASSWORD</a>
		    <a href="logout.php"><i class="fas fa-sign-out-alt"></i>  LOGOUT</a>
		  	<a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
	<?php
		}
		elseif ($_SESSION['utype']=='Employee') {?>
			<a href="employeeIndex.php"><i class="fa fa-home" aria-hidden="true"></i>  HOME</a>
		    <a href="updateProfile.php"><i class="far fa-edit"></i>  UPDATE PROFILE</a>
		   	<a href="empDetails.php?id=<?php echo $_SESSION['uname'] ?>"><i class="fa fa-search" aria-hidden="true"></i>  VIEW PROFILE</a>
		    <a href="changePassword.php"><i class="fas fa-key"></i>  CHANGE PASSWORD</a>
		    <a href="logout.php"><i class="fas fa-sign-out-alt"></i>  LOGOUT</a>
		  	<a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
	<?php	
		}
	?>
</div>