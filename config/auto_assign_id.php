<?php
function assign_id($tableName,$fieldName,$prefix,$noOfLeadingZeros)
{ 
	include('connect.php');

	$new_id="";
	$sql="";
	$value=1;
	
	$sql="SELECT " . $fieldName . " FROM " . $tableName . " ORDER BY " . $fieldName . " DESC";	
	
	$result = mysqli_query($connect,$sql);
	$no_of_rows=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);		
	
	if ($no_of_rows < 1)
	{		
		return $prefix . "000001";
	}
	else
	{
		$oldID=$row[$fieldName];	//Reading Last ID
		$oldID=str_replace($prefix,"",$oldID);	//Removing "Prefix"
		$value=(int)$oldID;	//Convert to Integer
		$value++;	//Increment		
		$newID=$prefix . NumberFormatter($value,$noOfLeadingZeros);			
		return $newID;		
	}
}

function NumberFormatter($number,$n) 
{	
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}
?>