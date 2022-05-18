<?php  
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Home</title>
</head>
<body>
<form action="#" method="#">
Welcome! 
<a href="Customer_Profile.php?CustomerID=<?php echo $_SESSION['CustomerID'] ?>">
	<img src="<?php echo $_SESSION['Image'] ?>" width="20px" height="20px"/>
	<b><?php echo $_SESSION['CustomerName']?></b> 	
</a>



|

<a href="Logout.php">Logout</a>

<hr/>


<a href="ProductDisplay.php">Product List</a>


</form>
</body>
</html>