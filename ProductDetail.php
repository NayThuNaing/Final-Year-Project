<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('ShoppingCartFunction.php');
include('CustomerHeader.php');

if (isset($_GET['btnAdd2Cart'])) 
{
	$txtProductID=$_GET['txtProductID'];
	$txtBuyQuantity=$_GET['txtBuyQuantity'];

	AddProduct($txtProductID,$txtBuyQuantity);
}

if (!isset($_SESSION['CustomerID'])) 
{
	echo "<script>window.alert('Please Login first to continue.')</script>";
	echo "<script>window.location='CustomerLogin.php'</script>";
}
else
{
	$ProductID=$_GET['ProductID'];
	
	$query="SELECT * FROM Product
			WHERE ProductID='$ProductID'";
	$result=mysqli_query($connection,$query);
	$count=mysqli_num_rows($result);
	
	if($count<1) 
	{
		echo "<script>window.alert('Product Information not Found.')</script>";
		echo "<script>window.location='ProductDisplay.php'</script>";
	}

	$arr=mysqli_fetch_array($result);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $arr['ProductName'] ?></title>
</head>
<body>
<form action="ProductDetail.php" method="get">

<hr/>
<table align="Center" border="0">
<tr>
	<td>
		<?php  
		$Image1=$arr['Image1'];
		$Image2=$arr['SideImage'];
		$Image3=$arr['Dozen'];
		list($width,$height,$type,$attr)=getimagesize($Image1);
		$w=$width/1.5;
		$h=$height/1.5;
		?>
		<img id="PImage" src="<?php echo $Image1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>"/>
		<hr/>
		<img src="<?php echo $Image1 ?>" width="108px" height="115px"
		onClick="document.getElementById('PImage').src='<?php echo $Image1 ?>' "/>

		<img src="<?php echo $Image2 ?>" width="108px" height="115px"
		onClick="document.getElementById('PImage').src='<?php echo $Image2 ?>' "/>

		<img src="<?php echo $Image3 ?>" width="108px" height="115px"
		onClick="document.getElementById('PImage').src='<?php echo $Image3 ?>' " />
	</td>
	<td>
		<table style="margin:20px;">
		<tr>
			<td><h3>Product Name</h3></td>
			<td>
				<h3>:<b><?php echo $arr['ProductName'] ?></h3></b>
			</td>
		</tr>
		<tr>
			<td><h3>BrandName</h3></td>
			<td>
				<h3>:<b><?php echo $arr['BrandName'] ?></h3></b>
			</td>
		</tr>
		<tr>
			<td><h3>Product Size (Liter)</h3></td>
			<td>
				<h3>:<b><?php echo $arr['ProductSize'] ?></b></h3>
			</td>
		</tr>
		
		<tr>
			<td><h3>Available Quantity</h3></td>
			<td>
				<h3>:<b><?php echo $arr['Quantity'] ?>  Bottle(s)</h3></b>
			</td>
		</tr>
		<tr>
			<td><h3>Order Quantity</h3></td>
			<td>
				<h3>:<input type="number" name="txtBuyQuantity" value="1" min="1" max="<?php echo $arr['Quantity']  ?>"/></h3>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
			<input type="hidden" name="txtProductID" value="<?php echo $ProductID ?>"/>
			</td>
		</tr>

		</table>
		<div class="col-md-12 col-md-offset-7">
					<button type="submit" name="btnAdd2Cart" class="btn btn-primary" value="Add 2 Cart" required/ >Add2Cart</button>
					
				</div>

	</td>
</tr>
<tr>
	<td colspan="2">
	<h3><b>Product Description</b></h3>
	<br/>
	<h3><?php echo $arr['Description'] ?></h3>
	</td>
</tr>
</table>

<hr/>
</form>
</body>
</html>
<?php 
include('CustomerFooter.php');
 ?>