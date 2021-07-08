<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

$paynowbillprefix = 'RFQ-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query3 = "select * from purchase_rfq order by auto_number desc limit 0, 1";
$exec3 = mysql_query($query3) or die(mysql_error());
$num3 = mysql_num_rows($exec3);
$res3 = mysql_fetch_array($exec3);
$billnumber = $res3['docno'];
$billdigit=strlen($billnumber);
if($num3 >0)
{

	$query24 = "select * from purchase_rfq order by auto_number desc limit 0, 1";
$exec24 = mysql_query($query24) or die ("Error in Query2".mysql_error());
$res24 = mysql_fetch_array($exec24);
$billnumber = $res24['docno'];
$billdigit=strlen($billnumber);
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	
	 $billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;
     
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	
}
else
{
$query2 = "select * from purchase_rfq order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';
}
}

foreach($_POST['docno'] as $key => $value)
{
$docno = $_POST['docno'][$key];
foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $docno)
		{
		$query58 = "update purchase_rfq set status='completed' where status='Process'";
		$exec58 = mysql_query($query58) or die(mysql_error());

$query33 = "select * from purchase_rfqrequest where docno='$docno' and approvalstatus='approved' and grandapprovalstatus='approved' group by medicinecode";
$exec33 = mysql_query($query33) or die(mysql_error());
while($res33 = mysql_fetch_array($exec33))
{
$itemname = $res33['medicinename'];
$itemcode = $res33['medicinecode'];

$query331 = "select sum(quantity) as totalquantity from purchase_rfqrequest where medicinecode = '$itemcode' and docno='$docno' and approvalstatus='approved' and grandapprovalstatus='approved'";
$exec331 = mysql_query($query331) or die(mysql_error()); 
$res331 = mysql_fetch_array($exec331);
$quantity = $res331['totalquantity'];
$rate = $res33['rate'];

$amount = $quantity * $rate;
$packagequantity = $res33['packagequantity'];
 
$analyzestatus='pending';

$query56="insert into purchase_rfq(companyanum,docno,medicinecode,medicinename,rate,quantity,amount,username, ipaddress, date,packagequantity,status,analyzestatus,locationname,locationcode)
          values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$amount','$username','$ipaddress','$currentdate','$packagequantity','Process','$analyzestatus','$locationname','$locationcode')";
$exec56 = mysql_query($query56) or die(mysql_error());		

 $query55="update purchase_rfqrequest set rfqgeneration='completed' where docno='$docno' and medicinecode='$itemcode'";
 $exec55=mysql_query($query55) or die(mysql_error());
  
 
}
}
}
}


header("location:generaterfq.php?st=success");
exit;
}

?>
<?php


if($st == 'success')
{

header("location:print_generaterfq.php");

}
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<form method="post" name="form1" action="generaterfq.php">
<?php 
$query34="select * from purchase_rfqrequest where approvalstatus='approved' and grandapprovalstatus='approved' and rfqgeneration='' group by docno";
		$exec34=mysql_query($query34) or die(mysql_error());
			$resnw1=mysql_num_rows($exec34);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
             
              <td colspan="9" bgcolor="#cccccc" class="bodytext31"><script language="javascript">
				function printbillreport1()
				{
					window.open("print_collectionpendingreport1hospital.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/CollectionPendingByPatientHospital.xls"
				}
				</script>
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Generate RFQ</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
			  
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>
			  </td>
              <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			<?php
			}
			?>
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>From</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>DOC No</strong></div></td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select</strong></div></td>
              
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
		$query34="select * from purchase_rfqrequest where approvalstatus='approved' and grandapprovalstatus='approved' and rfqgeneration='' group by docno";
		$exec34=mysql_query($query34) or die(mysql_error());
		while($res34=mysql_fetch_array($exec34))
			{
			$date=$res34['date'];
			$user=$res34['username'];
			$docno=$res34['docno'];
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $date; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $user; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docno; ?></div></td>
				<input type="hidden" name="docno[]" value="<?php echo $docno; ?>"> 
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo 'Approved' ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><input type="checkbox" name="select[]" id="select" checked="checked" value="<?php echo $docno; ?>"></div></td>
                       </tr>
			  <?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             		
              </tr>
          </tbody>
        </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	    <input type="submit" name="submit" value="Generate RFQ"></td>
	  </tr>
    </table>
</table>
</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

