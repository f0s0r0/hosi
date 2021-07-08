<?php
$hostname = '192.168.16.6:3307';
$hostlogin = 'integ_user';
$hostpassword = 'integ123';
$databasenamesmart = 'smartlink';
//Folder Name Change Only Necessary
$appfoldername = 'avenue_s3';

$fileData1 = '';

date_default_timezone_set('Africa/Nairobi'); 

$link = mysql_connect($hostname,$hostlogin,$hostpassword) or die('Could not connect Table : ' . mysql_error());
mysql_select_db($databasenamesmart) or die('Could not select database'. mysql_error());


$sno = 0;
$claimdate = date('Y-m-d');
$claimtime = date('H:i:s');


 //$importData = $fileDatatop.$fileData1;

$updatedate = date('Y-m-d H:i:s');

$sql = "UPDATE exchange_files SET Exchange_File = '$importData', Exchange_Date = '$updatedate', Progress_Flag = '2' WHERE Member_Nr = '$patientcode' AND Progress_Flag = '1' order by ID desc limit 1";
$current_id = mysql_query($sql) or die("<b>Error:</b> Problem on File Insert<br/>" . mysql_error());

//header("location:billing_pending_op2.php?billautonumber=$billautonumber&&st=success&&printbill=$printbill");
//exit;
?>
