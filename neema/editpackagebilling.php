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

$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');


$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}

if(isset($_REQUEST['loadtext'])) { $loadtext = $_REQUEST['loadtext']; } else { $loadtext = ''; }
if($loadtext == 'loadtext')
{
	for($i=0;$i<10;$i++)
	{
		if(isset($_REQUEST['pri'.$i]))
		{
			$pri = $_REQUEST['pri'.$i];
			$private = $_REQUEST['private'.$i];
			
			$query112 = "update privatedoctor_billing set rate = '$private', amount = '$private', username = '$username' where auto_number = '$pri'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			
			$query7 = "update billing_ipprivatedoctor a, privatedoctor_billing b set a.rate = '$private', a.amount = '$private', a.username = '$username' where b.description = a.description and a.patientcode = b.patientcode and a.visitcode = b.visitcode and b.auto_number = '$pri'";
			$exec7 = mysql_query($query7) or die(mysql_error());
		}
	}
	for($j=0;$j<10;$j++)
	{
		if(isset($_REQUEST['res'.$j]))
		{
			$res = $_REQUEST['res'.$j];
			$resident = $_REQUEST['resident'.$j];
			
			$query113 = "update residentdoctor_billing set rate = '$resident', amount = '$resident', username = '$username' where auto_number = '$res'";
			$exec113 = mysql_query($query113) or die(mysql_error());
		}
	}
	
	header("location:packagepatientslist.php");
} 
 
