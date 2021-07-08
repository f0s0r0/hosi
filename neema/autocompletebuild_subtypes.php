<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = $_REQUEST['searchsubtype'];


$res12paymenttypeanum = $_GET['searchpaymentcode'];
$searchsuppliername1 = $_REQUEST['searchsubtype'];
$stringbuild1 = "";

$query2 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = '' and subtype like '%$searchsuppliername1%' order by subtype";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2subtype = $res2['subtype'];
	
	$res2subtype = addslashes($res2subtype);

	$res2subtype = strtoupper($res2subtype);
	
	$res2subtype = trim($res2subtype);
	
	$res2subtype = preg_replace('/,/', ' ', $res2subtype); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2anum.' #'.$res2subtype.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2anum.' #'.$res2subtype.'';
	}
}

echo $stringbuild1;



?>