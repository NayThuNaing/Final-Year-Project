<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('PurchaseOrder_Functions.php');
include('header.php');

if(isset($_POST['btnSearch'])) 
{
	 $rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1) 
	{
		 $cboPurchaseOrderID=$_POST['cboPurchaseOrderID'];

		 $query="SELECT p.*, sup.SupplierID, sup.SupplierName
				FROM purchaseorder p, supplier sup
				WHERE p.PurchaseOrderID='$cboPurchaseOrderID'
				AND p.SupplierID=sup.SupplierID
				";
		$result=mysqli_query($connection,$query);
	}
	elseif($rdoSearchType == 2) 
	{
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));
		$To=date('Y-m-d',strtotime($_POST['txtTo']));

		$query="SELECT p.*, s.StaffID, s.StaffName
				FROM purchaseorder p, supplier sup
				WHERE p.PurchaseOrderDate BETWEEN '$From' AND '$To'
				AND p.StaffID=s.StaffID
				";
		$result=mysqli_query($connection,$query);
	}
	else
	{
		$cboStatus=$_POST['cboStatus'];

		$query="SELECT p.*, s.StaffID, s.StaffName
				FROM purchaseorder p, staff s
				WHERE p.Status='$cboStatus'
				AND p.StaffID=s.StaffID
				AND p.StaffID='StaffName'
				";
		$result=mysqli_query($connection,$query);
	}
}
elseif(isset($_POST['btnShowAll']))
{
	$query="SELECT p.*, s.StaffID, s.StaffName
				FROM purchaseorder p, Staff s
				WHERE p.StaffID=s.StaffID
				
				";
	$result=mysqli_query($connection,$query);
}
else
{
	$today=date('Y-m-d');

	$query="SELECT p.*, s.StaffID, s.StaffName
				FROM purchaseorder p, staff s
				WHERE p.PurchaseOrderDate='$today'
				AND p.StaffID=s.StaffID
				";
	$result=mysqli_query($connection,$query);
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Report List</title>
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
	<span class="custom-control-label">Search by Purchase_ID</span>  
	<select name="cboPurchaseOrderID">
		<option>Choose Purchase ID</option>
		<?php  
		$Purchase_Query="SELECT * FROM purchaseorder";
		$Purchase_ret=mysqli_query($connection,$Purchase_Query);
		$Purchase_count=mysqli_num_rows($Purchase_ret);

		for($i=0;$i<$Purchase_count;$i++) 
		{ 
			$Purchase_arr=mysqli_fetch_array($Purchase_ret);
			$PurchaseOrderID=$Purchase_arr['PurchaseOrderID'];

			echo "<option value='$PurchaseOrderID'>$PurchaseOrderID</option>";
		}
		?>
	</select>
</label>
	</td>
	<tr></tr>
	<td>
		 <label class="custom-control custom-radio">
	<input type="radio" name="rdoSearchType" value="2" name="radio-stacked" checked="" class="custom-control-input"/>
	<span class="custom-control-label">	Search by Purchase Date: </span>  
	<br/> <br> 
	From <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" />
	To	<input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" />
</label>
	</td>

	<tr></tr>
	<td>
		 <label class="custom-control custom-radio">
	<input type="radio" name="rdoSearchType" value="3" name="radio-stacked" checked="" class="custom-control-input"/>
	<span class="custom-control-label">	Search by Status </span>  

	Search by Status <br/>
	<select name="cboStatus">
		<option>Pending</option>
		<option>Confirmed</option>
	</select>
</label>
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
<legend>Purchase Results</legend>
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
	<th>Purchase_ID</th>
	<th>Purchase_Date</th>
	<th>Staff Name</th>
	<th>Total Amount</th>
	<th>Total Quantity</th>
	<th>Grand Total</th>
	<th>Status</th>
	<th>Action</th>
</tr>
<?php 
	for ($i=0;$i<$count;$i++) 
	{ 
		$rows=mysqli_fetch_array($result);
		$PurchaseOrderID=$rows['PurchaseOrderID'];
		echo "<tr>";
		echo "<td>" . $rows['PurchaseOrderID'] ."</td>";
		echo "<td>" . $rows['PurchaseOrderDate'] ."</td>";
		echo "<td>" . $_SESSION['StaffName'] ."</td>";
		echo "<td>" . $rows['TotalAmount'] ."</td>";
		echo "<td>" . $rows['TotalQuantity'] ."</td>";
		echo "<td>" . $rows['GrandTotal'] ."</td>";
		echo "<td>" . $rows['Status'] ."</td>";
		echo "<td>
			  <a href='PurchaseDetailReport.php?PurchaseOrderID=$PurchaseOrderID'>More..</a>
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