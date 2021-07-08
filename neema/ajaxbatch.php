 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$itemcode=isset($_REQUEST['q'])?$_REQUEST['q']:'';
$locationcode=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$storecode=isset($_REQUEST['sto'])?$_REQUEST['sto']:'';
$res1medicinename=isset($_REQUEST['strm'])?$_REQUEST['strm']:'';
?>
<option value="">Select</option>
<?php

//$res1medicinename="PARACETAMOL BP 500MG TABS";
$query35=mysql_query("select * from master_itempharmacy where itemname='$res1medicinename'");
$exec35=mysql_fetch_array($query35);
if($itemcode == '')
{
$itemcode=$exec35['itemcode'];
}
$query36=mysql_query("select * from purchase_details where itemname='$res1medicinename'");
$exec36=mysql_fetch_array($query36);
$batch=$exec36['batchnumber'];
$query38 = mysql_query("select * from purchase_details where itemname='$res1medicinename' ");
$rowcount=mysql_num_rows($query38);

$query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
 $query57;
$res57=mysql_query($query57);
$num57=mysql_num_rows($res57);
 $num57;?>


<?php
while($exec57 = mysql_fetch_array($res57))
{
if($loopcontrol != 'stop')
{
  $batchname = $exec57['batchnumber']; 
  $batchname = $exec57['batchnumber']; 
 $batchname;
 $fifo_code = $exec57["fifo_code"];
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	//include ('autocompletestockbatch.php');
	$currentstock = $exec57["batch_quantity"];
	$currentstock = $currentstock;
	 $currentstock;
	 $availableqty=0;
	 $query66 ="SELECT count(availableqty) as avl FROM tempmedicineqty WHERE medicinecode='".$itemcode."' and batchname = '".$batchname."'";		
		$exec66 = mysql_query($query66) or die(mysql_error());
		$res66 = mysql_fetch_array($exec66);
		$availableqty = $res66['avl'];
		if($availableqty > 0 && $availableqty!='')
		{
			//$currentstock=$currentstock-$availableqty;
		}
		
	?>
    <option value="<?php echo $batchname,'((',$fifo_code;?>"><?php echo $batchname,'(',$currentstock,')';?></option>
	
	  <?php
	  $loopcontrol=$loopcontrol+1;
	if($currentstock > 0 )
	{
//$totalstock = $totalstock+$currentstock;
/*if($totalstock >= $res1quantity)
{

$issuequantity = $res1quantity-$oldstock;
}
 else
 {
 $issuequantity = $currentstock;
 $oldstock = $oldstock+$currentstock;

 $pending=$res1quantity-$oldstock;

 }	*/
 $res1medicinename1=$res1medicinename;
 /*if($oldmedicinename == $res1medicinename)
 {
 $res1medicinename1='';
 $res1dose='';
 $res1frequency='';
 $res1days='';
 
 }*/
 $oldmedicinename=$res1medicinename;
 }
 }
 } $loopcontrol=1;?>
