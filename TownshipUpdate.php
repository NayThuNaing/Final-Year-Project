<?php  
include('connection.php');
include('header.php');
if(isset($_POST['btnUpdate'])) 
{
	$txtTownshipID=$_POST['txtTownshipID'];
	$txtTownshipName=$_POST['txtTownshipName'];
	$txtDeliveryCost=$_POST['txtDeliveryCost'];

	$Update="UPDATE Township
			 SET 
			 TownshipName='$txtTownshipName',
			 DeliveryCost='$txtDeliveryCost'
			 WHERE
			 TownshipID='$txtTownshipID'
			 ";
	$ret=mysqli_query($connection,$Update);

	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : TownshipID Updated.')</script>";
		echo "<script>window.location='TownshipUpdate.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in Township Update" . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['TownshipID'])) 
{
	$TownshipID=$_GET['TownshipID'];

	$Township_Query="SELECT * 
			  FROM Township WHERE 
			  TownshipID='$TownshipID'";

	$Township_ret=mysqli_query($connection,$Township_Query);
	$Township_rows=mysqli_fetch_array($Township_ret);
	$STypeCount=mysqli_num_rows($Township_ret);

	if ($STypeCount < 1) 
	{
		echo "<script>window.alert('ERROR : Township Profile Not Found.')</script>";
		echo "<script>window.location='Township.php'</script>";
	}
}
else
{
	$TownshipID="";
	echo "<script>window.location='Township.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Township Update</title>
</head>
<body>
<form action="TownshipUpdate.php" method="post">
	
<fieldset>
<legend>Enter Township Info for Update:</legend>
<table>

<input type="hidden" name="txtTownshipID" value="<?php echo $TownshipID ?>" required />

<tr>
	<td>Township name</td>
	<td>
	:<input type="text" name="txtTownshipName" value="<?php echo $Township_rows['TownshipName'] ?>" required />
	</td>
</tr>
<tr>
	<td>Delivery Cost</td>
	<td>
	<input type="text" name="txtDeliveryCost" value="<?php echo $Township_rows['DeliveryCost'] ?>"required />
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