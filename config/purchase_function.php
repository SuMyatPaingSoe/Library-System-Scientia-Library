<?php 
function Add($bookid,$purchaseprice,$purchasequantity)
{
	include('config/connect.php');
	$query="SELECT * FROM books WHERE book_id='$bookid'";
	$ret=mysqli_query($connect,$query);
	$count=mysqli_num_rows($ret);
	if ($count<1)
	 {
		echo "<p>NO Record Found.</p>";
		exit();
	}
	$arr=mysqli_fetch_array($ret);
	$booktitle=$arr['book_title'];
	$image1=$arr['cover'];
	if(isset($_SESSION['purchase_function'])) 
	{
	  $index=IndexOf($bookid);
	  if($index==-1)	
	  {
	  	$size=count($_SESSION['purchase_function']);

	  	$_SESSION['purchase_function'][$size]['book_id']=$bookid;
	  	$_SESSION['purchase_function'][$size]['book_title']=$booktitle;
	  	$_SESSION['purchase_function'][$size]['purchase_price']=$purchaseprice;
	  	$_SESSION['purchase_function'][$size]['purchase_quantity']=$purchasequantity;
	  	$_SESSION['purchase_function'][$size]['cover']=$image1;

	  
	}
	else
	{
      
	  	$_SESSION['purchase_function'][$index]['purchase_quantity']+=$purchasequantity;
	  	
	}
	}
	else
	{
		$_SESSION['purchase_function']=array();
        $_SESSION['purchase_function'][0]['book_id']=$bookid;
        $_SESSION['purchase_function'][0]['book_title']=$booktitle;
        $_SESSION['purchase_function'][0]['purchase_price']=$purchaseprice;
        $_SESSION['purchase_function'][0]['purchase_quantity']=$purchasequantity;
        $_SESSION['purchase_function'][0]['cover']=$image1;
	}
	echo "<script>window.location='book_purchase.php'</Script>";

}


function IndexOf($bookid)
{
	if(!isset($_SESSION['purchase_function']))
	{
		return -1;
	}
	$size=count($_SESSION['purchase_function']);
	if($size==0)
	{
		return -1;
	}
	for($i=0; $i<$size; $i++)
	{
		if($bookid==$_SESSION['purchase_function'][$i]['book_id'])
		{
		return $i;
		}
	}
	return -1;
}

function Remove($bookid)
{
	$index=IndexOf($bookid);
	if($index!=-1)
	{
		unset($_SESSION['purchase_function'][$index]);
		echo "<script>window.location='book_purchase.php'</script>";
	}
}

function ClearAll() {
	unset($_SESSION['purchase_function']);
	echo "<script>window.location='book_purchase.php'</script>";
}

function CalculateTotalAmount()
{
	$totalamount=0;
	$size=count($_SESSION['purchase_function']);
	for ($i=0; $i <$size ; $i++)
	 { 
		$purchaseprice=$_SESSION['purchase_function'][$i]['purchase_price'];
		$purchasequantity=$_SESSION['purchase_function'][$i]['purchase_quantity'];
		$totalamount=$totalamount + ($purchaseprice* $purchasequantity);
	}
	return $totalamount;
}

function CalculateTotalQuantity()
{
	$Qty=0;

	$size=count($_SESSION['purchase_function']);

	for ($i=0; $i <$size ; $i++) 
	{ 
		$quantity=$_SESSION['purchase_function'][$i]['purchase_quantity'];
		$Qty=$Qty + ($quantity);
	}
	return $Qty;
}
 ?>