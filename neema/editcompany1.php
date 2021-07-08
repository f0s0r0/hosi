<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
//Variable Declaration
$errmsg = "";

if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if ($companyanum == '') header ("location:addcompany1.php");

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == "frmflag1")
{
	
	//get dispensing here
	$dispensing=isset($_REQUEST['dispensing'])?$_REQUEST['dispensing']:'';
	//get dispensing ends here
	$companycode = $_REQUEST["companycode"];
	$companyname = $_REQUEST["companyname"];
	//$companyname = strtoupper($companyname);
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber1 = $_REQUEST["faxnumber1"];
	$faxnumber2  = $_REQUEST["faxnumber2"];
	$city  = $_REQUEST["city"];
	$state = $_REQUEST["state"];
	$country = $_REQUEST["country"];
	$pincode = $_REQUEST["pincode"];
	$tinnumber = $_REQUEST["tinnumber"];
	$cstnumber = $_REQUEST["cstnumber"];
	//$companystatus  = $_REQUEST["companystatus"];
	$companystatus = 'Active'; 
	$currencyname = $_REQUEST["currencyname"];
	$currencydecimalname = $_REQUEST["currencydecimalname"];
	$currencycode = $_REQUEST["currencycode"];
	$patientcodeprefix = $_REQUEST["patientcodeprefix"];
	$patientcodeprefix = strtoupper($patientcodeprefix);
	$visitcodeprefix = $_REQUEST["visitcodeprefix"];
	$visitcodeprefix = strtoupper($visitcodeprefix);
	$pharmbillnumberprefix = $_REQUEST["pharmbillprefix"];
	$pharmbillnumberprefix = strtoupper($pharmbillnumberprefix);
	 $radbillnumberprefix = $_REQUEST["radiologybillprefix"];
	  $radbillnumberprefix = strtoupper( $radbillnumberprefix);
	 $labbillnumberprefix = $_REQUEST["labbilleprefix"];
	  $labbillnumberprefix = strtoupper( $labbillnumberprefix);
	  $serbillnumberprefix = $_REQUEST["servicebillprefix"];
	  $serbillnumberprefix = strtoupper($serbillnumberprefix);
	 $refbillnumberprefix = $_REQUEST["referalbillprefix"];
	 $refbillnumberprefix = strtoupper($refbillnumberprefix);
	  $paylaterbillprefix=$_REQUEST['paylaterbillprefix'];
	 $paylaterbillprefix=strtoupper($paylaterbillprefix);
	 $labrefnoprefix=$_REQUEST['labrefprefix'];
	 $labrefnoprefix=strtoupper($labrefnoprefix);
	 $radrefnumber=$_REQUEST['radrefprefix'];
	 $radrefnumber=strtoupper($radrefnumber);
	 $serrefnumber=$_REQUEST['serrefprefix'];
	 $serrefnumber=strtoupper($serrefnumber);
	  $refrefnumber=$_REQUEST['refrefprefix'];
	 $refrefnumber=strtoupper($refrefnumber);
$pharefnumber=$_REQUEST['pharefprefix'];
	 $pharefnumber=strtoupper($pharefnumber);
$paynowprefix=$_REQUEST['paynowprefix'];
$paynowprefix=strtoupper($paynowprefix);
$paynowrefundprefix=$_REQUEST['paynowrefundprefix'];
$paynowrefundprefix=strtoupper($paynowrefundprefix);
	$showlogo = $_REQUEST["showlogo"];
	$nhifrebates = $_REQUEST["nhifrebate"];
	$ipadmissionfees = $_REQUEST['ipadmissionfees'];
		$ipvisitcodeprefix = $_REQUEST['ipvisitcodeprefix'];
		$creditipadmissionfees = $_REQUEST['creditipadmissionfees'];
		$incometax = $_REQUEST['incometax'];
		$pharmacydisc = $_REQUEST['pharmacydisc'];
		$shownostockitems = isset($_POST["nostock"])? 'Yes' : 'NO';
	$dateposted = $updatedatetime;
	
		$query1 = "update master_company set dispensing='".$dispensing."', companyname = '$companyname', shownostockitems = '$shownostockitems',
		phonenumber1 = '$phonenumber1', phonenumber2 = '$phonenumber2', emailid1 = '$emailid1', 
		emailid2 = '$emailid2', faxnumber1 = '$faxnumber1', faxnumber2 = '$faxnumber2', 
		address1 = '$address1', address2 = '$address2', area = '$area', city = '$city', state = '$state', pincode = '$pincode', 
		companystatus = '$companystatus', tinnumber = '$tinnumber', cstnumber = '$cstnumber', 
		currencyname = '$currencyname', currencycode = '$currencycode', currencydecimalname = '$currencydecimalname', 
		patientcodeprefix = '$patientcodeprefix', visitcodeprefix = '$visitcodeprefix',pharmacyprefix = '$pharmbillnumberprefix',radiologyprefix = '$radbillnumberprefix',labprefix = '$labbillnumberprefix', serviceprefix = '$serbillnumberprefix',referalprefix = '$refbillnumberprefix',paylaterbillprefix='$paylaterbillprefix',labrefnoprefix='$labrefnoprefix',
		radrefnoprefix='$radrefnumber',serrefnoprefix='$serrefnumber',refrefnoprefix='$refrefnumber',pharefnoprefix='$pharefnumber',paynowbillnoprefix='$paynowprefix',paynowrefundprefix='$paynowrefundprefix',showlogo = '$showlogo',nhifrebate='$nhifrebates',ipadmissionfees='$ipadmissionfees',ipvisitcodeprefix='$ipvisitcodeprefix',creditipadmissionfees='$creditipadmissionfees',incometax='$incometax',pharmacydisc='$pharmacydisc' where auto_number = '$companyanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			
		$errmsg = "Success. Hospital Details Updated.";
		
		$companycode = $_REQUEST["companycode"];
		$companyname = $_REQUEST["companyname"];
		//$companyname = strtoupper($companyname);
		$address1 = $_REQUEST["address1"];
		$address2 = $_REQUEST["address2"];
		$area = $_REQUEST["area"];
		$phonenumber1 = $_REQUEST["phonenumber1"];
		$phonenumber2 = $_REQUEST["phonenumber2"];
		$emailid1  = $_REQUEST["emailid1"];
		$emailid2 = $_REQUEST["emailid2"];
		$faxnumber1 = $_REQUEST["faxnumber1"];
		$faxnumber2  = $_REQUEST["faxnumber2"];
		$city  = $_REQUEST["city"];
		$state = $_REQUEST["state"];
		$country = $_REQUEST["country"];
		$pincode = $_REQUEST["pincode"];
		$tinnumber = $_REQUEST["tinnumber"];
		$cstnumber = $_REQUEST["cstnumber"];
		$dateposted = $updatedatetime;
		$currencyname = $_REQUEST["currencyname"];
		$currencydecimalname = $_REQUEST["currencydecimalname"];
		$currencycode = $_REQUEST["currencycode"];
		$patientcodeprefix = $_REQUEST["patientcodeprefix"];
		$visitcodeprefix = $_REQUEST["visitcodeprefix"];
		$showlogo = $_REQUEST["showlogo"];
		$radrefnoprefix=$_REQUEST['radrefprefix'];
		$serrefnoprefix=$_REQUEST['serrefprefix'];
		$refrefnoprefix=$_REQUEST['refrefprefix'];
		$pharefnoprefix=$_REQUEST['pharefprefix'];
		$paylaterbillnumberprefix=$_REQUEST['paylaterbillprefix'];
		$paynowbillnoprefix=$_REQUEST['paynowprefix'];
		$paynowrefundprefix=$_REQUEST['paynowrefundprefix'];
		$nhifrebate = $_REQUEST['nhifrebate'];
		$ipadmissionfees = $_REQUEST['ipadmissionfees'];
			$ipvisitcodeprefix = $_REQUEST['ipvisitcodeprefix'];
		$showcity = $city;
		$creditipadmissionfees = $_REQUEST['creditipadmissionfees'];
		$incometax = $_REQUEST['incometax'];
		$stocks = isset($_POST["nostock"])? 'Yes' : 'NO';

}
else
{
	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	
	$companycode = $res6["companycode"];
	$companyname = $res6["companyname"];
	//$companyname = strtoupper($companyname);
	$address1 = $res6["address1"];
	$address2 = $res6["address2"];
	$area = $res6["area"];
	$phonenumber1 = $res6["phonenumber1"];
	$phonenumber2 = $res6["phonenumber2"];
	$emailid1  = $res6["emailid1"];
	$emailid2 = $res6["emailid2"];
	$faxnumber1 = $res6["faxnumber1"];
	$faxnumber2  = $res6["faxnumber2"];
	$city  = $res6["city"];
	$state = $res6["state"];
	$country = $res6["country"];
	$pincode = $res6["pincode"];
	$tinnumber = $res6["tinnumber"];
	$cstnumber = $res6["cstnumber"];
	$companystatus  = $res6["companystatus"];
	$dateposted = $res6["dateposted"];
	$currencyname = $res6["currencyname"];
	$currencydecimalname = $res6["currencydecimalname"];
	$currencycode = $res6["currencycode"];
	$stockmanagement = $res6["stockmanagement"];
	$patientcodeprefix = $res6['patientcodeprefix'];
	$visitcodeprefix = $res6['visitcodeprefix'];
	$pharmbillnumberprefix=$res6['pharmacyprefix'];
	 $radbillnumberprefix=$res6['radiologyprefix'];
	 $labbillnumberprefix=$res6['labprefix'];
	 $serbillnumberprefix=$res6['serviceprefix'];
	 $refbillnumberprefix=$res6['referalprefix'];
	 $paylaterbillnumberprefix=$res6['paylaterbillprefix'];
	 $labrefnoprefix=$res6['labrefnoprefix'];
	 $radrefnoprefix=$res6['radrefnoprefix'];
	 $serrefnoprefix=$res6['serrefnoprefix'];
	  $refrefnoprefix=$res6['refrefnoprefix'];
	  $pharefnoprefix=$res6['pharefnoprefix'];
	  $paynowbillnoprefix=$res6['paynowbillnoprefix'];
	  $paynowrefundprefix=$res6['paynowrefundprefix'];
	$showlogo = $res6['showlogo'];
	$nhifrebate = $res6['nhifrebate'];
	$ipadmissionfees = $res6['ipadmissionfees'];
	$ipvisitcodeprefix = $res6['ipvisitcodeprefix'];
	$creditipadmissionfees = $res6['creditipadmissionfees'];
	$showcity = $city;
	$incometax = $res6['incometax'];
	$stocks = $res6['shownostockitems'];
	$dispensing=$res6['dispensing'];
	$pharmacydisc=$res6['pharmacydisc'];
	
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">



</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}

}


