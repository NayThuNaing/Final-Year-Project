<?php  
include('connection.php');
include('header.php');
if(isset($_POST['btnUpdate'])) 
{
	$txtProductID=$_POST['txtProductID'];
	$txtBrandName=$_POST['txtBrandName'];
	$txtProductName=$_POST['txtProductName'];
	$txtProductSize=$_POST['txtProductSize'];
	$txtPrice=$_POST['txtPrice'];
	$txtQuantity=$_POST['txtQuantity'];

	$txtDescription=$_POST['txtDescription'];

	$Update="UPDATE Product
			 SET 
			 ProductName='$txtProductName',
			 ProductSize='$txtProductSize',
			 Quantity='$txtQuantity',
			 Price='$txtPrice',
			 BrandName='$txtBrandName',
			 Desciption='$txtDescription',
			 WHERE
			 ProductID='$txtProductID'
			 ";
	$ret=mysqli_query($connection,$Update);

	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : Product Account Updated.')</script>";
		echo "<script>window.location='ProductEntry.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in Product Update" . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['ProductID'])) 
{
	$ProductID=$_GET['ProductID'];

	$Product_Query="SELECT *
			  FROM Product";

	$Product_ret=mysqli_query($connection,$Product_Query);
	$Product_rows=mysqli_fetch_array($Product_ret);
	$SCount=mysqli_num_rows($Product_ret);

	if ($SCount < 1) 
	{
		echo "<script>window.alert('ERROR : Product Profile Not Found.')</script>";
		echo "<script>window.location='ProductEntry.php'</script>";
	}
}
else
{
	$ProductID="";
	echo "<script>window.location='ProductEntry.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Update</title>
</head>
<body>
<form action="ProductUpdate.php" method="post">
	
<fieldset>
<legend>Enter Product Info for Update:</legend>
<table>
<tr>
	<td>Product Image</td>
	<td>
	<img src="<?php echo $Product_rows['Image1'] ?>" width="150px" height="150px"/>
	<input type="hidden" name="txtProductID" value="<?php echo $ProductID ?>" />
	</td>
</tr>
<tr>
	<td>Brand Name</td>
	<td>
	<input type="text" name="txtBrandName" value="<?php echo $Product_rows['BrandName'] ?>" required />
	</td>
</tr>
<tr>
	<td>Product Name</td>
	<td>
	<input type="text" name="txtProductName" value="<?php echo $Product_rows['ProductName'] ?>" required />
	</td>
</tr>
<tr>
	<td>Size <small>(Liters)</small></td>
	<td>
		<input type="text" name="txtProductSize" value="<?php echo $Product_rows['ProductSize'] ?>" required />
	</td>
</tr>
<tr>
	<td>Price</td>
	<td>
	<input type="text" name="txtPrice" value="<?php echo $Product_rows['Price'] ?>"required />
	</td>
</tr>
<tr>
	<td>Quantity</td>
	<td>
	<input type="text" name="txtQuantity" value="<?php echo $Product_rows['Quantity'] ?>" required />
	</td>
</tr>

<tr>
	<td>Description</td>
	<td>
	<textarea name="txtDescription"><?php echo $Product_rows['Description'] ?></textarea>
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