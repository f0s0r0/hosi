<?php 
session_start();

include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$i=0;
$batchbuild = '';
//here get location code and store code
//$locationcode=$_REQUEST['locationcode'];
//$storecode=$_REQUEST["tostore22"];


 $itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';
 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 $storecode=isset($_REQUEST['fromstore'])?$_REQUEST['fromstore']:'';
// $storecode=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:'';
 $loopcount = '0';
 
 /* $query44="select itemcode,batchnumber,companyanum from purchase_details where store='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode'";
$exec44=mysql_query($query44);
$numb44=mysql_num_rows($exec44);
while($res44=mysql_fetch_array($exec44))
{
$i=0;
$itemcode = $res44['itemcode'];
$batchname = $res44['batchnumber']; 
$companyanum = $_SESSION["companyanum"];
$itemcode = $itemcode;
$batchname = $batchname;

include ('autocompletestockbatch.php');
$currentstock = $currentstock;		

if($batchbuild == '')
{
$batchbuild = $batchname.'||'.$currentstock.'';
}
else
{
$batchbuild = $batchbuild.','.$batchname.'||'.$currentstock.'';
}
}*/



$query44="select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
$exec44=mysql_query($query44);
$numb44=mysql_num_rows($exec44);
while($res44=mysql_fetch_array($exec44))
{
$i=0;
$itemcode = $res44['itemcode'];
$batchname = $res44['batchnumber']; 
$currentstock = $res44["batch_quantity"];
$itemcode = $itemcode;
$batchname = $batchname;
$description = $res44["description"];
$fifo_code = $res44["fifo_code"];

$queryop44="select fifo_code from transaction_stock where fifo_code='$fifo_code' and description='OPENINGSTOCK'";
$execop44=mysql_query($queryop44);
$numbop44=mysql_num_rows($execop44);
if($numbop44>0)
{
	$color='#FFCC99';
}
else
{
	$color='#FFFFFF';
}
//$currentstock = $currentstock;		

if($batchbuild == '')
{
$batchbuild = $batchname.'||'.$currentstock.'||'.$color.'||'.$fifo_code.'';
}
else
{
$batchbuild = $batchbuild.','.$batchname.'||'.$currentstock.'||'.$color.'||'.$fifo_code.'';
}
}
echo 'Select Batch'.'||'.'0'.','.$batchbuild;

?>