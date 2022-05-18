
<?php 
include('connection.php');
include('header.php');
if (isset($_POST['btnUpdate']))
 {
 	$txtSupplierID=$_POST['txtSupplierID'];
	$txtSupplierName=$_POST['txtSupplierName'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$txtRole=$_POST['txtRole'];
	$txtAddress=$_POST['txtAddress'];

		$Update="UPDATE Supplier
			 SET 
			 SupplierName='$txtSupplierName',
			 Email='$txtEmail',
			 Password='$txtPassword',
			 Phone='$txtPhone',
			 Role='$txtRole',
			 Address='$txtAddress'
			 WHERE
			 SupplierID='$txtSupplierID'
			 ";
		$ret=mysqli_query($connection,$Update);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Supplier Account Created.')</script>";
			echo "<script>window.location='SupplierEntry.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Supplier Entry" . mysqli_error($connection) . "</p>";
		}

	}
if(isset($_GET['SupplierID']))

{
	$SupplierID=$_GET['SupplierID'];

	$Supplier_Query="SELECT * 
			  FROM Supplier 
			  WHERE SupplierID='$SupplierID'";

	$Supplier_ret=mysqli_query($connection,$Supplier_Query);
	$Supplier_rows=mysqli_fetch_array($Supplier_ret);
	$SCount=mysqli_num_rows($Supplier_ret);

	if ($SCount < 1) 
	{
		echo "<script>window.alert('ERROR : Supplier Profile Not Found.')</script>";
		echo "<script>window.location='SupplierEntry.php'</script>";
	}
}
else
{
	$SupplierID="";
	echo "<script>window.location='SupplierEntry.php'</script>";
}


 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>Supplier Entry</title>
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>
</head>
<body>
	<form action="SupplierUpdate.php" method="POST">
	<fieldset>
		<legend>Update Information :</legend>
	<table>
	<tr>
	<td>Supplier Image</td>
	<td>
		<img src="<?php echo $Supplier_rows['Image'] ?>" width="150px" height="150px"/>
		<input type="hidden" name="txtSupplierID" value="<?php echo $SupplierID ?>" />
	</td>
	</tr>
			<tr>
				<td>Supplier Name</td>
				<td>
					:<input type="text" name="txtSupplierName" 
					value="<?php echo $Supplier_rows['SupplierName'] ?>" required  />
				</td>
				<td>Email</td>
				<td>
					:<input type="email" name="txtEmail" value="<?php echo $Supplier_rows['Email'] ?>"required />
				</td>			 
			</tr>
			<tr><td>Password</td>
				<td>
					:<input type="password" name="txtPassword" value="<?php echo $Supplier_rows['Password'] ?>" required />
				</td>
				<td>Phone</td>
				<td>
					:<input type="text" name="txtPhone" value="<?php echo $Supplier_rows['Phone'] ?>" required />
				</td>
			</tr>

				<tr>
					<td>Address:</td>
					<td><textarea name="txtAddress"><?php echo $Supplier_rows['Address'] ?></textarea></td>

					<td>Role</td>
					<td>
						:<input type="text" name="txtRole" value="<?php echo $Supplier_rows['Role'] ?>" required/>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="btnUpdate" value="Update" />
						<input type="reset" name="Clear" />
					</td>
				</tr>
		</table>
	</fieldset>
<?php 
include('footer.php');
 ?>