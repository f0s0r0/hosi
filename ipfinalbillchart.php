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

$sumtotalamountcash = "0.00";
$sumtotalamountdirect = "0.00";
$sumtotalamountinsurance = "0.00";
$sumtotalamountstaff = "0.00";
$sumtotalamountcharity = "0.00";
$totalcreditcash = "0.00";
$totalcreditdirect = "0.00";
$totalcreditinsurance = "0.00";
$totalcreditstaff = "0.00";
$totalcreditcharity = "0.00";
$sumofcash = "0.00";
$sumofdirect = "0.00";
$sumofinsurance = "0.00"; 
$sumofstaff = "0.00";
$sumofcharity = "0.00";

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
        <td width="860"><form name="cbform1" method="post" action="ipfinalbillchart.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="10" bgcolor="#CCCCCC" class="bodytext3"><strong>IP Revenue </strong></td>
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

$query1 = "select * from billing_ip where paymenttype = 'CASH' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysql_query($query1) or die(mysql_error());
while($res1 = mysql_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountcash = $sumtotalamountcash + $res1amount;
 }
 if($sumtotalamountcash != 0)
		{
$alldepartment[] = 'CASH:';	
        } 

$query1 = "select * from billing_ip where paymenttype = 'DIRECT CREDIT' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysql_query($query1) or die(mysql_error());
while($res1 = mysql_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountdirect= $sumtotalamountdirect + $res1amount;
}
if($sumtotalamountdirect != 0)
		{
$alldepartment[] = 'DIRECT CREDIT:';	
        } 

$query1 = "select * from billing_ip where paymenttype = 'INSURANCE' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysql_query($query1) or die(mysql_error());
while($res1 = mysql_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountinsurance= $sumtotalamountinsurance + $res1amount;
}
if($sumtotalamountinsurance != 0)
		{
$alldepartment[] = 'INSURANCE:';	
        } 
	 
$query1 = "select * from billing_ip where paymenttype = 'STAFF' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysql_query($query1) or die(mysql_error());
while($res1 = mysql_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountstaff = $sumtotalamountstaff + $res1amount;
 }
if($sumtotalamountstaff != 0)
		{
$alldepartment[] = 'STAFF:';	
        } 
		 
$query1 = "select * from billing_ip where paymenttype = 'CHARITY' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysql_query($query1) or die(mysql_error());
while($res1 = mysql_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountcharity = $sumtotalamountcharity + $res1amount;
 }
 if($sumtotalamountcharity != 0)
		{
$alldepartment[] = 'CHARITY:';	
        } 
$data = array($sumtotalamountcash,$sumtotalamountdirect,$sumtotalamountinsurance,$sumtotalamountstaff,$sumtotalamountcharity);
$totalipfinal = array_sum($data);		
?>
		  
		  <?php
		    if($charttype== 'Pie') { ?>
		 	<tr>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/ipfinalbill_pie.php', false );
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
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/ipfinalbill_bar.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
				</td>
                </tr>
           <?php } ?>
		    <tr>
		        <td><strong>Total: <?php echo number_format($totalipfinal,2,'.',','); ?></strong>			  
             </td>
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