function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
	<?php
	$query11 = "select * from master_state group by state order by state";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$statename = $res11["state"];
	?>
		if(document.form1.state.value=="<?php echo $statename; ?>")
		{
		document.getElementById("city").options.length=null; 
		var combo = document.getElementById('city'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select City", ""); 
		<?php
		$query10="select * from master_city where state = '$statename' group by city order by city asc";
		$exec10=mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10=mysql_fetch_array($exec10))
		{
		$loopcount=$loopcount+1;
		$city1=$res10["city"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $city;?>", "<?php echo $city;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
}


function from1submit1()
{

	if (document.form1.companyname.value == "")
	{
		alert ("Hospital Name Cannot Be Empty.");
		document.form1.companyname.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		//alert ("City Cannot Be Empty.");
		//document.form1.city.focus();
		//return false;
	}
	else if (document.form1.state.value == "")
	{
		//alert ("State Cannot Be Empty.");
		//document.form1.state.focus();
		//return false;
	}
	else if (document.form1.patientcodeprefix.value == "") 
	{
		alert ("Please Enter Patient Code Prefix.");
		document.form1.patientcodeprefix.focus();
		return false;
	}
	else if (document.form1.visitcodeprefix.value == "") 
	{
		alert ("Please Enter Visit Number Prefix.");
		document.form1.visitcodeprefix.focus();
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
}

function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;

  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
  return false;
 }
}

</script>
<SCRIPT LANGUAGE="Javascript" SRC="js/ColorPicker2.js"></SCRIPT>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top">


      <form name="form1" id="form1" method="post" action="editcompany1.php?anum=<?php echo $companyanum; ?>" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Hospital - Update </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <tr>
                <td width="21%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Hospital Name   *</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="companyname" id="companyname" value="<?php echo $companyname; ?>" onKeyDown="return disableEnterKey()" size="60"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 1 </td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="address1" id="address1" value="<?php echo $address1; ?>" onKeyDown="return disableEnterKey()" size="60" /></td>
              </tr>
				<tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 2 </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="address2" id="address2" value="<?php echo $address2; ?>" onKeyDown="return disableEnterKey()" size="40" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Area / Location </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="area" id="area" value="<?php echo $area; ?>" size="20" /></td>
				</tr><tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">County * </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="state" id="state" value="<?php echo $state; ?>" size="20" />			</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">City * </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="city" id="city" value="<?php echo $city; ?>" size="20" />			</td>
                </tr>
				  <tr>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Post Box  </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="pincode" id="pincode" value="<?php echo $pincode; ?>" onKeyDown="return disableEnterKey()" size="30" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Country </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="country" id="country" value="<?php echo $country; ?>" size="20" />				</td>
				  </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Phone Number 1 </td>
                <td width="31%" align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" onKeyDown="return disableEnterKey()" size="20" />                </td>
                <td width="20%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Phone Number 2 </td>
                <td width="28%" align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
              </tr>
             
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Fax Number 1 </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="faxnumber1" id="faxnumber1" value="<?php echo $faxnumber1; ?>" onKeyDown="return disableEnterKey()" size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Fax Number 2 </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="faxnumber2" id="faxnumber2" value="<?php echo $faxnumber2; ?>" onKeyDown="return disableEnterKey()" size="20" /></td>
              </tr>
               <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 1 </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 2 </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
              </tr>
                
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">TIN Number </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">TL Number </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" size="20" /></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Currency  Name </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="currencyname" id="currencyname" value="<?php echo $currencyname; ?>" size="10" />
                    <span class="bodytext3">* Ex: Rupees</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Currency  Decimal Name </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="currencydecimalname" id="currencydecimalname" value="<?php echo $currencydecimalname; ?>" size="10" />
                    <span class="bodytext3">* Ex: Paise / Cent </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Currency  Code </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="currencycode" id="currencycode" value="<?php echo $currencycode; ?>" style="text-transform: uppercase;"  size="10" />
                    <span class="bodytext3">* Ex: INR</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Code Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="patientcodeprefix" id="patientcodeprefix" value="<?php echo $patientcodeprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Paylater Bill No Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="paylaterbillprefix" id="paylaterbillprefix" value="<?php echo  $paylaterbillnumberprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Visit Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="visitcodeprefix" id="visitcodeprefix" value="<?php echo $visitcodeprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Lab Ref No Prefix</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="labrefprefix" id="labrefprefix" value="<?php echo $labrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pharmacy Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="pharmbillprefix" id="pharmbillprefix" value="<?php echo $pharmbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
				
				   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Radiology Ref No Prefix</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="radrefprefix" id="radrefprefix" value="<?php echo $radrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Radiology Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="radiologybillprefix" id="radiologybillprefix" value="<?php echo $radbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Service Ref No Prefix</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="serrefprefix" id="serrefprefix" value="<?php echo $serrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Lab Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="labbilleprefix" id="labbillprefix" value="<?php echo $labbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
				 <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Referal Ref No</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="refrefprefix" id="refrefprefix" value="<?php echo $refrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Service Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="servicebillprefix" id="servicebillprefix" value="<?php echo $serbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pharmacy Ref No</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="pharefprefix" id="pharefprefix" value="<?php echo  $pharefnoprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
				
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Referal Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="referalbillprefix" id="referalbillprefix" value="<?php echo $refbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">PayNow Bill No Prefix</td>
             <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="paynowprefix" id="paynowprefix" value="<?php echo  $paynowbillnoprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
						  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">PayNow Refund Bill Number Prefix</td>
             <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="paynowrefundprefix" id="paynowrefundprefix" value="<?php echo  $paynowrefundprefix; ?>"  size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
		
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Show Medicines if No Stock</td>
             <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input type="checkbox" name="nostock" id="nostock" size="10" <?php if($stocks == 'Yes') echo "checked" ?>/>
                    <span class="bodytext3"></span></td>
						  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Dispensing Fee</td>
             <td align="left" valign="middle"  bgcolor="#E0E0E0">
             <input type="text" name="dispensing" onKeyDown="return numbervaild(event)" value="<?php echo $dispensing;?>">
				</td>
		
				</tr>
				
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Date Last Updated </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="dateposted" id="dateposted" value="<?php echo $dateposted; ?>" onKeyDown="return disableEnterKey()"size="20"  readonly="readonly" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">Hospital Code   *</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="companycode" id="companycode" value="<?php echo $companycode; ?>" readonly style="text-transform: uppercase;" size="20"></td>
              </tr>
              
              <tr>
                <td align="middle"  bgcolor="#E0E0E0"><div align="left"><span class="bodytext3">Show Logo </span></div></td>
                <td align="middle"  bgcolor="#E0E0E0">
				  <div align="left">
				    <select name="showlogo" id="showlogo" >
				      <?php
					if ($showlogo != '')
					{
					?>
				      <option value="<?php echo $showlogo; ?>" selected="selected"><?php echo $showlogo; ?></option>
				      <?php
					}
					else
					{
					?>
				      <option value="HIDE LOGO" selected="selected">HIDE LOGO</option>
				      <?php
					}
					?>
				      <option value="SHOW LOGO">SHOW LOGO</option>
				      <option value="HIDE LOGO">HIDE LOGO</option>
				      </select>
				      </div></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">NHIF Rebate</td>
               <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="nhifrebate" id="nhifrebate" value="<?php echo $nhifrebate; ?>"> </td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">IP Admission Fees </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="ipadmissionfees" id="ipadmissionfees" value="<?php echo $ipadmissionfees; ?>" size="20"/></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">IP Visit Code Prefix</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="ipvisitcodeprefix" id="ipvisitcodeprefix" value="<?php echo $ipvisitcodeprefix; ?>"></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Credit IP Admn Fees </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="creditipadmissionfees" id="creditipadmissionfees" value="<?php echo $creditipadmissionfees; ?>" size="20"/></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">Income Tax</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="incometax" id="incometax" value="<?php echo $incometax; ?>"></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pharmacy Disc.</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="pharmacydisc" id="pharmacydisc" value="<?php echo $pharmacydisc; ?>" size="10"/>%</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">&nbsp;</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
              </tr>
              
              <tr>
                <td colspan="4" align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="middle"  bgcolor="#cccccc"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
                  <input name="Submit222" type="submit"  value="Save Hospital" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

