<?php 
include('connection.php');
include('header.php');
if (isset($_POST['btnSave']))
{
	$txtRawMaterialsName=$_POST['txtRawMaterialsName'];
	$RegisterDate=$_POST['RegisterDate'];
	$numPrice=$_POST['numPrice'];
	$txtQuantity=$_POST['txtQuantity'];

	$Insert="INSERT INTO RawMaterials
		(RawMaterialsName, RegisterDate, Price, Quantity) VALUES
			('$txtRawMaterialsName','$RegisterDate','$numPrice','$txtQuantity') ";
		$ret=mysqli_query($connection,$Insert);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : RawMaterials Item inserted.')</script>";
			echo "<script>window.location='RawMaterialsEntry.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in RawMaterials Entry" . mysqli_error($connection) . "</p>";
		}
}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Raw Materials Entry</title>
	<script type="text/javascript" src="js/jquery-3.1.1.slim.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
</head>
<body>
	<script>
	$(document).ready( function () {
		$('#tableid').DataTable();
	} );
</script>
	<form action="RawMaterialsEntry.php" method="POST" />
	<fieldset>
	<legend>Enter Raw Materials Information:</legend>
		<table>

			<tr>
			<td>RawMaterialsName</td>
			<td>
				:<input type="text" name="txtRawMaterialsName" placeholder="Enter RawMaterials Name ">
			</td>
			</tr>
			<tr>
				<td>RegisterDate</td>
					<td>
						:<input type="text" name="RegisterDate" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" readonly/>
					</td>
			</tr>
			<tr>
				<td>Price</td>
				<td>:<input type="number" name="numPrice" required /></td>
			</tr>	
			<td>Quantity:</td>
			<td>
					:<input type="text" name="txtQuantity" required />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input style="background-color:#11BA23;" type="submit" name="btnSave" value="Save"/>
					<input  style="background-color:#E22919;" type="reset" value="Clear"/>
				</td>		
			</tr>
		</table>
		</fieldset>
		<br>
		<br>
		<br>

		<fieldset>
			<legend>RawMaterials Listing: </legend>
			<?php 
	
		$RawMaterialsList="SELECT * FROM RawMaterials 
			WHERE RawMaterialsID=RawMaterialsID";
			
			
			$RawMaterials_ret=mysqli_query($connection,$RawMaterialsList);
			$RawMaterials_Count=mysqli_num_rows($RawMaterials_ret);

			if($RawMaterials_Count<1)
			{
				echo "<p> No RawMaterials Records Found </p>.";
			}
			else
			{

			 ?>
			 <table id="tableid" class="display" border="2">
			 	<thead>	
			 	<tr>
			 		<th>No.</th>
			 		<th>ID</th>
			 		<th>Type</th>
			 		<th>Date</th>
			 		<th>Price</th>
			 		<th>Quantity</th>
			 		<th>Action</th>
			 	</tr>
			 </thead>
			 	<?php 

			 	for($i=0;$i<$RawMaterials_Count;$i++)
			 	{
			 		$arr=mysqli_fetch_array($RawMaterials_ret);
			 		$RawMaterialsID=$arr['RawMaterialsID'];
			 		echo "<tr>";
			 		echo "<td>" . ($i+1) . "</td>";
			 		echo "<td>$RawMaterialsID</td>";

			 		echo "<td>" . $arr['RawMaterialsName'] . "</td>";
			 		echo "<td>" . $arr['RegisterDate'] . "</td>";
			 		echo "<td>" . $arr['Price'] . "</td>";
			 		echo "<td>" . $arr['Quantity'] . "</td>";
			 		echo "<td>
			 				<a href='RawMaterialsUpdate.php?RawMaterialsID=$RawMaterialsID'> Update</a> |
			 				<a href='RawMaterialsDelete.php?RawMaterialsID=$RawMaterialsID'>Delete</a>
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