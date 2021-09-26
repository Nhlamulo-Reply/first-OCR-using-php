<?php
require_once('dbconnection.php');

function vote()
{
	$totalMarks= 0;
	$sel = "select * from vote WHERE partyName = $_SESSION['partyName']";
	$ret = mysqli_query($con,$sel);
	
	while($row=mysqli_fetch_array($ret))
	{
		$totalMarks = $totalMarks + row['votes'];
	}
	 
	 return($totalMarks);
 }
?>


