
<?php 
include('connection.php');
include('CustomerHeader.php');
if (isset($_POST['btnSave']))
{
	$txtCustomerName=$_POST['txtCustomerName'];
	$txtEmail=$_POST['txtEmail'];
	$txtDescription=$_POST['txtDescription'];

		 $Insert="INSERT INTO `CustomerFeedback`(`CustomerName`, `Email`, `Description`) VALUES 
				 ('$txtCustomerName','$txtEmail','$txtDescription') ";
		$ret=mysqli_query($connection,$Insert);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Thanks you for your Feedback.')</script>";
			echo "<script>window.location='ProductDetail.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Feedback" . mysqli_error($connection) . "</p>";
		}


}

 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>Customer Feedback</title>
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
	<form action="CustomerFeedback.php" method="POST" >
	<fieldset>
		<legend><h1>Enter Customer Feedback Info:</h1></legend>
		
		<div class="container">
		<div class="row">
			<div class="form-group">
				<h3><label for="name" class="col-md-2 label-control">Name:</label></h3>
				<div class="col-md-6">
					<input type="text" id="name" name="txtCustomerName" placeholder="Enter Customer Name" class="form-control ">
				</div><br>
				 
				<h3><label for="email" class="col-md-2 label-control">Email:</label></h3>
				<div class="col-md-6">
					<input type="email" id="txtEmail" name="txtEmail" placeholder="example@gmail.com" class="form-control" required/ >
				</div><br>

				<h3><label for="Description" class="col-md-2 label-control">Description:</label></h3>
				<div class="col-md-6">
				<textarea name="txtDescription" id="txtDescription" rows="5" class="form-control" required/></textarea>
				</div><br><br><br><br><br><br>


				<div class="col-md-12 col-md-offset-2">
					<button type="submit" name="btnSave" class="btn btn-primary" required/ >Feedback</button>
					<button type="reset" name="btnClear" class="btn btn-default" required/ >Cancel</button>
				</div>
			
			
	</fieldset>
	
</form>
</body>
</html>
<hr>
<?php 
include('CustomerFooter.php');
 ?>