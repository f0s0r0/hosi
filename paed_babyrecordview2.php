<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');

if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["patientcode"])) {  $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }

if ($visitcode!='' && $patientcode!='')
{
    $query1 = "select patientcode,visitcode,sex,birthweight,weightnow,gestation,temperature,apgar,rom,bba,bbayes,delivery,resuscitation,vitamink,eyeprophylaxis from paed_babyrecord where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec1 = mysql_query($query1) or die(mysql_error());
	$num1 = mysql_num_rows($exec1); 
	$res1 = mysql_fetch_array($exec1);
	$patientcode = $res1['patientcode'];
	$visitcode = $res1['visitcode'];
	$sex = $res1["sex"];
	$birthweight = $res1["birthweight"];
	$weightnow = $res1["weightnow"];
	$gestation = $res1["gestation"];
	$temperature = $res1["temperature"];
	$apgar = $res1["apgar"];
	$rom = $res1["rom"];
	$bba = $res1["bba"];
	$bbayes = $res1["bbayes"];
	$delivery = $res1["delivery"];
	$resuscitation = $res1["resuscitation"];
	$vitamink = $res1["vitamink"];
	$eyeprophylaxis = $res1["eyeprophylaxis"];
	
	$query2 = "select mothername,motherage,residence,gravidity,parity,hiv,arvs,vdrl,bloodgroup,fever,antibiotics,diabetes,tbtreat,labour1,labour2,hypertension,aph,babyproblem from paed_motherrecord where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec2 = mysql_query($query2) or die(mysql_error());
	$num2 = mysql_num_rows($exec2); 
	$res2 = mysql_fetch_array($exec2);
	$mothername = $res2["mothername"];
	$motherage = $res2["motherage"];
	$residence = $res2["residence"];
	$gravidity = $res2["gravidity"];
	$parity = $res2["parity"];
	$hiv = $res2["hiv"];
	$arvs = $res2["arvs"];
	$vdrl = $res2["vdrl"];
	$bloodgroup = $res2["bloodgroup"];
	$fever = $res2["fever"];
	$antibiotics = $res2["antibiotics"];
	$diabetes = $res2["diabetes"];
	$tbtreat = $res2["tbtreat"];
	$labour1 = $res2["labour1"];
	$labour2 = $res2["labour2"];
	$hypertension = $res2["hypertension"];
	$aph = $res2["aph"];
	$babyproblem = $res2["babyproblem"];
	
	$query3 = "select temp,resprate,pulse,bp,babyseen,stridor,lenillness,oxsaturation,feverdays,cyanosis,diffbreath,indrawing,diarrhoeadays,grunting,diarrhoeabloody,airentry,vomitseverything,crackles,difffeeding,cry,convulsionno,femoralpulse,pffits,caprefill,apnoea,murmur from paed_babyvitalsigns where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec3 = mysql_query($query3) or die(mysql_error());
	$num3 = mysql_num_rows($exec3); 
	$res3 = mysql_fetch_array($exec3);
	$temp = $res3["temp"];
	$resprate = $res3["resprate"];
	$pulse = $res3["pulse"];
	$bp = $res3["bp"];
	$babyseen = $res3["babyseen"];
	$stridor = $res3["stridor"];
	$lenillness = $res3["lenillness"];
	$oxsaturation = $res3["oxsaturation"];
	$feverdays = $res3["feverdays"];
	$cyanosis = $res3["cyanosis"];
	$diffbreath = $res3["diffbreath"];
	$indrawing = $res3["indrawing"];
	$diarrhoeadays = $res3["diarrhoeadays"];
	$grunting = $res3["grunting"];
	$diarrhoeabloody = $res3["diarrhoeabloody"];
	$airentry = $res3["airentry"];
	$vomitseverything = $res3["vomitseverything"];
	$crackles = $res3["crackles"];
	$difffeeding = $res3["difffeeding"];
	$cry = $res3["cry"];
	$convulsionno = $res3["convulsionno"];
	$femoralpulse = $res3["femoralpulse"];
	$pffits = $res3["pffits"];
	$caprefill = $res3["caprefill"];
	$apnoea = $res3["apnoea"];
	$murmur = $res3["murmur"];
	
	$query4 = "select anaemia,skin,skincold,jaundice,cansuck,gest,stiffneck,fontanelle,skull,irritable,limbs,tone,palateface,umbilicus,genitals,dysmorphic,summary from paed_genexam where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec4 = mysql_query($query4) or die(mysql_error());
	$num4 = mysql_num_rows($exec4); 
	$res4 = mysql_fetch_array($exec4);
	$anaemia = $res4["anaemia"];
	$skin = $res4["skin"];
	$skincold = $res4["skincold"];
	$jaundice = $res4["jaundice"];
	$cansuck = $res4["cansuck"];
	$gest = $res4["gest"];
	$stiffneck = $res4["stiffneck"];
	$fontanelle = $res4["fontanelle"];
	$skull = $res4["skull"];
	$irritable = $res4["irritable"];
	$limbs = $res4["limbs"];
	$tone = $res4["tone"];
	$palateface = $res4["palateface"];
	$umbilicus = $res4["umbilicus"];
	$genitals = $res4["genitals"];
	$dysmorphic = $res4["dysmorphic"];
	$summary = $res4["summary"];
	
	$query5 = "select malaria,glucose,haematology,chemistry,microbiology,hiv1,xray,other1,asphyxia,meconium,otherdiagnosis1,premature,twindelivery,newbornrds,jaundice1,otherdiagnosis2,neonatal,meningitis from paed_investigations where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec5 = mysql_query($query5) or die(mysql_error());
	$num5 = mysql_num_rows($exec5); 
	$res5 = mysql_fetch_array($exec5);
	$malaria = $res5["malaria"];
	$glucose = $res5["glucose"];
	$haematology = $res5["haematology"];
	$chemistry = $res5["chemistry"];
	$microbiology = $res5["microbiology"];
	$hiv1 = $res5["hiv1"];
	$xray = $res5["xray"];
	$other1 = $res5["other1"];
	$asphyxia = $res5["asphyxia"];
	$meconium = $res5["meconium"];
	$otherdiagnosis1 = $res5["otherdiagnosis1"];
	$premature = $res5["premature"];
	$twindelivery = $res5["twindelivery"];
	$newbornrds = $res5["newbornrds"];
	$jaundice1 = $res5["jaundice1"];
	$otherdiagnosis2 = $res5["otherdiagnosis2"];
	$neonatal = $res5["neonatal"];
	$meningitis = $res5["meningitis"];
	
	$query6 = "select vitaminkteo,arvpmtct,nutritionfeeds,oxygen,ivfluids,bloodtransfusion,incubator,phototherapy from paed_supportivecare where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysql_query($query6) or die(mysql_error());
	$num6 = mysql_num_rows($exec6); 
	$res6 = mysql_fetch_array($exec6);
	$vitaminkteo = $res6["vitaminkteo"];
	$arvpmtct = $res6["arvpmtct"];
	$nutritionfeeds = $res6["nutritionfeeds"];
	$oxygen = $res6["oxygen"];
	$ivfluids = $res6["ivfluids"];
	$bloodtransfusion = $res6["bloodtransfusion"];
	$incubator = $res6["incubator"];
	$phototherapy = $res6["phototherapy"];

	
	$query8 = "select intaketime from paed_foodintake where visitcode='$visitcode' and patientcode='$patientcode' and docno = '$docno' order by auto_number desc ";
	$exec8 = mysql_query($query8) or die(mysql_error());
	$num8 = mysql_num_rows($exec8);
	$res8 = mysql_fetch_array($exec8);
	$res8intaketime = $res8['intaketime'];
    $res8intaketime=date("g:i a",strtotime($res8intaketime));
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
}

