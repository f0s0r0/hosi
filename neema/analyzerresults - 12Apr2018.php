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

//This include updatation takes too long to load for hunge items database.


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
//if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

foreach($_POST['docnumber'] as $key => $value)
{
$docno = $_POST['docnumber'][$key];
$visitcode = $_POST['visitcode'][$key];
foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $docno)
		{
		 $paynowbillprefix = 'LRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from resultentry_lab order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='LRE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'LRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$docnumber=$billnumbercode;
		 
		 $qrylabs = "select * from pending_test_orders where sample_id = '$docno' and visitcode = '$visitcode' and result <> '' AND publishstatus <>'completed' group by testcode";
		 $execlabs = mysql_query($qrylabs) or die(mysql_error());
		while($reslabs = mysql_fetch_array($execlabs))
		{
		$labcode = $reslabs['testcode'];
		$labname = $reslabs['testname'];
		$patienttype = $reslabs['patient_from'];
		$patientname= $reslabs['patientname'];
		$patientcode = $reslabs['patientcode'];
		$sampleid = $reslabs['sample_id'];
		$qryacc = "select accountfullname from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execacc = mysql_query($qryacc) or die(mysql_error());
		$resacc = mysql_fetch_array($execacc);
		$accountname = $resacc['accountfullname'];
		if(strtolower($patienttype)=='out-patient')
		{
		$qryacc = "select accountfullname from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execacc = mysql_query($qryacc) or die(mysql_error());
		$resacc = mysql_fetch_array($execacc);
		$accountname = $resacc['accountfullname'];
		$query612 = "select * from consultation_lab where patientvisitcode = '$visitcode' and labitemcode = '$labcode' order by auto_number desc";
		$exec612 = mysql_query($query612) or die(mysql_error());
		$res612 = mysql_fetch_array($exec612);
		$orderedby = $res612['username'];
		$locationcodeget = $res612['locationcode'];
 		$locationnameget = $res612['locationname'];
		$query24 = "select * from master_employee where username = '$orderedby'";
		$exec24 = mysql_query($query24) or die(mysql_error());
		$res24 = mysql_fetch_array($exec24);
		$orderedbyname = $res24['employeename'];
			$qryresult = "select result,date(resultdatetime) as recorddate, time(resultdatetime) as recordtime,parametername,parametercode,referenceunit,referencerange from pending_test_orders as a join master_labreference as  b  on( a.testcode = b.itemcode and a.parametercode = b.referencename) where a.patientcode ='$patientcode' and a.visitcode = '$visitcode' and a.result <> '' and b.status <> 'deleted' and  a.testcode ='$labcode' and a.sample_id = '$docno'";
		$execresult = mysql_query($qryresult) or die(mysql_error());
		while($resresults = mysql_fetch_array($execresult))
		{
		$resultvalue = $resresults['result'];
		$referencevalue = $resresults['referencerange'];
		$dateonly = $resresults['recorddate'];
		$timeonly = $resresults['recordtime'];
		$refname = $resresults['parametercode'];
		$unit = $resresults['referenceunit'];
		$query26="insert into resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname,locationname,locationcode)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$labcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','','$username','$sampleid','$orderedbyname','".$locationnameget."','".$locationcodeget."')";
   $exec26=mysql_query($query26) or die(mysql_error());
   $status1='completed';
   
   $query76 = "update samplecollection_lab set resultentry='completed' where itemcode='$labcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'";
 $exec76 = mysql_query($query76) or die(mysql_error());
 
 $query77 = "update resultentry_lab set resultstatus='completed' where docnumber='$docnumber'";
 $exec77 = mysql_query($query77) or die(mysql_error());
 
 $query29=mysql_query("update consultation_lab set resultentry='$status1',resultdoc='$docnumber' where labitemcode='$labcode' and patientvisitcode='$visitcode' and docnumber='$sampleid'") or die(mysql_error());
 
    $query76 = "update master_consultation set results='completed',username='$orderedbyname',closevisit='' where patientvisitcode='$visitcode'";
   $exec76 = mysql_query($query76) or die(mysql_error());
   
   $query44 = "update consultation_lab set publishstatus='completed',publishdatetime='".date('Y-m-d h:i:s')."' where resultdoc='$docnumber'";
		$exec44 = mysql_query($query44) or die(mysql_error());

   		$query43 = "update resultentry_lab set publishstatus='completed',publishdatetime='".date('Y-m-d h:i:s')."' where docnumber='$docnumber'";
		$exec43 = mysql_query($query43) or die(mysql_error());
		
		$query43 = "update pending_test_orders set publishstatus='completed',publishdatetime='".date('Y-m-d h:i:s')."' where sample_id='$docno' and testcode='$labcode' and visitcode='$visitcode' and result<>'' and publishstatus=''";
		$exec43 = mysql_query($query43) or die(mysql_error());
	
		}
	
		}
		else
		{
		$qryacc = "select accountfullname from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execacc = mysql_query($qryacc) or die(mysql_error());
		$resacc = mysql_fetch_array($execacc);
		$accountname = $resacc['accountfullname'];
		$query612 = "select * from ipconsultation_lab where patientvisitcode = '$visitcode' order by auto_number desc";
		$exec612 = mysql_query($query612) or die(mysql_error());
		$res612 = mysql_fetch_array($exec612);
		$orderedby = $res612['username'];
		$locationcodeget = $res612['locationcode'];
 		$locationnameget = $res612['locationname'];

		$query24 = "select * from master_employee where username = '$orderedby'";
		$exec24 = mysql_query($query24) or die(mysql_error());
		$res24 = mysql_fetch_array($exec24);
		$orderedbyname = $res24['employeename'];
			$qryresult = "select result,date(resultdatetime) as recorddate, time(resultdatetime) as recordtime,parametername,parametercode,referenceunit,referencerange from pending_test_orders as a join master_labreference as  b  on( a.testcode = b.itemcode and a.parametername = b.referencename) where a.patientcode = '$patientcode' and a.visitcode = '$visitcode' and a.result <> '' and b.status <> 'deleted' and a.testcode ='$labcode' and a.sample_id = '$docno'";
		$execresult = mysql_query($qryresult) or die(mysql_error());
		while($resresults = mysql_fetch_array($execresult))
		{
		$resultvalue = $resresults['result'];
		$referencevalue = $resresults['referencerange'];
		$dateonly = $resresults['recorddate'];
		$timeonly = $resresults['recordtime'];
		$refname = $resresults['parametercode'];
		$unit = $resresults['referenceunit'];
		$query26="insert into ipresultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,locationcode,locationname)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$labcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$locationcodeget','$locationnameget')";
   $exec26=mysql_query($query26) or die(mysql_error());
   $status1='completed';
   $query29=mysql_query("update ipconsultation_lab set resultentry='$status1' where labitemcode='$labcode' and patientvisitcode='$visitcode' and docnumber='$docno'");
   
   $query43 = "update pending_test_orders set publishstatus='completed',publishdatetime='".date('Y-m-d h:i:s')."' where sample_id = '$docno' and testcode='$labcode' and visitcode='$visitcode' and result<>'' and publishstatus=''";
   $exec43 = mysql_query($query43) or die('this is ip 43'.mysql_error());
   	}
			
		}
		}

		 

   
  	}
		}
		}
		header("location:analyzerresults.php");
}

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

