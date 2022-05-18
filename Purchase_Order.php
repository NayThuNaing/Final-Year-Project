<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('PurchaseOrder_Functions.php');
include('header.php');


if(isset($_GET['btnSave'])) 
{
	$txtPurchaseOrderID=$_GET['txtPurchaseOrderID'];
	$txtPurchaseDate=$_GET['txtPurchaseDate'];
	$txtTotalAmount=$_GET['txtTotalAmount'];
	$cboSupplierID=$_GET['cboSupplierID'];	
	$txtVAT=$_GET['txtVAT'];
	$txtGrandTotal=$_GET['txtGrandTotal'];
	$txtTotalQuantity=$_GET['txtTotalQuantity'];
	$cboRawMaterialsID=$_GET['cboRawMaterialsID'];

	$Status="Pending";
	$StaffID=$_SESSION['StaffID'];

	//Insert Data to Purchase Table
	$Insert1="INSERT INTO `purchaseorder`
			  (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `SupplierID`, `Status`, `TaxAmount`, `GrandTotal`, `StaffID`, `TotalQuantity`, `RawMaterialsID`) 
			  VALUES
			  ('$txtPurchaseOrderID','$txtPurchaseDate','$txtTotalAmount','$cboSupplierID','$Status','$txtVAT','$txtGrandTotal','$StaffID','$txtTotalQuantity','$cboRawMaterialsID')
			  ";
	$ret=mysqli_query($connection,$Insert1);

	//Insert Data to PurchaseDetail Table

	$size=count($_SESSION['POFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 
		//Get Data from Session Array
		$RawMaterialsID=$_SESSION['POFunctions'][$i]['RawMaterialsID'];
		$PurchasePrice=$_SESSION['POFunctions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['POFunctions'][$i]['PurchaseQuantity'];

		$Insert2="INSERT INTO `purchaseorderdetail`
				  (`PurchaseOrderID`, `RawMaterialsID`, `Quantity`, `PurchasePrice`) 
				  VALUES
				  ('$txtPurchaseOrderID','$RawMaterialsID','$PurchaseQuantity','$PurchasePrice')
				  ";
		$ret=mysqli_query($connection,$Insert2);
	}

	if($ret) //True
	{
		unset($_SESSION['POFunctions']);
		
		echo "<script>window.alert('SUCCESS : Purchase Order Successfully Saved.')</script>";
		echo "<script>window.location='Purchase_Order.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in Purchase Order" . mysqli_error($connection) . "</p>";
	}
}


if(isset($_GET['btnAdd'])) 
{
	$cboRawMaterialsID=$_GET['cboRawMaterialsID'];
	$txtPurchasePrice=$_GET['txtPurchasePrice'];
	$txtPurchaseQuantity=$_GET['txtPurchaseQuantity'];

	AddRawMaterials($cboRawMaterialsID,$txtPurchasePrice,$txtPurchaseQuantity);
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
	<title>Purchase Order</title>
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

<form action="Purchase_Order.php" method="get">

<fieldset>
<legend>Purchase Order Info:</legend>
<table>
<tr>
	<td>PurchaseDate</td>
	<td>
		: <input type="text" name="txtPurchaseDate" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" readonly/>
	</td>

	<td>Total Amount</td>
	<td>
		: <input type="number" name="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly />
	</td>
	
</tr>
<tr>
	<td>PurchaseOrderID</td>
	<td>
		: <input type="text" name="txtPurchaseOrderID" value="<?php echo AutoID('purchaseorder','PurchaseOrderID','PUR-',6) ?>" readonly/>
	</td>

	<td>Total Quantity</td>
	<td>
		: <input type="number" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity() ?>" readonly/>
	</td>

</tr>
<tr>
	<td>Staff Info</td>
	<td>
		: <input type="text" name="txtStaffInfo" value="<?php echo $_SESSION['StaffName'] ?>" />
	</td>

	<td>VAT (5%)</td>
	<td>
		: <input type="number" name="txtVAT" value="<?php echo CalculateVAT() ?>" readonly/>
	</td>
</tr>
<tr>
	<td>RawMaterials Info</td>
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

	<td>Grand Total</td>
	<td>
		: <input type="number" name="txtGrandTotal" value="<?php echo CalculateGrandTotal() ?>" readonly/>
	</td>
</tr>
<tr>
	<td>PurchasePrice</td>
	<td>
		: <input type="number" name="txtPurchasePrice" value="0"/>
	</td>

	<td></td>
	<td>
		: <input style="background-color:#11BA23;" type="submit" name="btnAdd" value="Add"/>
		  <input style="background-color:#E22919;" type="reset"  value="Clear"/>
	</td>
</tr>
<tr>
	<td>Purchase Qty</td>
	<td>
		: <input type="number" name="txtPurchaseQuantity" value="0"/>
	</td>

	
</tr>

</table>

</fieldset>

<fieldset>
<legend>Purchase Order Details</legend>
<?php  
if (!isset($_SESSION['POFunctions'])) 
{
	echo "<p>No Record Found.</p>";
	exit();
}
?>

<table cellpadding="3px" border="1">
<tr>
	<th>No.</th>
	<th>RawMaterialsID</th>
	<th>RawMaterialsName</th>
	<th>PurchasePrice <small>(usd)</small></th>
	<th>PurchaseQty <small>(pcs)</small></th>
	<th>Sub-Total <small>(usd)</small></th>
	<th>Action</th>
</tr>
<?php 
	$size=count($_SESSION['POFunctions']);

	for($i=0;$i<$size;$i++) 
	{ 

		$RawMaterialsID=$_SESSION['POFunctions'][$i]['RawMaterialsID'];
		$RawMaterialsName=$_SESSION['POFunctions'][$i]['RawMaterialsName'];
		$PurchasePrice=$_SESSION['POFunctions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['POFunctions'][$i]['PurchaseQuantity'];
		$SubTotal=$PurchasePrice * $PurchaseQuantity;

		echo "<tr>";
		echo "<td>" . ($i+1) . "</td>";
		echo "<td>$RawMaterialsID</td>";
		echo "<td>$RawMaterialsName</td>";
		echo "<td>$PurchasePrice $</td>";
		echo "<td>$PurchaseQuantity</td>";
		echo "<td>$SubTotal</td>";
		echo "<td>
			  <a href='Purchase_Order.php?action=remove&RawMaterialsID=$RawMaterialsID'  >Remove</a>
			  </td>";
		echo "</tr>";
	}
?>
<tr>
	<td colspan="7" align="right">
	Choose Supplier ID :
	<select name="cboSupplierID">
		<option>-Choose Supplier-</option>
		<?php  
			$SupQuery="SELECT * FROM supplier";
			$Sup_ret=mysqli_query($connection,$SupQuery);
			$Sup_count=mysqli_num_rows($Sup_ret);

			for($i=0;$i<$Sup_count;$i++) 
			{ 
				$Sup_arr=mysqli_fetch_array($Sup_ret);
				$SupplierID=$Sup_arr['SupplierID'];
				$SupplierName=$Sup_arr['SupplierName'];

				echo "<option value='$SupplierID'>$SupplierID ~ $SupplierName</option>";
			}
		?>
	</select>
	|
	<input style="background-color:#11BA23;" type="submit" name="btnSave" value="Save" />
	|
	<a href="Purchase_Order.php?action=clearall" style="color:#E22919;">Clear All</a>
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