function bbaselect(bba)
{
	if (bba.value == "1")
	{
		document.getElementById("bbayes").style.display = '';
		return false;
	}
	else
	{
	    document.getElementById("bbayes").style.display = 'none';
		return false;
	}
}
</script>
<script src="js/datetimepicker_css.js"></script>
<?php
	$query1 = "select * from master_customer where customercode='$patientcode'";
	$exec1 = mysql_query($query1) or die(mysql_error());
	$num1 = mysql_num_rows($exec1);
	$res1 = mysql_fetch_array($exec1);
	$patientname = $res1['customerfullname'];
	$gender = $res1['gender'];
	$age = $res1['age'];
	$dob = $res1['dateofbirth'];
	
	$query = "select * from ip_bedallocation where patientcode='$patientcode'";
	$exec = mysql_query($query) or die(mysql_error());
	$num = mysql_num_rows($exec);
	$res = mysql_fetch_array($exec);
	$wardid = $res['ward'];
	
	$query2 = "select * from master_ward where auto_number='$wardid'";
	$exec2 = mysql_query($query2) or die(mysql_error());
	$num2 = mysql_num_rows($exec2);
	$res2 = mysql_fetch_array($exec2);
	$ward = $res2['ward'];

?>
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
  <form name="form1" id="form1" method="post" action="paed_babyrecord.php" onSubmit="return from1submit1()">
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="93%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#E0E0E0">
          <td class="bodytext3" bgcolor="#E0E0E0" valign="middle"><strong>Baby Name*</strong></td>
          <td width="29%" class="bodytext3" align="left" valign="middle" bgcolor="#E0E0E0"><?php echo $patientname; ?></td>
          <td bgcolor="#E0E0E0" class="bodytext3" valign="middle"><strong>Date of Admission</strong></td>
          <td width="11%" bgcolor="#E0E0E0" class="bodytext3" valign="middle"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="6"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
          <td width="9%" align="left" valign="middle" class="bodytext3"><strong>Sex</strong></td>
          <td width="12%" align="left" valign="middle" class="bodytext3"><select name="sex" id="sex" value=""  tabindex="12" autocomplete="off">
            <option value="<?php echo $gender;?>"><?php echo $gender;?></option>
          </select></td>
          <td width="6%" align="left" valign="middle" class="bodytext3"><strong>IP No.</strong></td>
          <td width="7%" align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?>
		  <input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode;?>">
		  <input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>">
		  </td>
        </tr>
        <tr>
          <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>DOB</strong></td>
          <td width="29%" bgcolor="#E0E0E0" class="bodytext3"><input name="dob" id="dob" style="border: 1px solid #001E6A" value="<?php echo $dob;?>"  size="6" onKeyDown="return disableEnterKey()"/>
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('dob')" style="cursor:pointer"/></td>
          <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
          <td align="left" class="bodytext3" valign="middle"><input type="text" name="age" id="age" value="<?php echo $age;?>" size="5"></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Birth Wt.</strong></td>
          <td align="left" class="bodytext3" valign="middle"><input type="text" name="birthweight" id="birthweight" value="<?php echo $birthweight;?>" size="5" readonly></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Wt Now</strong></td>
          <td align="left" valign="middle" class="bodytext3"><input type="text" name="weightnow" id="weightnow" value="<?php echo $weightnow;?>" size="5" readonly></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Gestation</strong></td>
          <td align="left" valign="middle" class="bodytext3"><input type="text" name="gestation" id="gestation" value="<?php echo $gestation;?>" size="5" readonly></td>
          <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Temp(&deg;C)</strong></td>
		  <td colspan="1" align="left" valign="middle" class="bodytext3"><input type="text" name="temperature" id="temperature" value="<?php echo $temperature;?>" size="5" readonly></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Apgar</strong></td>
          <td align="left" valign="middle" class="bodytext3"><input type="text" name="apgar" id="apgar" value="<?php echo $apgar;?>" size="5" readonly></td>
          <td colspan="1" align="left" valign="middle" class="bodytext3"><strong>ROM</strong></td>
		  <td colspan="1" align="left" valign="middle" class="bodytext3"><input type="text" name="rom" id="rom" value="<?php echo $rom;?>" size="10" readonly></td>
        </tr>
		<tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>BBA?</strong></td>
          <td align="left" valign="middle" class="bodytext3">
			<select name="bba" id="bba" value="" tabindex="12" autocomplete="off" onChange="bbaselect(this)">
			 <option value="<?php echo $bba;?>"><?php echo $bba;?></option>
			</select>
			<select name="bbayes" id="bbayes" value=""  tabindex="12" autocomplete="off" style="display:none;">
			 <option value="<?php echo $bbayes;?>"><?php echo $bbayes;?></option>
			</select>
		  </td>
          <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Delivery</strong></td>
		  <td colspan="1" align="left" valign="middle" class="bodytext3"><select name="delivery" id="delivery" value="" tabindex="12" autocomplete="off">
			 <option value="<?php echo $delivery;?>"><?php echo $delivery;?></option>
			</select></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Resuscitation</strong></td>
          <td align="left" valign="middle" class="bodytext3"><select name="resuscitation" id="resuscitation" value=""  tabindex="12" autocomplete="off">
            <option value="<?php echo $resuscitation;?>"><?php echo $resuscitation;?></option>
          </select></td>
          <td colspan="1" align="left" valign="middle" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Given Vitamin K</strong></td>
          <td align="left" valign="middle" class="bodytext3">
			<select name="vitamink" id="vitamink" value=""  tabindex="12" autocomplete="off">
            <option value="<?php echo $vitamink;?>"><?php echo $vitamink;?></option>
          </select></td>
          <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Given Eye Prophylaxis</strong></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3"><select name="eyeprophylaxis" id="eyeprophylaxis" value=""  tabindex="12" autocomplete="off">
            <option value="<?php echo $eyeprophylaxis;?>"><?php echo $eyeprophylaxis;?></option>
          </select></td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>
      </tbody>
    </table>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="860">
			<table width="848" height="85" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			  <tr>
			   <td height="20" colspan="12" bgcolor="#CCCCCC" class="bodytext3"><strong>Mother Record</strong></td>
			   </tr>
			  <tr>
			   <td width="123" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Name</td>
			   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="mothername" id="mothername" value="<?php echo $mothername;?>" size="20" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Age</td>
			   <td width="58" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="motherage" id="motherage" value="<?php echo $motherage;?>" size="5" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">IP No.</td>
			   <td width="73" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="ipno" id="ipno" value="" size="5" readonly></td>
			   <td width="49" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td width="211" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  </tr>
			 <tr>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Residence Sublocation</td>
			  <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="residence" id="residence" value="<?php echo $residence;?>" size="20" readonly></td>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Gravidity</td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="gravidity" id="gravidity" value="<?php echo $gravidity;?>" size="5" readonly></td>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Parity</td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="parity" id="parity" value="<?php echo $parity;?>" size="5" readonly></td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			 </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">HIV</td>
			   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="hiv" id="hiv" value="" tabindex="12" autocomplete="off">
			 <option value="<?php echo $parity;?>"><?php echo $parity;?></option>
			</select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">ARVs</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="arvs" id="arvs" value="" tabindex="12" autocomplete="off">
			 <option value="<?php echo $arvs;?>"><?php echo $arvs;?></option>
			</select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">VDRL</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="vdrl" id="vdrl" value="" tabindex="12" autocomplete="off">
			 <option value="<?php echo $vdrl;?>"><?php echo $vdrl;?></option>
			</select></td>			   
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Blood Gp </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="bloodgroup" id="bloodgroup" value="<?php echo $bloodgroup;?>" size="5" readonly></td>
			 </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Fever</td>
			   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="fever" id="fever" value="" tabindex="12" autocomplete="off">
			 <option value="<?php echo $fever;?>"><?php echo $fever;?></option>
			</select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Antibiotics</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="antibiotics" id="antibiotics" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $antibiotics;?>"><?php echo $antibiotics;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diabetes</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diabetes" id="diabetes" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $diabetes;?>"><?php echo $diabetes;?></option>
               </select></td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">TB Treat</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="tbtreat" id="tbtreat" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $tbtreat;?>"><?php echo $tbtreat;?></option>
               </select></td>
			   </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Labour</td>
			   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="labour1" id="labour1" value="<?php echo $labour1;?>" size="5" readonly><input type="text" name="labour2" id="labour2" value="<?php echo $labour2;?>" size="5" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Hypertension</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="hypertension" id="hypertension" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $hypertension;?>"><?php echo $hypertension;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">APH</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="aph" id="aph" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $aph;?>"><?php echo $aph;?></option>
               </select></td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			   <tr>
			   <td height="20" colspan="12" bgcolor="#CCCCCC" class="bodytext3"><strong>Babies Presenting Problems / Mothers Problems & Relevant Drugs Pre-Admission</strong></td>
			   </tr>
			   <tr>
			   <td height="20" colspan="12" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><textarea id="babyproblem" name="babyproblem" cols="90" readonly><?php echo $babyproblem;?></textarea></td>
			   </tr>
			</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td width="860">
			<table width="848" height="85" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			  <tr>
			   <td height="20" bgcolor="#CCCCCC" class="bodytext3"><strong>Vital Signs</strong></td>
			   <td width="49" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Temp(&deg;C)			     </td>
			   <td width="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="temp" id="temp" value="<?php echo $temp;?>" size="5" readonly></td>
			   <td width="59" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Resp Rate			     </td>
			   <td width="60" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="resprate" id="resprate" value="<?php echo $resprate;?>" size="5" readonly></td>
			   <td width="31" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pulse			     </td>
			   <td width="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="pulse" id="pulse" value="<?php echo $pulse;?>" size="5" readonly></td>
			   <td width="19" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">BP			     </td>
			   <td width="111" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="bp" id="bp" value="<?php echo $bp;?>" size="5" readonly></td>
			   <td width="258" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			  <tr>
			   <td width="121" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Baby Seen </td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="babyseen" id="babyseen" value="<?php echo $babyseen;?>" size="5" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Stridor</td>
			   <td width="258" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="stridor" id="stridor" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $stridor;?>"><?php echo $stridor;?></option>
               </select></td>
			   </tr>
			 <tr>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Length of illness </td>
			  <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="lenillness" id="lenillness" value="<?php echo $lenillness;?>" size="5" readonly></td>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Oxygen Saturation </td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="oxsaturation" id="oxsaturation" value="<?php echo $oxsaturation;?>" size="5" readonly></td>
			  </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Fever - No. of days</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="feverdays" id="feverdays" value="<?php echo $feverdays;?>" size="5" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Central Cyanosis </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="cyanosis" id="cyanosis" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $cyanosis;?>"><?php echo $cyanosis;?></option>
               </select></td>			   
			   </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Difficulty Breathing</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diffbreath" id="diffbreath" value="" tabindex="12" autocomplete="off">
			 <option value="<?php echo $diffbreath;?>"><?php echo $diffbreath;?></option>
			</select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">A &amp; B </td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Indrawing</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="indrawing" id="indrawing" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $indrawing;?>"><?php echo $indrawing;?></option>
               </select></td>
			   </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diarrhoea: No. of days</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="diarrhoeadays" id="diarrhoeadays" value="<?php echo $diarrhoeadays;?>" size="5" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Grunting</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="grunting" id="grunting" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $grunting;?>"><?php echo $grunting;?></option>
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diarrhoea bloody</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diarrhoeabloody" id="diarrhoeabloody" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $diarrhoeabloody;?>"><?php echo $diarrhoeabloody;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Air Entry Bilateral </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="airentry" id="airentry" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $airentry;?>"><?php echo $airentry;?></option>
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Vomits Everything</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="vomitseverything" id="vomitseverything" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $vomitseverything;?>"><?php echo $vomitseverything;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Crackles</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="crackles" id="crackles" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $crackles;?>"><?php echo $crackles;?></option>
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Difficulty Feeding</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="difffeeding" id="difffeeding" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $difffeeding;?>"><?php echo $difffeeding;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Cry</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="cry" id="cry" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $cry;?>"><?php echo $cry;?></option>
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Convulsions No.</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="convulsionno" id="convulsionno" value="<?php echo $convulsionno;?>" size="5" readonly></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">C</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Femoral Pulse </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="femoralpulse" id="femoralpulse" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $femoralpulse;?>"><?php echo $femoralpulse;?></option>
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Partial/Focal Fits</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="pffits" id="pffits" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $pffits;?>"><?php echo $pffits;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Cap Refill</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="caprefill" id="caprefill" value="<?php echo $caprefill;?>" size="5" readonly></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Apnoea</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="apnoea" id="apnoea" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $apnoea;?>"><?php echo $apnoea;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">C</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Murmur</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="murmur" id="murmur" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $murmur;?>"><?php echo $murmur;?></option>
               </select></td>
			   </tr>
			   <tr>
			   <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>General Examination </strong></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pallor/Anaemia</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="anaemia" id="anaemia" value="<?php echo $anaemia;?>" size="5" readonly></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Skin</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="skin" id="skin" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $skin;?>"><?php echo $skin;?></option>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Skin Cold</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="skincold" id="skincold" value="" tabindex="12" autocomplete="off">
                 <option value="<?php echo $skincold;?>"><?php echo $skincold;?></option>
               </select></td>
			   </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Jaundice</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="jaundice" id="jaundice" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $jaundice;?>"><?php echo $jaundice;?></option>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Can suck/breastfeed? </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="cansuck" id="cansuck" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $cansuck;?>"><?php echo $cansuck;?></option>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Gest/Size</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="gest" id="gest" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $gest;?>"><?php echo $gest;?></option>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Stiff neck </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="stiffneck" id="stiffneck" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $stiffneck;?>"><?php echo $stiffneck;?></option>
                 </select></td>
			     </tr>
			   <tr>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Abnormalities</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Disability</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Bulging fontanelle </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="fontanelle" id="fontanelle" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $fontanelle;?>"><?php echo $fontanelle;?></option>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Skull</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="skull" id="skull" value="<?php echo $skull;?>" size="20" readonly></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Irritable</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="irritable" id="irritable" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $irritable;?>"><?php echo $irritable;?></option>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Limbs/Spine</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="limbs" id="limbs" value="<?php echo $limbs;?>" size="20" readonly></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reduced movement/tone</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="tone" id="tone" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $tone;?>"><?php echo $tone;?></option>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Palate/Face</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="palateface" id="palateface" value="<?php echo $palateface;?>" size="20" readonly></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Umbilicus</strong></td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="umbilicus" id="umbilicus" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $umbilicus;?>"><?php echo $umbilicus;?></option>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Genitals/Anus</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="genitals" id="genitals" value="<?php echo $genitals;?>" size="20" readonly></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Dysmorphic</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="dysmorphic" id="dysmorphic" value="<?php echo $dysmorphic;?>" size="20" readonly></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Summary</strong></td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><textarea id="summary" name="summary" cols="90" readonly><?php echo $summary;?></textarea></td>
			     </tr>
			  </tbody>
			  </table>
			</td>
		</tr>
		<tr>
		 <td width="860">
		   <table width="703" height="85" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			  <tr>
			     <td colspan="7" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Investigations Ordered - record results in medical record</strong></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Malaria</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="malaria" id="malaria" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $malaria;?>"><?php echo $malaria;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Glucose</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="glucose" id="glucose" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $glucose;?>"><?php echo $glucose;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Haematology</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="haematology" id="haematology" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $haematology;?>"><?php echo $haematology;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Chemistry</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="chemistry" id="chemistry" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $chemistry;?>"><?php echo $chemistry;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Microbiology</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="microbiology" id="microbiology" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $microbiology;?>"><?php echo $microbiology;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">HIV</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="hiv1" id="hiv1" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $hiv1;?>"><?php echo $hiv1;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">X-Ray</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="xray" id="xray" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $xray;?>"><?php echo $xray;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Other</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="other1" id="other1" value="<?php echo $other1;?>" size="20" readonly></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="7" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Admission Diagnosis - Select &quot;1&quot; for primary diagnosis and &quot;2&quot; for any secondary diagnosis </strong></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Birth asphyxia </td>
			     <td width="78" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="asphyxia" id="asphyxia" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $asphyxia;?>"><?php echo $asphyxia;?></option>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Meconium aspiration </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="meconium" id="meconium" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $meconium;?>"><?php echo $meconium;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Other diagnosis 1 </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="otherdiagnosis1" id="otherdiagnosis1" value="<?php echo $otherdiagnosis1;?>" size="20" readonly></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Premature/LBW</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="premature" id="premature" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $premature;?>"><?php echo $premature;?></option>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Twin delivery </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="twindelivery" id="twindelivery" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $twindelivery;?>"><?php echo $twindelivery;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Newborn RDS</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="newbornrds" id="newbornrds" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $newbornrds;?>"><?php echo $newbornrds;?></option>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Jaundice</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="jaundice1" id="jaundice1" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $jaundice1;?>"><?php echo $jaundice1;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Other diagnosis 1</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="otherdiagnosis2" id="otherdiagnosis2" value="<?php echo $otherdiagnosis2;?>" size="20"></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Neonatal sepsis </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="neonatal" id="neonatal" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $neonatal;?>"><?php echo $neonatal;?></option>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Meningitis</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="meningitis" id="meningitis" value="" tabindex="12" autocomplete="off">
                   <option value="<?php echo $meningitis;?>"><?php echo $meningitis;?></option>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			</tbody>
		   </table>
		  </td>
		 </tr>
		<tr>
		 <td width="860">
		  <table width="703" height="85" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			   <tbody>
			   <tr>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Supportive Care - indicate what care you are providing a plan for and sign please </strong></td>
			   </tr>
			    <tr>
			     <td width="129" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Vitamin K &amp; TEO </td>
			     <td width="29" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="vitaminkteo" <?php if($vitaminkteo == '1') echo 'checked'; ?> onClick="return false;"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">ARVs for PMTCT </td>
			     <td width="423" colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="arvpmtct" <?php if($arvpmtct == '1') echo 'checked'; ?> onClick="return false;"></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Nutrition/Feeds</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="nutritionfeeds" <?php if($nutritionfeeds == '1') echo 'checked'; ?> onClick="return false;"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Oxygen</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="oxygen" <?php if($oxygen == '1') echo 'checked'; ?> onClick="return false;"></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">IV fluids </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="ivfluids" <?php if($ivfluids == '1') echo 'checked'; ?> onClick="return false;"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Blood transfusion </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="bloodtransfusion" <?php if($bloodtransfusion == '1') echo 'checked'; ?> onClick="return false;"></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Incubator/Keep warm </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="incubator" <?php if($incubator == '1') echo 'checked'; ?> onClick="return false;"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Phototherapy</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="phototherapy" <?php if($phototherapy == '1') echo 'checked'; ?> onClick="return false;"></td>
			     </tr>
			   <tr>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Results of Investigations</strong></td>
			     </tr>
			   </tbody>
			  </table>
		 </td>
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

