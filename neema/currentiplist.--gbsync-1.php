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

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php// echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
.style1 {font-weight: bold}
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
    <td width="97%" valign="top"><table width="838" border="0" cellpadding="0" cellspacing="0">
      
	  <tr>
        <td width="263">
	<form name="form1" id="form1" method="post"  action="currentiplist.php">	
	
	 <tbody>
          <tr bgcolor="#011E6A">
              <td height="21" colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Current IP List </strong></td>
            </tr>
             <tr>
          <td width="263" height="35" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="155" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="206" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           <tr>
  			  <td width="263" height="28" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="return funcSubTypeChange1()">
                    <?php
						
						$query1 = "select * from login_locationdetails where  username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						<option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                </select>
					 
              </span></td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
		     </tr>
            <tr>
              <td height="35" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
          </tbody>
		  </form>
      </table>
		
	
	
<?php
	$colorloopcount=0;
	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];

	


$querynw1 = "select * from ip_bedallocation where locationcode='$locationcode1' and paymentstatus = '' and creditapprovalstatus = '' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execnw1 = mysql_query($querynw1) or die ("Error in Querynw1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="6" bgcolor="#cccccc" valign="middle" class="bodytext31"><strong> </strong><label class="number"><<<?php echo $resnw1;?>>></label></td>
			 </tr>
            <tr>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
				  <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Reg. No. </strong></div></td>
				 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Visit Code </strong></div></td>
             
                  <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>IP Date </strong></div></td>
            </tr>
           <?php
		
	       $query1 = "select * from ip_bedallocation where locationcode='$locationcode1' and paymentstatus = '' and creditapprovalstatus = '' and recordstatus <> 'discharged' ";
		   $exec1 = mysql_query($query1) or die(mysql_error());
		   while($res1 = mysql_fetch_array($exec1))
		   {
		   $patientname = $res1['patientname'];
		   $patientcode = $res1['patientcode'];
		   $visitcode = $res1['visitcode'];
		  
		   $query2 = "select * from master_ipvisitentry where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec2 = mysql_query($query2) or die(mysql_error());
		   $res2 = mysql_fetch_array($exec2);
		   $registrationdate = $res2['registrationdate'];
		   //$accountname = $res2['accountfullname'];
		
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
			  <div class="bodytext31" align="center">
			    <div align="left"><?php echo $patientname; ?></div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			       <div align="left"><?php echo $visitcode; ?></div></td>
            
                <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationdate; ?></div></td>
            </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
      </tr>
          </tbody>
       
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
	   </table>
	 
   
  
<?php include ("includes/footer1.php"); ?>
</body>
</html>

