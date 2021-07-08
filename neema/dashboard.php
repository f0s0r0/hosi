<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="dashboard.php" onKeyDown="return disableEnterKey(event)">
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
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="0%">&nbsp;</td>
	<td width="0%">&nbsp;</td>
    <td width="84%" valign="top">
	<table width="525" border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td>&nbsp;</td>
	</tr>
	

		  <tr>
				<td width="74" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 440, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oprevenue_bar.php', false );
					$_SESSION['datefrom'] = $transactiondatefrom;
					$_SESSION['dateto'] = $transactiondateto;
					?>
				</td>
				<td width="74" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 440, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/collectionsummary_bar.php', false );
					$_SESSION['datefrom'] = $transactiondatefrom;
					$_SESSION['dateto'] = $transactiondateto;
					?>
				</td>
				<td width="74" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 440, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/consultationrevenueday-bar.php', false );
					$_SESSION['month'] = date('m',strtotime($transactiondateto));
					$_SESSION['year'] = date('Y',strtotime($transactiondateto));
					?>
				</td>
				</tr>
	            <tr>			
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 440, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/departmentrevenue_pie.php', false );
					$_SESSION['datefrom'] = $transactiondatefrom;
					$_SESSION['dateto'] = $transactiondateto;
					?>
				</td>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 440, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/revenuereportbytype_pie.php', false );
					/*$_SESSION['datefrom'] = $transactiondatefrom;
					$_SESSION['dateto'] = $transactiondatefrom;*/
					?>
				</td>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 440, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/ipfinalbill_pie.php', false );
					/*$_SESSION['datefrom'] = $transactiondatefrom;
					$_SESSION['dateto'] = $transactiondatefrom;*/
					?>
				</td>
				
          </tr>
				 
			   <tr>
                <td colspan="8" align="left" valign="middle"   class="bodytext32">&nbsp;</td>
               </tr>
	    </table>
		
	  </td>
    <td width="16%" valign="top">&nbsp;</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>