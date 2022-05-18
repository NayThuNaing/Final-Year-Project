<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('Production_Functions.php');
include('header.php');

if(isset($_POST['btnSearch'])) 
{
	 $rdoSearchType=$_POST['rdoSearchType'];

	if ($rdoSearchType == 1) 
	{
		 $cboProductionID=$_POST['cboProductionID'];

		 $query="SELECT p.*, st.StaffID
		 FROM production p, staff st
		 WHERE p.ProductionID='$cboProductionID'
		 AND p.StaffID=st.StaffID
				";
		$result=mysqli_query($connection,$query);
		
	}
	elseif($rdoSearchType == 2) 
	{
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));
		$To=date('Y-m-d',strtotime($_POST['txtTo']));

		$query="SELECT p.*, st.StaffID, st.StaffName
				FROM production p, staff st
				WHERE p.ProductionDate BETWEEN '$From' AND '$To'
				AND p.StaffID=st.StaffID
				";
		$result=mysqli_query($connection,$query);
		
	}
	
}
elseif(isset($_POST['btnShowAll']))
{
	$query="SELECT p.*, s.StaffID, s.StaffName
				FROM production p, Staff s
				WHERE p.StaffID=s.StaffID
				";
	$result=mysqli_query($connection,$query);
}
else
{
	$today=date('Y-m-d');

	$query="SELECT p.*, s.StaffID, s.StaffName
				FROM production p, staff s
				WHERE p.ProductionDate='$today'
				AND p.StaffID=s.StaffID
				";
	$result=mysqli_query($connection,$query);
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Procution Report List</title>
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
	<span class="custom-control-label">Search by Production_ID</span>  
	<select name="cboProductionID">
		<option>Choose Priduction ID</option>
		<?php  
		$Production_Query="SELECT * FROM production";
		$Production_ret=mysqli_query($connection,$Production_Query);
		$Production_count=mysqli_num_rows($Production_ret);

		for($i=0;$i<$Production_count;$i++) 
		{ 
			$Production_arr=mysqli_fetch_array($Production_ret);
			$ProductionID=$Production_arr['ProductionID'];

			echo "<option value='$ProductionID'>$ProductionID</option>";
		}
		?>
	</select>
</label>
	</td>
	<tr></tr>
	<td>
		 <label class="custom-control custom-radio">
	<input type="radio" name="rdoSearchType" value="2" name="radio-stacked" checked="" class="custom-control-input"/>
	<span class="custom-control-label">	Search by Production Date: </span>  
	<br/> <br> 
	From <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" />
	To	<input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" OnClick="showCalender(calender,this)" />
</label>
	</td>

	<tr></tr>
	<td>
		 
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
<legend>Production Results</legend>
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
	<th>Production_ID</th>
	<th>Production_Date</th>
	<th>Staff Name</th>
	<th>Raw Total Quantity</th>
	<th>Raw Price</th>
    <th>Product Size</th>
    <th>Product Qty</th>

	<th>Action</th>
</tr>
<?php 
	for ($i=0;$i<$count;$i++) 
	{ 
		$rows=mysqli_fetch_array($result);
		$ProductionID=$rows['ProductionID'];
		echo "<tr>";
		echo "<td>" . $rows['ProductionID'] ."</td>";
		echo "<td>" . $rows['ProductionDate'] ."</td>";
		echo "<td>" . $rows['StaffName'] ."</td>";
        echo "<td>" . $rows['TotalRawQty'] ."</td>";
		echo "<td>" . $rows['TotalRawPrice'] ."</td>";
		echo "<td>" . $rows['ProductSize'] ."</td>";
        echo "<td>" . $rows['Qty'] ."</td>";

	
		echo "<td>
			  <a href='ProductionDetailReport.php?ProductionID=$ProductionID'>More..</a>
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