<?php 

include('connection.php');
$StaffID=$_GET['StaffID'];
$Delete="DELETE FROM Staff WHERE StaffID='$StaffID'";
$result=mysqli_query($connection,$Delete);


if($result) //True
{
	echo "<script>window.alert('SUCCESS : Staff Account Deleted.')</script>";
	echo "<script>window.location='StaffEntry.php'</script>";
}
else
{
	echo "<p>Error : Something went wrong in Staff Delete" . mysqli_error($connection) . "</p>";
}
?>

