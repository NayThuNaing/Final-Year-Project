<?php  
include('connection.php');
include('header.php');
if(isset($_POST['btnUpdate'])) 
{
	$txtStaffID=$_POST['txtStaffID'];
	$txtStaffName=$_POST['txtStaffName'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$numSalary=$_POST['numSalary'];
	$cboStaffTypeID=$_POST['cboStaffTypeID'];
	$txtAddress=$_POST['txtAddress'];

	$Update="UPDATE Staff
			 SET 
			 StaffName='$txtStaffName',
			 Email='$txtEmail',
			 Phone='$txtPhone',
			 Salary='$numSalary',
			 Password='$txtPassword',
			 StaffTypeID='$cboStaffTypeID',
			 Address='$txtAddress'
			 WHERE
			 StaffID='$txtStaffID'
			 ";
	$ret=mysqli_query($connection,$Update);

	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : Staff Account Updated.')</script>";
		echo "<script>window.location='StaffEntry.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in Staff Update" . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['StaffID'])) 
{
	$StaffID=$_GET['StaffID'];

	$Staff_Query="SELECT s.*,st.* 
			  FROM Staff s, StaffType st 
			  WHERE s.StaffID='$StaffID'
			  AND s.StaffTypeID=st.StaffTypeID";

	$Staff_ret=mysqli_query($connection,$Staff_Query);
	$Staff_rows=mysqli_fetch_array($Staff_ret);
	$SCount=mysqli_num_rows($Staff_ret);

	if ($SCount < 1) 
	{
		echo "<script>window.alert('ERROR : Staff Profile Not Found.')</script>";
		echo "<script>window.location='StaffEntry.php'</script>";
	}
}
else
{
	$StaffID="";
	echo "<script>window.location='StaffEntry.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Update</title>
</head>
<body>
<form action="StaffUpdate.php" method="post">
	
<fieldset>
<legend>Enter Staff Info for Update:</legend>
<table>
<tr>
	<td>Staff Image</td>
	<td>
	<img src="<?php echo $Staff_rows['StaffImage'] ?>" width="150px" height="150px"/>
	<input type="hidden" name="txtStaffID" value="<?php echo $StaffID ?>" />
	</td>
</tr>
<tr>
	<td>Staff Name</td>
	<td>
	<input type="text" name="txtStaffName" value="<?php echo $Staff_rows['StaffName'] ?>" required />
	</td>
</tr>
<tr>
	<td>Email</td>
	<td>
	<input type="email" name="txtEmail" value="<?php echo $Staff_rows['Email'] ?>"required />
	</td>
</tr>
<tr>
	<td>Password</td>
	<td>
	<input type="password" name="txtPassword" value="<?php echo $Staff_rows['Password'] ?>" required />
	</td>
</tr>
<tr>
	<td>Phone</td>
	<td>
	<input type="text" name="txtPhone" value="<?php echo $Staff_rows['Phone'] ?>" required />
	</td>
</tr>
<tr>
	<td>Phone</td>
	<td>
	<input type="number" name="numSalary" value="<?php echo $Staff_rows['Salary'] ?>" required />
	</td>
</tr>
<tr>
	<td>Role</td>
	<td>
	<select name="cboStaffTypeID">
	<option value="<?php echo $Staff_rows['StaffTypeID'] ?>">
				   <?php echo $Staff_rows['StaffType'] ?>
	</option>
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
	</select>
	</td>
</tr>
<tr>
	<td>Address</td>
	<td>
	<textarea name="txtAddress"><?php echo $Staff_rows['Address'] ?></textarea>
	</td>
</tr>
<tr>
	<td></td>
	<td>
	<input type="submit" name="btnUpdate" value="Update"/>
	<input type="reset" value="Clear"/>
	</td>
</tr>
</table>
</fieldset>

</form>
</body>
</html>
<?php 
include('footer.php');
 ?>