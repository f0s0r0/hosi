<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];

$searchsuppliername = $_REQUEST['searchsuppliername'];
$stocks = '';
$stringbuild100 = "";
$query1 = "select * from master_ipvisitentry where patientfullname like '%$searchsuppliername%' order by patientfullname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{

	$res1customercode = $res1['patientcode'];
	$res1customername = $res1['patientfirstname'];
	$res1customerfullname=$res1['patientfullname'];
	$res1customervisitcode=$res1['visitcode'];
	$date = $res1['consultationdate'];
	$accountname = $res1['accountname'];
	 $query67 = "select * from master_accountname where auto_number='$accountname'";
	$exec67 = mysql_query($query67); 
	$res67 = mysql_fetch_array($exec67);
	$accname = $res67['accountname'];
		
	$querys = "SELECT * FROM `master_customer` where customercode = '$res1customercode'";
	$execs = mysql_query($querys) or die ("Error in Query4".mysql_error());
	$ress = mysql_fetch_array($execs);
	$dob = $ress['dateofbirth'];
	$days = (strtotime($date) - strtotime($dob))/86400;
		if($days >= 5)
	{
		$res1customercode = addslashes($res1customercode);
		$res1customername = addslashes($res1customername);
		$res1customerfullname=addslashes($res1customerfullname);
		$res1customervisitcode=addslashes($res1customervisitcode);
		
		$res1customercode = strtoupper($res1customercode);
		$res1customername = strtoupper($res1customername);
		$res1customerfullname=strtoupper($res1customerfullname);
		$res1customervisitcode=strtoupper($res1customervisitcode);
		
		$res1customercode = trim($res1customercode);
		$res1customername = trim($res1customername);
		$res1customervisitcode = trim($res1customervisitcode);
		
		$res1customercode = preg_replace('/,/', ' ', $res1customercode);
		$res1customername = preg_replace('/,/', ' ', $res1customername);
		$res1customervisitcode = preg_replace('/,/', ' ', $res1customervisitcode);

	
				if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res1customerfullname.'||'.$res1customercode.'||'.$res1customervisitcode.'||'.$accname.'';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res1customerfullname.'||'.$res1customercode.'||'.$res1customervisitcode.'||'.$accname.'';
			}
	}

}

echo $stringbuild100;



?>