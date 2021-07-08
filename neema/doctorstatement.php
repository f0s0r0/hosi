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

$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;
		  


include ("autocompletebuild_doctor.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
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

<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<script type="text/javascript" src="js/autosuggestdoctor.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	
	window.open("showinvoice.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function coasearch1(varCallFrom1)
{

	var varCallFrom1 = varCallFrom1;
	
	window.open("showwthinvoice.php?callfrom1="+varCallFrom1,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
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
    <td width="97%" valign="top"><table width="auto" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="doctorstatement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Statement - By Doctor</strong></td>
              </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Doctor </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
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
              <td colspan="14" bgcolor="#cccccc" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$arraysupplier = explode("#", $searchsuppliername);
			$arraysuppliername = $arraysupplier[0];
			$arraysuppliername = trim($arraysuppliername);
			$arraysuppliercode = $arraysupplier[1];
		
					
			}
				?>
 				
            </td> <td class="bodytext31" valign="top" bgcolor="#E0E0E0" align="left"> 
                 <a target="_blank" href="print_doctorstatement.php?code=<?php echo $arraysuppliercode;?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a> 
                </td> 
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
		$openingcreditamount = 0;
		$openingdebittamount = 0;
			 $query81 = "select * from billing_paynow where referalname = '$arraysuppliername' and billstatus='paid' and billdate < '$ADate1'";
			 $exec81 = mysql_query($query81) or die(mysql_error());
			 while($res81 = mysql_fetch_array($exec81))
			 {
			 $res81visitcode = $res81['visitcode'];
			 $query123="select * from consultation_referal where patientvisitcode='$res81visitcode' and referalname ='$arraysuppliername'";
		  	 $exec123=mysql_query($query123) or die(mysql_error());
			 while($res123 = mysql_fetch_array($exec123))
			 {
			 $paynowamount = $res123['referalrate'];
			 $openingcreditamount = $openingcreditamount + $paynowamount;
			 }
			 }
			  $query82 = "select * from billing_paylater where referalname = '$arraysuppliername' and billdate < '$ADate1'";
			 $exec82 = mysql_query($query82) or die(mysql_error());
			 while($res82 = mysql_fetch_array($exec82))
			 {
			 $res82visitcode = $res82['visitcode'];
			 $query124="select * from consultation_referal where patientvisitcode='$res82visitcode' and referalname ='$arraysuppliername'";
		  	 $exec124=mysql_query($query124) or die(mysql_error());
			 while($res124 = mysql_fetch_array($exec124))
			 {
			 $paylateramount = $res124['referalrate'];
			 $openingcreditamount = $openingcreditamount + $paylateramount;
			 }
			 }
			 $query83 = "select * from billing_ipprivatedoctor where description='$arraysuppliername' and recorddate < '$ADate1'";
			 $exec83 = mysql_query($query83) or die(mysql_error());
			 while($res83 = mysql_fetch_array($exec83))
			 {
			 $ipamount = $res83['amount'];
			 $openingcreditamount = $openingcreditamount + $ipamount;
			 }
			 $query51 = "select * from paymentmodecredit where source = 'doctorpaymententry' and billdate < '$ADate1'";
		  $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res51 = mysql_fetch_array($exec51))
		  {
		  $paymentdocno = $res51['billnumber'];
		  $res5transactionamount = $res51['transactionamount'];
		  $res5transactiondate = $res51['billdate'];
		  
		   $query15 = "select * from master_transactiondoctor where doctorcode = '$arraysuppliercode' and transactiondate < '$ADate1' and transactionmodule = 'PAYMENT' and docno ='$paymentdocno' and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec15 = mysql_query($query15) or die ("Error in Query5".mysql_error());
		  $num15 = mysql_num_rows($exec15);
		  if($num15 > 0)
		  {
		  
		  $openingdebittamount = $openingdebittamount + $res5transactionamount;
		  }
			 }
			 
			  $query5 = "select * from master_transactiondoctor where accountname = '$arraysuppliername' and transactiondate < '$ADate1' and recordstatus <> 'deallocated' group by docno order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  while($res5 = mysql_fetch_array($exec5))
		  {
		  $totaltransamount = $res5['taxamount'];
		   $openingdebittamount = $openingdebittamount + $totaltransamount;
		  }
			 $openingbalance = $openingcreditamount - $openingdebittamount;
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
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>
			</tr>
			
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
		  	$query21 = "select * from master_doctor where doctorname like '%$arraysuppliername%' and status <>'DELETED' group by doctorname order by doctorname desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$res21accountname = $res21['doctorname'];
			$supplieranum = $res21['auto_number'];
			 ?>
         
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>
            </tr>
		
		    <?php		
		
		  $query45 = "select * from billing_paynow where referalname = '$res21accountname' and billstatus='paid' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['billdate'];
		  $res45visitcode = $res45['visitcode'];
	      $res45patientname = $res45['referalname'];
		  $res45billnumber = $res45['billno'];
		  $res45accountname = $res45['accountname'];
		  $res45patientname = $res45['patientname'];
		  $res45patientcode = $res45['patientcode'];
		  
		  $query123="select * from consultation_referal where patientvisitcode='$res45visitcode' and referalname ='$res21accountname'";
		  $exec123=mysql_query($query123) or die(mysql_error());
		  $num123=mysql_num_rows($exec123);
		  if($num123 > 0)
		  {
		  $res123=mysql_fetch_array($exec123);
		  $res45transactionamount = $res123['referalrate'];
		  $res2transactionamount = $res45transactionamount;

		 if($res45transactionamount==0){
			continue;				
		 }
		  
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $snocount = $snocount + 1;
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res123['referalrate'];
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
		  
		 
		
		  
		   if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
	
		  
			
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
                <div class="bodytext31"><?php echo 'Towards Bill'; ?> (<?php echo $res45patientname.' , '.$res45patientcode.','.$res45visitcode; ?> , <?php echo $res45billnumber; ?> , <?php echo $res45accountname; ?>)</div></td>
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
		   }  
		   }
		   ?>
		   
		    <?php		
		
		  $query45 = "select * from billing_paylater where referalname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['billdate'];
		  $res45visitcode = $res45['visitcode'];
	      $res45patientname = $res45['referalname'];
		  $res45billnumber = $res45['billno'];
		  $res45accountname = $res45['accountname'];
		  $res45patientname = $res45['patientname'];
		  $res45patientcode = $res45['patientcode'];
		  $query123="select * from consultation_referal where patientvisitcode='$res45visitcode' and referalname ='$res21accountname'";
		  $exec123=mysql_query($query123) or die(mysql_error());
		  $num123=mysql_num_rows($exec123);
		  if($num123 > 0)
		  {
		  $res123=mysql_fetch_array($exec123);
		  $res45transactionamount = $res123['referalrate'];
		  $res2transactionamount = $res45transactionamount;

		 if($res45transactionamount==0){
			continue;				
		 }
		  
		    $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $snocount = $snocount + 1;
		  
		
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res123['referalrate'];
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
		  
		 
		
		    if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
		
	
		  
			
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
                <div class="bodytext31"><?php echo 'Towards Bill'; ?> (<?php echo $res45patientname.' , '.$res45patientcode.','.$res45visitcode; ?> , <?php echo $res45billnumber; ?> , <?php echo $res45accountname; ?>)</div></td>
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
		   } 
		   } 
		   ?>
		   	    <?php		
		
		  $query45 = "select * from billing_ipprivatedoctor where description='$res21accountname' and recorddate between '$ADate1' and '$ADate2' order by recorddate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['recorddate'];
		  $res45visitcode = $res45['visitcode'];
		  $res45patientnames = $res45['patientname'];
		  $res45patientcode = $res45['patientcode'];
		  $query11 = "select * from master_ipvisitentry where visitcode='$res45visitcode'";
		  $exec11 = mysql_query($query11) or die(mysql_error());
		  $res11 = mysql_fetch_array($exec11);
		  
		  $billtype = $res11['billtype'];
		  $res45accountname = $res11['accountfullname'];
	      $res45patientname = $res45['description'];
		  $res45billnumber = $res45['docno'];
		  
		 
		  $res45transactionamount = $res45['amount'];
		  $res2transactionamount = $res45transactionamount;

		 if($res45transactionamount==0){
			continue;				
		 }
		  
		    $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $snocount = $snocount + 1;
		  
		  
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res45['amount'];
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
		  
		 
		
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
	
		  
			
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
                <div class="bodytext31"><?php echo 'Towards Bill'; ?> (<?php echo $res45patientnames.' , '.$res45patientcode.','.$res45visitcode; ?> , <?php echo $res45billnumber; ?> , <?php echo $res45accountname; ?>)</div></td>
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
		   }  
		   ?>
			
			<?php
			
		  $query51 = "select * from paymentmodecredit where source = 'doctorpaymententry' and billdate between '$ADate1' and '$ADate2' group by billnumber order by billdate desc";
		  $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res51 = mysql_fetch_array($exec51))
		  {
		  $paymentdocno = $res51['billnumber'];
		  $res5transactionamount = $res51['transactionamount'];
		  $res5transactiondate = $res51['billdate'];
		  
		   $query5 = "select * from master_transactiondoctor where doctorcode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' and docno ='$paymentdocno' and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  if($num5 > 0)
		  {
		  while($res5 = mysql_fetch_array($exec5))
		  {
		  $res65visitcode = $res5['visitcode'];
		  $res65patientcode = $res5['patientcode'];
		  
     	  $query111 = "select * from master_ipvisitentry where visitcode='$res65visitcode'";
		  $exec111 = mysql_query($query111) or die(mysql_error());
		  $res111 = mysql_fetch_array($exec111);
		  
		  $billtype = $res111['billtype'];
		  $res65accountname = $res111['accountname'];
	      $res5patientname = $res5['accountname'];
		  $res5patientcode = $res5['doctorcode'];
		  //$totaltransamount = $res5['transactionamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  //$res5particulars = substr($res5particulars,2,6);
		   $res5transactionmode= $res5['transactionmode'];
		  if($res5transactionmode=='CHEQUE')
		  {
		    $totaltransamount = $res5['chequeamount'];
		  }
		  else if($res5transactionmode=='CASH')
		  {
		    $totaltransamount = $res5['cashamount'];
		  }
		  else if($res5transactionmode=='ONLINE')
		  {
		    $totaltransamount = $res5['onlineamount'];
		  }
		  else if($res5transactionmode=='CREDIT CARD')
		  {
		    $totaltransamount = $res5['cardamount'];
		  }
		  else if($res5transactionmode=='MPESA')
		  {
		    $totaltransamount = $res5['creditamount'];
		  }
		  else
		  {
		   $totaltransamount = $res5['transactionamount'];
	
		  }
//		  $res5taxamount = $res5['taxamount'];
		  $res5taxamount=0;
		  $totaltransamount = $totaltransamount-$res5taxamount;
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];

		 if($totaltransamount==0){
			continue;				
		 }
		  
		   $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		   $snocount = $snocount + 1;
		  
		   if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 - $totaltransamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 - $totaltransamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 - $totaltransamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 - $totaltransamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 - $totaltransamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater - $totaltransamount;
		  }
		  }
		  
		 
		
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalat = $totalat - $totaltransamount;
		  }
			if($res5chequenumber != '')
			{
			$res5chequenumber = ','.$res5chequenumber;
			}
			else
			{
			$res5chequenumber = '';
			}
			if($res5docnumber != '')
			{
			$res5docnumber = ','.$res5docnumber;
			}
			else
			{
			$res5docnumber = '';
			}
			if($res5remarks != '')
			{
			$res5remarks = ','.$res5remarks;
			}
			else
			{
			$res5remarks = '';
			}
			if($res5billnumber != '')
			{
			$res5billnumber = ','.$res5billnumber;
			}
			else
			{
			$res5billnumber = '';
			}
			
			
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
              <td class="bodytext31" valign="center"  align="left" onClick="javascript:coasearch('<?php echo $res5docnumber; ?>')">
                <div class="bodytext31"><?php echo 'Towards Payment ('.$res45patientcode.','.$res45visitcode.','.$res5transactionmode.$res5chequenumber.$res5docnumber.$res5remarks.$res5billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaltransamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }
		   }
		   }  
		   ?>
		   	
			<?php
			
		  	  
		  $query5 = "select * from master_transactiondoctor where accountname = '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deallocated' group by docno order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  while($res5 = mysql_fetch_array($exec5))
		  {
		 
		  $totaltransamount = $res5['taxamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5transactiondate = $res5['transactiondate'];
		  $res5docnumber = $res5['docno'];
		$res65visitcode = $res5['visitcode'];
		  $res65patientcode = $res5['patientcode'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];

		 if($totaltransamount==0){
			continue;				
		 }
		  
		  if($totaltransamount != '0.00')
		  {
		  
		   $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		   $snocount = $snocount + 1;
		  
		    if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 - $totaltransamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 - $totaltransamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 - $totaltransamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 - $totaltransamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 - $totaltransamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater - $totaltransamount;
		  }
		  }
		  
		 
		
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalat = $totalat - $totaltransamount;
		  }
			
			if($res5chequenumber != '')
			{
			$res5chequenumber = ','.$res5chequenumber;
			}
			else
			{
			$res5chequenumber = '';
			}
			if($res5docnumber != '')
			{
			$res5docnumber = ','.$res5docnumber;
			}
			else
			{
			$res5docnumber = '';
			}
			if($res5remarks != '')
			{
			$res5remarks = ','.$res5remarks;
			}
			else
			{
			$res5remarks = '';
			}
			
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
              <td class="bodytext31" valign="center"  align="left"  onClick="javascript:coasearch1('<?php echo $res5docnumber; ?>')">
                <div class="bodytext31"><?php echo 'Towards Withholding Tax ('.$res45patientcode.','.$res45visitcode.','.$res5transactionmode.$res5chequenumber.$res5docnumber.$res5remarks; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaltransamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }
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
                bgcolor="#D3EEB7"><?php echo number_format($totalamount30,2,'.',','); ?></td>
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
                 
                </td> 
				<td class="bodytext31" valign="center"  align="right"> 
                                </td> 
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
			
		
			?>
</table>


</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
