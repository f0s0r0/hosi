<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
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

<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
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
-->
</style>
</head>
<body>
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="4" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Lab Sample Collection</strong></div></td>
              </tr>
            <tr>
              <td width="5%"class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>
                 <td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Number</strong></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from consultation_lab where paymentstatus='paid' and labsamplecoll='pending' and patientcode='walkin' group by billnumber order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientfullname = $res1['patientname'];
			
			$query11="select * from billing_external where patientname='$patientfullname'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$billnumber=$res11['billno'];
			
			$consultationdate = $res1['consultationdate'];
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="externallabsamplecollection.php?billnumber=<?php echo $billnumber; ?>"><strong>Collect</strong></a></div></td>
              </tr>
			<?php
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

