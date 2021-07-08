<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$sno = 0;
$colorloopcount = '';
$totalcost = 0.00;

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["store"])) { $store1 = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["location"])) { $location1 = $_REQUEST["location"]; } else { $location1 = ""; }


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
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	  <tr>
        <td width="860">
	<form name="form1" id="form1" method="post" action="labresultsviewlist.php">
	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="889" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="6" bgcolor="#cccccc" class="bodytext31" align="left" valign="middle"><strong>Opening Stock Entry: <?php echo $docnumber.'/'.$store1.'/'.$location1; ?></strong></td>
			 </tr>
			  <tr>
			    <td width="41" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff">&nbsp;</td>
				  <td width="41" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>S.No.</strong></td>
				  				  <td width="233"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">Item</td>
				  				  <td width="142"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">Cost Price </td>
				  				  <td width="120"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">Qty</td>
				  				  <td width="216"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Expiry Date </strong></td>
				  				  <td rowspan="2" class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right"> 
                 <a target="_blank"  href="print_openingstockentry.php?ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>&&docnumber=<?php echo $docnumber; ?>&&store=<?php echo $store1; ?>&&location=<?php echo $location1; ?>" download> <img src="images/pdfdownload.jpg" width="30" height="30"></a></td>	
                  </tr>					
           <?php
		$query1 = "select * from openingstock_entry where recordstatus <> 'deleted' and billnumber='$docnumber' and transactiondate between '$fromdate' and '$todate' ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$res1billnumber =$res1['billnumber'];
		$res1itemname =$res1['itemname'];
		$res1transactiondate =$res1['transactiondate'];
		$res1expirydate =$res1['expirydate'];
		$res1quantity =$res1['quantity'];
		$res1rateperunit =$res1['rateperunit'];
		$res1totalrate =$res1['totalrate'];
	    $res1username =$res1['username'];
		$totalcost = $totalcost + $res1totalrate;
		
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
		 	  <td width="41" align="left" valign="center" class="bodytext31">&nbsp;</td>
				<td width="41" align="left" valign="center" class="bodytext31"><?php echo $sno= $sno + 1; ?></td>
	        	<td width="233"  align="left" valign="center" class="bodytext31"><?php echo $res1itemname; ?></td>
				<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1rateperunit,2,'.',','); ?></td>
				<td width="120"  align="right" valign="center" class="bodytext31"><?php echo intval($res1quantity); ?></td>
				<td width="216"  align="right" valign="center" class="bodytext31"><?php echo $res1expirydate; ?></td>
				<td width="40" bgcolor="#E0E0E0" align="right" valign="center" class="bodytext31">&nbsp;</td>
			    </tr>	
	      <?php } ?>		
		
			 <tr>
			   <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			<td  valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext31" align="right"><strong>Total</strong></td>
			<td  valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext31" align="right"><?php echo number_format($totalcost,2,'.',','); ?></td>
			<td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
			<td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
			<td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
		    </tr>		
          </tbody>
        </table>
<tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

