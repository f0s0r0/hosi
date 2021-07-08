<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$errmsg = "";


if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == "frmflag1")
{
	$patientname = $_REQUEST["patientname"];
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$operationname = $_REQUEST["operationname"];
	$age = $_REQUEST["age"];
	$gender = $_REQUEST["gender"];
	$ward = $_REQUEST["ward"];
	$docno = $_REQUEST['docno'];
	$locationcode = $_REQUEST["locationcode"];
	$oprecordtheatre = isset($_REQUEST["oprecordtheatre"])? 1 : 0;
	$oprecordward = isset($_REQUEST["oprecordward"])? 1 : 0;
	$ivtheatre = isset($_REQUEST["ivtheatre"])? 1 : 0;
	$ivward = isset($_REQUEST["ivward"])? 1 : 0;
	$intrafluidtheatre = isset($_REQUEST["intrafluidtheatre"])? 1 : 0;
	$intrafluidtheatrenot = isset($_REQUEST["intrafluidtheatrenot"])? 1 : 0;
	$intrafluidward = isset($_REQUEST["intrafluidward"])? 1 : 0;
	$postopdrugtheatre = isset($_REQUEST["postopdrugtheatre"])? 1 : 0;
	$postopdrugtheatrenot = isset($_REQUEST["postopdrugtheatrenot"])? 1 : 0;
	$postopdrugward = isset($_REQUEST["postopdrugward"])? 1 : 0;
	$nasotubetheatre = isset($_REQUEST["nasotubetheatre"])? 1 : 0;
	$nasotubetheatrenot = isset($_REQUEST["nasotubetheatrenot"])? 1 : 0;
	$nasotubeward = isset($_REQUEST["nasotubeward"])? 1 : 0;
	$roomobstheatre = $_REQUEST["roomobstheatre"];
	$roomobsward = $_REQUEST["roomobsward"];
	$preopfilmtheatre = isset($_REQUEST["preopfilmtheatre"])? 1 : 0;
	$preopfilmtheatrenot = isset($_REQUEST["preopfilmtheatrenot"])? 1 : 0;
	$preopfilmward = isset($_REQUEST["preopfilmward"])? 1 : 0;
	$xraytheatre = isset($_REQUEST["xraytheatre"])? 1 : 0;
	$xraytheatrenot = isset($_REQUEST["xraytheatrenot"])? 1 : 0;
	$xrayward = isset($_REQUEST["xrayward"])? 1 : 0;
	$drainstheatre = isset($_REQUEST["drainstheatre"])? 1 : 0;
	$drainsward = $_REQUEST["drainsward"];
	$dressingtheatre = isset($_REQUEST["dressingtheatre"])? 1 : 0;
	$dressingward = isset($_REQUEST["dressingward"])? 1 : 0;
	$dressingwardnot = isset($_REQUEST["dressingwardnot"])? 1 : 0;
	$forleytheatre = isset($_REQUEST["forleytheatre"])? 1 : 0;
	$forleyward = isset($_REQUEST["forleyward"])? 1 : 0;
	$nospecimentheatre = isset($_REQUEST["nospecimentheatre"])? 1 : 0;
	$nospecimenward = $_REQUEST["nospecimenward"];
	$specimentypetheatre = isset($_REQUEST["specimentypetheatre"])? 1 : 0;
	$specimentypeward = $_REQUEST["specimentypeward"];
	$investigationtheatre = $_REQUEST["investigationtheatre"];
	$investigationward = $_REQUEST["investigationward"];
	$temp = $_REQUEST["temp"];
	$c = $_REQUEST["c"];
	$p = $_REQUEST["p"];
	$r = $_REQUEST["r"];
	$bp = $_REQUEST["bp"];
	
	$query7 = "select * from postop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec7 = mysql_query($query7) or die(mysql_error());
	echo $nums7 = mysql_num_rows($exec7);
	//exit;
	
	if($nums7 == '0')
	{	
		if($patientname!='')
		{
     		$query5 = "insert into postop(docno,patientcode,visitcode,patientname,recorddate,operation,ward,oprecordtheatre,oprecordward,ivtheatre,ivward,intrafluidtheatre,intrafluidtheatrenot,
			intrafluidward,postopdrugtheatre,postopdrugtheatrenot,postopdrugward,nasotubetheatre,nasotubetheatrenot,nasotubeward,roomobstheatre,roomobsward,preopfilmtheatre,preopfilmtheatrenot,
			preopfilmward,xraytheatre,xraytheatrenot,xrayward,drainstheatre,drainsward,dressingtheatre,dressingward,dressingwardnot,forleytheatre,forleyward,nospecimentheatre,nospecimenward,
			specimentypetheatre,specimentypeward,investigationtheatre,investigationward,temp,c,p,r,bp,username,locationname,locationcode) 
			values('$docno','$patientcode','$visitcode','$patientname','$transactiondatefrom','$operationname','$ward','$oprecordtheatre','$oprecordward','$ivtheatre','$ivward','$intrafluidtheatre',
			'$intrafluidtheatrenot','$intrafluidward','$postopdrugtheatre','$postopdrugtheatrenot','$postopdrugward','$nasotubetheatre','$nasotubetheatrenot','$nasotubeward','$roomobstheatre',
			'$roomobsward','$preopfilmtheatre','$preopfilmtheatrenot','$preopfilmward','$xraytheatre','$xraytheatrenot','$xrayward','$drainstheatre','$drainsward','$dressingtheatre','$dressingward',
			'$dressingwardnot','$forleytheatre','$forleyward','$nospecimentheatre','$nospecimenward','$specimentypetheatre','$specimentypeward','$investigationtheatre','$investigationward',
			'$temp','$c','$p','$r','$bp','$username','$locationname','$locationcode')";
			$exec5 = mysql_query($query5) or die("Query5".mysql_error()); 
			header("location:otpatients.php");
		}
	}
	else
	{
		if($patientname!='')
		{
			$query8 = "update postop set oprecordtheatre='$oprecordtheatre',oprecordward='$oprecordward',ivtheatre='$ivtheatre',ivward='$ivward',intrafluidtheatre='$intrafluidtheatre',intrafluidtheatrenot='$intrafluidtheatrenot',
			intrafluidward='$intrafluidward',postopdrugtheatre='$postopdrugtheatre',postopdrugtheatrenot='$postopdrugtheatrenot',postopdrugward='$postopdrugward',nasotubetheatre='$nasotubetheatre',nasotubetheatrenot='$nasotubetheatrenot',
			nasotubeward='$nasotubeward',roomobstheatre='$roomobstheatre',roomobsward='$roomobsward',preopfilmtheatre='$preopfilmtheatre',preopfilmtheatrenot='$preopfilmtheatrenot',preopfilmward='$preopfilmward',
			xraytheatre='$xraytheatre',xraytheatrenot='$xraytheatrenot',xrayward='$xrayward',drainstheatre='$drainstheatre',drainsward='$drainsward',dressingtheatre='$dressingtheatre',dressingward='$dressingward',dressingwardnot='$dressingwardnot',
			forleytheatre='$forleytheatre',forleyward='$forleyward',nospecimentheatre='$nospecimentheatre',nospecimenward='$nospecimenward',specimentypetheatre='$specimentypetheatre',specimentypeward='$specimentypeward',investigationtheatre='$investigationtheatre',
			investigationward='$investigationward',temp='$temp',c='$c',p='$p',r='$r',bp='$bp',username='$username',locationname='$locationname',locationcode='$locationcode' where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
			$exec8 = mysql_query($query8) or die("Query8".mysql_error());
			header("location:otpatients.php");
		}
	}
	
}
if($visitcode!='' && $patientcode!='')
{
	$query1 = "select * from ip_otrequest where patientvisitcode='$visitcode' and patientcode='$patientcode'";
	$exec1 = mysql_query($query1) or die(mysql_error());
	$num1 = mysql_num_rows($exec1);
	$res1 = mysql_fetch_array($exec1);
	$patientname = $res1['patientname'];
	$patientcode = $res1['patientcode'];
	$visitcode = $res1['patientvisitcode'];
	$accoutname = $res1['accountname'];
	$operation = $res1['surgeryname'];
	$docno = $res1['docno'];
	$locationcode = $res1['locationcode'];
	$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
	$exec2 = mysql_query($query2) or die(mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$ward=$res2['ward'];
	$query3 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
	$exec3 = mysql_query($query3) or die(mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$wardname = $res3['ward'];
	$query4 = "select * from master_customer where customercode='$patientcode'";
	$exec4 = mysql_query($query4) or die(mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$age=$res4['age'];
	$gender=$res4['gender'];
	$query6 = "select * from postop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysql_query($query6) or die(mysql_error());
	$nums6 = mysql_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysql_fetch_array($exec6);
		$oprecordtheatre = $res6["oprecordtheatre"];
		$oprecordward = $res6["oprecordward"];
		$ivtheatre = $res6["ivtheatre"];
		$ivward = $res6["ivward"];
		$intrafluidtheatre = $res6["intrafluidtheatre"];
		$intrafluidtheatrenot = $res6["intrafluidtheatrenot"];
		$intrafluidward = $res6["intrafluidward"];
		$postopdrugtheatre = $res6["postopdrugtheatre"];
		$postopdrugtheatrenot = $res6["postopdrugtheatrenot"];
		$postopdrugward = $res6["postopdrugward"];
		$nasotubetheatre = $res6["nasotubetheatre"];
		$nasotubetheatrenot = $res6["nasotubetheatrenot"];
		$nasotubeward = $res6["nasotubeward"];
		$roomobstheatre = $res6["roomobstheatre"];
		$roomobsward = $res6["roomobsward"];
		$preopfilmtheatre = $res6["preopfilmtheatre"];
		$preopfilmtheatrenot = $res6["preopfilmtheatrenot"];
		$preopfilmward = $res6["preopfilmward"];
		$xraytheatre = $res6["xraytheatre"];
		$xraytheatrenot = $res6["xraytheatrenot"];
		$xrayward = $res6["xrayward"];
		$drainstheatre = $res6["drainstheatre"];
		$drainsward = $res6["drainsward"];
		$dressingtheatre = $res6["dressingtheatre"];
		$dressingward = $res6["dressingward"];
		$dressingwardnot = $res6["dressingwardnot"];
		$forleytheatre = $res6["forleytheatre"];
		$forleyward = $res6["forleyward"];
		$nospecimentheatre = $res6["nospecimentheatre"];
		$nospecimenward = $res6["nospecimenward"];
		$specimentypetheatre = $res6["specimentypetheatre"];
		$specimentypeward = $res6["specimentypeward"];
		$investigationtheatre = $res6["investigationtheatre"];
		$investigationward = $res6["investigationward"];
		$temp = $res6["temp"];
		$c = $res6["c"];
		$p = $res6["p"];
		$r = $res6["r"];
		$bp = $res6["bp"];
	}
	else
	{
		$oprecordtheatre = '';
		$oprecordward = '';
		$ivtheatre = '';
		$ivward = '';
		$intrafluidtheatre = '';
		$intrafluidtheatrenot = '';
		$intrafluidward = '';
		$postopdrugtheatre = '';
		$postopdrugtheatrenot = '';
		$postopdrugward = '';
		$nasotubetheatre = '';
		$nasotubetheatrenot = '';
		$nasotubeward = '';
		$roomobstheatre = '';
		$roomobsward = '';
		$preopfilmtheatre = '';
		$preopfilmtheatrenot = '';
		$preopfilmward = '';
		$xraytheatre = '';
		$xraytheatrenot = '';
		$xrayward = '';
		$drainstheatre = '';
		$drainsward = '';
		$dressingtheatre = '';
		$dressingward = '';
		$dressingwardnot = '';
		$forleytheatre = '';
		$forleyward = '';
		$nospecimentheatre = '';
		$nospecimenward = '';
		$specimentypetheatre = '';
		$specimentypeward = '';
		$investigationtheatre = '';
		$investigationward = '';
		$temp = '';
		$c = '';
		$p = '';
		$r = '';
		$bp = '';
	}
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
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

</script>
<script src="js/datetimepicker_css.js"></script>
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
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="61%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#E0E0E0">
          <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" />
          <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
          <td class="bodytext3" bgcolor="#E0E0E0"><strong>Patient  * </strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" bgcolor="#E0E0E0"><?php echo $patientname; ?></td>
          <td bgcolor="#E0E0E0" class="bodytext3"><strong>Date </strong></td>
          <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
          <td width="26%" bgcolor="#E0E0E0" class="bodytext3"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
          <td width="11%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="21%" align="left" valign="middle" class="bodytext3"><?php echo $wardname; ?></td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient Code</strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code </strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?></td>
          <td align="left" valign="top" class="bodytext3"><strong>Operation</strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $operation; ?></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $age; ?> & <?php echo $gender; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Ref. Dr. </strong></td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3"><strong>Doc no</strong></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3"><?php echo $docno; ?></td>
        </tr>
		<tr>
		<?php
		  $query131 = "select * from master_location where locationcode = '$locationcode'";
          $exec131 = mysql_query($query131) or die ("Error in Query131".mysql_error());
          $res131 = mysql_fetch_array($exec131);
          $locationname = $res131['locationname'];
	     ?>
		<td class="bodytext3" bgcolor="#E0E0E0"><strong>Location </strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" bgcolor="#E0E0E0"><?php echo $locationname; ?></td>
		 </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
        </tr>
      </tbody>
    </table>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top">


      <form name="form1" id="form1" method="post" action="postop.php?anum=<?php echo $companyanum; ?>" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="886" height="282" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="8"><strong>Post-Operative Check </strong>
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname;?>">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode;?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode;?>">
				<input type="hidden" name="operationname" id="operationname" value="<?php echo $operation;?>">
				<input type="hidden" name="age" id="age" value="<?php echo $age;?>">
				<input type="hidden" name="gender" id="gender" value="<?php echo $gender;?>">
				<input type="hidden" name="ward" id="ward" value="<?php echo $wardname;?>">
				<input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>">
				<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname;?>">
				<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode;?>">
				
				</td>
                
                <td colspan="2" bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="14" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              
              
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>POST-OPERATIVE CHECK </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3"><strong>CHECK THE APPROPRIATE RESPONSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>CHARTS, RECORDS, E.T.C. PRESENT </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3"><strong> THEATRE NURSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>WARD NURSE</strong></td>
				  </tr>
				<tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Operation Record </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="oprecordtheatre" id="oprecordtheatre" onClick="return funcpackcheck();" <?php if($oprecordtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="oprecordward" id="oprecordward" onClick="return funcpackcheck();" <?php if($oprecordward == '1') echo 'checked'; ?> value="1"></td>
                </tr>
				  <tr>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">IV Fluids and Transfussions Record </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="ivtheatre" id="ivtheatre" onClick="return funcpackcheck();" <?php if($ivtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td width="18%" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="ivward" id="ivward" onClick="return funcpackcheck();" <?php if($ivward == '1') echo 'checked'; ?> value="1"></td>
                <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Nursing Instructions For: </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                </tr>
              <tr>
                <td width="2%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td width="22%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Intravenous Fluids </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="intrafluidtheatre" id="intrafluidtheatre" onClick="return funcpackcheck();" <?php if($intrafluidtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="intrafluidtheatrenot" id="intrafluidtheatrenot" onClick="return funcpackcheck();" <?php if($intrafluidtheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="intrafluidward" id="intrafluidward" onClick="return funcpackcheck();" <?php if($intrafluidward == '1') echo 'checked'; ?> value="1"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Post-Operative Drugs </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="postopdrugtheatre" id="postopdrugtheatre" onClick="return funcpackcheck();" <?php if($postopdrugtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="postopdrugtheatrenot" id="postopdrugtheatrenot" onClick="return funcpackcheck();" <?php if($postopdrugtheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="postopdrugward" id="postopdrugward" onClick="return funcpackcheck();" <?php if($postopdrugward == '1') echo 'checked'; ?> value="1"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Naso-Gastric Tube </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="nasotubetheatre" id="nasotubetheatre" onClick="return funcpackcheck();" <?php if($nasotubetheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="nasotubetheatrenot" id="nasotubetheatrenot" onClick="return funcpackcheck();" <?php if($nasotubetheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="nasotubeward" id="nasotubeward" onClick="return funcpackcheck();" <?php if($nasotubeward == '1') echo 'checked'; ?> value="1"></td>
              </tr>
             
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Recovery Room Observations </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
                  <input name="roomobstheatre" id="roomobstheatre" value="<?php echo $roomobstheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="roomobsward" id="roomobsward" value="<?php echo $roomobsward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
               <tr>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">X-Rays</td>
                 <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
               </tr>
               <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pre-Operative Films </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="preopfilmtheatre" id="preopfilmtheatre" onClick="return funcpackcheck();" <?php if($preopfilmtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="preopfilmtheatrenot" id="preopfilmtheatrenot" onClick="return funcpackcheck();" <?php if($preopfilmtheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="preopfilmward" id="preopfilmward" onClick="return funcpackcheck();" <?php if($preopfilmward == '1') echo 'checked'; ?> value="1"></td>
                </tr>
               <tr>
                 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">X-Ray Card For Post-Operative Films </td>
                 <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="xraytheatre" id="xraytheatre" onClick="return funcpackcheck();" <?php if($xraytheatre == '1') echo 'checked'; ?> value="1"></td>
                 <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="xraytheatrenot" id="xraytheatrenot" onClick="return funcpackcheck();" <?php if($xraytheatrenot == '1') echo 'checked'; ?> value="1">
                   <span class="bodytext3">N/R</span></td>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="xrayward" id="xrayward" onClick="return funcpackcheck();" <?php if($xrayward == '1') echo 'checked'; ?> value="1"></td>
               </tr>
                
              <tr>
                <td colspan="10" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>DRAINS, DRESSING, E.T.C. PRESENT </strong></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Drains (indicate number) </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="drainstheatre" id="drainstheatre" onClick="return funcpackcheck();" <?php if($drainstheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="drainsward" id="drainsward" value="<?php echo $drainsward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Dressings Dry And Intact </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="dressingtheatre" id="dressingtheatre" onClick="return funcpackcheck();" <?php if($dressingtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="dressingward" id="dressingward" onClick="return funcpackcheck();" <?php if($dressingward == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="dressingwardnot" id="dressingwardnot" onClick="return funcpackcheck();" <?php if($dressingwardnot == '1') echo 'checked'; ?> value="1">
                  N/R</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Forley Catheter </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="forleytheatre" id="forleytheatre" onClick="return funcpackcheck();" <?php if($forleytheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="forleyward" id="forleyward" onClick="return funcpackcheck();" <?php if($forleyward == '1') echo 'checked'; ?> value="1"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>OTHER</strong></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
              </tr>
              
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>IF SPECIMEN TO GO WITH PATIENT </strong></td>
			     </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Number Of Specimen (s) </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="nospecimentheatre" id="nospecimentheatre" onClick="return funcpackcheck();" <?php if($nospecimentheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="nospecimenward" id="nospecimenward" value="<?php echo $nospecimenward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
				
				   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Type Of Specimen (s)</td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="specimentypetheatre" id="specimentypetheatre" onClick="return funcpackcheck();" <?php if($specimentypetheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="specimentypeward" id="specimentypeward" value="<?php echo $specimentypeward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Investigations Ordered </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
                  <input name="investigationtheatre" id="investigationtheatre" value="<?php echo $investigationtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="investigationward" id="investigationward" value="<?php echo $investigationward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
				 
			   <tr>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Vital Signs </td>
			     <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0"><spanp class="bodytext3">
			       <span class="bodytext3">Temp</span></span></td>
			     <td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
			       <input name="temp" id="temp" value="<?php echo $temp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">C
                     
			     </span></td>
			     <td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
			       <input name="c" id="c" value="<?php echo $c; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3"> R                 </span></td>
			     <td width="12%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
			       <input name="r" id="r" value="<?php echo $r; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">BP                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
			       <input name="bp" id="bp" value="<?php echo $bp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3"> P                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext3">
			       <input name="p" id="p" value="<?php echo $p; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
			     </tr>
			   
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>CHECKED BY:</strong> <?php echo $username; ?></td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
			     </tr>
              
               <tr>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
                <td align="middle"  bgcolor="#E0E0E0"><input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
                  <input name="Submit222" type="submit"  value="Save Post Op" class="button"/></td>
                <td align="middle"  bgcolor="#E0E0E0">&nbsp;</td>
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

