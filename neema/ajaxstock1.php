 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$itemcode=isset($_REQUEST['q'])?$_REQUEST['q']:'';
$locationcode=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$storecode=isset($_REQUEST['sto'])?$_REQUEST['sto']:'';
$res1medicinename=isset($_REQUEST['strm'])?$_REQUEST['strm']:'';
$res1fifo_code=isset($_REQUEST['fifo_code'])?$_REQUEST['fifo_code']:'';
?>

<?php
$rate = 0;
$query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code,rate from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and fifo_code='$res1fifo_code'";
 $query57;
$res57=mysql_query($query57);
$num57=mysql_num_rows($res57);
while($exec57 = mysql_fetch_array($res57))
{
$batchname = $exec57['batchnumber']; 
 //$rate=$exec57['rate']; 
$companyanum = $_SESSION["companyanum"];
$itemcode = $itemcode;

$loccolumn = $locationcode.'_rateperunit';

$query7 = "select `$loccolumn` as rate from master_medicine where itemcode = '$itemcode'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$rate = $res7['rate'];

	//include ('autocompletestockbatch.php');
$currentstock = $exec57["batch_quantity"];
$fifo_code = $exec57["fifo_code"];
 $query66 ="SELECT count(availableqty) as avl FROM tempmedicineqty WHERE medicinecode='".$itemcode."' and batchname = '".$batchname."'";		
		$exec66 = mysql_query($query66) or die(mysql_error());
		$res66 = mysql_fetch_array($exec66);
		$availableqty = $res66['avl'];
		if($availableqty > 0 && $availableqty!='')
		{
			//$currentstock=$currentstock-$availableqty;
		}
		$currentstock=''.$currentstock.'||'.$rate.'||';
echo $currentstock;
 } ?>
