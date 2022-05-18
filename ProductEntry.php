<?php 
include('connection.php');
include('AutoID_Functions.php');
include('header.php');
if (isset($_POST['btnSave']))
{
	$txtProductID=$_POST['txtProductID'];
	$txtProductName=$_POST['txtProductName'];
	$txtProductSize=$_POST['txtProductSize'];
	$numQty=$_POST['numQty'];
	$numPrice=$_POST['numPrice'];
	$txtBrandName=$_POST['txtBrandName'];
	$txtDescription=$_POST['txtDescription'];

//Upload Product Images1.............................


	$Image1=$_FILES['Image1']['name'];//xy.jpg
	$Folder="../ProductImages/";

	$filename=$Folder . "_" . $Image1;//StaffImage/_xy.jpg
	$copy=copy($_FILES['Image1']['tmp_name'], $filename);
	if(!$copy)
	{
		echo "<p>Cannot upload ProductImage.</p>";
		exit();
	}

	//Upload Product Images1.............................

	$Image2=$_FILES['Image2']['name'];//xy.jpg
	$Folder="../ProductImages/";

	$filename2=$Folder . "_" . $Image2;//StaffImage/_xy.jpg
	$copy2=copy($_FILES['Image2']['tmp_name'], $filename2);
	if(!$copy2)
	{
		echo "<p>Cannot upload ProductImage2.</p>";
		exit();
	}
//Upload Product Images2.............................

	$Image3=$_FILES['Image3']['name'];//xy.jpg
	$Folder="../ProductImages/";

	$filename3=$Folder . "_" . $Image3;//StaffImage/_xy.jpg
	$copy3=copy($_FILES['Image3']['tmp_name'], $filename3);
	if(!$copy3)
	{
		echo "<p>Cannot upload ProductImage3.</p>";
		exit();
	}

	//Upload Product Images3.............................


	$check="SELECT * FROM product WHERE ProductID='$txtProductID' ";
	$ret=mysqli_query($connection,$check) or die(mysqli_error($connection));
	$count=mysqli_num_rows($ret);

	if($count > 0) 
	{
		echo "<script>window.alert('ERROR : Product ID is already exist!.')</script>";
		echo "<script>window.location='ProductEntry.php'</script>";
	}
	else
	{
		 $Insert="INSERT INTO  `product`(`ProductID`, `ProductName`, `ProductSize`, `Quantity`, `Price`, `BrandName`, `Description`, `Image1`, `SideImage`, `Dozen`)  VALUES 
				 ('$txtProductID','$txtProductName','$txtProductSize','$numQty','$numPrice','$txtBrandName','$txtDescription','$filename','$filename2','$filename3') ";
		$ret=mysqli_query($connection,$Insert);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Product is Inserted.......')</script>";
			echo "<script>window.location='ProductEntry.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Product Entry" . mysqli_error($connection) . "</p>";
		}
	}
}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Product Entry</title>
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

<form action="ProductEntry.php" method="POST" enctype="multipart/form-data" >
	<fieldset>
	<legend>Enter Product Info:</legend>
		<table>

			<tr><td>ProductID</td>
		<td>
			: <input type="text" name="txtProductID" value="<?php echo AutoID('product','ProductID','PUR-',6) ?>" readonly/>
		</td>
				
				<td>Brand Name</td>
				<td>
					:<input type="text" name="txtBrandName" placeholder="Enter Brand Name" required />
				</td>
			</tr>
			<tr>
				<td>Product Name</td>
				<td>
					:<input type="text" name="txtProductName" placeholder="Enter Product Name "  required />
				</td>

				<td>Size(Liter)</td>
				<td>:<input type="text" name="txtProductSize"></td>
			</td>

			</tr>
			<tr>
				<td>Image1</td>
				<td>
					:<input type="file" name="Image1" required />
				</td>
				<td>Price</td>
				<td>
					:<input type="number" name="numPrice" required />
				</td>
				
			</tr>
			<tr>
				<td>Image2</td>
				<td>
					:<input type="file" name="Image2" required />
				</td>
				<td>Qty</td>
				<td>:<input type="number" name="numQty" required /></td>
			</tr>
			<tr>
				<td>Image3</td>
				<td>
					:<input type="file" name="Image3" required />
				</td>

			</tr>
			<tr>
				
				<td>Description</td>
				<td>:<textarea name="txtDescription" required /></textarea></td>
			
			</tr>
			<tr>
				<td></td>
				<td>
					:<input type="submit" name="btnSave" value="Save"/>
					 <input type="reset" value="Clear"/>
				</td>		
			</tr>
		</table>
		</fieldset>

		<!--Product Listing..................-->
		<br>
		<br>
		<br>

		<fieldset>
			<legend>Product Listing: </legend>
			<?php 
	
		$ProductList="SELECT * 
					FROM Product";
			
		
			$Product_ret=mysqli_query($connection,$ProductList);
			$Product_Count=mysqli_num_rows($Product_ret);

			if($Product_Count<1)
			{
				echo "<p> No Product Records Found </p>.";
			}
			else
			{

			 ?>
			 <table id="tableid" class="display" border="2">
			 	<thead>	
			 	<tr>
			 		<th>No.</th>
			 		<th>Image1</th>
			 		<th>Image2</th>
			 		<th>Image3</th>  
			 		<th>Name</th>
			 		<th>Size(Liter)</th>
			 		<th>Price</th>
			 		<th>Qty</th>
			 		<th>Action</th>
			 	</tr>
			 </thead>
			 	<?php 

			 	for($i=0;$i<$Product_Count;$i++)
			 	{
			 		$arr=mysqli_fetch_array($Product_ret);
			 		$ProductID=$arr['ProductID'];
			 		$Image1=$arr['Image1'];
			 		$Image2=$arr['SideImage'];
			 		$Image3=$arr['Dozen'];

			 		echo "<tr>";
			 		echo "<td>" . ($i+1) . "</td>";
			 		echo "<td> <img src='$Image1' width='100px' height='100px' /> </td>";
			 		echo "<td> <img src='$Image2' width='100px' height='100px' /> </td>";
			 		echo "<td> <img src='$Image3' width='100px' height='100px' /> </td>";

			 		echo "<td>" . $arr['ProductName'] . "</td>";
			 		echo "<td>" . $arr['ProductSize'] . "</td>";
			 		echo "<td>" . $arr['Price'] . "</td>";
			 		echo "<td>" . $arr['Quantity'] . "</td>";
			 		echo "<td>
			 				<a href='ProductUpdate.php?ProductID=$ProductID'> Update</a> |
			 				<a href='ProductDelete.php?ProductID=$ProductID'>Delete</a>
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

</body>
</html>