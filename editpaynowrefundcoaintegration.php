<?php

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = isset($_POST["frmflag1"]);
if ($frmflag1 == 'frmflag1')
{
for ($p=1;$p<=10;$p++)
		{	
$field = $_REQUEST['labpaynow'.$p];
$paynowlabcoa = $_REQUEST['paynowlabcoa'.$p];
$paynowlabsel = $_REQUEST['paynowlabsel'.$p];
$paynowlabtype = $_REQUEST['paynowlabtype'.$p];
$paynowlabcode = $_REQUEST['paynowlabcode'.$p];

if($paynowlabcoa != '')
{
$query33 = "update master_financialintegration set coa='$paynowlabcoa',selectstatus='$paynowlabsel',type='$paynowlabtype',code='$paynowlabcode',ipaddress='$ipaddress',recorddate='$updatedatetime',username='$username' where field='$field'";
$exec33 = mysql_query($query33) or die(mysql_error());
}
}
header("location:financialintegration.php");
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = isset($_REQUEST["st"]);
if ($st == 1)
{
	$errmsg = "Login Failed. Please Try Again With Proper User Id and Password.";
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0; 
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
.bodytext5 {	FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
-->
</style>
<?php

$query76 = "select * from master_financialintegration where field='labrefundpaynow'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];
$labcoaname = $res76['coa'];
$labtype = $res76['type'];
$labselect = $res76['selectstatus'];

$query761 = "select * from master_financialintegration where field='radiologyrefundpaynow'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];
$radiologycoaname = $res761['coa'];
$radiologytype = $res761['type'];
$radiologyselect = $res761['selectstatus'];

$query762 = "select * from master_financialintegration where field='servicerefundpaynow'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];
$servicecoaname = $res762['coa'];
$servicetype = $res762['type'];
$serviceselect = $res762['selectstatus'];

$query763 = "select * from master_financialintegration where field='referalrefundpaynow'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];
$referalcoaname = $res763['coa'];
$referaltype = $res763['type'];
$referalselect = $res763['selectstatus'];

$query764 = "select * from master_financialintegration where field='pharmacyrefundpaynow'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];
$pharmacycoaname = $res764['coa'];
$pharmacytype = $res764['type'];
$pharmacyselect = $res764['selectstatus'];

$query765 = "select * from master_financialintegration where field='cashrefundpaynow'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];
$cashcoaname = $res765['coa'];
$cashtype = $res765['type'];
$cashselect = $res765['selectstatus'];

$query766 = "select * from master_financialintegration where field='chequerefundpaynow'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];
$chequecoaname = $res766['coa'];
$chequetype = $res766['type'];
$chequeselect = $res766['selectstatus'];

$query767 = "select * from master_financialintegration where field='mpesarefundpaynow'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];
$mpesacoaname = $res767['coa'];
$mpesatype = $res767['type'];
$mpesaselect = $res767['selectstatus'];

$query768 = "select * from master_financialintegration where field='cardrefundpaynow'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];
$cardcoaname = $res768['coa'];
$cardtype = $res768['type'];
$cardselect = $res768['selectstatus'];

$query769 = "select * from master_financialintegration where field='onlinerefundpaynow'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];
$onlinecoaname = $res769['coa'];
$onlinetype = $res769['type'];
$onlineselect = $res769['selectstatus'];
?>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearch.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
</head>

<body onLoad="return setFocus()">
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		  	  	<form id="form1" name="form1" method="post" action="editpaynowrefundcoaintegration.php" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><table width="950" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; ">
              <tbody>
			              <tr>
    <td>&nbsp;</td>
 </tr>     
                 <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit Billing - Pay Now Refund</strong></td>
                  </tr>
					   <tr>
                        <td width="248" align="left" valign="top"  class="bodytext3"><strong>Field</strong></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><strong>Select COA</strong></td>
                        <td width="117" align="left" valign="top"  class="bodytext3"><strong>Select</strong></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><strong>Type</strong></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
				  </tr>
				 
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Lab <input type="hidden" name="labpaynow1" value="labpaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa1" id="paynowlabcoa" size="40" value="<?php echo $labcoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('1')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel1" id="paynowlabsel">
						<?php
						if($labselect != '')
						{
						if($labselect == 'dr')		
						{
						$labselect1 = 'Dr';
						}	
						else
						{
						$labselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $labselect; ?>"><?php echo $labselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype1" id="paynowlabtype" size="10" value="<?php echo $labtype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode1" id="paynowlabcode" size="10" value="<?php echo $labcoa; ?>"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Radiology <input type="hidden" name="labpaynow2" value="radiologypaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa2" id="paynowradiologycoa" size="40" value="<?php echo $radiologycoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('2')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel2" id="paynowradiologysel">
						<?php
						if($radiologyselect != '')
						{
						if($radiologyselect == 'dr')		
						{
						$radiologyselect1 = 'Dr';
						}	
						else
						{
						$radiologyselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $radiologyselect; ?>"><?php echo $radiologyselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype2" id="paynowradiologytype" size="10" value="<?php echo $radiologytype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode2" id="paynowradiologycode" size="10" value="<?php echo $radiologycoa; ?>"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Service <input type="hidden" name="labpaynow3" value="servicepaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa3" id="paynowservicecoa" size="40" value="<?php echo $servicecoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('3')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel3" id="paynowservicesel">
						<?php
						if($serviceselect != '')
						{
						if($serviceselect == 'dr')		
						{
						$serviceselect1 = 'Dr';
						}	
						else
						{
						$serviceselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $serviceselect; ?>"><?php echo $serviceselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype3" id="paynowservicetype" size="10" value="<?php echo $servicetype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode3" id="paynowservicecode" size="10" value="<?php echo $servicecoa; ?>"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Referral <input type="hidden" name="labpaynow4" value="referalpaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa4" id="paynowreferalcoa" size="40" value="<?php echo $referalcoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('4')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel4" id="paynowreferalsel">
						<?php
						if($referalselect != '')
						{
						if($referalselect == 'dr')		
						{
						$referalselect1 = 'Dr';
						}	
						else
						{
						$referalselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $referalselect; ?>"><?php echo $referalselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype4" id="paynowreferaltype" size="10" value="<?php echo $referaltype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode4" id="paynowreferalcode" size="10" value="<?php echo $referalcoa; ?>"/></td>
				  </tr>
				    <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Pharmacy <input type="hidden" name="labpaynow5" value="pharmacypaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa5" id="paynowpharmacycoa" size="40" value="<?php echo $pharmacycoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('5')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel5" id="paynowpharmacysel">
						<?php
						if($pharmacyselect != '')
						{
						if($pharmacyselect == 'dr')		
						{
						$pharmacyselect1 = 'Dr';
						}	
						else
						{
						$pharmacyselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $pharmacyselect; ?>"><?php echo $pharmacyselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype5" id="paynowpharmacytype" size="10" value="<?php echo $pharmacytype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode5" id="paynowpharmacycode" size="10" value="<?php echo $pharmacycoa; ?>"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Cash <input type="hidden" name="labpaynow6" value="cashpaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa6" id="paynowcashcoa" size="40" value="<?php echo $cashcoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('6')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel6" id="paynowcashsel">
						<?php
						if($cashselect != '')
						{
						if($cashselect == 'dr')		
						{
						$cashselect1 = 'Dr';
						}	
						else
						{
						$cashselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $cashselect; ?>"><?php echo $cashselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype6" id="paynowcashtype" size="10" value="<?php echo $cashtype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode6" id="paynowcashcode" size="10" value="<?php echo $cashcoa; ?>"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Cheque <input type="hidden" name="labpaynow7" value="chequepaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa7" id="paynowchequecoa" size="40" value="<?php echo $chequecoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('7')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel7" id="paynowchequesel">
						<?php
						if($chequeselect != '')
						{
						if($chequeselect == 'dr')		
						{
						$chequeselect1 = 'Dr';
						}	
						else
						{
						$chequeselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $chequeselect; ?>"><?php echo $chequeselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype7" id="paynowchequetype" size="10" value="<?php echo $chequetype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode7" id="paynowchequecode" size="10" value="<?php echo $chequecoa; ?>"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Mpesa <input type="hidden" name="labpaynow8" value="mpesapaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa8" id="paynowmpesacoa" size="40" value="<?php echo $mpesacoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('8')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel8" id="paynowmpesasel">
						<?php
						if($mpesaselect != '')
						{
						if($mpesaselect == 'dr')		
						{
						$mpesaselect1 = 'Dr';
						}	
						else
						{
						$mpesaselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $mpesaselect; ?>"><?php echo $mpesaselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype8" id="paynowmpesatype" size="10" value="<?php echo $mpesatype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode8" id="paynowmpesacode" size="10" value="<?php echo $mpesacoa; ?>"/></td>
				  </tr>
				     <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Card <input type="hidden" name="labpaynow9" value="cardpaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa9" id="paynowcardcoa" size="40" value="<?php echo $cardcoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('9')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel9" id="paynowcardsel">
						<?php
						if($cardselect != '')
						{
						if($cardselect == 'dr')		
						{
						$cardselect1 = 'Dr';
						}	
						else
						{
						$cardselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $cardselect; ?>"><?php echo $cardselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype9" id="paynowcardtype" size="10" value="<?php echo $cardtype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode9" id="paynowcardcode" size="10" value="<?php echo $cardcoa; ?>"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Online <input type="hidden" name="labpaynow10" value="onlinepaynow" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa10" id="paynowonlinecoa" size="40" value="<?php echo $onlinecoaname; ?>"/>
						 <input type="button" onClick="javascript:coasearch('10')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel10" id="paynowonlinesel">
						<?php
						if($onlineselect != '')
						{		
						if($onlineselect == 'dr')		
						{
						$onlineselect1 = 'Dr';
						}	
						else
						{
						$onlineselect1 = 'Cr';
						}	
						?>
						<option value="<?php echo $onlineselect; ?>"><?php echo $onlineselect1; ?></option>
						<?php
						}
						?>
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype10" id="paynowonlinetype" size="10" value="<?php echo $onlinetype; ?>"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode10" id="paynowonlinecode" size="10" value="<?php echo $onlinecoa; ?>"/></td>
				  </tr>
                <tr>
                 
                  <td align="middle" valign="top" colspan="7"><div align="right">
                      <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
                      <input type="submit" name="Submit" value="Save" style="border: 1px solid #001E6A" />
                      
                  </div></td>
                </tr>
              </tbody>
            </table>
           
        </td>
        </tr>
      </table>
	</form>
    </td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

