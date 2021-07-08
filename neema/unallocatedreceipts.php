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



<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
              <td width="4%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="8" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Unallocated Receipts</strong></div></td>
              </tr>
             <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="24%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account </strong></div></td>
				<td width="12%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>DOC No</strong></div></td>
              <td width="14%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doc Date</strong></div></td>
				 <td width="15%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Mode</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>User Name</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="11%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adj Amount</strong></div></td>

              	<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Balance</strong></div></td>
				
                    
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			$totaltransactionamount = 0;
			$totaladjustedamount = 0;
			$totalbalance = 0;
			
			$query1 = "select * from master_transactionpaylater where transactionstatus='onaccount' group by docno";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());	
			while($res1=mysql_fetch_array($exec1))
			{
			$accountname=$res1['accountname'];
			$docno = $res1['docno'];
			$docdate = $res1['transactiondate'];
			$transactionmode = $res1['transactionmode'];
			if(($transactionmode == 'CHEQUE')||($transactionmode == 'ONLINE'))
			{
			$number = $res1['chequenumber'];
			}
			else
			{
			$number = '';
			}
			$transactionamount = $res1['transactionamount'];
			
			$query2 = "select sum(transactionamount) as adjustedamount from master_transactionpaylater where docno='$docno' and transactiontype = 'PAYMENT' and transactionstatus = '' and recordstatus <> 'deallocated'";
			$exec2 = mysql_query($query2) or die ("Error in Query1".mysql_error());	
			$res2 = mysql_fetch_array($exec2);
			$adjustedamount = $res2['adjustedamount'];
			$usernam = $res1['username'];
			$balance = $transactionamount - $adjustedamount;
		if($adjustedamount == '')
		{
		$adjustedamount = '-';
		}
		
		if($balance != '0.00')
			{
			
			$totaltransactionamount = $totaltransactionamount + $transactionamount;
			$totaladjustedamount = $totaladjustedamount + $adjustedamount;
			$totalbalance = $totalbalance + $balance;
			
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
			    <div align="center"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docno; ?></div></td>
		        <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="center"><?php echo $docdate; ?></div></td>
			     <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="left"><?php echo $transactionmode; ?> <?php echo $number; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="right"><?php echo $usernam ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="right"><?php echo $transactionamount; ?></div></td>
					      <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="right"><?php echo $adjustedamount; ?></div></td>
			 	<td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="right"><?php echo number_format($balance,2,'.','.'); ?></div></td>
			  
		
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
			   <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totaltransactionamount,2,'.',','); ?></strong></td>
		  <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totaladjustedamount,2,'.',','); ?></strong></td>
				  <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalbalance,2,'.',','); ?></strong></td>
		
              </tr>
          </tbody>
        </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
<tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="center" valign="top" >
                                 </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
</form>

<?php include ("includes/footer1.php"); ?>

</body>
</html>

