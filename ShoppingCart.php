<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('ShoppingCartFunction.php');
include('CustomerHeader.php');

if(isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if ($action == "remove") 
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
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
	<title>Shopping Cart</title>
</head>
<body>
<form>

<fieldset>
<legend><h2>Your Cart</h2></legend>
<?php  
if (!isset($_SESSION['ShoppingCartFunction'])) 
{
	echo "<p>Your Shopping Cart is Empty!</p>";
	exit();
}
?>

<table cellpadding="3px" border="0" style="margin:50px">
<tr>
	<th border="1"><h3>Products</h3></th>
	<th><h3>ProductID</h3></th>
	<th><h3>ProductName</h3></th>
	<th><h3>Price <small>(usd)</h3></small></th>
	<th><h3>BuyQuantity <small>(pcs)</small></h3></th>
	<th><h3>Sub-Total <small>(usd)</h3></small></th>
	<th><h3>Action</h3></th>
</tr>
<?php 
	$size=count($_SESSION['ShoppingCartFunction']);

	for($i=0;$i<$size;$i++) 
	{ 
		$Image1=$_SESSION['ShoppingCartFunction'][$i]['Image1'];
		$ProductID=$_SESSION['ShoppingCartFunction'][$i]['ProductID'];
		$ProductName=$_SESSION['ShoppingCartFunction'][$i]['ProductName'];

		$Price=$_SESSION['ShoppingCartFunction'][$i]['Price'];

		$BuyQuantity=$_SESSION['ShoppingCartFunction'][$i]['BuyQuantity'];

		$SubTotal=$Price * $BuyQuantity;

		echo "<tr>";
		echo "<td><h3><img src='$Image1' width='100px' height='100px' /></h3></td>";
		echo "<td><h3>$ProductID<h3/></td>";
		echo "<td><h3>$ProductName</h3></td>";
		echo "<td><h3>$Price $</h3></td>";
		echo "<td><h3>$BuyQuantity</h3></td>";
		echo "<td><h3>$SubTotal</h3></td>";
		echo "<td>
			  <a href='ShoppingCart.php?action=remove&ProductID=$ProductID'>Remove</a>
			  </td>";
		echo "</tr>";
	}
?>
<tr>
	<td colspan="7" align="right">
	
	
	<button  type="submit" class="btn btn-primary" name="btnSave" value="Save" required><a style="color:white;" href="Checkout.php">CheckOut</a></button>
		<!--<a href="Checkout.php">Checkout Now</a> | -->
	</td>
</tr>
</table>

</fieldset>


</form>
</body>
</html>
<?php 
include('CustomerFooter.php');
 ?>