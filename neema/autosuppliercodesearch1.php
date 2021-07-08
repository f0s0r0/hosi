<?php
session_start();
include ("db/db_connect.php");


if (isset($_REQUEST["suppliersearch"])) { $suppliersearch = $_REQUEST["suppliersearch"]; } else { $suppliersearch = ""; }
$searchresult = "";

	
$query3 = "select * from master_accountname where accountname like '%$suppliersearch%' and accountssub = '19' limit 0,20";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
while($res3 = mysql_fetch_array($exec3))
{
	$res3suppliercode = $res3['id'];

	$suppliercode = $res3['id'];
	$suppliername = $res3['accountname'];


	if ($searchresult == '')
	{
		$searchresult = ''.$suppliercode.'||'.$suppliername.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$suppliercode.'||'.$suppliername.'';
	}

}

//}	

if ($searchresult != '')
{
	echo $searchresult;
}


?>