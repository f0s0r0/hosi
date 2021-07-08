<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
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
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
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
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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
		
		
              <form name="cbform1" method="post" action="userwiselabentry.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>User Wise Lab Bills</strong></td>
              </tr>
<!--            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
              </span></td>
           </tr>
-->		   
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
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Status </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                      <select name="status" id="status">
                      <option value="No" selected>No</option>
                      <option value="Yes">Yes</option>
                      </select></td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;  </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">&nbsp;</td>
               </tr>
                        
                        
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1205" 
            align="left" border="0">
          <tbody>
          
          <?php
		  			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$status=$_REQUEST['status'];
					if($status=='No')
					{
					$status1='';	
					}
?>
             <tr>
              <td colspan="7" align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="30%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
              <td width="22%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              
              <td width="21%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Category</td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Status</strong></div></td>
            </tr>
			<?php
			 
				
/*		  $query21 = "select * from master_visitentry where patientfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' order by visitcode";
		  $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		  while ($res21 = mysql_fetch_array($exec21))
		  {
     	  $res21patientfullname = $res21['patientfullname'];
		  $res21patientcode = $res21['patientcode'];
		  $res21visitcode = $res21['visitcode'];
		  $res21billtype = $res21['billtype'];
		  $res21gender = $res21['gender'];
		  
		  $query1age = "select * from master_customer where customercode = '$res21patientcode'";
		  $exec1age = mysql_query($query1age) or die ("Error in Query1age".mysql_error());
		  $res1age = mysql_fetch_array($exec1age);
		  $res1agedob = $res1age['dateofbirth'];
		  
			$today = new DateTime();
			$diff = $today->diff(new DateTime($res1agedob));
			
			if ($diff->y)
			{
				$age =  $diff->y . ' Years';
			}
			elseif ($diff->m)
			{
				 $age =  $diff->m . ' Months';
			}
			else
			{
				 $age =  $diff->d . ' Days';
			}
*/	
					if($status=='No')
					{
		  $query301 = "select username from consultation_lab where freestatus like '%$status%' and freestatus like '%$status1%' and consultationdate between '$ADate1' and '$ADate2' group by username order by auto_number desc";
					}
					else
					{
		  $query301 = "select username from consultation_lab where freestatus like '%$status%' and consultationdate between '$ADate1' and '$ADate2' group by username order by auto_number desc";
					}
		  $exec301 = mysql_query($query301) or die ("Error in Query301". mysql_error());
		  $num301 = mysql_num_rows($exec301);
		  while ($res301= mysql_fetch_array($exec301))
		  {
	      $searchusername = $res301['username']; 

		  ?>
          
		  <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo strtoupper($searchusername); ?> </strong></td>
              </tr>
			  
<!--		  <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo strtoupper($res21patientfullname); ?> (<?php echo $res21patientcode;?>, <?php echo $res21visitcode; ?>,<?php echo $res21gender; ?>,<?php echo $age; ?>)</strong></td>
              </tr>
-->			  
			  <?php
		  $query31 = "select * from consultation_lab where freestatus like '%$status%' and username='$searchusername' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec31 = mysql_query($query31) or die ("Error in Query31". mysql_error());
		  $num31 = mysql_num_rows($exec31);
			  
		  while ($res31= mysql_fetch_array($exec31))
		  {
	      $res21patientfullname = $res31['patientname'];
	      $res21patientcode = $res31['patientcode'];
	      $res21visitcode = $res31['patientvisitcode'];
		  
	      $res31labitemcode = $res31['labitemcode']; 
		  $res31labitemname = $res31['labitemname'];
		  $res31labitemrate = $res31['labitemrate'];
		  $accountname = $res31['accountname'];
		  $res31consultationdate = $res31['consultationdate'];
		  $freestatus = $res31['freestatus'];
		  //$username = $res31['username'];
		  
		  $total = $total + $res31labitemrate;
		  
		  
		  $query144 = "select * from master_lab where itemcode = '$res31labitemcode' ";
		  $exec144 =mysql_query($query144) or die(mysql_error());
		  $res144= mysql_fetch_array($exec144);
		  $res144categoryname = $res144['categoryname']; 
		  
			
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
		  if($freestatus=='')
		  {
			$freestatus='No';  
		  }
					  $snocount = $snocount + 1;

			?>
		
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res21patientfullname); ?> (<?php echo $res21patientcode;?>, <?php echo $res21visitcode; ?>)</td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $res31consultationdate; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res31labitemname; ?></div></td>
               <td class="bodytext31" valign="center" align="left"><?php echo $res144categoryname; ?></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res31labitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="right"><?php echo $freestatus;?> </td>
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
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong> Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
<!--              <td width="3%"  align="right" valign="center" 
                bgcolor="#E0E0E0" class="bodytext31"><a target="_blank" href="print_patientwiselabbills.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&patient=<?php echo $searchsuppliername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
-->            </tr>
<?php }?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
