<?php 
 include('connection.php');
 include('header.php');
 if (isset($_POST['btnSave']))
 {
 	$txtStaffType=$_POST['txtStaffType'];
 	$txtStatus=$_POST['txtStatus'];

 	$checkType="SELECT * FROM StaffType WHERE StaffType='$txtStaffType' ";
	$ret=mysqli_query($connection,$checkType) or die(mysqli_error($connection));
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('ERROR : Staff Type already exist.')</script>";
		echo "<script>window.location='StaffType.php'</script>";
	}
	else
	{
		$Insert="INSERT INTO `StaffType`
		(`StaffType`, `Status`) VALUES
				('$txtStaffType','$txtStatus') ";
		$ret=mysqli_query($connection,$Insert);
 	if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Staff Type Created.')</script>";
			echo "<script>window.location='StaffType.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Staff Type" . mysqli_error($connection) . "</p>";
		}
 	}
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Type</title>
	<script type="text/javascript" src="js/jquery-3.1.1.slim.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
</head>
<body>
	<script>
	$(document).ready( function () 
	{
		$('#tableid').DataTable();
	} );
	</script>
	<form action="StaffType.php" method="POST">
		<fieldset>
			<legend>Please Enter Staff Type</legend>
			<table>
				<tr>
					<td>Staff Type</td>
					<td><input type="text" name="txtStaffType" required /></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><input type="text" name="txtStatus"></td>

				</tr>
				<tr>
					<td></td>
					<td>
						<input style="background-color:#11BA23" type="submit" name="btnSave" value="Save" />
						<input style="background-color:#E22919;" type="reset" name="Clear" />
					</td>
				</tr>
			</table>
		</fieldset>
		<br>
		<br>
		<fieldset>
			<legend>Staff Type Listing :</legend>
<?php 
			$StaffTypeList="SELECT * FROM StaffType";
			
			$StaffType_ret=mysqli_query($connection,$StaffTypeList);
			$StaffType_count=mysqli_num_rows($StaffType_ret);

			if($StaffType_count<1)
			{
				echo "<p> No Staff Records Found </p>.";
			}
			else
			{

			 ?>
			 <table id="tableid" class="display" border="1">
			 	<thead>	
			 	<tr>
			 		<th>No.</th>
			 		<th>ID</th>
			 		<th>Staff Type</th>
			 		<th>Status</th>
			 		<th>Actions</th>
			 	</tr>
			 </thead>
			 	<?php 

			 	for($i=0;$i<$StaffType_count;$i++)
			 	{
			 		$arr=mysqli_fetch_array($StaffType_ret);
			 		$StaffTypeID=$arr['StaffTypeID'];
			 		

			 		echo "<tr>";
			 		echo "<td>" . ($i+1) . "</td>";
			 		echo "<td>$StaffTypeID</td>";
			 		echo "<td>" . $arr['StaffType'] . "</td>";
			 		echo "<td>" . $arr['Status'] . "</td>";
			 		echo "<td>
			 				<a href='StaffTypeUpdate.php?StaffTypeID=$StaffTypeID'> Update</a> |
			 				<a href='StaffTypeDelete.php?StaffTypeID=$StaffTypeID'>Delete</a>
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