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

$grandtotal = '0.00';
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
$total1 = '0.00';
$billnumber = '';
$netcashamount = '0.00';
$netcardamount = '0.00';
$netchequeamount = '0.00';
$netonlineamount = '0.00';
$netcreditamount = 0.00;
$nettotal = '0.00';

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  

include ("autocompletebuild_users.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where locationcode='$locationcode1' and auto_number = '$getcanum'";
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

<script type="text/javascript" src="js/autocomplete_users.js"></script>
<script type="text/javascript" src="js/autosuggestusers.js"></script>
<script type="text/javascript">
window.onload = function () 
{
//alert ('hai');
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
		
		
              <form name="cbform1" method="post" action="daybookreport.php">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Day Book Report </strong></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">
               </td>
              </tr>
           
           <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
            </tr>
			<tr>
           
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
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
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="867" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="7" bgcolor="#cccccc" class="bodytext31">
                <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$cbcustomername = $_REQUEST['cbcustomername'];
					//$patientfirstname =  $cbcustomername;
					
					$customername = $_REQUEST['cbcustomername'];
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
				}
				?> 			             </tr>
				<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				 $cbcustomername=trim(isset(explode('#',$cbcustomername)[1]) ? explode('#',$cbcustomername)[1]: '');
		  
			
			 $query31 = "select * from master_employee as me LEFT JOIN master_employeelocation as mel ON me.employeecode = mel.employeecode where mel.locationcode='$locationcode1' and me.shift = 'YES' and me.username like '%$cbcustomername%' and me.status <>'DELETED' GROUP BY me.employeecode";
			$exe31 = mysql_query($query31) or die("Error in Query31".mysql_error());
			while($res31 = mysql_fetch_array($exe31))
			{
			$res21username = $res31["username"];
			
			if( $res21username != '')
			{
			include("include_daybookreport.php");
			if($numsd2 !=0 || $numsd23 !=0 || $numsd24 !=0 || $numsd25 !=0 || $numsd26 !=0 || $numsd27 !=0 || $numsd28 !=0 || $numsd29 !=0 || $numsd40 !=0){
			?>
            <tr bgcolor="#9999FF">
              <td colspan="8"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo strtoupper ($res21username);?></strong></td>
              </tr>
				
				
<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Date </strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill No </strong></td>
              <td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash </strong></td>
              <td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Card </strong></td>
              <td width="12%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Cheque </strong></td>
				<td  width="12%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>
				<td  width="12%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Mpesa</strong></td>
				<td width="5%"  align="right" valign="center" bgcolor="#e0e0e0">&nbsp;</td>
				<td width="16%"  align="right" valign="center" bgcolor="#e0e0e0">&nbsp;</td>

			  
			  
			
			  
			  <?php 
			/*$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];*/
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalcashamount1 = '0.00';
			$totalcardamount1 = '0.00';
			$totalchequeamount1 = '0.00';
			$totalonlineamount1 = '0.00';
			$totalcreditamount1 = '0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query2 = "select * from master_transactionpaynow where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	        while($res2 = mysql_fetch_array($exec2))
			{
			$res2billnumber = $res2['billnumber'];
			$res2transactiondate = $res2['transactiondate'];
			
			$query3 = "select * from master_transactionpaynow where locationcode='$locationcode1' and billnumber = '$res2billnumber'";
			$exec3 = mysql_query($query3) or die ("Error in Query3" .mysql_error());
			$res3 = mysql_fetch_array($exec3);
			$res3cashamount1 = $res3['cashamount'];
			$res3cardamount1 = $res3['cardamount'];
			$res3creditamount1 = $res3['creditamount'];
			$res3chequeamount1 = $res3['chequeamount'];
			$res3onlineamount1 = $res3['onlineamount'];
			$res3transactionamount = $res3['transactionamount'];
			
			$totalcashamount1 = $totalcashamount1 + $res3cashamount1;
			$totalcardamount1 = $totalcardamount1 + $res3cardamount1;
			$totalchequeamount1 = $totalchequeamount1 + $res3chequeamount1;
			$totalonlineamount1 = $totalonlineamount1 + $res3onlineamount1;  
			$totalcreditamount1 = $totalcreditamount1 + $res3creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		if($res3transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res3cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res3cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res3chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res3onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res3creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center" bgcolor="#e0e0e0" align="right">&nbsp;</td>
				<td class="bodytext31" valign="center" bgcolor="#e0e0e0" align="right">&nbsp;</td>
              </tr>
			<?php
			}
			}
			?>
			  
			  <?php 
			/*$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount2 = '0.00';
			$totalcardamount2 = '0.00';
			$totalchequeamount2 = '0.00';
			$totalonlineamount2 ='0.00';
			$totalcreditamount2 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query23 = "select * from master_billing where locationcode='$locationcode1' and username = '$res21username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
	        while($res23 = mysql_fetch_array($exec23))
			{
			$res23billnumber = $res23['billnumber'];
			$res23billingdatetime = $res23['billingdatetime'];
			
			$query33 = "select * from master_billing where locationcode='$locationcode1' and billnumber = '$res23billnumber'";
			$exec33 = mysql_query($query33) or die ("Error in Query33" .mysql_error());
			$res33 = mysql_fetch_array($exec33);
			$res33cashamount1 = $res33['cashamount'];
			$res33cardamount1 = $res33['cardamount'];
			$res33creditamount1 = $res33['creditamount'];
			$res33chequeamount1 = $res33['chequeamount'];
			$res33onlineamount1 = $res33['onlineamount']; 
			$res33transactionamount = $res33['totalamount'];
			
			$totalcashamount2 = $totalcashamount2 + $res33cashamount1;
			$totalcardamount2 = $totalcardamount2 + $res33cardamount1;
			$totalchequeamount2 = $totalchequeamount2 + $res33chequeamount1;
			$totalonlineamount2 = $totalonlineamount2 + $res33onlineamount1; 
			$totalcreditamount2 = $totalcreditamount2 + $res33creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res33transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res23billingdatetime; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res23billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res33cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res33cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res33chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res33onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res33creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0" align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0" align="right">&nbsp;</td>
              </tr>
			  
			<?php
			 }	
			 }
			?>
			
			 <?php 
			/*$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount3 = '0.00';
			$totalcardamount3 = '0.00';
			$totalchequeamount3 = '0.00';
			$totalonlineamount3 ='0.00';
			$totalcreditamount3 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query24 = "select * from master_transactionexternal where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
	        while($res24 = mysql_fetch_array($exec24))
			{
			$res24billnumber = $res24['billnumber'];
			$res24transactiondate = $res24['transactiondate'];
			
			$query34 = "select * from master_transactionexternal where locationcode='$locationcode1' and billnumber = '$res24billnumber'";
			$exec34 = mysql_query($query34) or die ("Error in Query34" .mysql_error());
			$res34 = mysql_fetch_array($exec34);
			$res34cashamount1 = $res34['cashamount'];
			$res34cardamount1 = $res34['cardamount'];
			$res34creditamount1 = $res34['creditamount'];
			$res34chequeamount1 = $res34['chequeamount'];
			$res34onlineamount1 = $res34['onlineamount']; 
			$res34transactionamount = $res34['transactionamount'];
			
			$totalcashamount3 = $totalcashamount3 + $res34cashamount1;
			$totalcardamount3 = $totalcardamount3 + $res34cardamount1; 
			$totalchequeamount3 = $totalchequeamount3 + $res34chequeamount1;
			$totalonlineamount3 = $totalonlineamount3 + $res34onlineamount1; 
			$totalcreditamount3 = $totalcreditamount3 + $res34creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res34transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res24transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res24billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res34cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res34cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res34chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res34onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res34creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			
			<?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount4 = '0.00';
			$totalcardamount4 = '0.00';
			$totalchequeamount4 = '0.00';
			$totalonlineamount4 ='0.00';
			$totalcreditamount4 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query25 = "select * from refund_paynow where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
	        while($res25 = mysql_fetch_array($exec25))
			{
			$res25billnumber = $res25['billnumber'];
			$res25transactiondate = $res25['transactiondate'];
			
			$query35 = "select * from refund_paynow where locationcode='$locationcode1' and billnumber = '$res25billnumber'";
			$exec35 = mysql_query($query35) or die ("Error in Query35" .mysql_error());
			$res35 = mysql_fetch_array($exec35);
			$res35cashamount1 = $res35['cashamount'];
			$res35cardamount1 = $res35['cardamount'];
			$res35creditamount1 = $res35['creditamount'];
			$res35chequeamount1 = $res35['chequeamount'];
			$res35onlineamount1 = $res35['onlineamount'];
			$res35transactionamount = $res35['transactionamount'];
			
			$totalcashamount4 = $totalcashamount4 + $res35cashamount1;
			$totalcardamount4 = $totalcardamount4 + $res35cardamount1;
			$totalchequeamount4 = $totalchequeamount4 + $res35chequeamount1;
			$totalonlineamount4 = $totalonlineamount4 + $res35onlineamount1;
			$totalcreditamount4 = $totalcreditamount4 + $res35creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res35transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res25transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res25billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format(- $res35cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format(- $res35cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format(- $res35chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"   bgcolor="#e0e0e0" align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"   bgcolor="#e0e0e0" align="right">&nbsp;</td>
              </tr>
			<?php
			 }	
			 }
			?>
			 <?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount5 = '0.00';
			$totalcardamount5 = '0.00';
			$totalchequeamount5 = '0.00';
			$totalonlineamount5 ='0.00';
			$totalcreditamount5 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query26 = "select * from master_transactionadvancedeposit where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec26 = mysql_query($query26) or die ("Error in Query24".mysql_error());
	        while($res26 = mysql_fetch_array($exec26))
			{
			$res26billnumber = $res26['docno'];
			$res26transactiondate = $res26['transactiondate'];
			
			$query36 = "select * from master_transactionadvancedeposit where locationcode='$locationcode1' and docno = '$res26billnumber'";
			$exec36 = mysql_query($query36) or die ("Error in Query34" .mysql_error());
			$res36 = mysql_fetch_array($exec36);
			$res36cashamount1 = $res36['cashamount'];
			$res36cardamount1 = $res36['cardamount'];
			$res36creditamount1 = $res36['creditamount'];
			$res36chequeamount1 = $res36['chequeamount'];
			$res36onlineamount1 = $res36['onlineamount']; 
			$res36transactionamount = $res36['transactionamount'];
			
			$totalcashamount5 = $totalcashamount5 + $res36cashamount1;
			$totalcardamount5 = $totalcardamount5 + $res36cardamount1; 
			$totalchequeamount5 = $totalchequeamount5 + $res36chequeamount1;
			$totalonlineamount5 = $totalonlineamount5 + $res36onlineamount1; 
			$totalcreditamount5 = $totalcreditamount5 + $res36creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res36transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res26transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res26billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res36cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res36cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res36chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res36onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res36creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount6 = '0.00';
			$totalcardamount6 = '0.00';
			$totalchequeamount6 = '0.00';
			$totalonlineamount6 ='0.00';
			$totalcreditamount6 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query27 = "select * from master_transactionipdeposit where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec27 = mysql_query($query27) or die ("Error in Query24".mysql_error());
	        while($res27 = mysql_fetch_array($exec27))
			{
			$res27billnumber = $res27['docno'];
			$res27transactiondate = $res27['transactiondate'];
			
			$query37 = "select * from master_transactionipdeposit where locationcode='$locationcode1' and docno = '$res27billnumber' and docno <> ''";
			$exec37 = mysql_query($query37) or die ("Error in Query34" .mysql_error());
			while($res37 = mysql_fetch_array($exec37)){
			$res37cashamount1 = $res37['cashamount'];
			$res37cardamount1 = $res37['cardamount'];
			$res37creditamount1 = $res37['creditamount'];
			$res37chequeamount1 = $res37['chequeamount'];
			$res37onlineamount1 = $res37['onlineamount']; 
			$res37transactionamount = $res37['transactionamount'];
			
			$totalcashamount6 = $totalcashamount6 + $res37cashamount1;
			$totalcardamount6 = $totalcardamount6 + $res37cardamount1; 
			$totalchequeamount6 = $totalchequeamount6 + $res37chequeamount1;
			$totalonlineamount6 = $totalonlineamount6 + $res37onlineamount1; 
			$totalcreditamount6 = $totalcreditamount6 + $res37creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res37transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res27transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res27billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res37cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res37cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res37chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res37onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res37creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			 }
			?>
			<?php 
		/*	//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount7 = '0.00';
			$totalcardamount7 = '0.00';
			$totalchequeamount7 = '0.00';
			$totalonlineamount7 ='0.00';
			$totalcreditamount7 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query28 = "select * from master_transactionip where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec28 = mysql_query($query28) or die ("Error in Query24".mysql_error());
	        while($res28 = mysql_fetch_array($exec28))
			{
			$res28billnumber = $res28['billnumber'];
			$res28transactiondate = $res28['transactiondate'];
			
			$query38 = "select * from master_transactionip where locationcode='$locationcode1' and billnumber = '$res28billnumber'";
			$exec38 = mysql_query($query38) or die ("Error in Query34" .mysql_error());
			$res38 = mysql_fetch_array($exec38);
			$res38cashamount1 = $res38['cashamount'];
			$res38cardamount1 = $res38['cardamount'];
			$res38creditamount1 = $res38['mpesaamount'];
			$res38chequeamount1 = $res38['chequeamount'];
			$res38onlineamount1 = $res38['onlineamount']; 
			$res38transactionamount = $res38['transactionamount'];
			$res38returnbalance = $res38['returnbalance'];
			$res38cashamount1 = $res38cashamount1 + $res38returnbalance;
			
			$totalcashamount7 = $totalcashamount7 + $res38cashamount1;
			$totalcardamount7 = $totalcardamount7 + $res38cardamount1; 
			$totalchequeamount7 = $totalchequeamount7 + $res38chequeamount1;
			$totalonlineamount7 = $totalonlineamount7 + $res38onlineamount1; 
			$totalcreditamount7 = $totalcreditamount7 + $res38creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res38transactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res28transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res28billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res38cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res38cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res38chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
		/*	//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount7ar = '0.00';
			$totalcardamount7ar = '0.00';
			$totalchequeamount7ar = '0.00';
			$totalonlineamount7ar ='0.00';
			$totalcreditamount7ar ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query28ar = "select * from master_transactionpaylater where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionstatus = 'onaccount' order by username desc";
			$exec28ar = mysql_query($query28ar) or die ("Error in Query24".mysql_error());
	        while($res28ar = mysql_fetch_array($exec28ar))
			{
			$res28arbillnumber = $res28ar['docno'];
			$res28artransactiondate = $res28ar['transactiondate'];
			
			$query38ar = "select * from master_transactionpaylater where docno = '$res28arbillnumber' and transactionstatus = 'onaccount'";
			$exec38ar = mysql_query($query38ar) or die ("Error in Query34" .mysql_error());
			$res38ar = mysql_fetch_array($exec38ar);
			$res38arcashamount1 = $res38ar['cashamount'];
			$res38arcardamount1 = $res38ar['cardamount'];
			$res38arcreditamount1 = $res38ar['mpesaamount'];
			$res38archequeamount1 = $res38ar['chequeamount'];
			$res38aronlineamount1 = $res38ar['onlineamount']; 
			$res38artransactionamount = $res38ar['transactionamount'];
			
			$totalcashamount7ar = $totalcashamount7ar + $res38arcashamount1;
			$totalcardamount7ar = $totalcardamount7ar + $res38arcardamount1; 
			$totalchequeamount7ar = $totalchequeamount7ar + $res38archequeamount1;
			$totalonlineamount7ar = $totalonlineamount7ar + $res38aronlineamount1; 
			$totalcreditamount7ar = $totalcreditamount7ar + $res38arcreditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res38artransactionamount != '0.00')
		{
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
                <div class="bodytext31"><?php echo $res28artransactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res28arbillnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res38arcashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res38arcardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res38archequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38aronlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38arcreditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
		/*	//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount8 = '0.00';
			$totalcardamount8 = '0.00';
			$totalchequeamount8 = '0.00';
			$totalonlineamount8 ='0.00';
			$totalcreditamount8 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query29 = "select * from master_transactionipcreditapproved where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec29 = mysql_query($query29) or die ("Error in Query24".mysql_error());
	        while($res29 = mysql_fetch_array($exec29))
			{
			$res29billnumber = $res29['billnumber'];
			$res29transactiondate = $res29['transactiondate'];
			$res2postingaccount = $res29['postingaccount'];
			
			$query39 = "select * from master_transactionipcreditapproved where locationcode='$locationcode1' and billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";
			$exec39 = mysql_query($query39) or die ("Error in Query34" .mysql_error());
			$res39 = mysql_fetch_array($exec39);
			$res39cashamount1 = $res39['cashamount'];
			$res39cardamount1 = $res39['cardamount'];
			$res39creditamount1 = $res39['creditamount'];
			$res39chequeamount1 = $res39['chequeamount'];
			$res39onlineamount1 = $res39['onlineamount']; 
			$res39transactionamount = $res39['transactionamount'];
			
			$totalcashamount8 = $totalcashamount8 + $res39cashamount1;
			$totalcardamount8 = $totalcardamount8 + $res39cardamount1; 
			$totalchequeamount8 = $totalchequeamount8 + $res39chequeamount1;
			$totalonlineamount8 = $totalonlineamount8 + $res39onlineamount1;
			$totalcreditamount8 = $totalcreditamount8 + $res39creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res39cashamount1 != '0.00')||($res39cardamount1 != '0.00')||($res39chequeamount1 != '0.00')||($res39onlineamount1 != '0.00'))
		{
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
                <div class="bodytext31"><?php echo $res29transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res29billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res39cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res39cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res39chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res39onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res39creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount9 = '0.00';
			$totalcardamount9 = '0.00';
			$totalchequeamount9 = '0.00';
			$totalonlineamount9 ='0.00';
			$totalcreditamount9 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query40 = "select * from receiptsub_details where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exec40 = mysql_query($query40) or die ("Error in Query40".mysql_error());
	        while($res40 = mysql_fetch_array($exec40))
			{
			$res40billnumber = $res40['docnumber'];
			$res40transactiondate = $res40['transactiondate'];
			//$res40postingaccount = $res40['postingaccount'];
			
			/*$query39 = "select * from receiptsub_details where billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";
			$exec39 = mysql_query($query39) or die ("Error in Query34" .mysql_error());
			$res39 = mysql_fetch_array($exec39);*/
			$res40cashamount1 = $res40['cashamount'];
			$res40cardamount1 = $res40['cardamount'];
			$res40creditamount1 = $res40['creditamount'];
			$res40chequeamount1 = $res40['chequeamount'];
			$res40onlineamount1 = $res40['onlineamount']; 
			$res40transactionamount = $res40['transactionamount'];
			
			$totalcashamount9 = $totalcashamount9 + $res40cashamount1;
			$totalcardamount9 = $totalcardamount9 + $res40cardamount1; 
			$totalchequeamount9 = $totalchequeamount9 + $res40chequeamount1;
			$totalonlineamount9 = $totalonlineamount9 + $res40onlineamount1; 
			$totalcreditamount9 = $totalcreditamount9 + $res40creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res40cashamount1 != '0.00')||($res40cardamount1 != '0.00')||($res40chequeamount1 != '0.00')||($res40onlineamount1 != '0.00')||($res40creditamount1 != '0.00'))
		{
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
                <div class="bodytext31"><?php echo $res40transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res40billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res40cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res40cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res40chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php
			$totalcashamount92 = '0.00';
			$totalcardamount92 = '0.00';
			$totalchequeamount92 = '0.00';
			$totalonlineamount92 ='0.00';
			$totalcreditamount92 ='0.00';
			
			$query402 = "select * from deposit_refund where locationcode='$locationcode1' and username = '$res21username' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec402 = mysql_query($query402) or die ("Error in Query402".mysql_error());
	        while($res402 = mysql_fetch_array($exec402))
			{
			$res402billnumber = $res402['docno'];
			$res402transactiondate = $res402['recorddate'];
			//$res402postingaccount = $res402['postingaccount'];
			
			/*$query392 = "select * from receiptsub_details where billnumber = '$res292billnumber' and postingaccount = '$res2postingaccount'";
			$exec392 = mysql_query($query392) or die ("Error in Query34" .mysql_error());
			$res392 = mysql_fetch_array($exec392);*/
			$res402cashamount1 = $res402['cashamount'];
			$res402cardamount1 = $res402['cardamount'];
			$res402creditamount1 = $res402['creditamount'];
			$res402chequeamount1 = $res402['chequeamount'];
			$res402onlineamount1 = $res402['onlineamount']; 
			$res402transactionamount = $res402['amount'];
			
			$totalcashamount92 = $totalcashamount92 + $res402cashamount1;
			$totalcardamount92 = $totalcardamount92 + $res402cardamount1; 
			$totalchequeamount92 = $totalchequeamount92 + $res402chequeamount1;
			$totalonlineamount92 = $totalonlineamount92 + $res402onlineamount1; 
			$totalcreditamount92 = $totalcreditamount92 + $res402creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res402cashamount1 != '0.00')||($res402cardamount1 != '0.00')||($res402chequeamount1 != '0.00')||($res402onlineamount1 != '0.00'))
		{
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
                <div class="bodytext31"><?php echo $res402transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res402billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format(-$res402cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format(-$res402cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format(-$res402chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(-$res402onlineamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(-$res402creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#e0e0e0"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php
			$totalcashamount = $totalcashamount1 + $totalcashamount2 + $totalcashamount3 - $totalcashamount4 + $totalcashamount5 + $totalcashamount6 + $totalcashamount7 + $totalcashamount8 + $totalcashamount9 - $totalcashamount92 + $totalcashamount7ar;
			$totalcardamount = $totalcardamount1 + $totalcardamount2 + $totalcardamount3 - $totalcardamount4 + $totalcardamount5 + $totalcardamount6 + $totalcardamount7 + $totalcardamount8 + $totalcardamount9 - $totalcardamount92 + $totalcardamount7ar;
			$totalchequeamount = $totalchequeamount1 + $totalchequeamount2 + $totalchequeamount3 - $totalchequeamount4 + $totalchequeamount5 + $totalchequeamount6 + $totalchequeamount7 + $totalchequeamount8 + $totalchequeamount9 - $totalchequeamount92 + $totalchequeamount7ar;
			$totalonlineamount = $totalonlineamount1 + $totalonlineamount2 +$totalonlineamount3 - $totalonlineamount4 + $totalonlineamount5 + $totalonlineamount6 + $totalonlineamount7 + $totalonlineamount8 + $totalonlineamount9 - $totalonlineamount92 + $totalonlineamount7ar; 
			$totalcreditamount = $totalcreditamount1 + $totalcreditamount2 +$totalcreditamount3 - $totalcreditamount4 + $totalcreditamount5 + $totalcreditamount6 + $totalcreditamount7 + $totalcreditamount8 + $totalcreditamount9 - $totalcreditamount92 + $totalcreditamount7ar; 
			$netcashamount = $netcashamount + $totalcashamount;
			$netcardamount = $netcardamount + $totalcardamount;
			$netchequeamount = $netchequeamount + $totalchequeamount;
			$netonlineamount = $netonlineamount + $totalonlineamount;
			$netcreditamount = $netcreditamount + $totalcreditamount;
			$grandtotal = $totalcashamount + $totalcardamount + $totalchequeamount + $totalonlineamount + $totalcreditamount; 
			$nettotal = $nettotal + $grandtotal;
			
			if(($totalcashamount != '0.00')||($totalcardamount != '0.00')||($totalchequeamount != '0.00')||($totalonlineamount != '0.00'))
			{
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($totalcashamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($totalcardamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><?php echo number_format($totalchequeamount,2,'.',','); ?></td>
				<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><?php echo number_format($totalonlineamount,2,'.',',');?></td>
				<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><?php echo number_format($totalcreditamount,2,'.',',');?></td>
				<td  align="right" valign="center" 
                bgcolor="#e0e0e0" class="bodytext31"><a target="_blank" href="print_daybookreport.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $res21username; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
				<td><a href="print_daybookreportxl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
			 </tr>
			  
			  
			 <!-- <tr>
			    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Grand Total:</strong></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netcashamount,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netcardamount,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netchequeamount,2,'.',','); ?></td>
			    <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php echo number_format($netonlineamount,2,'.',',');?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                 bgcolor="#e0e0e0">&nbsp;</td>
			    </tr>-->
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			
              <td colspan="2" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total for Payment Modes :</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff" style="mso-number-format:'\@'"><?php echo number_format($grandtotal,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php //echo number_format($totalcardamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php //echo number_format($totalchequeamount,2,'.',','); ?></td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php //echo number_format($totalonlineamount,2,'.',',');?></td>
				</tr>
			  <?php 
			  }
			  }
			  	}		  
						  }}
			  ?>
			  <tr>
			    <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
			    </tr>
			  <tr>
	    <td colspan="3" class="bodytext31" valign="center"  align="right"><strong>Grand Total :</strong> </td>
		<td class="bodytext31" valign="center"  align="right"><?php echo number_format($nettotal,2,'.',','); ?></td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
	  </tr>	 
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

