
<?php 
include('connection.php');
include('header.php');
if (isset($_POST['btnUpdate']))
 {
 	$RawMaterialsID=$_POST['txtRawMaterialsID'];
	$txtRawMaterialsName=$_POST['txtRawMaterialsName'];
	$RegisterDate=$_POST['RegisterDate'];
	$txtPrice=$_POST['txtPrice'];
	$txtQuantity=$_POST['txtQuantity'];

		$Update="UPDATE RawMaterials
			 SET 
			 RawMaterialsName='$txtRawMaterialsName',
			 RegisterDate='$RegisterDate',
			 Price='$txtPrice',
			 Quantity='$txtQuantity',
			 WHERE
			 RawMaterialsID='$txtRawMaterialsID'
			 ";
		$ret=mysqli_query($connection,$Update);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : RawMaterials  Update.')</script>";
			echo "<script>window.location='RawMaterialsEntry.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in RawMaterials Update" . mysqli_error($connection) . "</p>";
		}

	}
if(isset($_GET['RawMaterialsID']))

{
	$RawMaterialsID=$_GET['RawMaterialsID'];

	$RawMaterials_Query="SELECT * 
			  FROM RawMaterials 
			  WHERE RawMaterialsID='$RawMaterialsID'";

	$RawMaterials_ret=mysqli_query($connection,$RawMaterials_Query);
	$RawMaterials_rows=mysqli_fetch_array($RawMaterials_ret);
	$RCount=mysqli_num_rows($RawMaterials_ret);

	if ($RCount < 1) 
	{
		echo "<script>window.alert('ERROR : RawMaterials Not Found.')</script>";
		echo "<script>window.location='RawMaterialsEntry.php'</script>";
	}
}
else
{
	$SupplierID="";
	echo "<script>window.location='RawMaterialsEntry.php'</script>";
}


 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>RawMaterials Update</title>
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>
</head>
<body>
	<form action="RawMaterialsUpdate.php" method="POST">
	<fieldset>
		<legend>Update Information :</legend>
	<table>
			<tr>
				<td>RawMaterials Name</td>
				<td>
					:<input type="text" name="txtRawMaterials" 
					value="<?php echo $RawMaterials_rows['RawMaterialsName'] ?>" required  />
					<input type="hidden" name="txtRawMaterialsID" value="<?php echo $RawMaterialsID ?>" />
				</td>
			</tr>
				<td>Reg Date</td>
				<td>
					:<input type="date" name="RegisterDate" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" readonly />
				</td>			 
			</tr>
			<tr>
				<td>Price</td>
				<td>
					:<input type="number" name="txtPrice" value="<?php echo $RawMaterials_rows['Price'] ?>" required />
				</td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td>
					:<input type="number" name="txtQuantity" value="<?php echo $RawMaterials_rows['Quantity'] ?>" required />
				</td>
			</tr>

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