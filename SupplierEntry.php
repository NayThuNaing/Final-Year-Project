
<?php 
include('connection.php');
include('header.php');
if (isset($_POST['btnSave']))
{
	$txtSupplierName=$_POST['txtSupplierName'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$RegisterDate=$_POST['RegisterDate'];
	$txtRole=$_POST['txtRole'];
	$txtAddress=$_POST['txtAddress'];


	$fileImage=$_FILES['fileImage']['name'];
	$Folder="../SupplierImages/";

	$filename=$Folder . "_" . $fileImage;
	$copy=copy($_FILES['fileImage']['tmp_name'], $filename);


	if(!$copy)
	{
		echo "<p>Cannot Upload Image!</p>";
		exit();
	}
	$checkEmail="SELECT * FROM Supplier WHERE Email='txtEmail'";
	$ret=mysqli_query($connection,$checkEmail) or die(mysqli_error($connection));
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('ERROR : Email Address already exist.')</script>";
		echo "<script>window.location='SupplierEntry.php'</script>";
	}
	else
	{
		 $Insert="INSERT INTO  `supplier`(`SupplierName`, `Email`, `Password`,
				 `Phone`, `RegisterDate`, `Role`, `Image`, `Address`) VALUES 
				 ('$txtSupplierName','$txtEmail','$txtPassword','$txtPhone','$RegisterDate','$txtRole','$filename', '$txtAddress') ";
		$ret=mysqli_query($connection,$Insert);

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

}

 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>Supplier Entry</title>
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
	<form action="SupplierEntry.php" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend>Enter Supplier Information :</legend>
		<table>
			<tr>
				<td>Supplier Name</td>
				<td>
					:<input type="text" name="txtSupplierName" placeholder="Enter Supplier Name" required />
				</td>
				<td>Email</td>
				<td>
					:<input type="email" name="txtEmail" placeholder="Enter Supplier Email Address" required />
				</td>			
			</tr>
			<tr><td>Password</td>
				<td>
					:<input type="password" name="txtPassword" placeholder="Enter Supplier Password" required />
				</td>
				<td>Phone</td>
				<td>
					:<input type="text" name="txtPhone" placeholder="+95- - - - - - - - - - - - - - -" required />
				</td>
			</tr>
				<tr>
					<td>RegisterDate</td>
					<td>
						:<input type="date" name="RegisterDate" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" readonly />
					</td>
					<td>Role</td>
					<td>
						:<input type="text" name="txtRole" placeholder="Enter Supplier Role" required />
					</td>
				</tr>
				<tr>
					<td>Image</td>
					<td>
						:<input type="file" name="fileImage" required />
					</td>
					
				</tr>
				<tr>
					<td>Address:</td>
					<td><textarea name="txtAddress"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input style="background-color:#11BA23;" type="submit" name="btnSave" required />
						<input style="background-color:#E22919;" type="reset" name="Clear" required />
					</td>
				</tr>
		</table>
	</fieldset>
	<br>
	<br>
	<fieldset>
		<legend>Supplier Listing</legend>
		<?php 
		$SupplierList="SELECT * FROM Supplier";
		$Supplier_ret=mysqli_query($connection,$SupplierList);
		$Supplier_count=mysqli_num_rows($Supplier_ret);
		if ($Supplier_count<1) 
		{
			echo "<P> No Found Supplier Record!.</p>";
		}else
			{

			 ?>
			 <table id="tableid" class="display" border="1">
			 	<thead>	
			 	<tr>
			 		<th>No.</th>
			 		<th>Images</th>
			 		<th>ID</th>
			 		<th>Supplier Name</th>
			 		<th>Phone</th>
			 		<th>Email</th>
			 		<th>Role</th>
			 		<th>Date</th>
			 		<th>Address</th>
			 		<th>Action</th>
			 	</tr>
			 </thead>
			 <?php 

			 	for($i=0;$i<$Supplier_count;$i++)
			 	{
			 		$arr=mysqli_fetch_array($Supplier_ret);
			 		$SupplierID=$arr['SupplierID'];
			 		$SupplierImage=$arr['Image'];

			 		echo "<tr>";
			 		echo "<td>" . ($i+1) . "</td>";
			 		echo "<td> <img src='$SupplierImage' with='100px' height='100px' /> </td>";
			 		echo "<td>$SupplierID</td>";

			 		echo "<td>" . $arr['SupplierName'] . "</td>";
			 		echo "<td>" . $arr['Phone'] . "</td>";
			 		echo "<td>" . $arr['Email'] . "</td>";
			 		echo "<td>" . $arr['Role'] . "</td>";
			 		echo "<td>" . $arr['RegisterDate'] . "</td>";
			 		echo "<td>" . $arr['Address'] . "</td>";
			 		echo "<td>
			 				<a href='SupplierUpdate.php?SupplierID=$SupplierID'> Update</a> |
			 				<a href='SupplierDelete.php?SupplierID=$SupplierID'>Delete</a>
			 				</td>";

			 		echo "</tr>";
			 	}
			 		 ?>
			 </table>
			 <?php 
			}

		 ?>
	</fieldset>
</form>
</body>
</html>
<?php 
include('footer.php');
 ?>