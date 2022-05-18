<?php  
session_start();
include('connection.php');
include('AutoID_Functions.php');
include('Production_Functions.php');
include('header.php');

if(isset($_POST['btnConfirm'])) 
{
	$txtProductionID=$_POST['txtProductionID'];

	$query=mysqli_query($connection, "SELECT * FROM productiondetail WHERE ProductionID='$txtProductionID'");

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



	if($ret) //True
	{
		echo "<script>window.alert('SUCCESS : Productuon Successfully Confirmed.')</script>";
		echo "<script>window.location='ProductionReport.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Production Details" . mysqli_error($connection) . "</p>";
	}


}

if (isset($_GET['ProductionID'])) 
{
	$ProductionID=$_GET['ProductionID'];
	
	$query1="SELECT p.*, s.StaffID,s.StaffName
			FROM production p, staff s
			WHERE p.StaffID=s.StaffID
			AND p.ProductionID='$ProductionID'
			";
	$result1=mysqli_query($connection,$query1);
	$row1=mysqli_fetch_array($result1);

	$query2="SELECT p.*, pd.*, r.RawMaterialsID, r.RawMaterialsName
			FROM production p, productiondetail pd, rawmaterials r
			WHERE p.ProductionID=pd.ProductionID
			AND pd.RawMaterialsID=r.RawMaterialsID
			AND p.ProductionID='$ProductionID'
			";
	//echo $query2;
	$result2=mysqli_query($connection,$query2);
	$count=mysqli_num_rows($result2);
	
}
else
{
	$ProductionID="";

	echo "<script>window.alert('ERROR : Puroduction Details not Found.')</script>";
	echo "<script>window.location='ProductionReport.php'</script>"; 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Production Details</title>
</head>
<body>
<form action="ProductionDetailReport.php" method="POST">

<fieldset>
	<tr>
<legend>Production Detail Report for POID : <?php echo $ProductionID ?></legend>

<table align="center" border="1" cellpadding="7px">
<tr>
	<td>Production_ID</td>
	<td><b><?php echo $ProductionID ?></b></td>

<tr>
<tr>
	<td>Production Date</td>
	<td><b><?php echo $row1['ProductionDate'] ?></b></td>
</tr>
	<td>Report Date</td>
	<td><b><?php echo date('Y-m-d') ?></b></td>
</tr>

<tr>

	<td>StaffName</td>
	<td><b><?php echo $row1['StaffName'] ?></b></td>
</tr>
<tr>
<tr>
	<td colspan="4">
		<table align="center" border="1">
			<tr>
				<th>RawMaterialsName</th>
				<th>Raw_Price</th>
				<th>Raw_Quantity</th>
				<th>Sub-Total</th>
			</tr>
		</tr>
			<?php  
			for ($i=0; $i < $count ; $i++) 
			{ 
				$row2=mysqli_fetch_array($result2);
				echo "<tr>";
				echo "<td>" . $row2['RawMaterialsName'] ."</td>";
				echo "<td>" . $row2['RawPrice'] ."</td>";
				echo "<td>" . $row2['RawQuantity'] ."</td>";
				echo "<td>" . ($row2['RawPrice'] * $row2['RawQuantity']) ."</td>";
				echo "</tr>";
				
			}

			?>
		</table>
	</td>
</tr>
<tr>
<tr>
	<td colspan="4" align="right">
	Total RawQty : <b><?php echo $row1['TotalRawQty'] ?> pcs</b> <br/>
	GrandTotal : <b><?php echo $row1['TotalRawPrice'] ?> USD</b> <br/>
	
	</td>
</tr>
</tr>
<tr>
<tr>
	<td colspan="4" align="right">
	<input type="hidden" name="txtProductionID" value="<?php echo $ProductionID ?>" />
	<?php  

	
		echo "<input type='submit' name='btnConfirm' value='Confirm'/>";
	
	
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