<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$snocount='';
$colorloopcount='';
$res3recorddate = array();
$countitem  = '';

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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["medicinename"])) { $itemname = $_REQUEST["medicinename"]; } else { $itemname = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>
<script>
function funcOnLoadBodyFunctionCall()
{	
	funcCustomerDropDownSearch1();	
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
             <form name="cbform1" method="post" action="labregentlinkreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Lab Test By Date </strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					 <tr>
              <td colspan="1" class="bodytext3" bgcolor="#FFFFFF"><strong> Select Item </strong></td>
			   <td colspan="4" class="bodytext3" bgcolor="#FFFFFF"> <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <input name="medicinename" type="text" id="medicinename" size="69" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" value="">
						  <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
              </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <strong>Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="39%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              <td width="44%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">Quantity</td>
              </tr>
			  
				<tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo  $itemname;?></strong></td>
              </tr>
				
			<?php
			$query3 = "select * from master_labregentlinking where itemname like '%$itemname%' and recordstatus <> 'deleted' "; 
			
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			while($res3 = mysql_fetch_array($exec3))
			{
			$labname= $res3['labname'];
			$quantity= $res3['quantity'];
			
            
           $query1 = "select * from resultentry_lab where itemname = '$labname' and resultstatus = 'completed' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemcode ";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $num1 = mysql_num_rows($exec1);
		  //echo $num1;
		  
		  while($res1 = mysql_fetch_array($exec1))
		   {
        	 $res1itemname = $res1['itemname'];
			 
				$query2 = "select itemname as item, count(itemname) as countitem from resultentry_lab where resultstatus = 'completed' and itemname = '$res1itemname' group by itemname, referencename";
				$exec2 = mysql_query($query2) or die ("Error in Query5".mysql_error());
				$num2 = mysql_num_rows($exec2);
			  //echo $num1;
			   while($res2 = mysql_fetch_array($exec2))
			    {
			   $countitem = $res2['countitem'];
                }
				$countitem = $countitem * $quantity;
				
			 $snocount = $snocount + 1;
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
             <?php echo $res1itemname; ?>           </td>
              <td class="bodytext31" valign="center"  align="center">
               <?php echo $countitem; ?>           </td>
              </tr>
			<?php
			}  }
			?>
            <tr>
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

