
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Water Template</title>
	<link rel="stylesheet" type="text/css" href="css/Bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style1.css">
	<link rel="stylesheet" type="text/css" href="css/all.min.css">
</head>
<body>
	<!--
	<nav>
			<ul class="nav nav-tabs">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				
				<li><a href="#"> <span class="glyphicon glyphicon-earphone"></span> Content</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
				<li><a href="Sign.html"> <span class="fas fa-sign-in-alt"></span>  Sigin</a></li>
			</ul>
		</nav>
	-->
	
	<div id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>MOON & SUN</h1>
				</div>
				<div class="col-md-12">
					<h3>Design By Template</h3>
				</div>
			</div>
		</div>
	</div>
		
		

	<!--
			<div class="col-md-12">
				<div class="small btn-group  visible-xs visible-sm">
					<div class="row">
						<div class="col-md-12">
							<button class="btn">HOME</button>
						</div>
						<div class="col-md-12">
							<button class="btn">TWO SIZWBAR</button>
						</div>
						<div class="col-md-12">
							<button class="btn">LEFT SIZEBAR</button>
						</div>
						<div class="col-md-12">
							<button class="btn">RIGHT SIZEBAR</button>
						</div>
						<div class="col-md-12">
							<button class="btn">NO SIZEBAR</button>
						</div>
					</div>
				</div>
			</div>
-->

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
						<div class="navbar-header">
							<button class="navbar-toggle" data-toggle="collapse" data-target="#Nav-down">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						
							<ul class="nav navbar-nav navbar-right">
								<li><a href="CustomerLogin.php"> <span class="fas fa-sign-in-alt"></span>  Login</a></li>
								<li><a href="CustomerEntry.php ">Register</a></li>
								<li><a href=""></a></li>
							</ul>
						</div>
					</nav>
					
				</div>
			</div>
		</div>
        


<?php 
include('connection.php');

if (isset($_POST['btnSave']))
{
	$txtCustomerName=$_POST['txtCustomerName'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$txtAddress=$_POST['txtAddress'];


	$fileImage=$_FILES['fileImage']['name'];
	$Folder="../CustomerImages/";

	$filename=$Folder . "_" . $fileImage;
	$copy=copy($_FILES['fileImage']['tmp_name'], $filename);


	if(!$copy)
	{
		echo "<p>Cannot Upload Image!</p>";
		exit();
	}
	$checkEmail="SELECT * FROM Customer WHERE Email='txtEmail'";
	$ret=mysqli_query($connection,$checkEmail) or die(mysqli_error($connection));
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('ERROR : Email Address already exist.')</script>";
		echo "<script>window.location='CustomerEntry.php'</script>";
	}
	else
	{
		 $Insert="INSERT INTO  `customer`(`CustomerName`, `Email`, `Password`, `Phone`, `Address`, `Image`) VALUES 
				 ('$txtCustomerName','$txtEmail','$txtPassword','$txtPhone','$txtAddress','$filename') ";
		$ret=mysqli_query($connection,$Insert);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Customer Account Created.')</script>";
			echo "<script>window.location='CustomerEntry.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Customer Entry" . mysqli_error($connection) . "</p>";
		}

	}

}

 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>Customer Entry</title>
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>
	
	
	<script type="text/javascript" src="js/jquery-3.1.1.slim.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
</head>
<body background="gray">

	<script>
	$(document).ready( function () {
		$('#tableid').DataTable();
	} );
</script>
	<form action="CustomerEntry.php" method="POST" enctype="multipart/form-data">
	<fieldset>
		<h1 style="align:center;">Enter Customer Info:</h1>
		<div class="container">
		<div class="row">
			<div class="form-group">
				<h3><label for="name" class="col-md-2 label-control">Name:</label></h3>
				<div class="col-md-6">
				<input type="text" id="name" name="txtCustomerName" placeholder="Enter User Name" class="form-control ">
				</div><br>
					
				<h3><label for="email" class="col-md-2 label-control">Email:</label></h3>

				<div class="col-md-6">
					<input type="email" id="email" name="txtEmail" placeholder="example@gmail.com" class="form-control ">
				</div><br>

				<h3><label for="password" class="col-md-2 label-control">Password:</label></h3>
				<div class="col-md-6">
				<input type="password" id="password" name="txtPassword" placeholder="Enter your Password" class="form-control" required/>
				</div><br>
			

				<h3><label for="Phone" class="col-md-2 label-control" >Phone No:</label></h3>
				<div class="col-md-6">
					<input type="text" id="phone" name="txtPhone" placeholder="+95 - - - - - - - - - -" class="form-control" required/ >
				</div><br>

				<h3><label for="file" class="col-md-2 label-control" >Image:</label></h3>
				<div class="col-md-6">
					<input type="file" id="file" name="fileImage" class="form-control" required/>
				</div><br>
			
				<h3><label for="address" class="col-md-2 label-control">Address:</label></h3>
				<div class="col-md-6">
					<input type="textarea" id="txtAddress" name="txtAddress" class="form-control" required/ >
				</div><br><br>

				<div class="col-md-12 col-md-offset-2">
					<button type="submit" class="btn btn-primary" name="btnSave" value="Save" required/ >Register</button>
					<button type="reset" name="Clear" class="btn btn-default" required/ >Cancel</button>
				</div>

			
		
	</fieldset>
	
</form>
</body>
</html>
<?php 
include('CustomerFooter.php');
 ?>