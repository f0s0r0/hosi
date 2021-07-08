<?php
//session_start();
include ("db/db_connect.php");

//$searchsuppliername = $_REQUEST['searchsuppliername'];
$searchcountyname = $_REQUEST['searchcountyname'];

$stringbuild1 = "";
$query1 = "select * from master_state where status <> 'deleted' and state like '%".$searchcountyname."%' order by state";
			$exec1 = mysql_query($query1) or die ("Error in Query1.state".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$state = $res1["state"];
	$res2anum = $res1['auto_number'];
	//$res2accountname = $res2['accountname'];
	
	$state = addslashes($state);

	$state = strtoupper($state);
	
	$state = trim($state);
	
	$state = preg_replace('/,/', ' ', $state); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$state.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$state.' ';
	}
}

echo $stringbuild1;



?>