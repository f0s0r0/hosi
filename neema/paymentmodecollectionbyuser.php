<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1='';
$res2username ='';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';
$cashamount = '0.00';
$cardamount = '0.00';
$chequeamount = '0.00';
$onlineamount = '0.00';
$total = '0.00';
$cashtotal = '0.00';
$cardtotal = '0.00';
$chequetotal = '0.00';
$onlinetotal = '0.00';
$res2cashamount1 ='';
$res2cardamount1 = '';
$res2chequeamount1 = '';
$res2onlineamount1 ='';
$cashamount2 = '0.00';
$cardamount2 = '0.00';
$chequeamount2 = '0.00';
$onlineamount2 = '0.00';
$creditamount2 = '0.00';
$total1 = '0.00';


 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$cbcustomername = $_REQUEST['cbcustomername'];
	
	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
	
	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }
	//$paymenttype = $_REQUEST['paymenttype'];
	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }
	//$billstatus = $_REQUEST['billstatus'];

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
<script language="javascript">


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


function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript" src="js/autocomplete_usersnew.js"></script>
<script type="text/javascript" src="js/autosuggestusersnew.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());
  
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

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1901" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1134">
		
		
              <form name="cbform1" method="post" action="paymentmodecollectionbyuser.php">
		<table width="660" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Collection Summary By User </strong></td>
              <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td> 
            </tr>
			
            <tr>
              <td width="150" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">
                       <input name="searchdescription" id="searchdescription" type="hidden" value="">
	<input name="searchemployeecode" id="searchemployeecode" type="hidden" value="<?= $triageuser; ?>">
	<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
 
               </td>
              </tr>
           
           <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td width="173" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1"  value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td width="132" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td width="173" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
            </tr>
			<tr>
           
			  <td width="150" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="173" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
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
					 
              </span></td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
			
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="776" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#cccccc" class="bodytext31">
                <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$cbcustomername = $_REQUEST['searchdescription'];
					//$patientfirstname =  $cbcustomername;
					
					$customername = $_REQUEST['searchdescription'];
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_salescustomerreport1pharmacy.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/StatementByPatientPharmacy.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
                <script language="javascript">
				function printbillreport1()
				{
					window.open("print_viewconsultation.php?<?php echo $urlpath; ?>","Window1",'width=1000,height=600,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/ViewConsultationBills.xls"
				}
				</script></td>
				
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash </strong></td>
              <td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Card </strong></td>
              <td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Cheque </strong></td>
				<td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Online </strong></td>
				<td width="7%" align="right" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><strong>MPESA</strong></td>
                <td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total </strong></div></td>
                <td width="7%"  align="right" valign="center" 
                bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
            </tr>
			  <?php
			 
			  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
			$cbcustomername=trim($cbcustomername);
		
			 //$res21employeename = $res21['employeename'];
			 $res21username = $cbcustomername;
			 
			 $query31 = "select* from master_employee where locationcode='$locationcode1' and username like '%$res21username%' and status <>'DELETED'";
			$exe31 = mysql_query($query31) or die("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exe31);
			$res3username = $res31["username"];
			 
			$query41 = "select billnumber from master_transactionpaynow where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe41 = mysql_query($query41) or die("Error in Query41".mysql_error());
		    $num1 = mysql_num_rows($exe41);
			//echo $num1;
			$res41 = mysql_fetch_array($exe41);
			//$res41billnumber1 = $res41['billnumber1'];
			//echo $res41billnumber1;
			
			$query51 = "select billnumber from master_transactionexternal where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe51 = mysql_query($query51) or die("Error in Query51".mysql_error());
			$num2 = mysql_num_rows($exe51);
			$res51 = mysql_fetch_array($exe51);
			
			$query61 = "select billnumber from master_billing where locationcode='$locationcode1' and username like '%$res3username%' and billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exe61 = mysql_query($query61) or die("Error in Query61".mysql_error());
			$num3 = mysql_num_rows($exe61);
			$res61 = mysql_fetch_array($exe61);
			
			$query71 = "select billnumber from refund_paynow where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe71 = mysql_query($query71) or die("Error in Query71".mysql_error());
			$num4 = mysql_num_rows($exe71);
			$res71 = mysql_fetch_array($exe71);
			
			$query81 = "select * from receiptsub_details where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe81 = mysql_query($query81) or die("Error in Query81".mysql_error());
			$num5 = mysql_num_rows($exe81);
			$res81 = mysql_fetch_array($exe81);
			
			$query91 = "select * from master_transactionadvancedeposit where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe91 = mysql_query($query91) or die("Error in Query91".mysql_error());
			$num6 = mysql_num_rows($exe91);
			$res91 = mysql_fetch_array($exe91);
			
			$query101 = "select * from master_transactionipdeposit where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe101 = mysql_query($query101) or die("Error in Query101".mysql_error());
			$num7 = mysql_num_rows($exe101);
			$res101 = mysql_fetch_array($exe101);
			
			$query111 = "select * from master_transactionip where locationcode='$locationcode1' and username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe111 = mysql_query($query111) or die("Error in Query111".mysql_error());
			$num8 = mysql_num_rows($exe111);
			$res111 = mysql_fetch_array($exe111);
			
			$query121 = "select * from master_transactionipcreditapproved where locationcode='$locationcode1' and  username like '%$res3username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe121 = mysql_query($query121) or die("Error in Query121".mysql_error());
			$num9 = mysql_num_rows($exe121);
			$res121 = mysql_fetch_array($exe121);
			
			$numbills = $num1 + $num2 + $num3 + $num4 + $num5 + $num6 + $num7 + $num8 + $num9;
			
			 if( $res21username != '')
			{
			?>
			
            <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo strtoupper ($res3username);?> (<?php echo $numbills; ?>)</strong></td>
              </tr>
			  
			<?php
			 
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
			 $query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(chequeamount) as chequeamount1,  sum(creditamount) as creditamount1, sum(onlineamount) as onlineamount1 from master_transactionpaynow where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username";
			
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	        $res2 = mysql_fetch_array($exec2);
			$res2cashamount1 = $res2['cashamount1'];
			$res2cardamount1 = $res2['cardamount1'];
			$res2chequeamount1 = $res2['chequeamount1'];
			$res2onlineamount1 = $res2['onlineamount1'];
		    $res2creditamount1 = $res2['creditamount1'];
			
		   $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode1' and username like '%$res21username%' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  
     	 $res4cashamount1 = $res4['cashamount1'];
		 $res4onlineamount1 = $res4['onlineamount1'];
		 $res4creditamount1 = $res4['creditamount1'];
		 $res4chequeamount1 = $res4['chequeamount1'];
		 $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //$num = mysql_num_rows($exec5);
		  //echo $num;
		  $res5 = mysql_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec6 = mysql_query($query6) or die ("Error in Query5".mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];

		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec7 = mysql_query($query7) or die ("Error in Query5".mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec8 = mysql_query($query8) or die ("Error in Query5".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec9 = mysql_query($query9) or die ("Error in Query5".mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];
		  
		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode1' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		  //$num = mysql_num_rows($exec5);
		  //echo $num;
		  $res10 = mysql_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
		  
		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1;
		   
		  $cashamount1 = $cashamount - $res5cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1;
		  
		  $cashamount2 = $cashamount2 + $cashamount1;
		  $cardamount2 = $cardamount2 + $cardamount1;
		  $chequeamount2 = $chequeamount2 + $chequeamount1;
		  $onlineamount2 = $onlineamount2 + $onlineamount1;
		  $creditamount2 = $creditamount2 + $creditamount1;
		   
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
		  
		  $total1 = $total1 + $total;
			
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="right">
               <?php echo number_format($cashamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
               <?php echo number_format($chequeamount1,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">
              <?php echo number_format($onlineamount1,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($creditamount1,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total, 2,'.',','); ?></td>
                <?php if($total1 != 0.00)
				  {
				   ?>
				<td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right"> 
                 <a target="_blank" href="print_paymentmodecollectionuser.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&locationcode=<?php echo $locationcode1; ?>&&user=<?php echo $res21username; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a>                </td>	
				<?php } ?>		
              </tr>
			<?php
			}
			
			}
			 	
			?>
			 
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($cashamount2,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($cardamount2,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($chequeamount2,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($onlineamount2,2,'.',',');?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($creditamount2,2,'.',',');?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($total1,2,'.',',');?></td>
              </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

