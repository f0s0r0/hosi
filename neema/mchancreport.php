<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-1 month')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>
<script type="text/javascript">

</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script>
$(document).ready(function(e) {
   
		$('#searchsuppliername').autocomplete({
		
	
	source:"ajaxpatientsearch.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var patname=ui.item.patientname;
			var customercode = ui.item.customercode;
			//alert(auto_number);
			$("#searchsupplierfullname").val(patname);
			$('#searchsuppliercode').val(customercode);
			
			},
    
	});
		
});

function Clearcode()
{
	$('#searchsuppliercode').val("");
}

</script>   
<script type="text/javascript">
function ack()
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>



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
		
		
              <form name="cbform1" method="post" action="mchancreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>MCH Report</strong></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
             <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off" onKeyUp="return Clearcode()">
			  <input name="searchsupplierfullname" id="searchsupplierfullname" value="" type="hidden">
              <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>">
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" onClick="return ack()"/>
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1250" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
 				
			</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="25%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
                <td width="22%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
                <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Residence</strong></div></td>
                <td width="27%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Package</strong></div></td>
                <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No of Visits</strong></div></td>
            </tr>
			<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{	
				
					$query1 = "select patientcode, visitcode, patientfullname, billtype, consultationdate, age, gender, accountfullname from master_visitentry where patientcode LIKE '%$searchsuppliercode%' and departmentname LIKE '%MCH%' and consultationdate between '$ADate1' and '$ADate2'";
					$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
					while($res1 = mysql_fetch_array($exec1))
					{
						$patientcode = $res1['patientcode'];
						$patientfullname = $res1['patientfullname'];
						$billtype = $res1['billtype'];
						$consultationdate = $res1['consultationdate'];
						$age = $res1['age'];
						$gender = $res1['gender'];
						$accountfullname = $res1['accountfullname'];
						
						$query21 = "select area from master_customer where customercode = '$patientcode'";
						$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
						$res21 = mysql_fetch_array($exec21);
						$area =  $res21['area'];
							
						$visitcount = 0;
						$servicesbuild = '';
							
						$query2 = "select visitcode from master_visitentry where patientcode = '$patientcode' and department='3'";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						while($res2 = mysql_fetch_array($exec2))
						{
							$visitcount =  $visitcount+1;
							$visitcode = $res2['visitcode'];
							
							$query22 = "select servicesitemname from consultation_services where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and servicesitemname LIKE 'ANC %'";
							$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
							while($res22 = mysql_fetch_array($exec22))
							{
								$services =  $res22['servicesitemname'];
								if($servicesbuild=='')
								{
									$servicesbuild = $services;
								}
								else
								{
									$servicesbuild = $servicesbuild.', '.$services;
								}
							}
						}
						
						if($servicesbuild == '')
						{
							$servicesbuild = 'NULL';
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
                    <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                    <td align="left" class="bodytext3"><?php echo $patientfullname; ?></td>
                    <td align="left" class="bodytext3"><?php echo $age; ?></td>
                    <td align="left" class="bodytext3"><?php echo $accountfullname; ?></td>
                    <td align="left" class="bodytext3"><?php echo ucfirst($area); ?></td>
                    <td align="left" class="bodytext3"><?php echo $servicesbuild; ?></td>
                    <td align="left" class="bodytext3"><?php echo $visitcount; ?></td>
                    </tr>
                    <?php	
					}
					?>
                    <tr>
                <td colspan="7" align="left" valign="center"  
                bgcolor="#FFF" class="bodytext31">&nbsp;</td>
                </tr>
                
                <tr>
                <td colspan="7" align="left" valign="center"  
                bgcolor="#CCC" class="bodytext31">&nbsp;</td>
                </tr>
                <?php
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
