<!--function funcBatchbuild1()
{
-->
<option value="">Select Batch</option>
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

//here get location code and store code
//$locationcode=$_REQUEST['locationcode'];
//$storecode=$_REQUEST["tostore22"];


 $itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';
 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 $storecode=isset($_REQUEST['fromstore'])?$_REQUEST['fromstore']:'';
 $loopcount = '0';
 
 $query44="select itemcode,batchnumber,companyanum from purchase_details where store='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode'";
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


?>
<option value="<?php echo $batchname;?>"><?php echo $batchname.' ('.$currentstock.')';?></option>
<?php

}
?><?php /*?><!--combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $batchname.' ('.$currentstock.')';?>", "<?php echo $batchname;?>"); --><?php */?>
