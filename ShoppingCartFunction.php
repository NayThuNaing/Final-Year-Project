<?php  
function AddProduct($ProductID,$BuyQuantity)
{
	include('connection.php');

	$query="SELECT * FROM Product WHERE ProductID='$ProductID'";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$row=mysqli_fetch_array($ret);

	$ProductName=$row['ProductName'];
	$Quantity=$row['Quantity'];
	$Price=$row['Price'];
	$Image1=$row['Image1'];

	if($count < 1) 
	{
		return false;
	}

	if ($BuyQuantity < 1) 
	{
		echo "<script>window.alert('ERROR : Incorrect Buying Quantity')</script>";
		echo "<script>window.location='Purchase_Order.php'</script>";
	}

	if ($BuyQuantity > $Quantity) 
	{
		echo "<script>window.alert('ERROR : Incorrect Buying Quantity')</script>";
		echo "<script>window.location='Purchase_Order.php'</script>";
	}

	if(isset($_SESSION['ShoppingCartFunction'])) 
	{
		$index=IndexOf($ProductID);

		if($index == -1) 
		{
			$size=count($_SESSION['ShoppingCartFunction']);

			$_SESSION['ShoppingCartFunction'][$size]['ProductID']=$ProductID;
			$_SESSION['ShoppingCartFunction'][$size]['Price']=$Price;
			$_SESSION['ShoppingCartFunction'][$size]['BuyQuantity']=$BuyQuantity;
			$_SESSION['ShoppingCartFunction'][$size]['ProductName']=$ProductName;
			$_SESSION['ShoppingCartFunction'][$size]['Image1']=$Image1;
		}
		else
		{
			$_SESSION['ShoppingCartFunction'][$index]['BuyQuantity']+=$BuyQuantity;
		}
	}
	else
	{
		$_SESSION['ShoppingCartFunction']=array();

		$_SESSION['ShoppingCartFunction'][0]['ProductID']=$ProductID;
		$_SESSION['ShoppingCartFunction'][0]['Price']=$Price;
		$_SESSION['ShoppingCartFunction'][0]['BuyQuantity']=$BuyQuantity;
		$_SESSION['ShoppingCartFunction'][0]['ProductName']=$ProductName;
		$_SESSION['ShoppingCartFunction'][0]['Image1']=$Image1;
	}

	echo "<script>window.location='ShoppingCart.php'</script>";
}

function RemoveProduct($ProductID)
{
	$index=IndexOf($ProductID);

	unset($_SESSION['ShoppingCartFunction'][$index]);
	$_SESSION['ShoppingCartFunction']=array_values($_SESSION['ShoppingCartFunction']);

	echo "<script>window.location='ShoppingCart.php'</script>";

}

function ClearAll()
{
	unset($_SESSION['ShoppingCartFunction']);
	echo "<script>window.location='ShoppingCart.php'</script>";
}


function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['ShoppingCartFunction']);

	for ($i=0;$i<$size;$i++) 
	{ 
		$Price=$_SESSION['ShoppingCartFunction'][$i]['Price'];
		$BuyQuantity=$_SESSION['ShoppingCartFunction'][$i]['BuyQuantity'];

		$TotalAmount+=($Price * $BuyQuantity);
	}

	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$size=count($_SESSION['ShoppingCartFunction']);

	for ($i=0;$i<$size;$i++) 
	{ 
		$BuyQuantity=$_SESSION['ShoppingCartFunction'][$i]['BuyQuantity'];

		$TotalQuantity+=$BuyQuantity;
	}

	return $TotalQuantity;
}

function CalculateVAT()
{
	$VAT=0;

	$VAT=CalculateTotalAmount() * 0.05;

	return $VAT;
}

function IndexOf($ProductID)
{
	if(!isset($_SESSION['ShoppingCartFunction'])) 
	{
		return -1;
	}

	$size=count($_SESSION['ShoppingCartFunction']);

	if ($size < 1) 
	{
		return -1;
	}

	for ($i=0; $i < $size; $i++) 
	{ 
		if ($ProductID == $_SESSION['ShoppingCartFunction'][$i]['ProductID']) 
		{
			return $i;
		}
	}
	return -1;
}

?>