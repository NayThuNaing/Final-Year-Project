<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('Production_Functions.php');
include('header.php');


if(isset($_GET['btnSave'])) 
{
	$txtProductionID=$_GET['txtProductionID'];
	$txtProductionDate=$_GET['txtProductionDate'];
	$txtProductID=$_GET['txtProductID'];
	$txtQty=$_GET['txtQty'];
	$txtTotalRawPrice=$_GET['txtTotalRawPrice'];
	$txtTotalRawQty=$_GET['txtTotalRawQty'];
	$txtProductSize=$_GET['txtProductSize'];
	$Status="Pending";
	$StaffID=$_SESSION['StaffID'];


	//Insert Data to Production Table
	$Insert1="INSERT INTO `production`(`ProductionID`, `ProductionDate`, `ProductID`, `Qty`, `TotalRawPrice`, `TotalRawQty`, `ProductSize`, `StaffID`) VALUES 
			  ('$txtProductionID','$txtProductionDate','$txtProductID','$txtQty','$txtTotalRawPrice','$txtTotalRawQty','$txtProductSize','$StaffID')
			  ";
	$ret=mysqli_query($connection,$Insert1);

	//Insert Data to ProductionDetail Table

	$size=count($_SESSION['PROFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 
		//Get Data from Session Array
		$RawMaterialsID=$_SESSION['PROFunctions'][$i]['RawMaterialsID'];
		$RawPrice=$_SESSION['PROFunctions'][$i]['RawPrice'];
		$RawQuantity=$_SESSION['PROFunctions'][$i]['RawQuantity'];

		$Insert2="INSERT INTO `productiondetail`(`ProductionID`, `RawMaterialsID`, `RawQuantity`, `RawPrice`)
				  VALUES
				  ('$txtProductionID','$RawMaterialsID','$RawQuantity','$RawPrice')
				  ";
		$ret=mysqli_query($connection,$Insert2);
	}

	if($ret) //True
	{
		unset($_SESSION['PROFunctions']);
		
		echo "<script>window.alert('SUCCESS : Production Successfully Saved.')</script>";
		echo "<script>window.location='Production.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in Production" . mysqli_error($connection) . "</p>";
	}
}


if(isset($_GET['btnAdd'])) 
{
	$cboRawMaterialsID=$_GET['cboRawMaterialsID'];
	$txtRawPrice=$_GET['txtRawPrice'];
	$txtRawQuantity=$_GET['txtRawQuantity'];

	AddRawMaterials($cboRawMaterialsID,$txtRawPrice,$txtRawQuantity);
}

if(isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if ($action == "remove") 
	{
		$RawMaterialsID=$_GET['RawMaterialsID'];
		RemoveRawMaterials($RawMaterialsID);
	}
	elseif ($action == "clearall") 
	{
		ClearAll();
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Production </title>
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>

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

<form action="Production.php" method="get">

<fieldset>
<legend>Production Info:</legend>
<table>
<tr>
	<td>ProductionID</td>
	<td>
		: <input type="text" name="txtProductionID" value="<?php echo AutoID('Production','ProductionID','PRO-',6) ?>" readonly/>
	</td>
	<td>ProductionDate</td>
	<td>
		: <input type="text" name="txtProductionDate" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" readonly/>
	</td>

	<tr>
		<td>Staff Info</td>
		<td>
		: <input type="text" name="txtStaffInfo" value="<?php echo $_SESSION['StaffName'] ?>" readonly />
		</td>

	</tr><br><br>
</table>
	<hr>

<!-- Raw Table  -->
	<table>
		<tr>
			<td>Raw Info</td>
		<td>
		: 
		<select name="cboRawMaterialsID">
		<option>-Choose RawMaterialsID-</option>
		<?php 
			$Raw_Query="SELECT * FROM RawMaterials";
			$Raw_Ret=mysqli_query($connection,$Raw_Query);
			$Raw_Count=mysqli_num_rows($Raw_Ret);

			for($i=0; $i<$Raw_Count;$i++) 
			{ 
				$rows=mysqli_fetch_array($Raw_Ret);
				$RawMaterialsID=$rows['RawMaterialsID'];
				$RawMaterialsName=$rows['RawMaterialsName'];

				echo "<option value='$RawMaterialsID'>$RawMaterialsID - $RawMaterialsName</option>";
			}
		?>
		</select>
	</td>
	<td>Quantity</td>
	<td>
		<input type="number" name="txtRawQuantity" value="0" required/>
	</td>
		</tr>
		<tr>
		<td>Price</td>
		<td>
		: <input type="number" name="txtRawPrice" value="0"/>
		</td>
			<td></td>
			<td>
				<input type="submit" name="btnAdd" value="Add" />
			</td>
				
		</tr>
	</table>
	<hr>
<!--Production Detail-->

<table>
<?php  
if (!isset($_SESSION['PROFunctions'])) 
{
	echo "<p>No Record Found.</p>";
	exit();
}
?>

<table cellpadding="3px" border="1">
<tr>
	<th>No.</th>
	<th>RawMaterialsID</th>
	<th>RawName</th>
	<th>Price <small>(usd)</small></th>
	<th>Qty <small>(pcs)</small></th>
	<th>Sub-Total <small>(usd)</small></th>
	<th>Action</th>
</tr>
<?php 
	$size=count($_SESSION['PROFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 

		$RawMaterialsID=$_SESSION['PROFunctions'][$i]['RawMaterialsID'];
		$RawMaterialsName=$_SESSION['PROFunctions'][$i]['RawMaterialsName'];
		$RawPrice=$_SESSION['PROFunctions'][$i]['RawPrice'];
		$RawQuantity=$_SESSION['PROFunctions'][$i]['RawQuantity'];
		$SubTotal=$RawPrice * $RawQuantity;

		echo "<tr>";
		echo "<td>" . ($i+1) . "</td>";
		echo "<td>$RawMaterialsID</td>";
		echo "<td>$RawMaterialsName</td>";
		echo "<td>$RawPrice $</td>";
		echo "<td>$RawQuantity</td>";
		echo "<td>$SubTotal</td>";
		echo "<td>
			  <a href='Production.php?action=remove&RawMaterialsID=$RawMaterialsID'>Remove</a>
			  </td>";
		echo "</tr>";
	}
?>
<tr>
	<td colspan="7" align="right">
	|
	<a href="Production.php?action=clearall">Clear All</a>
	</td>
</tr>
</table>
</table>
<hr>
<!--Product Table-->

<table>
<tr>
	<td>ProductID</td>
	<td>
		: <input type="text" name="txtProductID" value="<?php echo AutoID('product','ProductID','PUR-',6) ?>" readonly/>
	</td>

	<td>Total Raw Qty</td>
	<td>
		: <input type="number" name="txtTotalRawQty" value="<?php echo CalculateTotalRawQuantity() ?>" readonly/>
	</td>
</tr>

<tr>
		<td>Product Qty</td>
	<td>
		: <input type="number" name="txtQty" value="0" />
	</td>

	<td>Total Raw Price</td>
	<td>
		: <input type="number" name="txtTotalRawPrice" value="<?php echo CalculateTotalRawPrice() ?>" readonly/>
	</td>

</tr>
<tr>
	<td>Size <small>(Liter)</small></td>
	<td>:<input type="text" name="txtProductSize" ></td>
	
</tr>

<tr>
	<td></td>
	<td>
		: <input type="submit" name="btnSave" value="Save"/>
		  <input type="reset"  value="Clear"/>
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