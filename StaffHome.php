<?php  
session_start();
include('header.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Home</title>
</head>
<fieldset>
<body>
<form action="StaffHome.php" method="POST">
<b>Warmly Welcome To This Website!</b>
<a href="StaffProfile.php?StaffID=<?php echo $_SESSION['StaffID'] ?>"><br>
	<img src="<?php echo $_SESSION['StaffImage'] ?>" width="100px" height="100px"/>
	<b><?php echo $_SESSION['StaffName'] ?></b> 	
</a>
|

<a href="Logout.php">Logout</a><br>

<hr/>

<a href="StaffEntry.php">Manage Staff</a> |<br><br>
<a href="Purchase_Order.php">Manage Purchase</a><br><br>
<a href="PurchaseReport.php">Purchase Report</a>


</form>
</body>
</fieldset>
</html>
<?php 
include('footer.php');
 ?>