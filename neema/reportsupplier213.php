<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$totalat = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;


//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name.');
return false;
}
}
</script>
<?php include ("autocompletebuild_supplier1.php"); ?>
<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="reportsupplier213.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Statement - By Supplier</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
					//echo $searchsuppliername;
					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
					//echo $ADate1;
					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$arraysupplier = explode("#", $searchsuppliername);
					$arraysuppliername = $arraysupplier[0];
					$arraysuppliername = trim($arraysuppliername);
					$arraysuppliercode = $arraysupplier[1];
					
					$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&name=$arraysuppliername&&code=$arraysuppliercode";
				}
				else
				{
					$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&name=$arraysuppliername&&code=$arraysuppliercode";//&&companyname=$companyname";
				}
				?>
 				<?php
				/*//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_supplierreport.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);
*/
				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_supplierreport.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
            </tr>
			<?php
			$arraysupplier = explode("#", $searchsuppliername);
			$arraysuppliername = $arraysupplier[0];
			$arraysuppliername = trim($arraysuppliername);
			$arraysuppliercode = $arraysupplier[1];
		
			 $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			//$supplieranum = $res1['auto_number'];
			//$suppliercode = $res1['suppliercode'];
			$openingbalance = $res1['openingbalance'];	
		  
		//  $openingbalance = $res1transactionamount1 - $res4transactionamount1;
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>&nbsp;</strong></td>
				
              <td width="9%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="35%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong> Opening Balance </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="16%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="16%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$query21 = "select * from master_supplier where suppliername like '%$arraysuppliername%' and dateposted between '$ADate1' and '$ADate2' group by suppliername order by suppliername desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountname = $res21['suppliername'];
			$supplieranum = $res21['auto_number'];
			
			$query22 = "select * from master_supplier where suppliername = '$res21accountname' and status <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22accountname = $res22['suppliername'];

			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
			$totalamountgreater = 0;
		  
		      
		/*  $query2 = "select * from master_transactionpharmacy where supplieranum = '$supplieranum' and 
			transactiondate between '$transactiondatefrom' and '$transactiondateto' and customeranum = '0' and customername = '' 
			and companyanum = '$companyanum' and recordstatus <> 'DELETED' order by transactiondate";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['transactiondate'];
	      $res2patientname = $res2['suppliername'];
		  //$res2visitcode = $res2['visitcode'];
		  $res2billnumber = $res2['billnumber'];
		  $res2transactionamount = $res2['transactionamount'];
		  $res2patientcode = $res2['suppliercode'];
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  $total = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $total = $total + $res2transactionamount;
		  }
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res2['transactionamount'];
		  }
		  
		  if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 + $res2transactionamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $res2transactionamount;
		  }
		  }
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php  ?>, <?php echo $res2billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php //echo $days_between; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $days_between; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
 			<?php
                   */			

			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query3 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE'  group by docno order by auto_number desc";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $num = mysql_num_rows($exec3);
		  while ($res3 = mysql_fetch_array($exec3))
		  {
		  $totaltransamount = 0;
     	  $res3transactiondate = $res3['transactiondate'];
	      $res3billnumber = $res3['billnumber'];
		  $res3docno = $res3['docno'];
		  $res3transactionamount = $res3['transactionamount'];
		  $res3transactionmode = $res3['transactionmode'];
		  $res3transactionnumber = $res3['chequenumber'];
		  
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res3transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  //$snocount = $snocount + 1;
		  
		  $query56 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT NOTE' and  chequenumber= '$res3transactionnumber' and docno = '$res3docno'";
		  $exec56 = mysql_query($query56) or die(mysql_error());
		//  echo $num56 = mysql_num_rows($exec56);
		  while($res56 = mysql_fetch_array($exec56))
		  {
		  $transamount = $res56['transactionamount'];
		  $totaltransamount = $totaltransamount + $transamount;
		  }
		  // $total = $totaltransamount - $total;
		   		 
		
		  //echo $res3transactionamount;
		 /* if($days_between <= 30)
		  {
		  $totalamount30 = $totalamount30 - $totaltransamount;
		  
		 //echo $totalamount30;
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  $totalamount60 = $totalamount60 - $totaltransamount;
		 
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  $totalamount90 = $totalamount90 - $totaltransamount;
		  
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $totaltransamount;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $totaltransamount;
		 
		  }
		  else
		  {
		  
		  $totalamountgreater = $totalamountgreater - $totaltransamount;
		  
		  }*/
			
			//echo $cashamount;
			/*$colorloopcount = $colorloopcount + 1;
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
	*/
			?>
         <!--  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3transactionmode; ?> <?php echo $res3transactionnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($totaltransamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>-->
			<?php
			}
			?>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query45 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' order by transactiondate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['transactiondate'];
	      $res45patientname = $res45['suppliername'];
		  $res45patientcode = $res45['suppliercode'];
		  $res45transactionamount = $res45['transactionamount'];
		  $res45billnumber = $res45['billnumber'];
		  $res45openingbalance = $res45['openingbalance'];
		  
		  $query85 = "select * from master_purchase where billnumber = '$res45billnumber' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec85 = mysql_query($query85) or die ("Error in Query85".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   while ($res85 = mysql_fetch_array($exec85))
		  {
		  $res85supplierbillnumber = $res85['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $totalat = $totalat + $res45transactionamount + $openingbalance;
		    
  		 // $total = $res45transactionamount + $openingbalance;
		  
		  /* 
		  $total = $total - $totalamountgreater;
		  
		  if($res5transactionamount == '')
		  {
		  $res5transactionamount = '0.00';
		  }
		  else
		  {
		  $res5transactionamount = $res5['transactionamount'];
		  }
		  
		  if($days_between <= 30)
		  {
		
		  $totalamount30 = $totalamount30 - $res5transactionamount;
		 
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount60 = $totalamount60 - $res5transactionamount;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount90 = $totalamount90 - $res5transactionamount;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		
		  $totalamount120 = $totalamount120 - $res5transactionamount;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $res5transactionamount;
		 
		  }
		  else
		  {
		
		  $totalamountgreater = $res5transactionamount - $totalamountgreater;
		  
		  }*/
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res45transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Purchase'; ?> (<?php echo $res85supplierbillnumber; ?>,<?php echo $res45billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res45transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  }
		   ?>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query5 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res5 = mysql_fetch_array($exec5))
		  {
     	  $res5transactiondate = $res5['transactiondate'];
	      $res5patientname = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  $res5transactionamount = $res5['transactionamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  
		  $query15 = "select * from master_purchase where billnumber = '$res5billnumber' ";
		  $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   $res15 = mysql_fetch_array($exec15);
		  
		  $res15supplierbillnumber = $res15['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  $total = $res5transactionamount + $res5openingbalance;
		  
		  $totalat = $totalat - $total;
		  /* 
		  $total = $total - $totalamountgreater;
		  
		  if($res5transactionamount == '')
		  {
		  $res5transactionamount = '0.00';
		  }
		  else
		  {
		  $res5transactionamount = $res5['transactionamount'];
		  }
		  
		  if($days_between <= 30)
		  {
		
		  $totalamount30 = $totalamount30 - $res5transactionamount;
		 
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount60 = $totalamount60 - $res5transactionamount;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount90 = $totalamount90 - $res5transactionamount;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		
		  $totalamount120 = $totalamount120 - $res5transactionamount;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $res5transactionamount;
		 
		  }
		  else
		  {
		
		  $totalamountgreater = $res5transactionamount - $totalamountgreater;
		  
		  }*/
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Payment ('.$res5transactionmode.','.$res5chequenumber.','.$res5docnumber.','.$res5remarks; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res5transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  
		   ?>
		   
		   <?php
		      
		  $query65 = "select * from purchasereturn_details where suppliername = '$arraysuppliername' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
		  $exec65 = mysql_query($query65) or die ("Error in Query65".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res65 = mysql_fetch_array($exec65))
		  {
     	  $res65transactiondate = $res65['entrydate'];
	      $res65patientname = $res65['suppliername'];
		  $res65patientcode = $res65['suppliercode'];
		  $res65subtotal= $res65['subtotal'];
		  $res65billnumber = $res65['billnumber'];
		  $res65grnnumber = $res65['grnbillnumber'];
		 
		  $totalatret = $totalat - $res65subtotal ;
		  
		  $totalat = $totalat - $res65subtotal; 
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res65transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Return ('.$res65billnumber.','.$res65grnnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res65subtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
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
            </tr>
				 </tbody>
        </table></td>
      </tr>
	  
   
			<tr>
        <td>&nbsp;</td>
      </tr>
		
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
            	 </tr>
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total Due</strong></td>
            </tr>
			<?php 
			$grandtotal = $totalat;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalat,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right"> 
                 <a href="print_supplierreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&name=<?php echo $arraysuppliername; ?>&&code=<?php echo $arraysuppliercode; ?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>
            </tr>
			
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
           
               </tr>
			  </table>
			<?php
			}
			}
			}
			?>
</table>


</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
