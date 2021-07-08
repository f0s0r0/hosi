<?php
$hostname = '192.168.16.6:3307';
$hostlogin = 'integ_user';
$hostpassword = 'integ123';
$databasename = 'smartlink';

//Folder Name Change Only Necessary

$link = mysql_connect($hostname,$hostlogin,$hostpassword) or die('Could not connect Database : ' . mysql_error());
mysql_select_db($databasename) or die('Could not select database'. mysql_error());
$customersearch = $_REQUEST['customersearch'];
$registrationdate = $_REQUEST['registrationdate'];

$query1 = "select * from exchange_files where Member_Nr = '$customersearch' and Progress_Flag = '1' and DATE(Smart_Date) = '$registrationdate'";
//$query1 = "select * from exchange_files where Progress_Flag = '1'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$num = mysql_num_rows($exec1);


	$Smart_File = $res1['Smart_File'];
	$Admit_ID = $res1['Admit_ID'];
//echo $Member_Nr = $res1['Member_Nr'];
	//echo $Smart_Date = $res1['Smart_Date'];
	
	$myXMLData = $Smart_File;
	
	if($num > 0)
	{
		$xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
		//print_r($xml);
	}
	
	
	if($num > 0)
	{
		echo $xml->Benefits->Benefit->Nr."#".$xml->Benefits->Benefit->Amount."#".$Admit_ID.'';
	}
	else
	{
		echo '0'."#".'0'."#".'0';
	}


?>
