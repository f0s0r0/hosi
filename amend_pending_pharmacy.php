<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ''; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["patientname1"])) { $patientname1 = $_REQUEST["patientname1"]; } else { $patientname1 = ''; }
if (isset($_REQUEST["patientcode1"])) { $patientcode1 = $_REQUEST["patientcode1"]; } else { $patientcode1 = ''; }
if (isset($_REQUEST["visitcode1"])) { $visitcode1 = $_REQUEST["visitcode1"]; } else { $visitcode1 = ''; }
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
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.number
{
padding-left:650px;
text-align:right;
font-weight:bold;

}
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<?php $querynw1 = "select * from master_consultationpharm where medicineissue='pending' and billing = '' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
?>
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
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		  <form name="cbform1" method="post" action="amend_pending_pharmacy.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Amend Pending Pharmacy</strong></td>
			</tr>
			 <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientname1" type="text" id="patientname1" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode1" type="text" id="patientcode1" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode1" type="text" id="visitcode1" value="" size="50" autocomplete="off">
              </span></td>
              </tr>  
			  <tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31">Date From </td>
                      <td width="38%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="11%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Date To </td>
                      <td width="38%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>
				<tr>
		   <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"> Location </span></td>
          <td  colspan="3" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
           <select name="location" id="location">
           <?php
		   
		    $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname"; 
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];
			?>
		  <option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>
        <?php   }?>
		   </select></span></td>
          </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
	   </tr>
      
	   <tr>
	     <td>	
		   <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
          <!--  <tr>
              <td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#cccccc" class="bodytext31">
			  <div align="left"><strong>Amend Pharmacy</strong><label class="number"><<<?php echo $resnw1;?>>></label></div>			  </td>
            </tr>-->
			
			 <tr>
              <td width="2%"  class="bodytext31">&nbsp;</td>
              <td colspan="15"  class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
			  	}
				?>			   </td>  
            </tr>
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>OP Date </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
               <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$query1 = "select * from master_consultationpharm where medicineissue='pending' and patientcode like '%$patientcode1' and patientvisitcode like '%$visitcode1%' and patientname like '%$patientname1%' and recorddate between '$ADate1' and '$ADate2' and  billing = '' group by patientvisitcode order by auto_number desc";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			
			
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
		  	$consultationdate=$res1['recorddate'];
			
			
			$query21 = "select * from master_visitentry where visitcode='$visitcode'";
			$exec21 = mysql_query($query21) or die(mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$patientaccountname=$res21['accountfullname'];
			$patientname = $res21['patientfullname'];
		$query2 = "select visitcode from master_visitentry where visitcode='$visitcode' and overallpayment='' and visitcode not in (select visitcode from billing_paylater)";
			$exec2 = mysql_query($query2) or die(mysql_error());
			
			
			$num2 = mysql_num_rows($exec2);
		if($num2 > 0)
		{
		
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
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientaccountname; ?></div></td>
              
              <td class="bodytext31" valign="center"  align="left"><a href="amendpharmacy.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Amend</strong></a>			  </td>
              </tr>
			<?php
			   }
			  }    
			
			?>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

