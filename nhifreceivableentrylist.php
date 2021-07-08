<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$searchaccount = '';
$searchaccountcode = '';
$searchaccountanum = '';

//This include updatation takes too long to load for hunge items database.

	$searchaccountcode=isset($_REQUEST['accountcode'])?$_REQUEST['accountcode']:'';
	$accountanum=isset($_REQUEST['accountanum'])?$_REQUEST['accountanum']:'';
	$searchaccount=isset($_REQUEST['accountname'])?$_REQUEST['accountname']:'';
	
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



include ("autocompletebuild_accounts_1.php");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchdocno=$_POST['docno'];
	
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];

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
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}



</script>
<script type="text/javascript" src="js/autocomplete_accounts1.js"></script>
<script type="text/javascript" src="js/autosuggest3accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("accountname"), new StateSuggestions());        
}
</script>
<script type="text/javascript">


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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
		
		
              <form name="cbform1" method="post" action="nhifreceivableentrylist.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Account Activity </strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="accountname" type="text" id="accountname" style="border: 1px solid #001E6A;" value="<?php echo $searchaccount; ?>" size="50" autocomplete="off">
                <input type="hidden" name="accountcode" id="accountcode" value="<?php echo $searchaccountcode; ?>">
                <input type="hidden" name="accountanum" id="accountanum" value="<?php echo $accountanum; ?>">
				<input type="hidden" name="accountnamenew" id="accountnamenew" value="">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docno" type="text" id="docno" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   
			  <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
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
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="nhifreceivableentrylist.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$searchdocno=$_POST['docno'];
	
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];

	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
          <tbody>
             <tr bgcolor="#011E6A">
              <td colspan="8" bgcolor="#CCCCCC" class="bodytext3"><strong>Payments </strong></td>
              </tr>
           <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>S.No</strong></td>
                <td width="10%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
                <td width="25%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>
				  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mode</strong></td>
					  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Inst.Number</strong></td>
			
				        <td width="7%"class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Amount </strong></div></td>
               <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
				 </tr>
			  <?php 
             $query2 = "select * from master_transactionpaylater where accountnameid = '$searchaccountcode' and accountnameano='$accountanum' and docno like '%$searchdocno%' and transactiondate between '$fromdate' and '$todate' and transactiontype <> 'pharmacycredit' and transactionmode <> 'CREDIT NOTE' and transactionmode <> '' and transactiontype <> 'paylatercredit'  and transactiontype <> 'finalize' group by docno order by auto_number desc";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $num2 = mysql_num_rows($exec2);
			  
			  while ($res2 = mysql_fetch_array($exec2))
			  {
			      $totalamount=0;
			 	  $transactiondate = $res2['transactiondate'];
				  $accountname = $res2['accountname'];
				  $docno = $res2['docno'];
				  $mode = $res2['transactionmode'];
				  $amount = $res2['transactionamount'];
				  $totalamount = $res2['receivableamount'];
				 
				  $number = $res2['chequenumber'];
				 $locationcode='LTC-1';
				  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
               
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $accountname; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $mode; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div>
                </div></td>
				
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>
                </div></td>
           
		   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"><a href="nhifreceivableentry.php?docno=<?php echo $docno; ?>&&locationcode=<?=$locationcode;?>">VIEW</a> </span> </div>
                </div></td>
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
				 </tr>
          </tbody>
        </table>
	
		
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<table width="708" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td width="700" colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Credit Notes </strong></td>
              </tr>
			 
	  <tr>
	  <td>
	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
          <tbody>
		  <tr>
		    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>S.No</strong></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>
				  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient</strong></td>
					  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg.No</strong></td>
			
				        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Visitcode</strong></div></td>
					        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Amount</strong></div></td>
          
               <td align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
           </tr>
		    <?php 
			$transamount = 0;
			$colorloopcount1 = 0;
            $query24 = "select sum(transactionamount) as transamount,transactiondate,accountname,docno,patientname,patientcode,visitcode from master_transactionpaylater where accountnameid = '$searchaccountcode' and accountnameano='$accountanum' and (transactiontype = 'pharmacycredit' || transactiontype = 'paylatercredit')  and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";
			  $exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
			  $num24 = mysql_num_rows($exec24);
			 // echo $num2;
			  while ($res24 = mysql_fetch_array($exec24))
			  {
			      $totalamount1=0;
			 	  $transactiondate1 = $res24['transactiondate'];
				  $accountname1 = $res24['accountname'];
				  $docno1 = $res24['docno'];
				  $patients = $res24['patientname'];
				  $patientcodes = $res24['patientcode'];
				  $visitcodes = $res24['visitcode'];
				  $transamount = $res24['transamount'];
				   $locationcode1=$res24['locationcode'];
				  if($transamount>0){
			      
				  $query77 = "select sum(transactionamount) as allocatedamount from master_transactionpaylater where docno = '$docno1' and recordstatus = 'allocated'";
				  $exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
				  $res77 = mysql_fetch_array($exec77); 
				  $allocatedamount = $res77['allocatedamount'];
				  
				  $balanceamount = $transamount - $allocatedamount;
				  if($balanceamount > 0)
				  {
				 $transamount = number_format($transamount,2,'.','');
				  
			  $colorloopcount1 = $colorloopcount1 + 1;
			  $showcolor1 = ($colorloopcount1 & 1); 
			  $colorcode1 = '';
				if ($showcolor1 == 0)
				{
					//echo "if";
					$colorcode1 = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$colorcode1 = 'bgcolor="#D3EEB7"';
				}
			  ?>
			    <tr <?php echo $colorcode1; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount1; ?></td>
               
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $transactiondate1; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $accountname1; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $docno1; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patients; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $patientcodes; ?> </span> </div>
                </div></td>
				
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $visitcodes; ?> </span> </div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"> <span class="bodytext3"> <?php echo number_format($transamount,2,'.',','); ?></span> </div>
                </div></td>
           
		   <td  align="center" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"> <span class="bodytext3"><a href="nhifreceivableentry.php?docno=<?php echo $docno1; ?>&&locationcode=<?=$locationcode1;?>">VIEW</a> </span> </div>
                </div></td>
                    </tr>
			  <?php
			  }
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
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
                   
           	</tr>
			<?php 
			}
			?>
		  </tbody>
		  </table>
		  </td>
		  </tr>
			  </tbody>
			  </table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

