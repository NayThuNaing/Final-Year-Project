<?php  
function AddRawMaterials($RawMaterialsID,$RawPrice,$RawQuantity)
{
	include('connection.php');

	$query="SELECT * FROM RawMaterials WHERE RawMaterialsID='$RawMaterialsID'";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$row=mysqli_fetch_array($ret);

	$RawMaterialsName=$row['RawMaterialsName'];
	if($count < 1) 
	{
		return false;
	}

	if ($RawQuantity < 1) 
	{
		echo "<script>window.alert('ERROR : Incorrect RawMaterials Quantity')</script>";
		echo "<script>window.location='Production.php'</script>";
	}

	if(isset($_SESSION['PROFunctions'])) 
	{
		$index=IndexOf($RawMaterialsID);

		if($index == -1) 
		{
			$size=count($_SESSION['PROFunctions']);

			$_SESSION['PROFunctions'][$size]['RawMaterialsID']=$RawMaterialsID;
			$_SESSION['PROFunctions'][$size]['RawPrice']=$RawPrice;
			$_SESSION['PROFunctions'][$size]['RawQuantity']=$RawQuantity;
			$_SESSION['PROFunctions'][$size]['RawMaterialsName']=$RawMaterialsName;
		}
		else
		{
			$_SESSION['PROFunctions'][$index]['RawQuantity']+=$RawQuantity;
		}
	}
	else
	{
		$_SESSION['PROFunctions']=array();

		$_SESSION['PROFunctions'][0]['RawMaterialsID']=$RawMaterialsID;
		$_SESSION['PROFunctions'][0]['RawPrice']=$RawPrice;
		$_SESSION['PROFunctions'][0]['RawQuantity']=$RawQuantity;
		$_SESSION['PROFunctions'][0]['RawMaterialsName']=$RawMaterialsName;
	}

	echo "<script>window.location='Production.php'</script>";
}

function RemoveRawMaterials($RawMaterialsID)
{
	$index=IndexOf($RawMaterialsID);

	unset($_SESSION['PROFunctions'][$index]);
	$_SESSION['PROFunctions']=array_values($_SESSION['PROFunctions']);

	echo "<script>window.location='Production.php'</script>";

}

function ClearAll()
{
	unset($_SESSION['PROFunctions']);
	echo "<script>window.location='Production.php'</script>";
}

function CalculateTotalRawPrice()
{
	$TotalRawPrice=0;

	$size=count($_SESSION['PROFunctions']);

	for ($i=0;$i<$size;$i++) 
	{ 
		$RawPrice=$_SESSION['PROFunctions'][$i]['RawPrice'];
		$RawQuantity=$_SESSION['PROFunctions'][$i]['RawQuantity'];

		$TotalRawPrice+=($RawPrice * $RawQuantity);
	}

	return $TotalRawPrice;
}

function CalculateTotalRawQuantity()
{
	$TotalRawQuantity=0;

	$size=count($_SESSION['PROFunctions']);

	for ($i=0;$i<$size;$i++) 
	{ 
		$RawQuantity=$_SESSION['PROFunctions'][$i]['RawQuantity'];

		$TotalRawQuantity+=$RawQuantity;
	}

	return $TotalRawQuantity;
}

function IndexOf($RawMaterialsID)
{
	if(!isset($_SESSION['PROFunctions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['PROFunctions']);

	if ($size < 1) 
	{
		return -1;
	}

	for ($i=0; $i < $size; $i++) 
	{ 
		if ($RawMaterialsID == $_SESSION['PROFunctions'][$i]['RawMaterialsID']) 
		{
			return $i;
		}
	}
	return -1;
}

?>