$query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
while ($res1111 = mysql_fetch_array($exec1111))
{
$locationnumber = $res1111["location"];
$query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'delete'";
$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
while ($res1112 = mysql_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
 }
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

if (isset($_REQUEST["anum"])) { $danum = $_REQUEST["anum"]; } else { $danum = ""; }
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if($st == 'pri' && $danum != '')
{
	$query6 = "select description, patientcode, visitcode from privatedoctor_billing where auto_number = '$danum'";
	$exec6 = mysql_query($query6) or die(mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$desc = $res6['description'];
	$patientcode = $res6['patientcode'];
	$visitcode = $res6['visitcode'];
	
	$query7 = "delete from billing_ipprivatedoctor where description = '$desc' and patientcode = '$patientcode' and visitcode = '$visitcode'";
	$exec7 = mysql_query($query7) or die(mysql_error());
	
	$query112 = "delete from privatedoctor_billing where auto_number = '$danum'";
	$exec112 = mysql_query($query112) or die(mysql_error());
	
}
if($st == 'res' && $danum != '')
{
	$query113 = "delete from residentdoctor_billing where auto_number = '$danum'";
	$exec113 = mysql_query($query113) or die(mysql_error());
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

$visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
 $query1 = "select mipv.patientcode,mipv.accountname,mipv.visitcode,mipv.patientfullname,mipp.packagename,mipv.package,mipp.rate,mipv.billtype,mipv.locationcode,mipv.locationname from master_ippackage as mipp  LEFT JOIN master_ipvisitentry as mipv ON mipv.package = mipp.auto_number where visitcode = '".$visitcode."'  AND mipv.visitcode NOT IN (SELECT visitcode FROM billing_ip )  order by patientfullname ";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);

	$res1customercode = $res1['patientcode'];
	$res1patientfullname=$res1['patientfullname'];
	$res1accountname = $res1['accountname'];
	
	$res1visitcode = $res1['visitcode'];
	$res1packagename = $res1['packagename'];
	$res1package = $res1['package'];
	$res1rate = $res1['rate'];
	$res1billtype = $res1['billtype'];
	$locationcode = $res1['locationcode'];
	$locationname = $res1['locationname'];
	
	$query111 = "select * from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
	$res111 = mysql_fetch_array($exec111);
	$res111accountname = $res111['accountname'];

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
function calculateamount()
{//alert("ok");
	var totapack = document.getElementById("totalpackagecost").value;
	//alert(totapack);
	var pvt1=document.getElementById("pvtdoctorrate1").value; //alert(pvt1);
	var pvt2=document.getElementById("pvtdoctorrate2").value; //alert(pvt2);
	var pvt3=document.getElementById("pvtdoctorrate3").value;// alert(pvt3);
	var pvt4=document.getElementById("pvtdoctorrate4").value; //alert(pvt4);
	
	if(pvt1==''){pvt1=0;}
	if(pvt2==''){pvt2=0;}
	if(pvt3==''){pvt3=0;}
	if(pvt4==''){pvt4=0;}
	
	var pvtd1=document.getElementById("hpldoctorrate1").value; //alert(pvtd1);
	var pvtd2=document.getElementById("hpldoctorrate2").value; //alert(pvtd2);
	var pvtd3=document.getElementById("hpldoctorrate3").value;// alert(pvt3);
	var pvtd4=document.getElementById("hpldoctorrate4").value; //alert(pvt4);
	
	if(pvtd1==''){pvtd1=0;}
	if(pvtd2==''){pvtd2=0;}
	if(pvtd3==''){pvtd3=0;}
	if(pvtd4==''){pvtd4=0;}
	
	var pvttotal = parseFloat(pvt1)+parseFloat(pvt2)+parseFloat(pvt3)+parseFloat(pvt4)+parseFloat(pvtd1)+parseFloat(pvtd2)+parseFloat(pvtd3)+parseFloat(pvtd4); //alert(parseFloat(pvttotal));
	
	var newtotal = parseFloat(totapack)-parseFloat(pvttotal);//alert(newtotal);
	
	document.getElementById("availableamount1").value=newtotal.toFixed(2);
	document.getElementById("availableamount").value=newtotal.toFixed(2);
	if(totapack<pvttotal){alert("Doctor's Cost Greater than Available Package"); return false;}
	}
	
function calculateamount1(doc,val)
{}
function funcOnLoadBodyFunctionCall()
{}

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

function DelRes(id)
{	
	var cc = confirm("Are you sure to delete ?");
	if(cc == false) { return false; }
	window.location = "editpackagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&st=res&&anum="+id;	
}

function DelPri(id)
{
	var cc = confirm("Are you sure to delete ?");
	if(cc == false) { return false; }
	window.location = "editpackagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&st=pri&&anum="+id;	
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
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autosuggestpackagedoc.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri.js"></script>

<script type="text/javascript" src="js/autosuggestpackagedoc1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri1.js"></script>

<script type="text/javascript" src="js/autosuggestpackagedoc2.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri2.js"></script>

<script type="text/javascript" src="js/autosuggestpackagedoc3.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri3.js"></script>

<script type="text/javascript" src="js/autocomplete_newcustomerpackage.js"></script>
<script type="text/javascript" src="js/autocustomercodesearchpackage.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
        <td width="800" rowspan="9"><form name="cbform1" method="post" action="editpackagebilling.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong> Package Split Billing - Edit </strong></td>
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<?php echo $res1location; ?>
						<?php
						}
						?>
                   <input type="hidden" name="location" id="location" value="<?php echo $res1locationanum;?>">
						
                  
                  </td>
     
              </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input type="text" name="ptname" id="ptname" disabled value="<?php echo $res1patientfullname;?>">
              </span></td>
              </tr>
			    <tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="regcode" id="regcode" disabled value="<?php echo $res1customercode;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="ipcode" id="ipcode" disabled value="<?php echo $res1visitcode;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Package</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="packg" id="packg" disabled value="<?php echo $res1packagename;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Package Cost</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="costpkg" id="costpkg" disabled value="<?php echo $res1rate;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="account" id="account" disabled value="<?php echo $res111accountname;?>">
              </span></td>
              </tr>
              
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill Type</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="billtype" id="billtype" disabled value="<?php echo $res1billtype;?>">
                <input type="hidden" name="locationcodeget" id="locationcodeget" disabled value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" id="locationnameget" disabled value="<?php echo $locationname;?>">
              </span></td>
              </tr>
			   <!-- <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>-->
			<?php /*?>  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr><?php */?>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			 <!-- <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />-->
                 <!-- <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />--></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
        <td width="481" class="bodytext3" style="font-size: 14px">&nbsp;</td>
      </tr>
      <!--<tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="externalbilling.php" target="_blank" style="text-decoration:none;">External Billing </a></strong></span></td>
      </tr>-->
     <!-- <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="billing_pending_op2.php" target="_blank" style="text-decoration:none;">Credit Patient Billing</a></strong></span></td>
      </tr>-->
     <!-- <tr>
         <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="ipbilling.php" target="_blank" style="text-decoration:none;">Inpatient Billing </a></strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="advancedeposit.php" target="_blank" style="text-decoration:none;">Advance Deposit </a></strong></span></td>
      </tr>
      <tr>
         <td><span class="bodytext32" style="font-size: 14px"><strong><a href="approvedcreditlist.php" target="_blank" style="text-decoration:none;">Approved Credit List </a></strong></span></td>
      </tr>-->
      <!--<tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="consultationrefundlist.php" target="_blank" style="text-decoration:none;">Consultation Refund </a></strong></span></td>
      </tr>
      <tr>-->
        <!--<td><span class="bodytext32" style="font-size: 14px"><strong><a href="paylaterrefundlist.php" target="_blank" style="text-decoration:none;">Credit Patient Refund </a></strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="refundreferrallist.php" target="_blank" style="text-decoration:none;">Pay Now Referral Refund </a></strong></span></td>
      </tr>-->
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr> <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="2">&nbsp;
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];


	// $searchpatient = $_POST['patient'];
	//$searchpatientcode=$_POST['patientcode'];
	//$searchvisitcode = $_POST['visitcode'];
	//$fromdate=$_POST['ADate1'];
	//$todate=$_POST['ADate2'];



	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
<form name="form1" id="form1" method="post" action="editpackagebilling.php">	
		<table id="AutoNumber33" style="BORDER-COLLAPSE: collapse; " 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
             
           <tr><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="5" class="bodytext3"><strong>Private Doctor</strong></td></tr>
			<?php
			$sno = 0;
			$totalamount = 0.00;
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$privno = mysql_num_rows($exec112);
			while($res112 = mysql_fetch_array($exec112))
			{
			$sno = $sno + 1;
			$anum = $res112['auto_number'];
			$desc = $res112['description'];
			$quantity = $res112['quantity'];
			$rate = $res112['rate'];
			$amount = $res112['amount'];
			$totalamount = $totalamount + $amount;
			?>
			<tr bgcolor="#D3EEB7">
			<td align="left" valign="middle" class="bodytext3"><a href="#" onclick="return DelPri('<?php echo $anum; ?>');">Delete</a></td>
			<td align="left" valign="top"><span class="bodytext3">
			<?php echo $desc;?>
			</span></td>
			<td align="left" valign="top"><span class="bodytext3">
			<input type="hidden" name="pri<?php echo $sno; ?>" value="<?php echo $anum; ?>" />
			<input type="text" name="private<?php echo $sno; ?>" id="amt<?php echo $sno; ?>" value="<?php echo $amount;?>" />
			</span></td>
			</tr>
			<?php
			}
			?>		
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="5" class="bodytext3"><strong>Resident Doctor</strong></td></tr>
			<?php
			$query132 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec132 = mysql_query($query132) or die(mysql_error());
			$privno1 = mysql_num_rows($exec132);
			while($res132 = mysql_fetch_array($exec132))
			{
			$sno = $sno + 1;
			$anum1 = $res132['auto_number'];
			$desc1 = $res132['description'];
			$quantity1 = $res132['quantity'];
			$rate1 = $res132['rate'];
			$amount1 = $res132['amount'];
			$totalamount = $totalamount + $amount1;
			?>
			<tr bgcolor="#CBDBFA">
			<td align="left" valign="middle" class="bodytext3"><a href="#" onclick="return DelRes('<?php echo $anum1; ?>');">Delete</a></td>
			<td align="left" valign="top"><span class="bodytext3">
			<?php echo $desc1;?>
			</span></td>
			<td align="left" valign="top"><span class="bodytext3">
			<input type="hidden" name="res<?php echo $sno; ?>" value="<?php echo $anum1; ?>" />
			<input type="text" name="resident<?php echo $sno; ?>" id="amt<?php echo $sno; ?>" value="<?php echo $amount1;?>" />
			</span></td>
			</tr>
			<?php
			}
			?>			
                  
              <tr>
                     <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				            <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><b>Package Amount :<?php echo $res1rate;?></b><input type="hidden" name="totalpackagecost" id="totalpackagecost" value="<?php echo $res1rate;?>"></td>
        
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><b>Available Amount : <input type="text" readonly style="border:none;background:none" value="<?php echo $totalamount; ?>	" id="availableamount" name="availableamount"></b><input type="hidden" name="availableamount1" id="availableamount1" value=""></td>
				 
             
               
                
           	</tr>
           <tr> <td><input type="submit"></td><td></td><td></td></tr>
           <input type="hidden" name="loadtext" value="loadtext">
          </tbody>
        </table>













                <input type="hidden" name="ptname1" id="ptname1"  value="<?php echo $res1patientfullname;?>">
                <input type="hidden" name="regcode1" id="regcode1"  value="<?php echo $res1customercode;?>">
                <input type="hidden" name="ipcode1" id="ipcode1"  value="<?php echo $res1visitcode;?>">
                <input type="hidden" name="packg1" id="packg1"  value="<?php echo $res1packagename;?>">
                <input type="hidden" name="costpkg1" id="costpkg1"  value="<?php echo $res1rate;?>">
                <input type="hidden" name="account1" id="account1"  value="<?php echo $res111accountname;?>">
                <input type="hidden" name="billtype1" id="billtype1"  value="<?php echo $res1billtype;?>">
                <input type="hidden" name="locationcodeget1" id="locationcodeget1"  value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget1" id="locationnameget1"  value="<?php echo $locationname;?>">
              </span></td>
              </tr>
		 </form>
		 <?php
		 
		 ?>		</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

