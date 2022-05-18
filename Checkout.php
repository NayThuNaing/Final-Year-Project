<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('ShoppingCartFunction.php');
include('CustomerHeader.php');

if(isset($_POST['btnSave'])) 
{
	$txtInvoiceNo=$_POST['txtInvoiceNo'];
	$txtInvoiceDate=$_POST['txtInvoiceDate'];	
	$CustomerID=$_SESSION['CustomerID'];

	//--------Check Same or Other Address----------
	$txtPhone=$_POST['txtPhone'];
	$txtAddress=$_POST['txtAddress'];
	//---------------------------------------------
	
	$txtTotalQty=$_POST['txtTotalQty'];
	$txtTotalAmount=$_POST['txtTotalAmount'];
	$txtVAT=$_POST['txtVAT'];
	$txtDeliveryCost=$_POST['txtDeliveryCost'];
	$txtGrandTotal=$_POST['txtGrandTotal'];

	$rdoPaymentType=$_POST['rdoPaymentType'];
	$txtCardNo=$_POST['txtCardNo'];
	$Status="Pending";

	$Insert1="INSERT INTO Orders
			(OrderID,OrderDate,CustomerID,DeliveryAddress,DeliveryPhone,TotalQuantity,TotalAmount,VAT,DeliveryCost,GrandTotal,PaymentType,CardNo,Status)
			VALUES
			('$txtInvoiceNo','$txtInvoiceDate','$CustomerID','$txtAddress','$txtPhone','$txtTotalQty','$txtTotalAmount','$txtVAT','$txtDeliveryCost','$txtGrandTotal','$rdoPaymentType','$txtCardNo','$Status')";
	$ret=mysqli_query($connection,$Insert1);

	//----------Save Data into Order Details----------------------------------

	$size=count($_SESSION['ShoppingCartFunction']);

	for($i=0;$i<$size;$i++) 
	{ 
		//Get Data from Session Array
		$ProductID=$_SESSION['ShoppingCartFunction'][$i]['ProductID'];
		$Price=$_SESSION['ShoppingCartFunction'][$i]['Price'];
		$BuyQuantity=$_SESSION['ShoppingCartFunction'][$i]['BuyQuantity'];

		$Insert2="INSERT INTO orderdetails
				  (OrderID,ProductID,Price,Quantity) 
				  VALUES
				  ('$txtInvoiceNo','$ProductID','$Price','$BuyQuantity')
				  ";
		$ret=mysqli_query($connection,$Insert2);
	}

	if($ret) //True
	{
		unset($_SESSION['ShoppingCartFunction']);
		
		echo "<script>window.alert('SUCCESS : Order Successfully Saved.')</script>";
		echo "<script>window.location='ProductDisplay.php'</script>";
	}
	else
	{
		echo "<p>Error : Something went wrong in Order" . mysqli_error($connection) . "</p>";
	}

}

$CustomerID=$_SESSION['CustomerID'];

$query="SELECT * FROM Customer WHERE CustomerID='$CustomerID' ";
$ret=mysqli_query($connection,$query);
$rows=mysqli_fetch_array($ret);



?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout (Payment)</title>

<script type="text/javascript">

function ShowAddress()
{
	document.getElementById('OtherAddress').style.display="block";
}
function HideAddress()
{
	document.getElementById('OtherAddress').style.display="none";
}
function ShowPayment()
{
	document.getElementById('PaymentArea').style.display="block";
}
function HidePayment()
{
	document.getElementById('PaymentArea').style.display="none";
}

function GetDeliveryCost()
{
	var e=document.getElementById('cboTownship');
	var result=e.options[e.selectedIndex].value;
	document.getElementById('txtDeliveryCost').value=result;

	var TotalAmt=document.getElementById('txtTotalAmount').value;
	var VAT=document.getElementById('txtVAT').value;

	document.getElementById('txtGrandTotal').value=Number(result) + Number(TotalAmt) + Number(VAT);

}

</script>

</head>
<body>
<form action="Checkout.php"	method="post">

<fieldset>
<legend><h2>Customer Details :</h2></legend>

<h3 style="margin:20px;"><input type="radio" name="rdoAddress" value="SameAddress" onclick="HideAddress()" checked /> Same Address</h3>
<h3 style="margin:20px;"><input type="radio" name="rdoAddress" value="OtherAddress" onclick="ShowAddress()" /> Other Address</h3>

<hr/>
<div id="OtherAddress" style="display: none; margin:20px;">
	<p>Phone No :</p> 
	<input type="text" name="txtPhone" placeholder="+95------------" /> <br/>
	<p>Address :</p> 
	<textarea name="txtAddress"></textarea>
	<hr/>
</div>


<table cellpadding="5px" style="margin:30px;">
<tr>
	<td><h3>Customer Name</h3></td>
	<td><h3>: <?php echo $rows['CustomerName'] ?></h3></td>
</tr>
<tr>
	<td><h3>Email</h3></td>
	<td><h3>: <?php echo $rows['Email'] ?></h3></td>
</tr>
<tr>
	<td><h3>Phone No</h3></td>
	<td><h3>: <?php echo $rows['Phone'] ?></h3></td>
</tr>
<tr>
	<td><h3>Address</h3></td>
	<td><h3>: <?php echo $rows['Address'] ?></h3></td>
</tr>
</table>

<hr/>
<b><h3 style="margin:20px;">Direction :</h3></b>
<textarea style="margin:20px;" name="txtDirection" rows="1" cols="50"></textarea>

</fieldset>	

