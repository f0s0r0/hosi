<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
include ("autocompletebuild_users.php");

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_users.js"></script>
<script type="text/javascript" src="js/autosuggestusers.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        
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
function check()
{
var cbcustomername=document.getElementById("cbcustomername").value;
if(cbcustomername=='')
{
	alert("Please select the user");
	document.getElementById("cbcustomername").focus();
	return false;
}
}
</script>

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
		
		
              <form  method="post" action="radiologyreportbyuser.php">
		<table width="658" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Radiology Report By User</strong></td>
              </tr>
              
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> User </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">

              </span>
                    </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        &nbsp;</td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
              <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag2" value="cbfrmflag1">
                  <input  onClick="return check()" type="submit" value="Search" name="Submit" />
                  </td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
	   <?php
	   $cbcustomername=isset($_REQUEST['cbcustomername'])?$_REQUEST['cbcustomername']:'';
			$cbcustomername=trim($cbcustomername);
	    if($cbfrmflag2 == 'cbfrmflag1' && $cbcustomername <>''){?>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="860" 
            align="left" border="0">
          <tbody>
          
          <?php
		  
		  			$cbcustomername=$_REQUEST['cbcustomername'];
			$cbcustomername=trim($cbcustomername);

		  $query7 = "select username from resultentry_radiology where username like '$cbcustomername' and recorddate between '$ADate1' and '$ADate2'"; 
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  $numcount=mysql_num_rows($exec7);
		    $query71 = "select username from ipresultentry_radiology where username like '$cbcustomername' and recorddate between '$ADate1' and '$ADate2'"; 
		  $exec71 = mysql_query($query71) or die ("Error in Query71".mysql_error());
		  $numcount1=mysql_num_rows($exec71);

		  ?>
            <tr>
              <td colspan='12' bgcolor="#cccccc" class="bodytext31"><?php echo 'Total Radiology Report by  '.$cbcustomername?>(<?php echo $numcount+$numcount1;?>)</td>
            </tr>
            <tr>
              <td width="5%" height="24"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				
              <td width="18%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
   				  <td width="11%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit.Code</strong></div></td>
   				  <td width="14%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Date</strong></div></td>
   				  <td width="26%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>
   				  <td width="9%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Rate</strong></div></td>
   				  <td width="9%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Entry By</strong></div></td>
            </tr>
			
			<?php
			
		      
		
		  $query4 = "select * from resultentry_radiology where username like '$cbcustomername' and recorddate between '$ADate1' and '$ADate2' ";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $numcount=mysql_num_rows($exec4);
		  while($res4 = mysql_fetch_array($exec4))
			{
				$customerfullname= $res4['patientname'];
				$patientcode= $res4['patientcode'];
				$visitcode= $res4['patientvisitcode'];
				$itemname= $res4['itemname'];
				$registrationdate= $res4['recorddate'];
				$sampleid= $res4['docnumber'];
				$registeredby= $res4['username'];
				$itemcode=$res4['itemcode'];
				
				
				$query01="select radiologyitemrate from consultation_radiology where patientvisitcode='$visitcode' and radiologyitemname='$itemname' group by radiologyitemname";
				$exe01=mysql_query($query01) or die("Error in query01".mysql_error());
				$res01=mysql_fetch_array($exe01);
				
				$rate= $res01['radiologyitemrate'];
				
				
				
				
				

						
				
			
				$snocount=$snocount+1;
				//echo $cashamount;
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customerfullname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $itemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $rate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $registeredby; ?></div></td>
                
				</tr>
			<?php
			}
			
				  $query41 = "select * from ipresultentry_radiology where username like '$cbcustomername' and recorddate between '$ADate1' and '$ADate2' ";
		  $exec41 = mysql_query($query41) or die ("Error in Query4".mysql_error());
		  $numcount1=mysql_num_rows($exec41);
		  while($res41 = mysql_fetch_array($exec41))
			{
				$customerfullname= $res41['patientname'];
				$patientcode= $res41['patientcode'];
				$visitcode= $res41['patientvisitcode'];
				$itemname= $res41['itemname'];
				$registrationdate= $res41['recorddate'];
				$sampleid= $res41['docnumber'];
				$registeredby= $res41['username'];
				$itemcode=$res41['itemcode'];
				
				
				$query011="select radiologyitemrate from ipconsultation_radiology where patientvisitcode='$visitcode' and radiologyitemname='$itemname' group by radiologyitemname";
				$exe011=mysql_query($query011) or die("Error in query011".mysql_error());
				$res011=mysql_fetch_array($exe011);
				
				$rate= $res011['radiologyitemrate'];
				
				
				
				
				

						
				
			
				$snocount=$snocount+1;
				//echo $cashamount;
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customerfullname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $itemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $rate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $registeredby; ?></div></td>
                
				</tr>
			<?php
			}
			?>
			
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td colspan="10" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                
				
				 
			  
			</tr>
          </tbody>
        </table></td><?php }?>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
