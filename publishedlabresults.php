<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$res21itemname='';
$res21itemcode='';
$docnumber1 = '';
//This include updatation takes too long to load for hunge items database.

if (isset($_REQUEST["rowcount"])) { echo $rowcount = $_REQUEST["rowcount"]; } else { $rowcount = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
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

function cbsuppliername1()
{
	document.cbform1.submit();
}



</script>
<script type="text/javascript">


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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

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
.style1 {font-weight: bold}
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
		
		
              <form name="cbform1" method="post" action="publishedlabresults.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Published Lab Results </strong></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			      <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc Number</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="publishedlabresults.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$docnumber=$_POST['docnumber'];
	/*}
	else
	{
	$searchpatient = '';
	$searchpatientcode= '';
	$searchvisitcode='';
	$docnumber='';
	$fromdate=$transactiondatefrom;
	$todate=$transactiondateto;*/

	
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

$querynw1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and resultstatus='completed' and publishstatus = 'completed' group by docnumber order by auto_number desc";
		$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
		$resnw1=mysql_num_rows($execnw1);
			
$queryn21 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientname like '%$searchpatient%' and patientcode = 'walkin' and patientvisitcode = 'walkinvis' and recorddate between '$fromdate' and '$todate' and resultstatus='completed' and publishstatus = '' group by docnumber order by auto_number desc";
		$execn21 = mysql_query($queryn21) or die ("Error in Query21".mysql_error());
		$numn21=mysql_num_rows($execn21);
		$resnw1 = $numn21 + $resnw1;
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1191" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="12" bgcolor="#cccccc" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Published Lab Results </strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
			 </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="7%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Print</strong></td>

								 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Date </strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>
              <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				  <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Doc No</strong></div></td>
             
                <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Test Name</strong></div></td>
                <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Time</strong></div></td>
               <!-- <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Publish DateTimg</strong></div></td>-->
				 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Ordered By</strong></td>

             <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
				
              </tr>
           <?php
		$query1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and resultstatus='completed' and publishstatus = 'completed' group by docnumber order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemname='';
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['patientvisitcode'];
		$consultationdate=$res1['recorddate'];
	   $docnumber=$res1['docnumber'];
	   
	   $query11="select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and resultstatus='completed' and publishstatus = 'completed' group by itemcode ";
				  $exec11=mysql_query($query11) or die(mysql_error());
				  $num11=mysql_num_rows($exec11);
	   
	    while($res11=mysql_fetch_array($exec11))
				  {
				  $itemname='';
				 $item=$res11['itemname'];
				   if($num11 == '1') {
				 $itemname=$item;    }
				 else {
				 $itemname=$item.', '. $itemname;
				      }
					  $itemcode = $res11['itemcode'];
				}
				
				$query23 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcode'";
				$exec23 = mysql_query($query23) or die(mysql_error());
				$res23 = mysql_fetch_array($exec23);
				$requestedby = $res23['username'];
				$sampledatetime = $res23['sampledatetime'];
				$publishdatetime = $res23['publishdatetime'];
				
				$query24 = "select * from master_employee where username = '$requestedby'";
				$exec24 = mysql_query($query24) or die(mysql_error());
				$res24 = mysql_fetch_array($exec24);
				$requestedbyname = $res24['employeename'];
		
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
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="center"><a target="_blank" href="printlabresults.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>"><strong>Print</strong></a></td>

			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docnumber; ?></div></td>
				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 
             <td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?>
			    <div align="center">
			   </div></td>
               <td class="bodytext31" valign="center"  align="center"><?php 
			   
			   
			     $datetemp=strtotime($publishdatetime)-strtotime($sampledatetime);echo  /*number_format($datetemp/60,2,'.',',')*/ round($datetemp/60); ?>
			    </td>
              <?php /*?> <td class="bodytext31" valign="center"  align="center"><?php echo $publishdatetime; ?>
			    </td><?php */?>
                   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $requestedbyname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><a href="labresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>"><strong>View</strong></a></td>
            
			  </tr>
		   <?php 
		   } 
		  
		   ?>
		   
		   <?php
		$query21 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientname like '%$searchpatient%' and patientcode = 'walkin' and patientvisitcode = 'walkinvis' and recorddate between '$fromdate' and '$todate' and resultstatus='completed' group by docnumber order by auto_number desc";
		$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		$num21=mysql_num_rows($exec21);
		
		while($res21 = mysql_fetch_array($exec21))
		{
		$res21patientname=$res21['patientname'];
		$res21consultationdate=$res21['recorddate'];
	    $res21docnumber=$res21['docnumber'];
	   
	   $query22="select * from resultentry_lab where patientcode like '%walkin%' and patientvisitcode like '%walkinvis%' and  patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber = '$res21docnumber' and resultstatus='completed' and publishstatus = '' group by itemcode ";
				  $exec22=mysql_query($query22) or die(mysql_error());
				  $num22=mysql_num_rows($exec22);
	   
	              while($res22=mysql_fetch_array($exec22))
				  {
				 $res21itemname='';
				 $res21item=$res22['itemname'];
				   if($num22 == '1') {
				 $res21itemname=$res21item;    }
				 else {
				 $res21itemname=$res21item.', '. $res21itemname;
				      }
					  $res21itemcode = $res22['itemcode'];
				  }
				
				$query23 = "select * from consultation_lab where patientcode='%walkin%' and resultdoc = '$res21docnumber' and patientvisitcode='%walkinvis%' and labitemcode='$res21itemcode'";
				$exec23 = mysql_query($query23) or die(mysql_error());
				$res23 = mysql_fetch_array($exec23);
				$res23requestedby = $res23['username'];
				
				$query24 = "select * from master_employee where username = '$res23requestedby'";
				$exec24 = mysql_query($query24) or die(mysql_error());
				$res24 = mysql_fetch_array($exec24);
				$res24requestedbyname = $res24['employeename'];
		
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
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="center"><a target="_blank" href="printlabresults.php?patientcode=walkin&&visitcode=walkinvis&&docnumber=<?php echo $res21docnumber; ?>"><strong>Print</strong></a></td>

			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res21consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo 'walkin'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo 'walkinvis'; ?></div></td>
				<input type="hidden" name="visitcode1[]" id="visitcode" value="<?php echo 'walkinvis'; ?>">
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $res21patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res21docnumber; ?></div></td>
				<input type="hidden" name="docnumber1[]" value="<?php echo $res21docnumber; ?>"> 
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21itemname; ?>
			    <div align="center">
			   </div></td>
                   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res24requestedbyname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><a href="labresultsview.php?patientcode=walkin&&visitcode=walkinvis&&docnumber=<?php echo $res21docnumber; ?>"><strong>View</strong></a></td>
            
			  </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			             
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>

      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
               

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
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
      <?php }?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

