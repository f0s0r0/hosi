<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.

if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }

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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	$docno = $_REQUEST['docno'];
	$customer = $_REQUEST['customer'];
	$customercode = $_REQUEST['customercode'];
	$amount = $_REQUEST['amount'];
	$amount = str_replace(',','',$amount);
	$mode = $_REQUEST['mode'];
	$remarks = $_REQUEST['remarks'];
	
	if($customercode != '' && $amount > 0)
	{
	
	if($mode == 'CASH')
	{
		$query4 = "update master_transactionadvancedeposit set patientname = '$customer', patientcode = '$customercode', transactionamount = '$amount', cashamount = '$amount', username = '$username',remarks = '$remarks' where docno = '$docno'";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		
		$query2 = "update paymentmodedebit set patientname = '$customer', patientcode = '$customercode', cash = '$amount', username = '$username' where billnumber = '$docno'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	}
	else if($mode == 'MPESA')
	{
		$query41 = "update master_transactionadvancedeposit set patientname = '$customer', patientcode = '$customercode', transactionamount = '$amount', creditamount = '$amount', username = '$username',remarks = '$remarks' where docno = '$docno'";
		$exec41 = mysql_query($query41) or die ("Error in Query41".mysql_error());
		
		$query2 = "update paymentmodedebit set patientname = '$customer', patientcode = '$customercode', mpesa = '$amount', username = '$username' where billnumber = '$docno'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	}
	else if($mode == 'CREDITCARD')
	{
		$query42 = "update master_transactionadvancedeposit set patientname = '$customer', patientcode = '$customercode', transactionamount = '$amount', cardamount = '$amount', username = '$username',remarks = '$remarks' where docno = '$docno'";
		$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
		
		$query2 = "update paymentmodedebit set patientname = '$customer', patientcode = '$customercode', card = '$amount', username = '$username' where billnumber = '$docno'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	}
	else if($mode == 'CHEQUE')
	{
		$query43 = "update master_transactionadvancedeposit set patientname = '$customer', patientcode = '$customercode', transactionamount = '$amount', chequeamount = '$amount', username = '$username',remarks = '$remarks' where docno = '$docno'";
		$exec43 = mysql_query($query43) or die ("Error in Query43".mysql_error());
		
		$query2 = "update paymentmodedebit set patientname = '$customer', patientcode = '$customercode', cheque = '$amount', username = '$username' where billnumber = '$docno'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	}
	else if($mode == 'ONLINE')
	{
		$query431 = "update master_transactionadvancedeposit set patientname = '$customer', patientcode = '$customercode', transactionamount = '$amount', onlineamount = '$amount', username = '$username',remarks = '$remarks' where docno = '$docno'";
		$exec431 = mysql_query($query431) or die ("Error in Query431".mysql_error());
		
		$query2 = "update paymentmodedebit set patientname = '$customer', patientcode = '$customercode', online = '$amount', username = '$username' where billnumber = '$docno'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	}
	
	}
	
	header("location:advancepatientslist.php");
}

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

function ajaxlocationfunction(val)
{

}
					
//ajax to get location which is selected ends here




function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcPopupOnLoad1();
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


function funcPrintReceipt1()
{
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

<script>
function funcPopupOnLoad1()
{

}
</script>
<?php 
include ("js/dropdownlist1newscriptingadv.php"); ?>
<script type="text/javascript" src="js/autosuggestnewadv.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomeradv.js"></script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
		</td>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  <form name="form11" id="form11" method="post" action="editadvancedeposit.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1043" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div>
				<input type="hidden" name="locationcodeget" id="locationcodeget"></td>
				<td width="11%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Doc No</strong></div></td>
					 <td width="22%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				<td width="12%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Visit No</strong></div></td>
				  <td width="13%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
              </tr>
           <?php
		   $colorloopcount = 0;
		   $sno = 0;
		  $query2 = "select * from master_transactionadvancedeposit where docno = '$docno'";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while($res2 = mysql_fetch_array($exec2))
		  {
		  $docno = $res2['docno'];
		  $patientname = $res2['patientname'];
		  $patientcode = $res2['patientcode'];
		  $visitcode = $res2['visitcode'];
		  $date = $res2['transactiondate'];
		  $amount = $res2['transactionamount'];
		  $mode = $res2['transactionmode'];
		  $remarks = $res2['remarks'];
		  
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
          </tr>
		   <?php
		   }
		   ?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td colspan="4" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             			
			</tr>
			<tr>
              <td colspan="2" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#FFF"><strong>Edit Patient </strong> </td>
				<td colspan="5" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFF"><input name="customer" id="customer" size="60" autocomplete="off" value="<?php echo $patientname; ?>">
				 	  	  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="<?php echo $patientcode; ?>" type="hidden"></td>
			</tr>
			<tr>
              <td colspan="2" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#FFF"><strong>Edit Amount </strong> </td>
				<td colspan="5" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFF"><input type="text" name="amount" id="amount" value="<?php echo $amount; ?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"></td>
			</tr>
			<tr>
              <td colspan="2" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#FFF"><strong>Remarks</strong> </td>
				<td colspan="5" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFF"><textarea rows="4" cols="35" name="remarks"><?php echo $remarks; ?></textarea></td>
			</tr>
			<tr>
              <td colspan="2" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#FFF"><strong>&nbsp;</strong> </td>
				<td colspan="5" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFF">
				<input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>">
				<input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
				<input type="submit" name="submit" id="submit" value="Submit"></td>
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
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

