<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('PurchaseOrder_Functions.php');
include('CustomerHeader.php');

if (!isset($_SESSION['CustomerID'])) 
{
	echo "<script>window.alert('Please Login first to continue.')</script>";
	echo "<script>window.location='CustomerLogin.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Display</title>
</head>
<hr>
<body>
<form action="ProductDisplay.php" method="post"/>

<fieldset>
	<h2><label for="Seaarch" class="col-md-2 label-control">SEARCH:</label></h2>

	<div class="col-md-6">
	<input type="text" name="txtData" id="txtData" placeholder="Search Product Here..."  class="form-control" />
	<!--<input type="submit" name="btnSearch" value="Search" />-->
	</div>
	<button type="submit" name="btnSearch" value="Search" class="btn btn-primary" id="btn">Search</button><br><br><br>

 
<table border="0" cellpadding="10px" style="margin:150px;">
<?php  
if (isset($_POST['btnSearch'])) 
{
	$txtData=$_POST['txtData'];

	$query1="SELECT * FROM Product
			 WHERE ProductName LIKE '%$txtData%'
			 OR Price='$txtData'
			 ORDER BY ProductID DESC";
	$result1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($result1);

	for($i=0;$i<$count1;$i+=4) 
	{ 
		$query2="SELECT * FROM Product 
				 WHERE ProductName LIKE '%$txtData%'
				 OR Price='$txtData' 
				 ORDER BY ProductID DESC
				 LIMIT $i,4";
		$result2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($result2);

		echo "<tr>";
		for ($x=0;$x<$count2;$x++) 
		{ 
			$arr=mysqli_fetch_array($result1);

			$Image1=$arr['Image1'];
			list($width,$height,$type,$attr)=getimagesize($Image1);
			$w=$width/3;
			$h=$height/3;

			$ProductID=$arr['ProductID'];
			$ProductName=$arr['ProductName'];
			$Price=$arr['Price'];
			?>
			<td align="Center">
				<img src="<?php echo $Image1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>"/>
				<br/>
				<b><?php echo $ProductName ?></b>
				<hr/>
				<h3><b><?php echo $Price ?></b> MMK</h3>
				<hr/>
				<a href="ProductDetail.php?ProductID=<?php echo $ProductID ?>">More.</a>
			</td>
			<?php
		}
		echo "</tr>";
	}
	
}
else
{
	$query1="SELECT * FROM Product 
			 ORDER BY ProductID DESC";
	$result1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($result1);

	for($i=0;$i<$count1;$i+=4) 
	{ 
		$query2="SELECT * FROM Product 
				 ORDER BY ProductID DESC
				 LIMIT $i,4";
		$result2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($result2);

		echo "<tr>";
		for ($x=0;$x<$count2;$x++) 
		{ 
			$arr=mysqli_fetch_array($result1);

			$Image1=$arr['Image1'];
			list($width,$height,$type,$attr)=getimagesize($Image1);
			$w=$width/1.2;
			$h=$height/1.2;

			$ProductID=$arr['ProductID'];
			$ProductName=$arr['ProductName'];
			$Price=$arr['Price'];
			?>
			<td align="Center">
				<img src="<?php echo $Image1 ?>" width="<?php echo $w ?>" height="<?php echo $h ?>"/>
				<br/>
				<b><h3><?php echo $ProductName ?></h3></b>
				<hr/>
				<h3><b><?php echo $Price ?></b> MMK</h3>
				<hr/>
				<button type="submit" class="btn btn-primary" name="btnSave" value="Save" required/><a style="color:white;" href="ProductDetail.php?ProductID=<?php echo $ProductID ?>">More...</a></button>
			</td>
			<?php
		}
		echo "</tr>";
	}
}	
?>

</table>
</form>
</body>
</html>
<hr>
<?php 
include('CustomerFooter.php');
 ?>