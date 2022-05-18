<?php 

include('connection.php');
$ProductID=$_GET['ProductID'];
$Delete="DELETE FROM Product WHERE ProductID='$ProductID'";
$result=mysqli_query($connection,$Delete);


if($result) //True
{
	echo "<script>window.alert('SUCCESS : Product Account Deleted.')</script>";
	echo "<script>window.location='ProductEntry.php'</script>";
}
else
{
	echo "<p>Error : Something went wrong in ProductSupplier Delete" . mysqli_error($connection) . "</p>";
}
?>

