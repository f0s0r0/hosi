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
	
$field = $_REQUEST['labpaynow'.$p];
$paynowlabcoa = $_REQUEST['paynowlabcoa'.$p];
$paynowlabsel = $_REQUEST['paynowlabsel'.$p];
$paynowlabtype = $_REQUEST['paynowlabtype'.$p];
$paynowlabcode = $_REQUEST['paynowlabcode'.$p];

if($paynowlabcoa != '')
{
$query33 = "insert into master_financialintegration(field,coa,selectstatus,type,code,ipaddress,recorddate,username)values('$field','$paynowlabcoa','$paynowlabsel','$paynowlabtype','$paynowlabcode','$ipaddress','$updatedatetime','$username')";
$exec33 = mysql_query($query33) or die(mysql_error());
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
		  	  	<form id="form1" name="form1" method="post" action="grtcoaintegration.php" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><table width="950" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; ">
              <tbody>
			              <tr>
    <td>&nbsp;</td>
 </tr>     
                 <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#CCCCCC" class="bodytext3"><strong>Goods Return</strong></td>
                  </tr>
					   <tr>
                        <td width="248" align="left" valign="top"  class="bodytext3"><strong>Field</strong></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><strong>Select COA</strong></td>
                        <td width="117" align="left" valign="top"  class="bodytext3"><strong>Select</strong></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><strong>Type</strong></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
				  </tr>
				 
				 
				 
				  
				   				    
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Credit Account <input type="hidden" name="labpaynow" value="grt" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa" id="paynowcashcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('6')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel" id="paynowcashsel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype" id="paynowcashtype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode" id="paynowcashcode" size="10"/></td>
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

