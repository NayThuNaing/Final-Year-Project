<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('PurchaseOrder_Functions.php');
include('header.php');

if(isset($_POST['btnConfirm'])) 
{
	$txtPurchaseOrderID=$_POST['txtPurchaseOrderID'];

	$query=mysqli_query($connection, "SELECT * FROM purchaseorderdetail WHERE PurchaseOrderID='$txtPurchaseOrderID'");

	while($row=mysqli_fetch_array($query)) 
	{
		$RawMaterialsID=$row['RawMaterialsID'];
		$Quantity=$row['Quantity'];

		$UpdateQty="UPDATE RawMaterials
					SET Quantity= Quantity + '$Quantity'
					WHERE RawMaterialsID='$RawMaterialsID'
					";
		$ret=mysqli_query($connection,$UpdateQty);
	}

	$UpdateStatus="UPDATE purchaseorder
				   SET Status='Confirmed'
				   WHERE PurchaseOrderID='$txtPurchaseOrderID'";
	$ret=mysqli_query($connection,$UpdateStatus);

	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : Purchase Order Successfully Confirmed.')</script>";
		echo "<script>window.location='PurchaseReport.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase Details" . mysqli_error($connection) . "</p>";
	}


}

if (isset($_GET['PurchaseOrderID'])) 
{
	$PurchaseOrderID=$_GET['PurchaseOrderID'];
	
	$query1="SELECT p.*, sup.SupplierID, sup.SupplierName, s.StaffID,s.StaffName
			FROM purchaseOrder p, supplier sup, staff s
			WHERE p.SupplierID=sup.SupplierID
			AND p.StaffID=s.StaffID
			AND p.PurchaseOrderID='$PurchaseOrderID'
			";
	$result1=mysqli_query($connection,$query1);
	$row1=mysqli_fetch_array($result1);

	$query2="SELECT p.*, pd.*, r.RawMaterialsID, r.RawMaterialsName
			FROM purchaseorder p, purchaseorderdetail pd, rawmaterials r
			WHERE p.PurchaseOrderID=pd.PurchaseOrderID
			AND pd.RawMaterialsID=r.RawMaterialsID
			AND p.PurchaseOrderID='$PurchaseOrderID'
			";
	//echo $query2;
	$result2=mysqli_query($connection,$query2);
	$count=mysqli_num_rows($result2);

}
else
{
	$PurchaseOrderID="";

	echo "<script>window.alert('ERROR : Purchase Order Details not Found.')</script>";
	echo "<script>window.location='PurchaseReport.php'</script>"; 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Purchase Details</title>
</head>
<body>
<form action="PurchaseDetailReport.php" method="POST">

<fieldset>
	<tr>
<legend>Purchase Order Detail Report for POID : <?php echo $PurchaseOrderID ?></legend>

<table align="center" border="1" cellpadding="7px">
<tr>
	<td>Purchase_ID</td>
	<td><b><?php echo $PurchaseOrderID ?></b></td>
</tr>
	<td>Status</td>
	<td><b><?php echo $row1['Status'] ?></b></td>

</tr>
<tr>
<tr>
	<td>Purchase Date</td>
	<td><b><?php echo $row1['PurchaseOrderDate'] ?></b></td>
</tr>
	<td>Report Date</td>
	<td><b><?php echo date('Y-m-d') ?></b></td>
</tr>

<tr>
<tr>
	<td>SupplierName</td>
	<td><b><?php echo $row1['SupplierName'] ?></b></td>
</tr>
	<td>StaffName</td>
	<td><b><?php echo $row1['StaffName'] ?></b></td>
</tr>
<tr>
<tr>
	<td colspan="4">
		<table align="center" border="1">
			<tr>
				<th>RawMaterials Name</th>
				<th>Pur_Price</th>
				<th>Pur_Quantity</th>
				<th>Sub-Total</th>
			</tr>
		</tr>
			<?php  
			for ($i=0; $i < $count ; $i++) 
			{ 
				$row2=mysqli_fetch_array($result2);
				echo "<tr>";
				echo "<td>" . $row2['RawMaterialsName'] ."</td>";
				echo "<td>" . $row2['PurchasePrice'] ."</td>";
				echo "<td>" . $row2['Quantity'] ."</td>";
				echo "<td>" . ($row2['PurchasePrice'] * $row2['Quantity']) ."</td>";
				echo "</tr>";
			}

			?>
		</table>
	</td>
</tr>
<tr>
<tr>
	<td colspan="4" align="right">
	Total Quantity : <b><?php echo $row1['TotalQuantity'] ?>  Pcs</br> <br>
	Total Amount : <b><?php echo $row1['TotalAmount'] ?>  USD</b> <br/><br>
	GrandTotal : <b><?php echo $row1['GrandTotal'] ?>  USD</b> <br/><br>
	
	</td>
</tr>
</tr>
<tr>
<tr>
	<td colspan="4" align="right">
	<input type="hidden" name="txtPurchaseOrderID" value="<?php echo $PurchaseOrderID ?>" />
	<?php  
	if ($row1['Status'] === "Pending") 
	{
		echo "<input type='submit' name='btnConfirm' value='Confirm'/>";
	}
	else
	{
		echo "<input type='submit' name='btnConfirm' value='Confirm'>";
	}
	?>
	</td>
</tr>
</tr>
</table>
</fieldset>

</form>
</body>
</html>
	<!---Print--->
	<script>var pfHeaderImgUrl = '';var pfHeaderTagline = 'Order%20Report';var pfdisableClickToDel = 0;var pfHideImages = 0;var pfImageDisplayStyle = 'right';var pfDisablePDF = 0;var pfDisableEmail = 0;var pfDisablePrint = 0;var pfCustomCSS = '';var pfBtVersion='1';(function(){var js, pf;pf = document.createElement('script');pf.type = 'text/javascript';if('https:' == document.location.protocol){js='https://pf-cdn.printfriendly.com/ssl/main.js'}else{js='http://cdn.printfriendly.com/printfriendly.js'}pf.src=js;document.getElementsByTagName('head')[0].appendChild(pf)})();</script>
	<a href="http://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onClick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="http://cdn.printfriendly.com/button-print-grnw20.png" alt="Print Friendly and PDF"/></a>
	<!---Print--->



<?php 
include('footer.php');
 ?>