<?php 

include('connection.php');
$TownshipID=$_GET['TownshipID'];
$Delete="DELETE FROM Township WHERE TownshipID='$TownshipID'";
$result=mysqli_query($connection,$Delete);


if($result) //True
{
	echo "<script>window.alert('SUCCESS : Township Account Deleted.')</script>";
	echo "<script>window.location='Township.php'</script>";
}
else
{
	echo "<p>Error : Something went wrong in Township Delete" . mysqli_error($connection) . "</p>";
}
?>

