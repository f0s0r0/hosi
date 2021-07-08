<?php
session_start();
include ("db/db_connect.php");

$accountnamesearch=isset($_REQUEST['accountnamesearch'])?$_REQUEST['accountnamesearch']:'';
//$maintype=isset($_REQUEST['maintype'])?$_REQUEST['maintype']:'';
//$subtype=isset($_REQUEST['subtype'])?$_REQUEST['subtype']:'';

$stringbuild1 = "";
$query2 = "select * from master_accountname where accountname like '%$accountnamesearch%' and accountssub = '17' and recordstatus <> 'Deleted'";// order by accountname limit 0, 15";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2accountname = $res2['accountname'];
	$res2expirydate = $res2['expirydate'];
	
	$res2accountname = addslashes($res2accountname);

	$res2accountname = strtoupper($res2accountname);
	
	$res2accountname = trim($res2accountname);
	
	$res2accountname = preg_replace('/,/', ' ', $res2accountname); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2accountname.' #'.$res2anum.'#'.$res2expirydate;
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2accountname.' #'.$res2anum.'#'.$res2expirydate;
	}
}

echo $stringbuild1;






?>