<?php 

include('connection.php');
$SupplerID=$_GET['SupplierID'];
$Delete="DELETE FROM Supplier WHERE SupplierID='$SupplerID'";
$result=mysqli_query($connection,$Delete);


if($result) //True
{
	echo "<script>window.alert('SUCCESS : Supplier Account Deleted.')</script>";
	echo "<script>window.location='SupplierEntry.php'</script>";
}
else
{
	echo "<p>Error : Something went wrong in Supplier Delete" . mysqli_error($connection) . "</p>";
}
?>