<fieldset>
<legend><h2>Checkout infomation :</h2></legend>
<table cellpadding="5px" style="margin:30px;">
<tr>
	<td><h3>Invoice NO</h3></td>
	<td>
		<h3>: <input type="text" name="txtInvoiceNo" value="<?php echo AutoID('Orders','OrderID','ORD-',6) ?>" readonly /></h3>
	</td>
	<td><h3>Invoice Date</h3></td>
	<td>
		<h3>: <input type="text" name="txtInvoiceDate" value="<?php echo date('Y-m-d') ?>" readonly /></h3>
	</td>
</tr>
<tr>
	<td><h3>TotalQty</h3></td>
	<td>
		<h3>: <input type="text" name="txtTotalQty" value="<?php echo CalculateTotalQuantity()  ?>" readonly /></h3>
	</td>
	<td><h3>Total Amount</h3></td>
	<td>
		<h3>: <input type="text" name="txtTotalAmount" id="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly /></h3>
	</td>
</tr>
<tr>
	<td></td>
	<td></td>

	<td><h3>VAT(5%)</h3></td>
	<td>
		<h3>: <input type="text" name="txtVAT" id="txtVAT"  value="<?php echo CalculateVAT()  ?>" readonly /></h3>
	</td>

</tr>
<tr>
	<td><h3>Choose Township</h3></td>
	<td>
		<h3>: 
		<select name="cboTownship" id="cboTownship" onchange="GetDeliveryCost()" />
		<option>-Choose Township-</option>
		<?php 
			$Tsp_Query="SELECT * FROM Township";
			$Tsp_Ret=mysqli_query($connection,$Tsp_Query);
			$Tsp_Count=mysqli_num_rows($Tsp_Ret);

			for($i=0; $i<$Tsp_Count;$i++) 
			{ 
				$rows=mysqli_fetch_array($Tsp_Ret);
				$TownshipID=$rows['TownshipID'];
				$TownshipName=$rows['TownshipName'];
				$DeliveryCost=$rows['DeliveryCost'];

				echo "<option value='$DeliveryCost'>$TownshipName - $DeliveryCost (MMK)</option>";
			}
		?>

		</select></h3>
	</td>
	<td><h3>Delivery Cost</h3></td>
	<td>
		<h3>: <input type="text" name="txtDeliveryCost" id="txtDeliveryCost" value="0" readonly /></h3>
	</td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td><h3>Grand Total</h3></td>
	<td>
		<h3>: <input type="text" name="txtGrandTotal" id="txtGrandTotal" value="0" readonly />
	</td></h3>
</tr>
<tr>
	<td colspan="4">
	<hr/>
	<h3>Choose Payment Type:</h3>

	<input type="radio" name="rdoPaymentType" value="COD" checked onclick="HidePayment()" />
	<img src="images/COD.png" width="50px" height="50px"/>

	<input type="radio" name="rdoPaymentType" value="VISA" onclick="ShowPayment()" />
	<img src="images/VISA.png" width="50px" height="35px"/>

	<input type="radio" name="rdoPaymentType" value="MPU" onclick="ShowPayment()" />
	<img src="images/MPU.png" width="50px" height="25px"/>

	<input type="radio" name="rdoPaymentType" value="KBZPAY" onclick="#" />
	<img src="images/KBZPAY.png" width="50px" height="50px"/>
	<hr/>
	</td>
</tr>
<tr>
	<td colspan="4">
	<div id="PaymentArea" class="PaymentArea" style="background-color: #CCC;display: none;">

	Card No : <input type="text" name="txtCardNo" placeholder="xxxx xxxx xxxx xxxx"/>
	Expires : 
	<select name="cboMonth">
		<option>Month</option>
		<option>January</option>
		<option>February</option>
		<option>March</option>
		<option>April</option>
		<option>May</option>
		<option>June</option>
		<option>July</option>
		<option>Auguest</option>
		<option>September</option>
		<option>October</option>
		<option>November</option>
		<option>December</option>
	</select>
	<select name="cboYear">
		<option>Year</option>
		<option>2015</option>
		<option>2016</option>
		<option>2017</option>
		<option>2018</option>
		<option>2019</option>
		<option>2020</option>
		<option>2021</option>
		<option>2022</option>
		<option>2023</option>
		<option>2024</option>
		<option>2025</option>
		<option>2026</option>
		<option>2027</option>
	</select>
	</div>
	</td>
</tr>
<tr>
	<td colspan="4">
	
	<button type="submit" class="btn btn-primary" name="btnSave" value="Save" >Save</button>
	</td>
</tr>
</table>
</fieldset>

<fieldset>
<legend><h2>Shopping Cart</h2></legend>
<table cellpadding="3px" border="0" style="margin:30px;">
<tr>
	<th><h3>Image</h3></th>
	<th><h3>ProductID</h3></th>
	<th><h3>ProductName</h3></th>
	<th><h3>Price <small>(usd)</h3></small></th>
	<th><h3>BuyQuantity <small>(pcs)</h3></small></th>
	<th><h3>Sub-Total <small>(usd)</h3></small></th>

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
		echo "<td><img src='$Image1' width='100px' height='100px' /></td>";
		echo "<td><h3>$ProductID</h3></td>";
		echo "<td><h3>$ProductName</h3></td>";
		echo "<td><h3>$Price $</h3></td>";
		echo "<td><h3>$BuyQuantity</h3></td>";
		echo "<td><h3>$SubTotal</h3></td>";
		echo "<td>
			  <a href='Checkout.php?action=#&ProductID=$ProductID'></a>
			  </td>";
		echo "</tr>";
	}
?>
</table>



</fieldset>

</form>
</body>
</html>
<hr>
<?php 
include('CustomerFooter.php');
 ?>
