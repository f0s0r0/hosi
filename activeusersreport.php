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

$colorloopcount = '';
$snocount = '';
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

<body>
<table width="1365" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="475" 
            align="left" border="0">
          <tbody>
            <tr bgcolor="#cccccc">
        <td colspan="4" class="bodytext3"><strong>Active Users Report</strong></td>
      </tr>
            <tr>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="46%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User</strong></div></td>
              <td width="33%" align="left" valign="right"  
                bgcolor="#ffffff" class="bodytext31"><strong> Login Date and Time </strong></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Status</strong></td>
            </tr>
			
			<?php
			
			
		  $query2 = "select * from details_login where logouttime = '0000-00-00 00:00:00' order by auto_number desc";
		 
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2user = $res2['username'];
		  $res2logintime = $res2['logintime'];
		  
		  $query6 = "select * from master_employee where username = '$res2user'";
		  $exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  $res6employeename = $res6['employeename'];
		  $status = 'Active';
		  
		  
		  $snocount = $snocount + 1;
			
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
                <div class="bodytext31"><?php echo $res6employeename; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2logintime; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $status; ?></div></td>
             
           </tr>
			<?php
			}
			
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong></strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong></strong></td>
            </tr>
			
            
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

