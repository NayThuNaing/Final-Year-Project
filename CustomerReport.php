<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('ShoppingCartFunction.php');
include('header.php');

if(isset($_POST['btnSearch'])) 
{
	 $rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1) 
	{
		 $cboOrderID=$_POST['cboOrderID'];

		 $query="SELECT p.*, sup.CustomerID, sup.CustomerName
				FROM orders p, Customer sup
				WHERE p.OrderID='$cboOrderID'
				AND p.CustomerID=sup.CustomerID
				";
		$result=mysqli_query($connection,$query);
	}
	elseif($rdoSearchType == 2) 
	{
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));
		$To=date('Y-m-d',strtotime($_POST['txtTo']));

		$query="SELECT p.*, s.CustomerID, s.CustomerName
				FROM orders p, Customer s
				WHERE p.OrderDate BETWEEN '$From' AND '$To'
				AND p.CustomerID=s.CustomerID
				";
		$result=mysqli_query($connection,$query);
	}
	else
	{
		$cboStatus=$_POST['cboStatus'];

		$query="SELECT p.*, s.CustomerID, s.CustomerName
				FROM orders p, Customer s
				WHERE p.Status='$cboStatus'
				AND p.CustomerID=s.CustomerID
				AND p.CustomerID='CustomerName'
				";
		$result=mysqli_query($connection,$query);
	}
}
elseif(isset($_POST['btnShowAll']))
{
	$query="SELECT p.*, s.CustomerID, s.CustomerName
				FROM orders p, Customer s
				WHERE p.CustomerID=s.CustomerID
				
				";
	$result=mysqli_query($connection,$query);
}
else
{
	$today=date('Y-m-d');

	$query="SELECT p.*, s.CustomerID, s.CustomerName
				FROM orders p, customer s
				WHERE p.OrderDate='$today'
				AND p.CustomerID=s.CustomerID
				";
	$result=mysqli_query($connection,$query);
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Orders Report List</title>
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>
</head>
<body>
<form action="" method="post">
<table border="1" cellpadding="7px">
<tr>
	<td>
		<label class="custom-control custom-radio">
	<input type="radio" name="rdoSearchType" value="1" name="radio-stacked" checked="" class="custom-control-input" checked />
	<span class="custom-control-label">Search by Orders_ID</span>  
	<select name="cboOrderID">
		<option>Choose Orders ID</option>
		<?php  
		$Orders_Query="SELECT * FROM orders";
		$Orders_ret=mysqli_query($connection,$Orders_Query);
		$Orders_count=mysqli_num_rows($Orders_ret);

		for($i=0;$i<$Orders_count;$i++) 
		{ 
			$Orders_arr=mysqli_fetch_array($Orders_ret);
			$OrderID=$Orders_arr['OrderID'];

			echo "<option value='$OrderID'>$OrderID</option>";
		}
		

		?>
	</select>
</label>
	</td>
	<tr></tr>
	<td>
		 <label class="custom-control custom-radio">
	<input type="radio" name="rdoSearchType" value="2" name="radio-stacked" checked="" class="custom-control-input"/>
	<span class="custom-control-label">	Search by Orders Date: </span>  
	<br/> <br> 
	From <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" />
	To	<input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" />

	</td>
		<td>
		<input type="submit" name="btnSearch" value="Search" />
		<input type="submit" name="btnShowAll" value="Show All" />
		<input type="reset" name="btnreset" value="Clear" />
		</td>
		
</tr>
</table>

<hr/>

<fieldset>
<legend>Orders Results</legend>
<?php  

$count=mysqli_num_rows($result);

if ($count < 1) 
{
	echo "<p>No Data Found.</p>";
	exit();
}
?>

<table border="1" cellpadding="5px">
<tr>
	<th>Orders_ID</th>
	<th>Orders_Date</th>
	<th>Customer Name</th>
	<th>Total Amount</th>
	<th>Total Quantity</th>
	<th>Grand Total</th>
	<th>PaymentType</th>
	<th>Action</th>
</tr>
<?php 
	for ($i=0;$i<$count;$i++) 
	{ 
		$rows=mysqli_fetch_array($result);
		$OrderID=$rows['OrderID'];
		echo "<tr>";
		echo "<td>" . $rows['OrderID'] ."</td>";
		echo "<td>" . $rows['OrderDate'] ."</td>";
		echo "<td>" . $rows['CustomerName'] ."</td>";
		echo "<td>" . $rows['TotalAmount'] ."</td>";
		echo "<td>" . $rows['TotalQuantity'] ."</td>";
		echo "<td>" . $rows['GrandTotal'] ."</td>";
		echo "<td>" . $rows['PaymentType'] ."</td>";
		echo "<td>
			  <a href='CustomerDetailReport.php?OrderID=$OrderID'>More..</a>
			  </td>";
		echo "</tr>";
	}

?>
</table>

</fieldset>


</form>
</body>
</html>
<?php 
include('footer.php');
 ?>