function pendingfunc(visitcode)
{
var varvisitcode = visitcode;
window.open("pendinglabs.php?visitcode="+varvisitcode+"","OriginalWindowA5",'width=500,height=400,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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
text-align:center;
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
		
		
              <form name="cbform1" method="post" action="analyzerresults.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Lab Results View </strong></td>
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
              <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
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
	<form name="form1" id="form1" method="post" action="analyzerresults.php">	
		
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

$querynw1 = "select * from pending_test_orders where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and patientcode <> 'walkin' and date(resultdatetime) between '$fromdate' and '$todate' and sample_id like '%$docnumber%' and publishstatus = '' group by sample_id order by auto_number desc";

			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
			
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="930" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="13" bgcolor="#cccccc" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Lab Results View</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
			 </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
								 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Date </strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				  <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pending</strong></div></td>
             
                <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Test Name</strong></div></td>
                
				 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Ordered By</strong></td>
		

             <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
				 <td width="7%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Select</strong></td>

              </tr>
           <?php
            
		
		$query1 = "select * from pending_test_orders where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and date(resultdatetime) between '$fromdate' and '$todate' and sample_id like '%$docnumber%' and publishstatus = '' group by sample_id order by visitcode";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemname='';
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['resultdatetime'];
	        $docnumber=$res1['sample_id'];
		//$rusername = $res1['username'];
	   
	   $query11="select * from pending_test_orders where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and date(resultdatetime) between '$fromdate' and '$todate' and sample_id like '%$docnumber%' and publishstatus = '' group by testcode ";
				  $exec11=mysql_query($query11) or die(mysql_error());
				  $num11=mysql_num_rows($exec11);
	   
	    while($res11=mysql_fetch_array($exec11))
				  {
				  $itemname='';
				 $item=$res11['testname'];
				   if($num11 == '1') {
				 $itemname=$item;    }
				 else {
				 $itemname=$item.', '. $itemname;
				      }
					  $itemcode = $res11['testcode'];
				}
				
				$query7 = "select a.auto_number from samplecollection_lab as a JOIN consultation_lab as b ON a.patientvisitcode=b.patientvisitcode where a.patientvisitcode='$visitcode'  and a.docnumber=a.docnumber and a.itemcode=b.labitemcode and a.acknowledge = 'completed' and a.status = 'completed' and a.resultentry = '' and b.labrefund = 'norefund' order by a.recorddate desc";
				$exec7 = mysql_query($query7) or die(mysql_error());
				$num43=mysql_num_rows($exec7);
				
				$query23 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcode'";
				$exec23 = mysql_query($query23) or die(mysql_error());
				$res23 = mysql_fetch_array($exec23);
				$num23=mysql_num_rows($exec23);
				if($num23==0)
				{
				$query23 = "select * from ipconsultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcode'";
				$exec23 = mysql_query($query23) or die(mysql_error());
				$res23 = mysql_fetch_array($exec23);
				}
				$requestedby = $res23['username'];
				
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
			              
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center" align="left" onClick="return pendingfunc('<?php echo $visitcode; ?>');">
			    <div align="center" ><input class="bal" type="text" name="pending" id="pending" value="<?php echo $num43; ?>" size="4" readonly  style=" <?php if($num43>0){echo "cursor:pointer";}?>"></div></td>
				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 
             <td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?>
			    <div align="center">
			   </div></td>
                   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $requestedbyname; ?></div></td>
		

              <td class="bodytext31" valign="center"  align="left"><a href="analyzerresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>"><strong>View</strong></a></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="checkbox" name="select[]" id="select" value="<?php echo $docnumber; ?>"></div></td>

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

      <td colspan="2" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
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
	  <td class="bodytext31" valign="center"  align="center" style="padding-left:450px;">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	    <input type="submit" name="submit" value="Publish Results"></td>
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

