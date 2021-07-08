<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$tottransactionamount1 = '';
$registrationdate = '';
$packageanum1 = '';
$billtype = '';
$tottransactionamount = '';

 $colorloopcount1 =0;
 $sno1 = 0;
 $transactionamount = '';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$searchsuppliername=isset($_REQUEST['searchsuppliername'])?$_REQUEST['searchsuppliername']:'';
?>
<?php
						
           
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						 $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						 $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
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
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script>

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

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
.style3 {
	COLOR: #3b3b3c;
	FONT-FAMILY: Tahoma;
	text-decoration: none;
	font-size: 11px;
	font-weight: bold;
}
</style>
</head>



<body>
 
<table width="98%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1389">
        <form name="cbform1" method="post" action="ipcreditaccountreport.php">
        
          <table width="1000" border="0"  align="left" cellpadding="3" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
           <tr>
          <td colspan="2" bgcolor="#cccccc" class="bodytext31"><strong>Search IP Credit</strong></td>
            <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
						
						
                  
                  </td> 
          </tr>
        
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off"/>
              </td>
           </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchpatient" type="text" id="searchpatient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchpatientcode" type="text" id="searchpatientcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchvisitcode" type="text" id="searchvisitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>	
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="24%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="4%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="65%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
  			  <td width="7%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="24%" align="left" valign="top"  bgcolor="#FFFFFF">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						<option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
						
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
			</table>
		
			</form>
		  </td>
      </tr>
</table></td>


</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>
      <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 

            align="left" border="0">
            <tbody>
            
             <tr>
              <td width="2%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="12%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>
				 <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				
				 <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				  <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">
                <div align="center"><strong>IP Date</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Type</strong> </div></td>
                <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sub Type</strong> </div></td>
					 <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No</strong> </div></td>
                
					 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Deposits </strong></div></td>
				    <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Outstanding</strong></div></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Limit</strong></div></td>
				 <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Interim</strong></div></td>
               
              </tr>
               </tbody>
			  <?php 
			   if (isset($_POST["cbfrmflag1"])) { $cbfrmflag1 = $_POST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

                 if($cbfrmflag1== 'cbfrmflag1')
				 {
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					$searchpatient = $_REQUEST['searchpatient'];
					$searchpatientcode = $_REQUEST['searchpatientcode'];
					$searchvisitcode = $_REQUEST['searchvisitcode'];
 //$query34 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = '' and recordstatus <> '' and locationcode ='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
$query34 = "select * from ip_bedallocation where locationcode ='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   $num1 = mysql_num_rows($exec34);
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		  $visitcode = $res34['visitcode'];
		   $docnumberr = $res34['docno'];
		   
		   $query36 = "select * from ip_bedtransfer where patientcode= '$patientcode' and visitcode='$visitcode'  and locationcode ='$locationcode'  order by auto_number desc ";
		   $exec36 = mysql_query($query36) or die(mysql_error());
		   $num36 = mysql_num_rows($exec36);
		   $res36 = mysql_fetch_array($exec36);
		   $nbed = $res36['bed'];
		   
           $query35 = "select * from ip_bedallocation where patientcode= '$patientcode' and visitcode='$visitcode' and docno = '$docnumberr' and paymentstatus = '' and creditapprovalstatus = ''  ";
		   $exec35 = mysql_query($query35) or die(mysql_error());
		   $res35 = mysql_fetch_array($exec35);
		   $bednumber = $res35['bed'];
		   $paymentstatus = $res35['paymentstatus'];
		   $creditapprovalstatus = $res35['creditapprovalstatus'];
		   
		     
		   if($num36 > 0)
		     {
			   $bednumber = $nbed; 
			  }
		   
		   $query50 = "select * from master_bed where auto_number='$bednumber'";
		                  $exec50 = mysql_query($query50) or die(mysql_error());
						  $res50 = mysql_fetch_array($exec50);
						  $bednames = $res50['bed'];
		 
		  
			include ('ipcreditaccountreport3.php');
			$total = $overalltotal;
		//echo  $overalltotal;
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'  and locationcode='$locationcode' ";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   $res82 = mysql_fetch_array($exec82);
		   $accountname = $res82['accountfullname'];
		   $registrationdate = $res82['registrationdate'];
		   $billtype = $res82['billtype'];
		   $overalllimit = $res82['overalllimit'];
		   $patienttype=$res82['type'];
		   $subtype=$res82['subtype'];
		   //$consultationfee = $res82['admissionfees'];
		   
		     $query83 = "select sum(transactionamount) from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'  and recordstatus ='' and locationcode ='$locationcode'";
		     $exec83 = mysql_query($query83) or die(mysql_error());
		     $res83 = mysql_fetch_array($exec83);
			$transactionamount = $res83['sum(transactionamount)'];
			
			$tottransactionamount = $tottransactionamount + $transactionamount;
			$tottransactionamount1 = $tottransactionamount1 + $total;
			  
		    $colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#D3EEB7"';
			}
			?>
			  <tr <?php echo $colorcode1; ?>>	  
             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $registrationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patienttype; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $subtype; ?></div></td>
               
               
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bednames; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accountname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($transactionamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($total,2,'.',',');  ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($overalllimit,2,'.',','); ?></div></td>
			 <td width="4%"  align="center" valign="center" class="bodytext31"><div align="center"><a target="_blank" href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>View</strong></a> </div></td>
			  </tr>
			 
		   <tr>
		   
           <td class="bodytext31" valign="center"  align="center" colspan="9"></td>
           <td class="bodytext31" valign="center" >
           <div align="center"><strong>
		   <?php echo number_format($tottransactionamount,2,'.',','); ?></strong></div>
           </td>
          
		   <td class="bodytext31" valign="center"  align="right"><div align="center"><strong><?php echo number_format($tottransactionamount1,2,'.',','); ?></strong></div></td>
         </tr>
 <?php
			  }
			 
				 }
			  ?>
		 
          </tbody>
		  
        </table>
		</td>
        </tr>

	 
	  
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

