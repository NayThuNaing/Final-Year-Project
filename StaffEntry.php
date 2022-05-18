
<?php 

include('connection.php');
include('header.php');
if (isset($_POST['btnSave']))
{
	$txtStaffName=$_POST['txtStaffName'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$cboStaffTypeID=$_POST['cboStaffTypeID'];
	$txtSalary=$_POST['txtSalary'];

	$txtAddress=$_POST['txtAddress'];
	
	//Image Upload start-------
	$fileStaffImage=$_FILES['fileStaffImage']['name'];//xy.jpg
	$Folder="../StaffImages/";

	$filename=$Folder . "_" . $fileStaffImage;//StaffImage/_xy.jpg
	$copy=copy($_FILES['fileStaffImage']['tmp_name'], $filename);
	if(!$copy)
	{
		echo "<p>Cannot upload StaffImage.</p>";
		exit();
	}
	
	$checkEmail="SELECT * FROM Staff WHERE Email='$txtEmail' ";
	$ret=mysqli_query($connection,$checkEmail) or die(mysqli_error($connection));
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('ERROR : Email Address already exist.')</script>";
		echo "<script>window.location='StaffEntry.php'</script>";
	}
	else
	{
		$Insert="INSERT INTO `staff`
		(`StaffName`, `Email`, `Password`, `Phone`,`StaffTypeID`,`Salary`, `Address`, `StaffImage`) VALUES
			('$txtStaffName','$txtEmail','$txtPassword','$txtPhone','$cboStaffTypeID','$txtSalary','$txtAddress', '$filename') ";
		$ret=mysqli_query($connection,$Insert);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Staff Account Created.')</script>";
			//echo "<script>window.location='StaffEntry.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Staff Entry" . mysqli_error($connection) . "</p>";
		}
	}
}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Staff Entry</title>
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



	<form action="StaffEntry.php" method="POST" enctype="multipart/form-data">
	<fieldset>
	<legend>Enter Staff Information:</legend>
		<table border="0" align="Left">
			<tr>
			
				<td>Staff Name:</td>
				<td><input type="text" name="txtStaffName" placeholder="Enter your name" required  /></td>
				<td>Email :</td>
				<td><input type="email" name="txtEmail" placeholder="example@email.com" required />
				</td>
				
			</tr>

			</tr>
			<tr>
				<td>Password :</td>
				<td><input type="Password" name="txtPassword" placeholder="XXXXXXXX" required /></td>
			
				<td>Phone :</td>
				<td><input type="text" name="txtPhone" placeholder="+95- - - - - -" required /></td>
			</tr>	

			<tr>
			<td>Staff Image:</td>
			<td><input type="file" name="fileStaffImage" required /></td>
			
			<td>Role :</td>
			<td>
				<select name="cboStaffTypeID" required/>
			<optgroup label="-Choose Staff Type-">
			<option>-Choose Staff Type-</option>
	<?php 
			$StaffType_Query="SELECT * FROM StaffType";
			$StaffType_Ret=mysqli_query($connection,$StaffType_Query);
			$Staff_Count=mysqli_num_rows($StaffType_Ret);

		for($i=0; $i<$Staff_Count;$i++) 
		{ 
			$rows=mysqli_fetch_array($StaffType_Ret);
			$StaffTypeID=$rows['StaffTypeID'];
			$StaffType=$rows['StaffType'];

			echo "<option value='$StaffTypeID'>$StaffTypeID - $StaffType</option>";
		}


	?>

</optgroup>
	</select>
			</td>

			</tr>
			<tr>
				<td>Address :</td>
				<td><textarea name="txtAddress"></textarea>
				</td>
				<td>Salary:</td>
				<td>
					<input type="text" name="txtSalary" required />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input style="background-color:#11BA23;" type="submit" name="btnSave" value="Save"/>
					<input style="background-color:#E22919;"type="reset" value="Clear"/>
				</td>
				
			</tr>

		</table>
		</fieldset>
		<br>
		<br>
		<br>

		<fieldset>
			<legend>Staff Listing : </legend>
			<?php 
			$StaffList="SELECT s.*, st.* FROM Staff s, StaffType st
			WHERE s.StaffTypeID=st.StaffTypeID";
			
			$Staff_ret=mysqli_query($connection,$StaffList);
			$Staff_count=mysqli_num_rows($Staff_ret);

			if($Staff_count<1)
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
			 		<th>Images</th>
			 		<th>ID</th>
			 		<th>Staff Name</th>
			 		<th>Phone</th>
			 		<th>Email</th>
			 		<th>StaffType</th>
			 		<th>Salary</th>
			 		<th>Action</th>
			 	</tr>
			 </thead>
			 	<?php 

			 	for($i=0;$i<$Staff_count;$i++)
			 	{
			 		$arr=mysqli_fetch_array($Staff_ret);
			 		$StaffID=$arr['StaffID'];
			 		$StaffImage=$arr['StaffImage'];

			 		echo "<tr>";
			 		echo "<td>" . ($i+1) . "</td>";
			 		echo "<td> <img src='$StaffImage' width='100px' height='100px' /> </td>";
			 		echo "<td>$StaffID</td>";

			 		echo "<td>" . $arr['StaffName'] . "</td>";
			 		echo "<td>" . $arr['Phone'] . "</td>";
			 		echo "<td>" . $arr['Email'] . "</td>";
			 		echo "<td>" . $arr['StaffType'] . "</td>";
			 		echo "<td>" . $arr['Salary'] . "</td>";
			 		echo "<td>
			 				<a href='StaffUpdate.php?StaffID=$StaffID'> Update</a> |
			 				<a href='StaffDelete.php?StaffID=$StaffID'>Delete</a>
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