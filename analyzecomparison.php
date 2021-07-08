<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$errmsg = '';
$bgcolorcode = '';
$largevalue = 0;
$sno = '';
$colorloopcount = '';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frm1submit1 == 'frm1submit1')
{
	
	foreach($_POST['itemname'] as $key => $value)
	{
	$rfqnumber = $_POST['rfqnumber'][$key];
	$itemname = $_POST['itemname'][$key];
	$itemcode = $_POST['itemcode'][$key];
	$suppliername =  $_POST['suppliercoa'][$key];
	$suppliercode =  $_POST['suppliercode'][$key];
	$analyzedocno = $_REQUEST['docno'];
	$paynowbillprefix = 'RFQPO-';
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from master_rfqpurchaseorder where suppliercode = '$suppliercode' and recordstatus <> 'generated'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
 	$num2 = mysql_num_rows($exec2);
	$res2 = mysql_fetch_array($exec2);
 	$billnumber = $res2["billnumber"];

	$billdigit=strlen($billnumber);
	if($num2 > 0)
	{
		$billnumbercode = $billnumber;
		$status = 'generated';
	}
	else
	{
		$query24 = "select * from master_rfqpurchaseorder where recordstatus='generated' or recordstatus='ready'";
		$exec24 = mysql_query($query24) or die ("Error in Query2".mysql_error());
		while($res24 = mysql_fetch_array($exec24))
		{
			$billnumber = $res24['billnumber'];
			$billdigit=strlen($billnumber);
			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			
			$billnumbercode = intval($billnumbercode);
			if($billnumbercode > $largevalue)
			{
				$largevalue = $billnumbercode;
			}
		}
		$billnumbercode = $largevalue;
		
		$billnumbercode = $billnumbercode + 1;
		
		$maxanum = $billnumbercode;
		$status = 'ready';
		
		$billnumbercode = $paynowbillprefix .$maxanum;
		$openingbalance = '0.00';
	}
	
	
	 $query56="insert into master_rfqpurchaseorder(companyanum,billnumber,itemcode,itemname,username, ipaddress, billdate,suppliername,suppliercode,recordstatus,rfqnumber) values('$companyanum','$billnumbercode','$itemcode','$itemname','$username','$ipaddress','$currentdate','$suppliername','$suppliercode','$status','$analyzedocno')";
	 $exec56 = mysql_query($query56) or die(mysql_error());	
	 
	 	$query16 = "update master_rfq set status = 'generated',ponumber='$billnumbercode' where medicinecode = '$itemcode' and status='' and docno ='$rfqnumber'";
	$exec16 = mysql_query($query16) or die(mysql_error());
	}
	
	//$query16 = "update master_rfq set status = 'generated' where status = ''";
	//$exec16 = mysql_query($query16) or die(mysql_error());
	
	$query17 = "update master_rfqpurchaseorder set recordstatus = 'generated' where recordstatus = 'ready' and billnumber ='$rfqnumber'";
	$exec17 = mysql_query($query17) or die(mysql_error());

	$query18 = "update purchase_rfq set analyzestatus = 'completed' where docno = '$analyzedocno'";
	$exec18 = mysql_query($query18) or die(mysql_error().'QUERY 18');
	
	header("location:menupage1.php?mainmenuid=MM029");
}

if(isset($_REQUEST['billnumber']))
$docno = $_REQUEST['billnumber'];


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
-->
</style>
</head>
<script language="javascript">

function dataimport1verify()
{
	if (document.getElementById("uploadedfile").value == "")
	{
		alert ("Please Select The TAB Delimited File To Proceed.");
		return false;
	}
}

