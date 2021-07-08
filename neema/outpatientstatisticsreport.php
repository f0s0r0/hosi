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
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }


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
</style>

<script src="js/datetimepicker_css.js"></script>

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
    
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
              <form name="cbform1" id="cbform1" method="post" action="outpatientstatisticsreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>OP Statistics By Fee Type</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
           
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			  <input  type="submit" id="toggleButton" value="Search" name="Submit" onClick="hideTable(true);"/>
			  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
			 </td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="992" 
            align="left" border="0">
          <tbody>
<tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="4"></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                <td bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                <td bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                <td bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
              </tr>
            <tr>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="29%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Type</strong></div></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>
              <td width="12%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Cash </strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Insurance</strong></div></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Direct Credit </strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Staff </strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td> 
            </tr>
			<?php
			
		  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		  if ($cbfrmflag1 == 'cbfrmflag1')
				{
		  $query1 = "select * from master_consultationtype";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  while ($res1 = mysql_fetch_array($exec1))
		  {
		  $res1consultationtype = $res1['consultationtype'];
		  $res1department = $res1['department'];
		  $res1auto_number = $res1['auto_number'];
          
		  $query3 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='1' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $num1 = mysql_num_rows($exec3);
		  $res3 = mysql_fetch_array($exec3);
		  
		  $query6 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='3' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		  $num2 = mysql_num_rows($exec6);
		  $res6 = mysql_fetch_array($exec3);
		  
		  /* $query7 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='3' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  $num3 = mysql_num_rows($exec7);
		  $res7 = mysql_fetch_array($exec7);*/
		  
		  $query8 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='2' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec8= mysql_query($query8) or die ("Error in Query8".mysql_error());
		  $num4 = mysql_num_rows($exec8);
		  $res8 = mysql_fetch_array($exec8);
		  
		  $query9 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='5' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		  $num5 = mysql_num_rows($exec9);
		  $res9 = mysql_fetch_array($exec9);
		  
		  $query4 = "select * from master_department where auto_number = '$res1department'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $res4department = $res4['department'];
		  
		  $query5 = "select * from master_department where auto_number = '$res1department'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $res5 = mysql_fetch_array($exec5);
		  $res5department = $res5['department'];
		  
		  $total = $num1 + $num2 + $num4 +$num5;
		  if($total != '0')
		  {
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
                <div class="bodytext31"><?php echo $res1consultationtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res4department; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $num1; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $num2; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo $num4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $num5; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $total; ?></div></td>
            
             
           </tr>
			<?php
			}
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"><strong><!--Total--></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php //echo $totallab; ?></strong></div></td>
              
             
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
