<?php 
include('connection.php');
include('header.php');
if (isset($_POST['btnSave']))
{
	$txtTownshipName=$_POST['txtTownshipName'];
	$txtDeliveryCost=$_POST['txtDeliveryCost'];

	$Insert="INSERT INTO `township`(`TownshipName`, `DeliveryCost`) 
			VALUES
			('$txtTownshipName','$txtDeliveryCost') ";
		$ret=mysqli_query($connection,$Insert);

		if($ret) //True
		{
			echo "<script>window.alert('SUCCESS : Township Name inserted.')</script>";
			echo "<script>window.location='Township.php'</script>";
		}
		else
		{
			echo "<p>Error : Something went wrong in Township Entry" . mysqli_error($connection) . "</p>";
		}
}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Township</title>
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
	<form action="Township.php" method="POST" />
	<fieldset>
	<legend>Enter Township Info:</legend>
		<table>

			<tr>
			<td>Township Name</td>
			<td>
				:<input type="text" name="txtTownshipName" placeholder="Enter Township Name " required />
			</td>
			</tr>
			
			<tr>
				<td>Delivery Cost</td>
				<td>:<input type="number" name="txtDeliveryCost" required /></td>
			</tr>	
			
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="btnSave" value="Save"/>
					<input type="reset" value="Clear"/>
				</td>		
			</tr>
		</table>
		</fieldset>
		<br>
		<br>
		<br>

		<fieldset>
			<legend>Township Listing: </legend>
			<?php 
	
		$TownshipList="SELECT * FROM township 
			WHERE TownshipID=TownshipID";
			
			
			$Township_ret=mysqli_query($connection,$TownshipList);
			$Township_Count=mysqli_num_rows($Township_ret);

			if($Township_Count<1)
			{
				echo "<p> No Township Records Found </p>.";
			}
			else
			{

			 ?>
			 <table id="tableid" class="display" border="2">
			 	<thead>	
			 	<tr>
			 		<th>No.</th>
			 		<th>ID</th>
			 		<th>Township Name</th>
			 		<th>Delivery Cost</th>
			 		<td>Action</td>
			 	</tr>
			 </thead>
			 	<?php 

			 	for($i=0;$i<$Township_Count;$i++)
			 	{
			 		$arr=mysqli_fetch_array($Township_ret);
			 		$TownshipID=$arr['TownshipID'];
			 		echo "<tr>";
			 		echo "<td>" . ($i+1) . "</td>";
			 		echo "<td>$TownshipID</td>";

			 		echo "<td>" . $arr['TownshipName'] . "</td>";
			 		echo "<td>" . $arr['DeliveryCost'] . "</td>";
	
			 		echo "<td>
			 				<a href='TownshipUpdate.php?TownshipID=$TownshipID'> Update</a> |
			 				<a href='TownshipDelete.php?TownshipID=$TownshipID'>Delete</a>
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