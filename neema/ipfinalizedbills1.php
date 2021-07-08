<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$totalamount1 = "0.00";
$balanceamount = "0.00";
$openingbalance = "0.00";
$sumtotalamount = "0.00";
$totalcredit = "0.00";
$totalcredit1 = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = '';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["patientname"])) { $patientname = $_REQUEST["patientname"]; } else { $patientname = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
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
<script type="text/javascript" src="js/autocomplete_ippackage.js"></script>
<script type="text/javascript" src="js/autosuggest4packages.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>

<script>

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

</script>

<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>

<script>
function updatebox(varSerialNumber,billamt,totalcount1)
{

var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=totalcount1;
var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
{
    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
	var balanceamt=billamt-billamt;
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	var totalbillamt=document.getElementById("paymentamount").value;
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
		
			//alert(totalbillamt);


document.getElementById("paymentamount").value = totalbillamt.toFixed(2);
document.getElementById("totaladjamt").value=totalbillamt.toFixed(2);
}
else
{
//alert(totalcount1);
for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
}
//alert(grandtotaladjamt);
document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

 }  
}
function checkboxcheck(varSerialNumber5)
{

if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)
{
alert("Please click on the Select check box");
return false;
}
return true;
}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=totalcount;
var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);
for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}

document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt.toFixed(2);

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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
		
		
              <form name="cbform1" method="post" action="ipfinalizedbills1.php">
		<table width="640" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>IP Finalized Bills</strong></td>
              <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
              
             	<tr>
                	<td align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Patient Name </td>
                    <td colspan="3" align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> <input type="text" name="patientname" id="patientname" value="<?= $patientname; ?>" size="50" /> </td>
                </tr>
               
               	<tr>
                	<td align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Patient Code </td>
                    <td colspan="3" align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> <input type="text" name="patientcode" id="patientcode" value="<?= $patientcode; ?>" size="50" /> </td>
                </tr>
            
		           	<tr>
                	<td align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Visit Code </td>
                    <td colspan="3" align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> <input type="text" name="visitcode" id="visitcode" value="<?= $visitcode; ?>" size="50" /> </td>
                </tr>
            
			  <tr>
                      <td width="14%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="48%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>
				<tr>
  			  <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" onClick="return funcAccount1()" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
}	
?>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="881" 
            align="left" border="0">
          <tbody>
            
            <tr>
              <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient</strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>IP No </strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Code </strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code </strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>IP Date </strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Bill </strong></div></td>
              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">&nbsp;</td>
              <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Account</td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1"><div align="right">Amount</div></td>
              <td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1"><div align="right">User</div></td>
              </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$patientname = $_REQUEST['patientname'];
			$patientcode = $_REQUEST['patientcode'];
			$visitcode = $_REQUEST['visitcode'];
			
			$query18 = "select * from ip_bedallocation where patientname like '%$patientname%' and patientcode like '%$patientcode%' and visitcode like '%$visitcode%' and locationcode='$locationcode1' and paymentstatus ='completed' and creditapprovalstatus = '' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
			while($res18 = mysql_fetch_array($exec18))
			 {
			$res18patientcode = $res18['patientcode'];
			$res18visitcode = $res18['visitcode'];
			
			
			$query73 = "select * from master_ipvisitentry where locationcode='$locationcode1' and visitcode='$res18visitcode' and patientcode='$res18patientcode'";
			$exec73 = mysql_query($query73) or die(mysql_error());
			$res73 = mysql_fetch_array($exec73);
			$res73finalbillno = $res73['finalbillno'];
			$res73patientname= $res73['patientfullname'];
		    $res73accountfullname = $res73['accountfullname'];
			$res73consultationdate = $res73['consultationdate'];
			
			$query733 = "select * from master_transactionip where locationcode='$locationcode1' and billnumber='$res73finalbillno'";
			$exec733 = mysql_query($query733) or die(mysql_error());
			$res733 = mysql_fetch_array($exec733);
			$res18username = $res733['username'];	
			
			$query813 = "select * from billing_ip where locationcode='$locationcode1' and billno='$res73finalbillno'";
			$exec813 = mysql_query($query813) or die(mysql_error());
			$res813 = mysql_fetch_array($exec813);
			
			$num813 = mysql_num_rows($exec813);
			if($num813 > 0)
			{
			$totalamount1=$res813['totalamount'];
			$sumtotalamount = $sumtotalamount + $totalamount1;
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
          <tr <?php echo $colorcode; ?>>
             <td align="left" valign="center" class="bodytext31">
			   <?php echo $sno = $sno + 1; ?></td>
			
			  <td align="left" valign="center" class="bodytext31">
			   <?php echo $res73patientname; ?></td>
				<td align="center" valign="center" class="bodytext31"><div align="left"><?php echo $res73finalbillno; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><div align="left"><?php echo $res18patientcode; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><div align="left"><?php echo $res18visitcode; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><div align="left"><?php echo $res73consultationdate; ?></div></td>
				<td  align="center" valign="center" class="bodytext31">
				  <div align="right"><?php echo number_format($totalamount1,2,'.',','); ?></div></td>
				<td  align="left" valign="center" class="bodytext31">&nbsp;</td>
				<td  align="left" valign="center" class="bodytext31"><?php echo $res73accountfullname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><div align="right"><?php echo $totalamount1; ?>				</div></td>
				<td  align="center" valign="center" class="bodytext31"><div align="right"><?php echo strtoupper($res18username); ?></div></td>
			   </tr>
		   <?php 
		   }  
		   ?>
		   
		   <?php
			$query28 = "select * from ip_bedallocation where patientname like '%$patientname%' and patientcode like '%$patientcode%' and visitcode like '%$visitcode%' and locationcode='$locationcode1' and paymentstatus ='completed' and creditapprovalstatus = 'approved' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec28 = mysql_query($query28) or die ("Error in Query1".mysql_error());
			while($res28 = mysql_fetch_array($exec28))
			 {
			$res28patientcode = $res28['patientcode'];
			$res28visitcode = $res28['visitcode'];
			
			$query37 = "select * from master_ipvisitentry where locationcode='$locationcode1' and visitcode='$res28visitcode' and patientcode='$res28patientcode'";
			$exec37 = mysql_query($query37) or die(mysql_error());
			$res37 = mysql_fetch_array($exec37);
			$res37finalbillno = $res37['finalbillno'];
			$res37patientname= $res37['patientfullname'];
		    $res37accountfullname = $res37['accountfullname'];
			$res37consultationdate = $res37['consultationdate'];
			
			
			$query81 = "select * from billing_ipcreditapproved where locationcode='$locationcode1' and billno='$res37finalbillno' ";
			$exec81 = mysql_query($query81) or die(mysql_error());
			$res81 = mysql_fetch_array($exec81);
			$num81 = mysql_num_rows($exec81);
			if($num81 > 0)
			{
			$res81totalamount=$res81['totalamount'];
			$res81deposit=$res81['deposit'];
		    $res81totalrevenue=$res81['totalrevenue'];
			$totalcredit = $totalcredit + $res81totalrevenue;
			}
			
			$query733 = "select * from master_transactionipcreditapproved where locationcode='$locationcode1' and billnumber='$res37finalbillno'";
			$exec733 = mysql_query($query733) or die(mysql_error());
			$res733 = mysql_fetch_array($exec733);
			$res37username = $res733['username'];	
			
			$query181 = "select * from master_transactionipcreditapproved where locationcode='$locationcode1' and billnumber='$res37finalbillno'";
			$exec181 = mysql_query($query181) or die(mysql_error());
			while($res181 = mysql_fetch_array($exec181)) {
			$num181 = mysql_num_rows($exec181);
			if($num181 > 0)
			{
			$res181transactionamount=$res181['transactionamount'];
			$res181postingaccount=$res181['postingaccount'];
			$totalcredit1 = $totalcredit1 + $res181transactionamount;
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
          <tr <?php echo $colorcode; ?>>
             <td align="left" valign="center" class="bodytext31">
			   <?php echo $sno = $sno + 1; ?></td>
			
			  <td align="left" valign="center" class="bodytext31">
			   <?php echo $res37patientname; ?></td>
				<td align="center" valign="center" class="bodytext31"><div align="left"><?php echo $res37finalbillno; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><div align="left"><?php echo $res37consultationdate; ?></div></td>
				<td  align="center" valign="center" class="bodytext31">
				  
				    
			      <div align="right"><?php echo number_format($res81totalrevenue,2,'.',','); ?>	            </div></td>
				<td  align="left" valign="center" class="bodytext31">&nbsp;</td>
				<td  align="left" valign="center" class="bodytext31"><?php echo $res181postingaccount; ?></td>
				<td  align="center" valign="center" class="bodytext31"><div align="right"><?php echo number_format($res181transactionamount,2,'.',','); ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><div align="right"><?php echo strtoupper($res37username); ?></div></td>
			   </tr>
		   <?php 
		   }  } }
		   ?>
		    
			<?php $grandtotal = $sumtotalamount + $totalcredit;  ?>
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
              <td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"><?php echo number_format($grandtotal,2,'.',','); ?></div></td>
				<td  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
				<td  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"></div></td>
              </tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