</script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popupcoasearchcomparison.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function validate()
{
var hasChecked = false;
var k=0;
var serial = document.getElementById("serial").value;

for(j=1;j<=serial;j++)
{

var chks = document.getElementById("paynowlabcode"+j+"").value;

if (chks != '')
{
k=k+1;
}
//alert(k);
//alert(serial);
if(parseInt(k) == parseInt(serial))
{

hasChecked = true;
}
}

if (hasChecked == false)
{
alert("Please select a Supplier for all items or click back button on the browser to exit Analyze Comparison");
return false;
}
return true;
}
</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
     <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
       <td width="97%" valign="top"><form action="analyzecomparison.php" method="post" name="form1" id="form1" onSubmit="return validate()">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td colspan="2">
                  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
					<tr>
	  <td>&nbsp;
	  </td>
	  </tr>
			<tr>
              <td bgcolor="#CCCCCC" class="bodytext3" colspan="8"><strong>Analyze</strong></td>
			 
		</tr>
					<tr>
					<td align="center" valign="center" class="bodytext31"><strong>Date</strong></td>
					<td align="left" valign="center" class="bodytext31"><?php echo $currentdate; ?></td>
					<td align="center" valign="center" class="bodytext31"><strong>User</strong></td>
					<td align="left" valign="center" class="bodytext31"><?php echo $username; ?></td>
					</tr>
					</tbody>
                  </table>				  </td>
		  </tr>
		  <tr>
  <td colspan="2">&nbsp;</td>
  </tr>
					<tr>
        <td colspan="2"><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0" >
          <tbody>
		  
		  <tr  bgcolor="#ffffff">
              <td align="left" valign="center" class="bodytext31"><strong>S.No</strong></td>
              <td align="left" valign="center" class="bodytext31" width="200"><strong>ITEM (PKGSIZE, N.UNIT,Qty)</strong></td>
    <?php
	$query1 = "select suppliername from master_rfq where medicinecode in (select medicinecode from purchase_rfq where docno='$docno') and status='' and docno='$docno' group by suppliername order by auto_number asc";
	$exec1 = mysql_query($query1) or die(mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$suppliername = $res1['suppliername'];
	?>
	 <td align="right" valign="center" class="bodytext31" width="70"><strong><?php echo $suppliername; ?></strong></td>
         
		 <?php
		 }
		 ?> 
		 <td align="left" valign="center" class="bodytext31"><strong>Select Supplier</strong></td>
		 </tr>
		
		 <?php
		 
		 $query11 = "select * from master_rfq where medicinecode in (select medicinecode from purchase_rfq where docno='$docno') and status='' and docno='$docno' group by medicinecode order by auto_number asc";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows=mysql_num_rows($exec11);
		 while($res11 = mysql_fetch_array($exec11))
		 {
		 $rfqnumber= $res11['docno'];
		 $itemname = $res11['medicinename'];
		 $itemcode = $res11['medicinecode'];
		 $packsize = $res11['packsize'];
		 $packagequantity = $res11['packagequantity'];
		 		 $reqquantity = $res11['quantity'];

		 
		 $sno = $sno + 1;
		 $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
	
		 ?>
		  <tr <?php echo $colorcode; ?>>
		  <td align="left" valign="center" class="bodytext31"><?php echo $sno; ?></td>
		  <td align="left" valign="center" class="bodytext31"><?php echo $itemname; ?>(<?php echo $packsize; ?>,<?php echo $packagequantity; ?>,<?php echo $reqquantity; ?>)</td>
		  <input type="hidden" name="itemname[]" id="itemname" value="<?php echo $itemname; ?>">
		  <input type="hidden" name="itemcode[]" id="itemcode" value="<?php echo $itemcode; ?>">
          <input type="hidden" name="rfqnumber[]" id="rfqnumber" value="<?= $rfqnumber ?>">
		  <input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>">
          
		  <?php
		  $query12 = "select * from master_rfq where medicinecode='$itemcode' and status = '' and docno='$docno' order by auto_number asc";
		 $exec12 = mysql_query($query12) or die(mysql_error());
		 while($res12 = mysql_fetch_array($exec12))
		 {
		  $rate = $res12['rate'];
		
		  $query13 = "select min(rate) as lowestrate from master_rfq where rate <> '0.00' and medicinecode='$itemcode' and docno='$docno' and status = '' ";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  $res13 = mysql_fetch_array($exec13);
		  $lowestrate = $res13['lowestrate'];
		  
		  $query14 = "select max(rate) as higherrate from master_rfq where rate <> '0.00' and medicinecode='$itemcode' and status = '' and docno='$docno'";
		  $exec14 = mysql_query($query14) or die(mysql_error());
		  $res14 = mysql_fetch_array($exec14);
		  $higherrate = $res14['higherrate'];
		  
		  $query15 = "select avg(rate) as averagerate from master_rfq where rate <> '0.00' and medicinecode='$itemcode' and status = '' and docno='$docno'";
		  $exec15 = mysql_query($query15) or die(mysql_error());
		  $res15 = mysql_fetch_array($exec15);
		  $averagerate = $res15['averagerate'];
		  
		  if($lowestrate == $rate)
		  {
		  $subcolorcode = 'bgcolor="#40FF00"';
		  }
		  else if($higherrate == $rate)
		  {
		   $subcolorcode = 'bgcolor="#FA5858"';
		  } 
		   else if($averagerate == $rate)
		  {
		  $subcolorcode = 'bgcolor="yellow"';
		  } 
		  else
		  {
		  $subcolorcode = '';
		  }
		 
		  
		 
		  ?>
		  <td align="right" valign="center" class="bodytext31" <?php echo $subcolorcode; ?>><?php echo $rate; ?></td>
		  <?php
		  }
		  ?>
		  <td align="left" valign="center" class="bodytext31">
		   <input type="text" name="suppliercoa[]" id="paynowlabcoa<?php echo $sno; ?>" size="40"/>
						 <input type="button" onClick="javascript:coasearch('<?php echo $sno; ?>')" value="Map" accesskey="m" style="border: 1px solid #001E6A">
						 <input type="hidden" name="paynowlabtype6" id="paynowlabtype<?php echo $sno; ?>" size="10"/>
						 <input type="hidden" name="suppliercode[]" id="paynowlabcode<?php echo $sno; ?>" size="10"/>		  </td>
		  </tr>
		 <?php
		 
		 }
		 ?>
		 <input type="hidden" name="serial" id="serial" value="<?php echo $sno; ?>">
		  </tbody>
		  </table>		 </td>
		 </tr>
				  <tr>
	  <td width="63%"  align="right" valign="center" class="bodytext31">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	 
	    <input type="submit" name="submit" value="Save"></td>
	  <td width="37%"  align="right" valign="center" class="bodytext31">&nbsp;</td>
		  </tr>
        </table>
		</form>
                </td>
            </tr>
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

