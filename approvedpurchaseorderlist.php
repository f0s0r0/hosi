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

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PO-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
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

function loadprintpagepdf1(pono)
{
	var ponumnber = pono;
	//alert(varpatientcodes);
		window.open("print_localpurchaseorder.php?billnumber="+ponumnber,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
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
<script src="js/datetimepicker_css.js"></script>

<body>

<?php 
$query34="select * from purchaseorder_details where recordstatus='generated' and goodsstatus ='' and itemstatus != 'deleted' group by billnumber";
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1074" 
            align="left" border="0">
          <tbody>
		  <tr>
          	<td colspan="12">
            	<form name="cbform1" method="post" action="approvedpurchaseorderlist.php" >
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
         
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong> Purchase Orders </strong></td>
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation">                  
                  </td>
     
              </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location"   style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
              
			    <tr>
            
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
         
        </table>
		</form>
		  </td>
		  </tr>
		 <tr>
              <td colspan="10" bgcolor="#cccccc" class="bodytext31">
			  <div align="left"><strong>Purchase Orders</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
			  
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
              <td width="2%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td colspan="9"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>
			  </td>
              <td width="1%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			<?php
			}
			?>
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>PO No</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Indent No</strong></div></td>
				<td width="55%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Value</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
              	<td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>
             	<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Export</strong></div></td>
               <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Email</strong></div></td>
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
			
		$query34="select * from purchaseorder_details where recordstatus='generated' and goodsstatus ='' and itemstatus != 'deleted' and billdate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		$exec34=mysql_query($query34) or die(mysql_error());
		while($res34=mysql_fetch_array($exec34))
			{
			$date=$res34['billdate'];
			$user=$res34['username'];
			$pono=$res34['billnumber'];
			$suppliername=$res34['suppliername'];
			$suppliercode=$res34['suppliercode'];
			$purchaseindentdocno=$res34['purchaseindentdocno'];
			$totalamount = 0;
			
			$query36="select * from purchaseorder_details where recordstatus='generated' and billnumber='$pono' and goodsstatus ='' and itemstatus != 'deleted'";
			$exec36=mysql_query($query36) or die(mysql_error());
			while($res36=mysql_fetch_array($exec36))
			{
			$amount=$res36['totalamount'];
			$totalamount=$totalamount+$amount;
			}
			$totalamount=number_format($totalamount,2);
			
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
			    <div align="center"><?php echo $pono; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $purchaseindentdocno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $suppliername; ?></div></td>
		        <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo $totalamount; ?></div></td>
			      <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><a href="viewpo.php?billnumber=<?php echo $pono; ?>">View</a></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><a href="javascript:loadprintpagepdf1('<?php echo $pono; ?>')"><strong>Print</strong></a></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><a href="print_localpurchaseorderxl.php?billnumber=<?php echo $pono; ?>"><strong>Excel</strong></a></div></td>
			     <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center">Email</div></td>
			
			
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
	  
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	   </td>
	  </tr>
    </table>
</table>

<?php include ("includes/footer1.php"); ?>

</body>
</html>

