<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('ShoppingCartFunction.php');
include('header.php');

if(isset($_POST['btnConfirm'])) 
{
	$txtOrderID=$_POST['txtOrderID'];

	$query=mysqli_query($connection, "SELECT * FROM orderdetails WHERE OrderID='$txtOrderID'");

	while($row=mysqli_fetch_array($query)) 
	{
		$ProductID=$row['ProductID'];
		$Quantity=$row['Quantity'];

		$UpdateQty="UPDATE Product
					SET Quantity= Quantity + '$Quantity'
					WHERE ProductID='$ProductID'
					";
		$ret=mysqli_query($connection,$UpdateQty);
	}

	$UpdateStatus="UPDATE orders
				   SET Status='Confirmed'
				   WHERE OrderID='$txtOrderID'";
	$ret=mysqli_query($connection,$UpdateStatus);

	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : Order Successfully Confirmed.')</script>";
		echo "<script>window.location='CustomerDetailReport.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Customer Details" . mysqli_error($connection) . "</p>";
	}


}

if (isset($_GET['OrderID'])) 
{
	$OrderID=$_GET['OrderID'];
	
	$query1="SELECT p.*, s.CustomerID,s.CustomerName
			FROM Orders p, customer s
			WHERE 
			 p.CustomerID=s.CustomerID
			AND p.OrderID='$OrderID'
			";
	$result1=mysqli_query($connection,$query1);
	$row1=mysqli_fetch_array($result1);

	$query2="SELECT p.*, pd.*, r.ProductID, r.ProductName
			FROM orders p, orderdetails pd, product r
			WHERE p.OrderID=pd.OrderID
			AND pd.ProductID=r.ProductID
			AND pd.OrderID='$OrderID'
			";
	//echo $query2;
	$result2=mysqli_query($connection,$query2);
	$count=mysqli_num_rows($result2);

}
else
{
	$OrderID="";

	echo "<script>window.alert('ERROR : Purchase Order Details not Found.')</script>";
	echo "<script>window.location='CustomerReport.php'</script>"; 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Purchase Details</title>
</head>
<body>
<form action="CustomerDetailReport.php" method="POST">

<fieldset>
	<tr>
<legend>Purchase Order Detail Report for POID : <?php echo $OrderID ?></legend>

<table align="center" border="1" cellpadding="7px">
<tr>
	<td>Purchase_ID</td>
	<td><b><?php echo $OrderID ?></b></td>
</tr>
	<td>Status</td>
	<td><b><?php echo $row1['Status'] ?></b></td>

</tr>
<tr>
<tr>
	<td>Purchase Date</td>
	<td><b><?php echo $row1['OrderDate'] ?></b></td>
</tr>
	<td>Report Date</td>
	<td><b><?php echo date('Y-m-d') ?></b></td>
</tr>

<tr>

	<td>CustomerName</td>
	<td><b><?php echo $row1['CustomerName'] ?></b></td>
</tr>
<tr>
<tr>
	<td colspan="4">
		<table align="center" border="1" >
			<tr>
				<th>Product Name</th>
				<th>  Price  </th>
				<th>  Quantity</th>
				<th>  Sub-Total</th>
			</tr>
		</tr>
			<?php  
			for ($i=0; $i < $count ; $i++) 
			{ 
				$row2=mysqli_fetch_array($result2);
				echo "<tr>";
				echo "<td>" . $row2['ProductName'] ."</td>";
				echo "<td>" . $row2['Price'] ."</td>";
				echo "<td>" . $row2['Quantity'] ."</td>";
				echo "<td>" . ($row2['Price'] * $row2['Quantity']) ."</td>";
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
	<input type="hidden" name="txtOrderID" value="<?php echo $OrderID ?>" />
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