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

if (isset($_REQUEST["charttype"])) {  $charttype = $_REQUEST["charttype"]; } else { $charttype = ""; }
if (isset($_REQUEST["ADate1"])) {  $datefrom = $_REQUEST["ADate1"]; } else { $datefrom = ""; }
if (isset($_REQUEST["ADate2"])) {  $dateto = $_REQUEST["ADate2"]; } else { $dateto = ""; }
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

function selectmonth()
{
	if (document.getElementById("month").value == "")
	{
		alert ("Search Month.");
		document.getElementById("month").focus();
		return false;
	}
}
function selectcharttype()
{
	if (document.getElementById("charttype").value == "")
	{
		alert ("Search Chart.");
		document.getElementById("charttype").focus();
		return false;
	}
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
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
        <td width="860"><form name="cbform1" method="post" action="oprevenuechart.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="10" bgcolor="#CCCCCC" class="bodytext3"><strong>OP Revenue </strong></td>
              </tr>
        
             <tr>
          <td width="79" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="150" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1"  value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="57" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="139" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="90" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Chart Type </strong></td>
          <td width="237" align="left" valign="center"  bgcolor="#ffffff"><strong>
            <select name="charttype" id="charttype" required>
			  <?php
				/*if ($charttype != '')
				{
				?>
                 <option value="<?php echo $charttype; ?>" selected="selected"><?php echo $charttype; ?></option>
				 <?php
				}*/
				?>
              <option value="Pie">Pie</option>
			  <option value="Bar">Bar</option>
              <!--<option value="Line">Line</option>-->
            </select>
          </strong></td>
             </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="9" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return selectmonth(); return selectcharttype();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="labresultsviewlist.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{
if (isset($_REQUEST["charttype"])) { $charttype = $_REQUEST["charttype"]; } else { $charttype = ""; }
if (isset($_REQUEST["ADate1"])) {  $datefrom = $_REQUEST["ADate1"]; } else { $datefrom = ""; }
if (isset($_REQUEST["ADate2"])) {  $dateto = $_REQUEST["ADate2"]; } else { $dateto = ""; }
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="802" 
            align="left" border="0">
          <tbody>
		  <?php
		  $query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$res1consultationamount = $res1['billamount1'];

if($res1consultationamount != 0)
{
$data[] = $res1consultationamount;
$alldepartment1[] = "Consultation" ;
}

$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2labitemrate = $res2['labitemrate1'];

$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$res3labitemrate = $res3['labitemrate1'];

$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec14 = mysql_query($query14) or die ("Error in query14".mysql_error());
$res14 = mysql_fetch_array($exec14);
$res14labitemrate = $res14['labitemrate1'];

$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;

if($totallabitemrate != 0)
{
$data[] = $totallabitemrate;
$alldepartment1[] = "Lab" ;
}

$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$res4radiologyitemrate = $res4['radiologyitemrate1'];

$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
$res5radiologyitemrate = $res5['radiologyitemrate1'];

$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
$res15 = mysql_fetch_array($exec15);
$res15radiologyitemrate = $res15['radiologyitemrate1'];

$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;

if($totalradiologyitemrate != 0)
{
$data[] = $totalradiologyitemrate;
$alldepartment1[] = "Radiology" ;
}

$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
$res6 = mysql_fetch_array($exec6);
$res6servicesitemrate = $res6['servicesitemrate1'];

$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$res7servicesitemrate = $res7['servicesitemrate1'];

$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
$res16 = mysql_fetch_array($exec16);
$res16servicesitemrate = $res16['servicesitemrate1'];

$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;

if($totalservicesitemrate != 0)
{
$data[] = $totalservicesitemrate;
$alldepartment1[] = "Services" ;
}

$query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$res8pharmacyitemrate = $res8['amount1'];

$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$res9pharmacyitemrate = $res9['amount1'];

$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
$res17 = mysql_fetch_array($exec17);
$res17pharmacyitemrate = $res17['amount1'];

$totalpharmacyitemrate = $res8pharmacyitemrate + $res9pharmacyitemrate + $res17pharmacyitemrate;

if($totalpharmacyitemrate != 0)
{
$data[] = $totalpharmacyitemrate;
$alldepartment1[] = "Pharmacy" ;
}

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
$res10 = mysql_fetch_array($exec10);
$res10referalitemrate = $res10['referalrate1'];

$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$res11referalitemrate = $res11['referalrate1'];

$totalreferalitemrate = $res10referalitemrate + $res11referalitemrate;

if($totalreferalitemrate != 0)
{
$data[] = $totalreferalitemrate;
$alldepartment1[] = "Referral" ;
}
$totalop = array_sum($data);
?>
		  
		  <?php
		    if($charttype== 'Pie') { ?>
		 	<tr>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oprevenue_pie.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
				</td>
                </tr>
           <?php } ?>
		   
		  <?php
		    if($charttype== 'Bar') { ?>
		 	<tr>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( '90%', 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oprevenue_bar.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
				</td>
                </tr>
           <?php } ?>
		   <tr>
		     <td><strong>Total: <?php echo number_format($totalop,2,'.',','); ?></strong></td>
			 </tr>
		   <?php
		    /*if($charttype== 'Line') { ?>
				<!--<tr>
				<td>
					<?php
					include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oprevenue_line.php', false );
				    $_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					*/?>
				 </td>
			</tr>
			  <?php //} ?>	
          </tbody>
        </table>
<?php
}
?>	
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

