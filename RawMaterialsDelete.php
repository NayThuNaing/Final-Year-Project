<?php 

include('connection.php');
$RawMaterialsID=$_GET['RawMaterialsID'];
$Delete="DELETE FROM RawMaterials WHERE RawMaterialsID='$RawMaterialsID'";
$result=mysqli_query($connection,$Delete);


if($result) //True
{
	echo "<script>window.alert('SUCCESS : RawMaterials Account Deleted.')</script>";
	echo "<script>window.location='RawMaterialsEntry.php'</script>";
}
else
{
	echo "<p>Error : Something went wrong in RawMaterials Delete" . mysqli_error($connection) . "</p>";
}
?>

