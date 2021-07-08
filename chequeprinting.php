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

$docno = $_SESSION['docno'];

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
	}
	$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date('Y-m-d');
	$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date('Y-m-d');
	$payable=isset($_REQUEST['payable'])?$_REQUEST['payable']:'';	
	$sdocno=isset($_REQUEST['sdocno'])?$_REQUEST['sdocno']:'';		
		//location get end here
//$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

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
padding-left:650px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript">
function chequeprint(docno,fm)
{
	var docno = docno;
	var fm = fm;
	var url="print_cheque.php?RandomKey="+Math.random()+"&&docno="+docno+"&&fm="+fm;
	
window.open(url,"Pharmacy",'width=600,height=600');
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
  <td width="2%">&nbsp;</td>
    <td colspan="9">
    <form name="cbform1" method="post" action="chequeprinting.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <tr>
              <td colspan="4" class="bodytext3">&nbsp;</td>
              </tr>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Cheque Printing </strong></td>
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
					if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
                  
              </td>
     
            </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                </select>
              </span></td>
            </tr>
			    <tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payable</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="payable" type="text" id="payable" value="<?php echo $payable; ?>" size="50" autocomplete="off">
              </span></td>
            </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="sdocno" type="text" id="sdocno" value="<?php echo $sdocno; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
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
          </tbody>
        </table>
	  </form>	
   
    </td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="98%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="801" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="5" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Supplier Payment</strong></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
               <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date </strong></div></td>
          		<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Docno </strong></div></td>
              <td width="51%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier </strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			$colorloopcount = '';
			$sno = '';
			$query2 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
						 $locationname = $res2["locationname"];
						 $locationcode = $res2["locationcode"];
			}
?>		
				
				
	<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{					
			$query1 = "select docno, transactionamount,suppliername,transactiondate from master_transactionpharmacy where suppliername like '%$payable%' and docno like '%$sdocno%' and transactionmode = 'CHEQUE' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2' group by docno order by auto_number desc";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$docno = $res1['docno'];
			$transactiondate = $res1['transactiondate'];
			$suppliername = $res1['suppliername'];
			
			$query11 = "select sum(transactionamount) as transactionamount from master_transactionpharmacy where docno = '$docno' and transactionmode = 'CHEQUE' and recordstatus = 'allocated'";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$res11 = mysql_fetch_array($exec11);
			$transactionamount = $res11['transactionamount'];
			
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $docno; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $suppliername;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo number_format($transactionamount,2); ?></div></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="#" onClick="return chequeprint('<?php echo $docno; ?>','supplier')"><strong>Print</strong></a></div></td>
              </tr>
			<?php
			}  
			}
			?>
			<tr>
			<td align="left" colspan="6">&nbsp;</td>
			</tr>
			<tr>
              <td width="7%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="5" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Expense Payment</strong></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
               <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date </strong></div></td>
          		<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Docno </strong></div></td>
              <td width="51%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payee </strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
	
	<?php
	$sno=0;
	$colorloopcount=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{					
			$query2 = "select docnumber, transactionamount,remarks,transactiondate, payee from expensesub_details where transactionmode = 'CHEQUE' and payee like '%$payable%' and docnumber like '%$sdocno%' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//echo mysql_num_rows($exec2);
			while ($res2 = mysql_fetch_array($exec2))
			{
			$docno = $res2['docnumber'];
			$transactionamount = $res2['transactionamount'];
			$transactiondate = $res2['transactiondate'];
			$remarks = $res2['remarks'];
			$payee = $res2['payee'];
			
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $docno; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $payee;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo number_format($transactionamount,2); ?></div></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="#" onClick="return chequeprint('<?php echo $docno; ?>','expense')"><strong>Print</strong></a></div></td>
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
             
              </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

