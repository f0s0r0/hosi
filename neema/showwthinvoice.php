<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');


if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>
<?php
if (isset($_REQUEST["close"])) { $close = $_REQUEST["close"]; } else { $close = ""; }
echo $close;
?>
<?php if($close == 1) {

echo "<script language=javascript>\n".

" window.close();\n".
"</script>\n";
exit();
}
?>

<?php

if (isset($_REQUEST["callfrom1"])) { $callfrom1 = $_REQUEST["callfrom1"]; } else { $callfrom1 = ""; }

$callfrom1 = substr($callfrom1,1);
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

<script>

function refsearch(number,value)
{
var number = number;
var value = value;
window.opener.document.getElementById("result"+number+"").value = value;
window.opener.document.getElementById("result"+number+"").focus();
window.close();
}
function validcheck()
{
if(document.getElementById("drugstatus").value == '')
{
alert("Please Select Drug Status");
document.getElementById("drugstatus").focus();
return false;
}
if(document.getElementById("drugstatus").value == 'incomplete')
{
if(document.getElementById("remarks").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks").focus();
return false;
}
}
}
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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

<script src="js/datetimepicker_css.js"></script>

<body>
<form name="form1" id="form1" method="post" action="showwthinvoice.php">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
  <td class="bodytext31"></td>
    <td colspan="12" class="bodytext31"><strong>Invoices for <?php echo $callfrom1; ?></strong></td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
     	
	         <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">S.No</div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left">Invoice No</div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="left">Patient</div></td>
			  </tr>
           <?php
            $colorloopcount ='';
			$sno = '';
			$i = 1;
		
		$query1 = "select * from master_transactiondoctor where docno='$callfrom1' and taxamount <> '0.00' group by billnumber";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		while($res1 = mysql_fetch_array($exec1))
	 {
	 
	 $billnumber = $res1['billnumber'];
	 $visitcode = $res1['visitcode'];
	 $patientcode = $res1['patientcode'];
	 $query11 = "select * from master_customer where customercode='$patientcode'";
		  $exec11 = mysql_query($query11) or die(mysql_error());
		  $res11 = mysql_fetch_array($exec11);
		  $patientname = $res11['customerfullname'];
			
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
       			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $billnumber; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>
			  </tr>
			  
		   <?php 
		  
		  }
		   ?>   		
		  
		</table>		</td>
		</tr>
  </table>
  
</form>

</body>
</html>

