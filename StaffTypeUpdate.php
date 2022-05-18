<?php  
include('connection.php');

if(isset($_POST['btnUpdate'])) 
{
	$txtStaffTypeID=$_POST['txtStaffTypeID'];
	$txtStaffType=$_POST['txtStaffType'];
	$txtStatus=$_POST['txtStatus'];

	$Update="UPDATE StaffType
			 SET 
			 StaffType='$txtStaffType',
			 Status='$txtStatus'
			 WHERE
			 StaffTypeID='$txtStaffTypeID'
			 ";
	$ret=mysqli_query($connection,$Update);

	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : StaffType Updated.')</script>";
		echo "<script>window.location='StaffTypeUpdate.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in StaffType Update" . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['StaffTypeID'])) 
{
	$StaffTypeID=$_GET['StaffTypeID'];

	$StaffType_Query="SELECT * 
			  FROM StaffType WHERE 
			  StaffTypeID='$StaffTypeID'";

	$StaffType_ret=mysqli_query($connection,$StaffType_Query);
	$StaffType_rows=mysqli_fetch_array($StaffType_ret);
	$STypeCount=mysqli_num_rows($StaffType_ret);

	if ($STypeCount < 1) 
	{
		echo "<script>window.alert('ERROR : Staff Type Profile Not Found.')</script>";
		echo "<script>window.location='StaffType.php'</script>";
	}
}
else
{
	$StaffTypeID="";
	echo "<script>window.location='StaffType.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>StaffType Update</title>
</head>

<body>
<form action="StaffTypeUpdate.php" method="post">
	
<fieldset>
<legend>Enter StaffType Info for Update:</legend>
<table>

<input type="hidden" name="txtStaffTypeID" value="<?php echo $StaffTypeID ?>" required />

<tr>
	<td>StaffType</td>
	<td>
	<input type="text" name="txtStaffType" value="<?php echo $StaffType_rows['StaffType'] ?>" required />
	</td>
</tr>
<tr>
	<td>Status</td>
	<td>
	<input type="text" name="txtStatus" value="<?php echo $StaffType_rows['Status'] ?>"required />
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