<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$recorddate = date('Y-m-d');

if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["patientcode"])) {  $patientcode1 = $_REQUEST["patientcode"]; } else { $patientcode1 = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode1 = $_REQUEST["visitcode"]; } else { $visitcode1 = ""; }
if (isset($_REQUEST["docno"])) { $docno1 = $_REQUEST["docno"]; } else { $docno1 = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == "frmflag1")
{
	$docno = $_REQUEST["docno"];
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$refhospital = $_REQUEST["refhospital"];
	$refhospitalyes='';
	if($refhospital=='1')
	 {
	   $refhospitalyes = $_REQUEST["refhospitalyes"];
	 }
	$readmission = $_REQUEST["readmission"];
	$residence = $_REQUEST["residence"];
	$complaints = $_REQUEST["complaints"];
	$timeseen = $_REQUEST["timeseen"];
	$vaccines = $_REQUEST["vaccines"];
	$weight = $_REQUEST["weight"];
	$height = $_REQUEST["height"];
	$whz = $_REQUEST["whz"];
	$muac = $_REQUEST["muac"];
	
	$temp = $_REQUEST["temp"];
	$resprate = $_REQUEST["resprate"];
	$pulse = $_REQUEST["pulse"];
	$bp = $_REQUEST["bp"];
	$lenillness = $_REQUEST["lenillness"];
	$stridor = $_REQUEST["stridor"];
	$feverdays = $_REQUEST["feverdays"];
	$oxsaturation = $_REQUEST["oxsaturation"];
	$coughdays = $_REQUEST["coughdays"];
	$cyanosis = $_REQUEST["cyanosis"];
	$coughweek = $_REQUEST["coughweek"];
	$indrawing = $_REQUEST["indrawing"];
	$diffbreath = $_REQUEST["diffbreath"];
	$grunting = $_REQUEST["grunting"];
	$diarrhoeadays = $_REQUEST["diarrhoeadays"];
	$acidotic = $_REQUEST["acidotic"];
	$diarrhoea14 = $_REQUEST["diarrhoea14"];
	$wheeze = $_REQUEST["wheeze"];
	$diarrhoeabloody = $_REQUEST["diarrhoeabloody"];
	$crackles = $_REQUEST["crackles"];
	$vomitseverything = $_REQUEST["vomitseverything"];
	$peripulse = $_REQUEST["peripulse"];
	$difffeeding = $_REQUEST["difffeeding"];   
	$caprefill = $_REQUEST["caprefill"];
	$convulsionno = $_REQUEST["convulsionno"];
	$anaemia = $_REQUEST["anaemia"];
	$anaemia1 = $_REQUEST["anaemia1"];
	$pffits = $_REQUEST["pffits"];
	$skinwarm = $_REQUEST["skinwarm"];
	$treatment = $_REQUEST["treatment"];
	$sunkeneye = $_REQUEST["sunkeneye"];
	$pinch = $_REQUEST["pinch"];
	
	$clubbing = $_REQUEST["clubbing"];
	$avpu = $_REQUEST["avpu"];
	$thrush = $_REQUEST["thrush"];
	$cansuck = $_REQUEST["cansuck"];
	$lymphnode = $_REQUEST["lymphnode"];
	$stiffneck = $_REQUEST["stiffneck"];
	$jaundice = $_REQUEST["jaundice"];
	$fontanelle = $_REQUEST["fontanelle"];
	$severewaste = $_REQUEST["severewaste"];
	$irritable = $_REQUEST["irritable"];
	$oedema = $_REQUEST["oedema"];
	$tone = $_REQUEST["tone"];
	$summary = $_REQUEST["summary"];
	
	$malaria = $_REQUEST["malaria"];
	$glucose = $_REQUEST["glucose"];
	$haematology = $_REQUEST["haematology"];
	$chemistry = $_REQUEST["chemistry"];
	$microbiology = $_REQUEST["microbiology"];
	$hiv = $_REQUEST["hiv"];
	$xray = $_REQUEST["xray"];
	$other = $_REQUEST["other"];
	$malaria1 = $_REQUEST["malaria1"];
	$smalaria = $_REQUEST["smalaria"];
	$anaemia = $_REQUEST["anaemia"];
	$sanaemia = $_REQUEST["sanaemia"];
	$pneumonia = $_REQUEST["pneumonia"];
	$spneumonia = $_REQUEST["spneumonia"];
	$meningitis = $_REQUEST["meningitis"];
	$diarrhoea = $_REQUEST["diarrhoea"];
	$sdiarrhoea = $_REQUEST["sdiarrhoea"];
	$neonatal = $_REQUEST["neonatal"];
	$dehydration = $_REQUEST["dehydration"];
	$sdehydration = $_REQUEST["sdehydration"];
	$asphyxia = $_REQUEST["asphyxia"];
	$hiv1 = $_REQUEST["hiv1"];
	$shiv1 = $_REQUEST["shiv1"];
	$lbw = $_REQUEST["lbw"];
	$malnutrition = $_REQUEST["malnutrition"];
	$smalnutrition = $_REQUEST["smalnutrition"];
	$burns = $_REQUEST["burns"];
	$other1 = $_REQUEST["other1"];
	$other2 = $_REQUEST["other2"];
	
	$warm = isset($_REQUEST["warm"])? 1 : 0;
	$oxygen = isset($_REQUEST["oxygen"])? 1 : 0;
	$ivfluids = isset($_REQUEST["ivfluids"])? 1 : 0;
	$bloodtransfusion = isset($_REQUEST["bloodtransfusion"])? 1 : 0;
	$vitamina = isset($_REQUEST["vitamina"])? 1 : 0;
	$nutritionfeeds = isset($_REQUEST["nutritionfeeds"])? 1 : 0;
	
	
		
if($docno1=='')
{
	$paynowbillprefix = 'PAD-';  
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select docno from paed_admexamination order by auto_number desc";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2billnumber = $res2["docno"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='PAD-'.'1';
	$docno=$billnumber;
	$openingbalance = '0.00';
}
else
{
	$res2billnumber = $res2["docno"];
	$billnumbercode = substr($res2billnumber,$paynowbillprefix1, $billdigit);
	
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumber = 'PAD-' .$maxanum;
	$docno=$billnumber;
	$openingbalance = '0.00';
	
}
}
else

{
	 $docno=$docno1; 
}
	
	$querys="select * from paed_admexamination where patientcode='$patientcode' and visitcode='$visitcode'";
	$execs = mysql_query($querys) or die("Query1".mysql_error());
	$rows=mysql_num_rows($execs);
	

	if($rows > 0  )
	{
	 $query1=" update paed_admexamination set docno='$docno',patientcode='$patientcode',visitcode='$visitcode',refhospital='$refhospital',refhospitalyes='$refhospitalyes',readmission='$readmission',residence='$residence',complaints='$complaints',timeseen='$timeseen',vaccines='$vaccines',weight='$weight',height='$height',whz='$whz',muac='$muac',recorddate='$recorddate',username='$username' where   patientcode='$patientcode' and visitcode='$visitcode'   ";
	 $exec1 = mysql_query($query1) or die("Query1".mysql_error());
	
	$query2=" update paed_admvitalsigns set docno='$docno',patientcode='$patientcode',visitcode='$visitcode',temp='$temp',resprate='$resprate',pulse='$pulse',bp='$bp',lenillness='$lenillness',stridor='$stridor',feverdays='$feverdays',oxsaturation='$oxsaturation',coughdays='$coughdays',cyanosis='$cyanosis',coughweek='$coughweek',indrawing='$indrawing',diffbreath='$diffbreath',grunting='$grunting',diarrhoeadays='$diarrhoeadays',acidotic='$acidotic',diarrhoea14='$diarrhoea14',wheeze='$wheeze',diarrhoeabloody='$diarrhoeabloody',crackles='$crackles',vomitseverything='$vomitseverything',peripulse='$peripulse',difffeeding='$difffeeding',caprefill='$caprefill',convulsionno='$convulsionno',anaemia='$anaemia',pffits='$pffits',skinwarm='$skinwarm',treatment='$treatment',sunkeneye='$sunkeneye',pinch='$pinch',recorddate='$recorddate',username='$username' where   patientcode='$patientcode' and visitcode='$visitcode'   ";
	$exec2 = mysql_query($query2) or die("Query2".mysql_error());
	
	$query3=" update paed_admgenexam set docno='$docno',patientcode='$patientcode',visitcode='$visitcode',clubbing='$clubbing',avpu='$avpu',thrush='$thrush',cansuck='$cansuck',lymphnode='$lymphnode',stiffneck='$stiffneck',jaundice='$jaundice',fontanelle='$fontanelle',severewaste='$severewaste',irritable='$irritable',oedema='$oedema',tone='$tone',summary='$summary',recorddate='$recorddate',username='$username' where   patientcode='$patientcode' and visitcode='$visitcode'  ";
	$exec3 = mysql_query($query3) or die("Query3".mysql_error());
	
	$query4=" update paed_adminvestigations set docno='$docno',patientcode='$patientcode',visitcode='$visitcode',malaria='$malaria',glucose='$glucose',haematology='$haematology',chemistry='$chemistry',microbiology='$microbiology',hiv='$hiv',xray='$xray',other='$other',malaria1='$malaria1',smalaria='$smalaria',anaemia='$anaemia1',sanaemia='$sanaemia',pneumonia='$pneumonia',spneumonia='$spneumonia',meningitis='$meningitis',diarrhoea='$diarrhoea',sdiarrhoea='$sdiarrhoea',neonatal='$neonatal',dehydration='$dehydration',sdehydration='$sdehydration',asphyxia='$asphyxia',malnutrition='$malnutrition',smalnutrition='$smalnutrition',lbw='$lbw',hiv1='$hiv1',shiv1='$shiv1',burns='$burns',other1='$other1',other2='$other2',recorddate='$recorddate',username='$username' where   patientcode='$patientcode' and visitcode='$visitcode'    ";
	$exec4 = mysql_query($query4) or die("Query4".mysql_error());
	
	
	$query5=" update paed_admsupportivecare set docno='$docno',patientcode='$patientcode',visitcode='$visitcode',warm='$warm',oxygen='$oxygen',ivfluids='$ivfluids',bloodtransfusion='$bloodtransfusion',vitamina='$vitamina',nutritionfeeds='$nutritionfeeds',recorddate='$recorddate',username='$username'  where   patientcode='$patientcode' and visitcode='$visitcode'   ";
	$exec5 = mysql_query($query5) or die("Query5".mysql_error());
	}
	else
	
	{
	$query1 = "insert into paed_admexamination(docno,patientcode,visitcode,refhospital,refhospitalyes,readmission,residence,complaints,timeseen,vaccines,weight,height,whz,muac,recorddate,username) 	values('$docno','$patientcode','$visitcode','$refhospital','$refhospitalyes','$readmission','$residence','$complaints','$timeseen','$vaccines','$weight','$height','$whz','$muac','$transactiondatefrom','$username')";
	$exec1 = mysql_query($query1) or die("Query1".mysql_error());
	
	$query2 = "insert into paed_admvitalsigns(docno,patientcode,visitcode,temp,resprate,pulse,bp,lenillness,stridor,feverdays,oxsaturation,coughdays,cyanosis,coughweek,indrawing,diffbreath,grunting,diarrhoeadays,acidotic,diarrhoea14,wheeze,diarrhoeabloody,crackles,vomitseverything,peripulse,difffeeding,caprefill,convulsionno,anaemia,pffits,skinwarm,treatment,sunkeneye,pinch,recorddate,username) values('$docno','$patientcode','$visitcode','$temp','$resprate','$pulse','$bp','$lenillness','$stridor','$feverdays','$oxsaturation','$coughdays','$cyanosis','$coughweek','$indrawing','$diffbreath','$grunting','$diarrhoeadays','$acidotic','$diarrhoea14','$wheeze','$diarrhoeabloody','$crackles','$vomitseverything','$peripulse','$difffeeding','$caprefill','$convulsionno','$anaemia','$pffits','$skinwarm','$treatment','$sunkeneye','$pinch','$transactiondatefrom','$username')";
	$exec2 = mysql_query($query2) or die("Query2".mysql_error());
	
	$query3 = "insert into paed_admgenexam(docno,patientcode,visitcode,clubbing,avpu,thrush,cansuck,lymphnode,stiffneck,jaundice,fontanelle,severewaste,irritable,oedema,tone,summary,recorddate,username) values('$docno','$patientcode','$visitcode','$clubbing','$avpu','$thrush','$cansuck','$lymphnode','$stiffneck','$jaundice','$fontanelle','$severewaste','$irritable','$oedema','$tone','$summary','$transactiondatefrom','$username')"; 
	$exec3 = mysql_query($query3) or die("Query3".mysql_error());
	
	$query4 = "insert into paed_adminvestigations(docno,patientcode,visitcode,malaria,glucose,haematology,chemistry,microbiology,hiv,xray,other,malaria1,smalaria,anaemia,sanaemia,pneumonia,spneumonia,meningitis,diarrhoea,sdiarrhoea,neonatal,dehydration,sdehydration,asphyxia,malnutrition,smalnutrition,lbw,hiv1,shiv1,burns,other1,other2,recorddate,username) values('$docno','$patientcode','$visitcode','$malaria','$glucose','$haematology','$chemistry','$microbiology','$hiv','$xray','$other','$malaria1','$smalaria','$anaemia1','$sanaemia','$pneumonia','$spneumonia','$meningitis','$diarrhoea','$sdiarrhoea','$neonatal','$dehydration','$sdehydration','$asphyxia','$malnutrition','$smalnutrition','$lbw','$hiv1','$shiv1','$burns','$other1','$other2','$transactiondatefrom','$username')";  
	$exec4 = mysql_query($query4) or die("Query4".mysql_error());
	
	$query5 = "insert into paed_admsupportivecare(docno,patientcode,visitcode,warm,oxygen,ivfluids,bloodtransfusion,vitamina,nutritionfeeds,recorddate,username) values('$docno','$patientcode','$visitcode','$warm','$oxygen','$ivfluids','$bloodtransfusion','$vitamina','$nutritionfeeds','$transactiondatefrom','$username')";   
	$exec5 = mysql_query($query5) or die("Query5".mysql_error());
	
	
}
header("location:peadiatricactivity.php");
}
if ($visitcode1!='' && $patientcode1!=''  )
{

	$query6 = "select * from paed_admexamination where patientcode='$patientcode1' and visitcode='$visitcode1' and docno = '$docno1'";
	$exec6 = mysql_query($query6) or die(mysql_error());
	$nums6 = mysql_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysql_fetch_array($exec6);
		$res6refhospital = $res6["refhospital"];
		if($res6refhospital=='0') { $res6refhospital='No'; }
		if($res6refhospital=='1') { $res6refhospital='Yes'; }
		$res6refhospitalyes = $res6["refhospitalyes"];
		$res6readmission = $res6["readmission"];
		if($res6readmission=='0') { $res6readmission='No'; }
		if($res6readmission=='1') { $res6readmission='Yes'; }
		$res6residence = $res6["residence"];
		$res6complaints = $res6["complaints"];
		$res6timeseen = $res6["timeseen"];
		$res6vaccines = $res6["vaccines"];
		$res6weight = $res6["weight"];
		$res6height = $res6["height"];
		$res6whz = $res6["whz"];
		$res6muac = $res6["muac"];
	}
	else
	{
		$res6refhospital = '';
		$res6refhospitalyes = '';
		$res6readmission = '';
		$res6residence = '';
		$res6complaints = '';
		$res6timeseen = '';
		$res6vaccines = '';
		$res6weight = '';
		$res6height = '';
		$res6whz = '';
		$res6muac = '';
	}
	
	$query7 = "select * from paed_admvitalsigns where patientcode='$patientcode1' and visitcode='$visitcode1' and docno = '$docno1'";
	$exec7 = mysql_query($query7) or die(mysql_error());
	$nums7 = mysql_num_rows($exec7);
	if($nums7 > 0)
	{
		$res7 = mysql_fetch_array($exec7);
		$res7temp = $res7["temp"];
		$res7resprate = $res7["resprate"];
		$res7pulse = $res7["pulse"];
		$res7bp = $res7["bp"];
		$res7lenillness = $res7["lenillness"];
		$res7stridor = $res7["stridor"];
		$res7feverdays = $res7["feverdays"];
		$res7oxsaturation = $res7["oxsaturation"];
		$res7coughdays = $res7["coughdays"];
		$res7cyanosis = $res7["cyanosis"];
		$res7coughweek = $res7["coughweek"];
		$res7indrawing = $res7["indrawing"];
		$res7diffbreath = $res7["diffbreath"];
		$res7grunting = $res7["grunting"];
		$res7diarrhoeadays = $res7["diarrhoeadays"];
		$res7acidotic = $res7["acidotic"];
		$res7diarrhoea14 = $res7["diarrhoea14"];
		$res7wheeze = $res7["wheeze"];
		$res7diarrhoeabloody = $res7["diarrhoeabloody"];
		$res7crackles = $res7["crackles"];
		$res7vomitseverything = $res7["vomitseverything"];
		$res7peripulse = $res7["peripulse"];
		$res7difffeeding = $res7["difffeeding"];   
		$res7caprefill = $res7["caprefill"];
		$res7convulsionno = $res7["convulsionno"];
		$res7anaemia = $res7["anaemia"];
		$res7pffits = $res7["pffits"];
		$res7skinwarm = $res7["skinwarm"];
		$res7treatment = $res7["treatment"];
		$res7sunkeneye = $res7["sunkeneye"];
		$res7pinch = $res7["pinch"];
	}
	else
	{
		$res7temp = '';
		$res7resprate = '';
		$res7pulse = '';
		$res7bp = '';
		$res7lenillness = '';
		$res7stridor = '';
		$res7feverdays = '';
		$res7oxsaturation = '';
		$res7coughdays = '';
		$res7cyanosis = '';
		$res7coughweek = '';
		$res7indrawing = '';
		$res7diffbreath = '';
		$res7grunting = '';
		$res7diarrhoeadays = '';
		$res7acidotic = '';
		$res7diarrhoea14 = '';
		$res7wheeze = '';
		$res7diarrhoeabloody = '';
		$res7crackles = '';
		$res7vomitseverything = '';
		$res7peripulse = '';
		$res7difffeeding = '';
		$res7caprefill = '';
		$res7convulsionno = '';
		$res7anaemia = '';
		$res7pffits = '';
		$res7skinwarm = '';
		$res7treatment = '';
		$res7sunkeneye = '';
		$res7pinch = '';
	}
	
	
	$query8 = "select * from paed_admgenexam where patientcode='$patientcode1' and visitcode='$visitcode1' and docno = '$docno1'";
	$exec8 = mysql_query($query8) or die(mysql_error());
	$nums8 = mysql_num_rows($exec8);
	if($nums8 > 0)
	{
		$res8 = mysql_fetch_array($exec8);
		$res8clubbing = $res8["clubbing"];
		$res8avpu = $res8["avpu"];
		$res8thrush = $res8["thrush"];
		$res8cansuck = $res8["cansuck"];
		$res8lymphnode = $res8["lymphnode"];
		$res8stiffneck = $res8["stiffneck"];
		$res8jaundice = $res8["jaundice"];
		$res8fontanelle = $res8["fontanelle"];
		$res8severewaste = $res8["severewaste"];
		$res8irritable = $res8["irritable"];
		$res8oedema = $res8["oedema"];
		$res8tone = $res8["tone"];
		$res8summary = $res8["summary"];
	}
	else
	{
		$clubbing = '';
		$res8avpu = '';
		$res8thrush = '';
		$res8cansuck = '';
		$res8lymphnode = '';
		$res8stiffneck = '';
		$res8jaundice = '';
		$res8fontanelle = '';
		$res8severewaste = '';
		$res8irritable = '';
		$res8oedema = '';
		$res8tone = '';
		$res8summary = '';
	}
	
	$query9 = "select * from paed_adminvestigations where patientcode='$patientcode1' and visitcode='$visitcode1' and docno = '$docno1'";
	$exec9 = mysql_query($query9) or die(mysql_error());
	$nums9 = mysql_num_rows($exec9);
	if($nums9 > 0)
	{
		$res9 = mysql_fetch_array($exec9);
		$res9malaria = $res9["malaria"];
		$res9glucose = $res9["glucose"];
		$res9haematology = $res9["haematology"];
		$res9chemistry = $res9["chemistry"];
		$res9microbiology = $res9["microbiology"];
		$res9hiv = $res9["hiv"];
		$res9xray = $res9["xray"];
		$res9other = $res9["other"];
		$res9malaria1 = $res9["malaria1"];
		$res9smalaria = $res9["smalaria"];
		$res9anaemia = $res9["anaemia"];
		$res9sanaemia = $res9["sanaemia"];
		$res9pneumonia = $res9["pneumonia"];
		$res9spneumonia = $res9["spneumonia"];
		$res9meningitis = $res9["meningitis"];
		$res9diarrhoea = $res9["diarrhoea"];
		$res9sdiarrhoea = $res9["sdiarrhoea"];
		$res9neonatal = $res9["neonatal"];
		$res9dehydration = $res9["dehydration"];
		$res9sdehydration = $res9["sdehydration"];
		$res9asphyxia = $res9["asphyxia"];
		$res9malnutrition = $res9["malnutrition"];
		$res9smalnutrition = $res9["smalnutrition"];
		$res9lbw = $res9["lbw"];
		$res9hiv1 = $res9["hiv1"];
		$res9shiv1 = $res9["shiv1"];
		$res9burns = $res9["burns"];
		$res9other1 = $res9["other1"];
		$res9other2 = $res9["other2"];
	}
	else
	{
		$res9malaria = '';
		$res9glucose = '';
		$res9haematology = '';
		$res9chemistry = '';
		$res9microbiology = '';
		$res9hiv = '';
		$res9xray = '';
		$res9other = '';
		$res9malaria1 = '';
		$res9smalaria = '';
		$res9anaemia = '';
		$res9sanaemia = '';
		$res9pneumonia = '';
		$res9spneumonia = '';
		$res9meningitis = '';
		$res9diarrhoea = '';
		$res9sdiarrhoea = '';
		$res9neonatal = '';
		$res9dehydration = '';
		$res9sdehydration = '';
		$res9asphyxia = '';
		$res9malnutrition = '';
		$res9smalnutrition = '';
		$res9lbw = '';
		$res9hiv1 = '';
		$res9shiv1 = '';
		$res9burns = '';
		$res9other1 = '';
		$res9other2 = '';
	}
	
	$query10 = "select warm,oxygen,ivfluids,bloodtransfusion,vitamina,nutritionfeeds from paed_admsupportivecare where patientcode='$patientcode1' and visitcode='$visitcode1' and docno = '$docno1'";
	$exec10 = mysql_query($query10) or die(mysql_error());
	$nums10 = mysql_num_rows($exec10);
	if($nums10 > 0)
	{
		$res10 = mysql_fetch_array($exec10);
		$res10warm = $res10["warm"];
		$res10oxygen = $res10["oxygen"];
		$res10ivfluids = $res10["ivfluids"];
		$res10bloodtransfusion = $res10["bloodtransfusion"];
		$res10vitamina = $res10["vitamina"];
		$res10nutritionfeeds = $res10["nutritionfeeds"];
	}
	else
	{
		$res10warm = '';
		$res10oxygen = '';
		$res10ivfluids = '';
		$res10bloodtransfusion = '';
		$res10vitamina = '';
		$res10nutritionfeeds = '';
	}


	if($docno1=='')
{
	$paynowbillprefix = 'PAD-';  
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select docno from paed_admexamination order by auto_number desc";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2billnumber = $res2["docno"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='PAD-'.'1';
	$docno=$billnumber;
	$openingbalance = '0.00';
}
else
{
	$res2billnumber = $res2["docno"];
	$billnumbercode = substr($res2billnumber,$paynowbillprefix1, $billdigit);
	
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumber = 'PAD-' .$maxanum;
	$docno=$billnumber;
	$openingbalance = '0.00';
	
}
}
else

{
	 $docno=$docno1; 
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

function refselect(ref)
{
	if (ref.value == "1")
	{
		document.getElementById("refhospitalyes").style.display = '';
		return false;
	}
	else
	{
	    document.getElementById("refhospitalyes").style.display = 'none';
		return false;
	}
}
</script>
<script src="js/datetimepicker_css.js"></script>

<?php 

	$query1 = "select * from master_customer where customercode='$patientcode1'";
	$exec1 = mysql_query($query1) or die(mysql_error());
	$num1 = mysql_num_rows($exec1);
	$res1 = mysql_fetch_array($exec1);
	$patientname = $res1['customerfullname'];
	$gender = $res1['gender'];
	$age = $res1['age'];
	$dob = $res1['dateofbirth'];
	
	$query = "select * from ip_bedallocation where patientcode='$patientcode1'";
	$exec = mysql_query($query) or die(mysql_error());
	$num = mysql_num_rows($exec);
	$res = mysql_fetch_array($exec);
	$wardid = $res['ward'];
	
	$query2 = "select ward from master_ward where auto_number='$wardid'";
	$exec2 = mysql_query($query2) or die(mysql_error());
	$num2 = mysql_num_rows($exec2);
	$res2 = mysql_fetch_array($exec2);
	$ward = $res2['ward'];
	
	$query23 = "select registrationdate from master_ipvisitentry where patientcode='$patientcode1' and visitcode='$visitcode1'";
	$exec23 = mysql_query($query23) or die(mysql_error());
	$num23 = mysql_num_rows($exec23);
	$res23 = mysql_fetch_array($exec23);
	$registrationdate = $res23['registrationdate'];
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
  <form name="form1" id="form1" method="post" action="paed_admissionrecordview.php" onSubmit="return from1submit1()">
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="93%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
       <tbody>
        <tr bgcolor="#E0E0E0">
          <td class="bodytext3" bgcolor="#E0E0E0" valign="middle"><strong>Name*</strong></td>
          <td width="28%" colspan="4" align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3"><?php echo $patientname; ?>
		  <input type="hidden" name="patientcode" value="<?php echo $patientcode1; ?>"></td>
          <td bgcolor="#E0E0E0" class="bodytext3" valign="middle"><strong>Date of Admission</strong></td>
          <td width="11%" bgcolor="#E0E0E0" class="bodytext3" valign="middle">
		  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $registrationdate; ?>" size="6"  readonly onKeyDown="return disableEnterKey()" />
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
          <td width="9%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="14%" align="left" valign="middle" class="bodytext3"><strong><input type="text" name="ward2" id="ward2" value="<?php echo $ward; ?>" size="15"></strong></td>
          <td width="5%" align="left" valign="middle" class="bodytext3"><strong>IP No.</strong></td>
          <td width="10%" align="left" valign="middle" class="bodytext3"><?php echo $visitcode1; ?>
		  <input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode1;?>">
		  <input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>"></td>
          <input type="hidden" name="docno1" id="docno1" value="<?php echo $docno1;?>">
        </tr>
        <tr>
          <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>DOB</strong></td>
          <td width="28%" colspan="4" bgcolor="#E0E0E0" class="bodytext3">
		  <input name="dob" id="dob" style="border: 1px solid #001E6A" value="<?php echo $dob;?>" size="6" onKeyDown="return disableEnterKey()"/>
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dob')" style="cursor:pointer"/></td>
          <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
          <td align="left" class="bodytext3" valign="middle"><input type="text" name="age" id="age" value="<?php echo $age; ?>" size="5"></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Sex</strong></td>
          <td align="left" class="bodytext3" valign="middle"><select name="sex" id="sex" value=""  tabindex="12" autocomplete="off">
        <?php 
			 	
			 	if($gender=='Female')
				{
					$gen='1';
				}
				else
				{
					$gen='0';
				}
				?>
                 <option value="<?php echo $gen; ?>"><?php echo $gender ?></option>
               
          </select></td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
		
		<tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Referred to hospital </strong></td>
          <td colspan="4" align="left" valign="middle" class="bodytext3">
			<select name="refhospital" id="refhospital" value="" tabindex="12" autocomplete="off" onChange="refselect(this)" ="">
			
             <?php
			if($res6refhospital!='')
			{
				if($res6refhospital==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res6refhospital;?>"><?php echo $val;?></option>
            <?php
			if($res6refhospital==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?> 
			</select>
			<select name="refhospitalyes" id="refhospitalyes" value=""  tabindex="12" autocomplete="off" <?php if($res6refhospitalyes=='') { ?> style="display:none;" <?php } ?> ="">
			 
                  <?php
			if($res6refhospitalyes!='')
			{
				
				
			?>
				<option value="<?php echo $res6refhospitalyes;?>"><?php echo $res6refhospitalyes;?></option>
            <?php
			if($res6refhospitalyes=='Other Facility')
			{
			 	
                echo '<option value="Other Hospital">Other Hospital</option>';
                	
			}
			else
			{
				echo '<option value="Other Facility">Other Facility</option>';
			}
			}
			else
			{
			?>
			 
         		<option value="Other Hospital">Other Hospital</option>
			 <option value="Other Facility">Other Facility</option>
             <?php
             }
            ?> 
             
             
			</select></td>
          <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Re-admission to this hospital? </strong></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3"><select name="readmission" id="readmission" value=""  tabindex="12" autocomplete="off">
           
              <?php
			if($res6readmission!='')
			{
				if($res6readmission==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res6readmission;?>"><?php echo $val;?></option>
            <?php
			if($res6readmission==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?> 
            
          </select></td>
          <td align="left" valign="top" class="bodytext3"><strong>Residence Sub-location</strong></td>
          <td align="left" valign="top" class="bodytext3"><input type="text" name="residence" id="residence" value="<?php echo $res6residence; ?>" size="20" ></td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>
		<tr>
		  <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Presenting Complaints 
		    <input type="text" name="complaints" id="complaints" value="<?php echo $res6complaints; ?>" size="20" ></strong></td>
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
			<table width="848" height="51" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			   <tr>
			   <td height="20" colspan="15" bgcolor="#CCCCCC" class="bodytext3"><strong>History &amp; Examination </strong></td>
			   </tr>
			   <tr>
			     <td width="14%" height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Seen</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="timeseen" id="timeseen" value="<?php echo $res6timeseen; ?>" size="5"></td>
			     <td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Vaccines</td>
			     <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="vaccines" id="vaccines" value=""  tabindex="12" autocomplete="off" ="">
            
            
             <?php
			if($res6vaccines!='')
			{
			?>
				<option value="<?php echo $res6vaccines;?>"><?php echo $res6vaccines;?></option>
            <?php
			if($res6vaccines=='OPV/Penta X')
			{
			 	
              	echo '<option value="Measles">Measles</option>';
				echo '<option value="Pneumo X">Pneumo X</option>';
				echo '<option value="BCG">BCG</option>';
			}
			else if($res6vaccines=='Pneumo X')
			{
				echo '<option value="OPV/Penta X">OPV/Penta X</option>';
				echo '<option value="Measles">Measles</option>';
				echo '<option value="BCG">BCG</option>';
			}
			else if($res6vaccines=='BCG')
			{
				echo '<option value="OPV/Penta X">OPV/Penta X</option>';
				echo '<option value="Pneumo X">Pneumo X</option>';
				echo '<option value="Measles">Measles</option>';
			}
			else
			{
				echo '<option value="OPV/Penta X">OPV/Penta X</option>';
				echo '<option value="Pneumo X">Pneumo X</option>';
				echo '<option value="BCG">BCG</option>';
			}
			}
			else
			{
			?>
			 
             <option value="OPV/Penta X">OPV/Penta X</option>
            <option value="Pneumo X">Pneumo X</option>
			<option value="BCG">BCG</option>
			<option value="Measles">Measles</option>
             <?php
             }
            ?>
            
           
          </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Weight</td>
			     <td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="weight" id="weight" value="<?php echo $res6weight; ?>" size="5" ></td>
			     <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Height/Length</td>
			     <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="height" id="height" value="<?php echo $res6height; ?>" size="5" ></td>
			     <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">WHZ</td>
			     <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="whz" id="whz" value="<?php echo $res6whz; ?>" size="5" ></td>
			     <td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">MUAC</td>
			     <td width="23%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="muac" id="muac" value="<?php echo $res6muac; ?>" size="5" ></td>
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
			   <td width="49" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Temp(&deg;C)</td>
			   <td width="33" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="temp" id="temp" value="<?php echo $res7temp; ?>" size="5" ></td>
			   <td width="57" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Resp Rate</td>
			   <td width="34" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="resprate" id="resprate" value="<?php echo $res7resprate; ?>" size="5" ></td>
			   <td width="27" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pulse</td>
			   <td width="90" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="pulse" id="pulse" value="<?php echo $res7pulse; ?>" size="5" ></td>
			   <td width="14" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">BP</td>
			   <td width="118" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="bp" id="bp" value="<?php echo $res7bp; ?>" size="5" ></td>
			   <td width="225" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			  <tr>
			   <td width="121" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Length of illness</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="lenillness" id="lenillness" value="<?php echo $res7lenillness; ?>" size="5" ></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Stridor</td>
			   <td width="225" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="stridor" id="stridor" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res7stridor!='')
			{
				if($res7stridor==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7stridor;?>"><?php echo $val;?></option>
            <?php
			if($res7stridor==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?> 
               </select></td>
			   </tr>
			 <tr>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Fever - No. of days</td>
			  <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="feverdays" id="feverdays" value="<?php echo $res7feverdays; ?>" size="5" ></td>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Oxygen Saturation </td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="oxsaturation" id="oxsaturation" value="<?php echo $res7oxsaturation; ?>" size="5" ></td>
			  </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Cough - No. of days</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="coughdays" id="coughdays" value="<?php echo $res7coughdays; ?>" size="5" ></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Central Cyanosis </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="cyanosis" id="cyanosis" value="" tabindex="12" autocomplete="off" ="">
                 
                  <?php
			if($res7cyanosis!='')
			{
				if($res7cyanosis==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7cyanosis;?>"><?php echo $val;?></option>
            <?php
			if($res7cyanosis==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>			   
			   </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Cough &gt; 2 weeks </td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="coughweek" id="coughweek" value="" tabindex="12" autocomplete="off">
                  
                  <?php
			if($res7coughweek!='')
			{
				if($res7coughweek==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7coughweek;?>"><?php echo $val;?></option>
            <?php
			if($res7coughweek==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>A &amp; B</strong></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Indrawing</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="indrawing" id="indrawing" value="" tabindex="12" autocomplete="off" ="">
                
                 
                  <?php
			if($res7indrawing!='')
			{
			?>
				 <option value="<?php echo $res7indrawing;?>"><?php echo $res7indrawing;?></option>
            <?php
			if($res7indrawing=='None/mild')
			{
			 	
              echo '<option value="Severe">Severe</option>';
			  echo '<option value="Sternum">Sternum</option>';
                	
			}
			else if($res7indrawing=='Severe')
			{
			  echo '<option value="None/mild">None/mild</option>';
			  echo '<option value="Sternum">Sternum</option>';
			}
			else
			{
			  echo '<option value="None/mild">None/mild</option>';
			  echo '<option value="Severe">Severe</option>';
			}
			}
			else
			{
			?>
             	<option value="None/mild">None/mild</option>
                 <option value="Severe">Severe</option>
				 <option value="Sternum">Sternum</option>
            <?php 
			}
			?>
                 
               </select></td>
			   </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Difficulty Breathing</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diffbreath" id="diffbreath" value="" tabindex="12" autocomplete="off" ="">
			
              <?php
			if($res7diffbreath!='')
			{
				if($res7diffbreath==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7diffbreath;?>"><?php echo $val;?></option>
            <?php
			if($res7diffbreath==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
             
			</select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Grunting</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="grunting" id="grunting" value="" tabindex="12" autocomplete="off" ="">
                 
                  <?php
			if($res7grunting!='')
			{
				if($res7grunting==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7grunting;?>"><?php echo $val;?></option>
            <?php
			if($res7grunting==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 
               </select></td>
			   </tr>
			 <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diarrhoea: No. of days</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="diarrhoeadays" id="diarrhoeadays" value="<?php echo $res7diarrhoeadays; ?>" size="5" ></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Acidotic Breathing</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="acidotic" id="acidotic" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res7acidotic!='')
			{
				if($res7acidotic==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7acidotic;?>"><?php echo $val;?></option>
            <?php
			if($res7acidotic==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diarrhoea &gt; 14d </td>
			      <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diarrhoea14" id="diarrhoea14" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res7diarrhoea14!='')
			{
				if($res7diarrhoea14==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7diarrhoea14;?>"><?php echo $val;?></option>
            <?php
			if($res7diarrhoea14==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Wheeze</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="wheeze" id="wheeze" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res7wheeze!='')
			{
				if($res7wheeze==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7wheeze;?>"><?php echo $val;?></option>
            <?php
			if($res7wheeze==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			     </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diarrhoea bloody</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diarrhoeabloody" id="diarrhoeabloody" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res7diarrhoeabloody!='')
			{
				if($res7diarrhoeabloody==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7diarrhoeabloody;?>"><?php echo $val;?></option>
            <?php
			if($res7diarrhoeabloody==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Crackles</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="crackles" id="crackles" value="" tabindex="12" autocomplete="off" ="">
                 
                  <?php
			if($res7crackles!='')
			{
				if($res7crackles==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7crackles;?>"><?php echo $val;?></option>
            <?php
			if($res7crackles==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Vomits Everything</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="vomitseverything" id="vomitseverything" value="" tabindex="12" autocomplete="off" ="">
                 
                  <?php
			if($res7vomitseverything!='')
			{
				if($res7vomitseverything==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7vomitseverything;?>"><?php echo $val;?></option>
            <?php
			if($res7vomitseverything==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Peripheral Pulse </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="peripulse" id="peripulse" value="" tabindex="12" autocomplete="off" ="">
                 
                  <?php
			if($res7peripulse!='')
			{
				
				
			?>
				<option value="<?php echo $res7peripulse;?>"><?php echo $res7peripulse;?></option>
            <?php
			if($res7peripulse=='Normal')
			{
			 	
                echo '<option value="Weak">Weak</option>';
                	
			}
			else
			{
				echo '<option value="Normal">Normal</option>';
			}
			}
			else
			{
			?>
			 
         		  <option value="Normal">Normal</option>
			     <option value="Weak">Weak</option>
             <?php
             }
            ?> 
                 
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Difficulty Feeding</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="difffeeding" id="difffeeding" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res7difffeeding!='')
			{
				if($res7difffeeding==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7difffeeding;?>"><?php echo $val;?></option>
            <?php
			if($res7difffeeding==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Cap Refill</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="caprefill" id="caprefill" value="<?php echo $res7caprefill; ?>" size="5" ></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Convulsions No.</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="convulsionno" id="convulsionno" value="<?php echo $res7convulsionno; ?>" size="5" ></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>C &amp; Dehydr'n </strong></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pallor/Anaemia</td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="anaemia" id="anaemia" value="<?php echo $res7anaemia; ?>" size="5" ></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Partial/Focal Fits</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="pffits" id="pffits" value="" tabindex="12" autocomplete="off" ="">
                 
                 
                  <?php
			if($res7pffits!='')
			{
				if($res7pffits==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7pffits;?>"><?php echo $val;?></option>
            <?php
			if($res7pffits==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Skin Warm </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="skinwarm" id="skinwarm" value="" tabindex="12" autocomplete="off" ="">
                
                      <?php
			if($res7skinwarm!='')
			{
			?>
				 <option value="<?php echo $res7skinwarm;?>"><?php echo $res7skinwarm;?></option>
            <?php
			if($res7skinwarm=='Hand')
			{
			 	
              echo '<option value="Elbow">Elbow</option>';
			  echo '<option value="Shoulder">Shoulder</option>';
                	
			}
			else if($res7skinwarm=='Elbow')
			{
			  echo '<option value="Hand">Hand</option>';
			  echo '<option value="Shoulder">Shoulder</option>';
			}
			else
			{
			  echo '<option value="Hand">Hand</option>';
			  echo '<option value="Elbow">Elbow</option>';
			}
			}
			else
			{
			?>
             	   <option value="Hand">Hand</option>
                 <option value="Elbow">Elbow</option>
				 <option value="Shoulder">Shoulder</option>
            <?php 
			}
			?>
                 
                
               </select></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Treatment given: </td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="treatment" id="treatment" value="<?php echo $res7treatment; ?>" size="5" ></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp; </td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Sunken Eyes </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="sunkeneye" id="sunkeneye" value="" tabindex="12" autocomplete="off" ="">
                
                   <?php
			if($res7sunkeneye!='')
			{
				if($res7sunkeneye==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res7sunkeneye;?>"><?php echo $val;?></option>
            <?php
			if($res7sunkeneye==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   </tr>
			   <tr>
			   <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>General Examination</strong></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Skin Pinch </td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="pinch" id="pinch" value="<?php echo $res7pinch; ?>" size="5" ></td>
			   </tr>
			   <tr>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Clubbing</td>
			   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="clubbing" id="clubbing" value="" tabindex="12" autocomplete="off" ="">
                
                   <?php
			if($res8clubbing!='')
			{
				if($res8clubbing==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8clubbing;?>"><?php echo $val;?></option>
            <?php
			if($res8clubbing==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
               </select></td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>AVPU</strong></td>
			   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="avpu" id="avpu" value="" tabindex="12" autocomplete="off" ="">
                
                  <?php
			if($res8avpu!='')
			{
			?>
				 <option value="<?php echo $res8avpu;?>"><?php echo $res8avpu;?></option>
            <?php
			if($res8avpu=='A')
			{
			 	
              echo '<option value="P">P</option>';
			  echo '<option value="U">U</option>';
			  echo '<option value="V">V</option>';
                	
			}
			else if($res8avpu=='V')
			{
			  echo '<option value="P">P</option>';
			  echo '<option value="U">U</option>';
			  echo '<option value="A">A</option>';
			}
			else if($res8avpu=='P')
			{
			  echo '<option value="A">A</option>';
			  echo '<option value="U">U</option>';
			  echo '<option value="V">V</option>';
			}
			else
			{
			  echo '<option value="P">P</option>';
			  echo '<option value="A">A</option>';
			  echo '<option value="V">V</option>';
			}
			}
			else
			{
			?>   <option value="A">A</option>
                 <option value="V">V</option>
				 <option value="P">P</option>
				 <option value="U">U</option>
            <?php 
			}
			?>
                 
                 
                 
               </select></td>
			   </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Thrush</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="thrush" id="thrush" value="" tabindex="12" autocomplete="off" ="">
                 
                   <?php
			if($res8thrush!='')
			{
				if($res8thrush==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8thrush;?>"><?php echo $val;?></option>
            <?php
			if($res8thrush==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Disability</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Can drink/breastfeed? </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="cansuck" id="cansuck" value="" tabindex="12" autocomplete="off" ="">
                  
                   <?php
			if($res8cansuck!='')
			{
				if($res8cansuck==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8cansuck;?>"><?php echo $val;?></option>
            <?php
			if($res8cansuck==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Lymph Nodes &gt; 1 </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="lymphnode" id="lymphnode" value="" tabindex="12" autocomplete="off" ="">
                  
                      <?php
			if($res8lymphnode!='')
			{
			?>
				 <option value="<?php echo $res8lymphnode;?>"><?php echo $res8lymphnode;?></option>
            <?php
			if($res8lymphnode=='Normal')
			{
			 	
              echo '<option value="Prem">Prem</option>';
			  echo '<option value="SGA/wasted">SGA/wasted</option>';
                	
			}
			else if($res8lymphnode=='Prem')
			{
			  echo '<option value="Normal">Normal</option>';
			  echo '<option value="SGA/wasted">SGA/wasted</option>';
			}
			else
			{
			  echo '<option value="Normal">Normal</option>';
			  echo '<option value="Prem">Prem</option>';
			}
			}
			else
			{
			?>
             	  <option value="Normal">Normal</option>
                   <option value="Prem">Prem</option>
				   <option value="SGA/wasted">SGA/wasted</option>
            <?php 
			}
			?>
                   
                   
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Stiff neck </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="stiffneck" id="stiffneck" value="" tabindex="12" autocomplete="off" ="">
                   
                     <?php
			if($res8stiffneck!='')
			{
				if($res8stiffneck==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8stiffneck;?>"><?php echo $val;?></option>
            <?php
			if($res8stiffneck==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Jaundice</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="jaundice" id="jaundice" value="" tabindex="12" autocomplete="off" ="">
                   
                     <?php
			if($res8jaundice!='')
			{
			?>
				 <option value="<?php echo $res8jaundice;?>"><?php echo $res8jaundice;?></option>
            <?php
			if($res8jaundice=='0')
			{
			 	
              echo '<option value="+">+</option>';
			  echo '<option value="+++">+++</option>';
                	
			}
			else if($res8jaundice=='+')
			{
			  echo '<option value="0">0</option>';
			  echo '<option value="+++">+++</option>';
			}
			else
			{
			  echo '<option value="+">+</option>';
			  echo '<option value="0">0</option>';
			}
			}
			else
			{
			?>
             	  <option value="0">0</option>
                   <option value="+">+</option>
				   <option value="+++">+++</option>
            <?php 
			}
			?>
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Bulging fontanelle </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="fontanelle" id="fontanelle" value="" tabindex="12" autocomplete="off" ="">
                 
                    <?php
			if($res8fontanelle!='')
			{
				if($res8fontanelle==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8fontanelle;?>"><?php echo $val;?></option>
            <?php
			if($res8fontanelle==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Visible severe wasting </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="severewaste" id="severewaste" value="<?php echo $res8severewaste; ?>" size="20" ></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>If young infant &lt; 2m </strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Irritable</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="irritable" id="irritable" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res8irritable!='')
			{
				if($res8irritable==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8irritable;?>"><?php echo $val;?></option>
            <?php
			if($res8irritable==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Oedema</td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="oedema" id="oedema" value="" tabindex="12" autocomplete="off" ="">
                  
                   
                     <?php
			if($res8oedema!='')
			{
			?>
				 <option value="<?php echo $res8oedema;?>"><?php echo $res8oedema;?></option>
            <?php
			if($res8oedema=='None')
			{
			 	
              echo '<option value="Foot">Foot</option>';
			  echo '<option value="Knee">Knee</option>';
			  echo '<option value="Face">Face</option>';
                	
			}
			else if($res8oedema=='Foot')
			{
			  echo '<option value="None">None</option>';
			  echo '<option value="Knee">Knee</option>';
			  echo '<option value="Face">Face</option>';
                	
			}
			else if($res8oedema=='Knee')
			{
			  echo '<option value="None">None</option>';
			  echo '<option value="Foot">Foot</option>';
			  echo '<option value="Face">Face</option>';
                	
			}
			else
			{
			  echo '<option value="Foot">Foot</option>';
			  echo '<option value="Knee">Knee</option>';
			  echo '<option value="None">None</option>';
                	
			}
			}
			else
			{
			?>
                    <option value="None">None</option>
                   <option value="Foot">Foot</option>
				   <option value="Knee">Knee</option>
				   <option value="Face">Face</option>
                   
                    <?php 
			}
			?>
                   
                 </select></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reduced movement/tone</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="tone" id="tone" value="" tabindex="12" autocomplete="off" ="">
                 
                   <?php
			if($res8tone!='')
			{
				if($res8tone==1)
				{
				   $val='Yes';
				}
				else
				{
					$val='No';
				}
				
			?>
				<option value="<?php echo $res8tone;?>"><?php echo $val;?></option>
            <?php
			if($res8tone==0)
			{
			 	
                echo '<option value="1">Yes</option>';
                	
			}
			else
			{
				echo '<option value="0">No</option>';
			}
			}
			else
			{
			?>
			 
             <option value="0">No</option>
			 <option value="1">Yes</option>
             <?php
             }
            ?>
                 </select></td>
			   </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Summary</strong></td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><textarea id="summary" name="summary" cols="90" ><?php echo $res8summary; ?></textarea></td>
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
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Investigations Ordered - record results in medical record</strong></td>
			     </tr>
			   <tr>
			     <td width="63" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Malaria</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="malaria" id="malaria" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res9malaria!='')
			{
				
				
			?>
				<option value="<?php echo $res9malaria;?>"><?php echo $res9malaria;?></option>
            <?php
			if($res9malaria=='Blood Slide')
			{
			 	
                echo '<option value="Rapid Test">Rapid Test</option>';
                	
			}
			else
			{
				echo '<option value="Blood Slide">Blood Slide</option>';
			}
			}
			else
			{
			?>
			 
         		 <option value="Blood Slide">Blood Slide</option>
                   <option value="Rapid Test">Rapid Test</option>
             <?php
             }
            ?> 
             
                   
                 </select></td>
			     <td width="81" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Glucose</td>
			     <td width="359" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="glucose" id="glucose" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res9glucose!='')
			{
				
				
			?>
				<option value="<?php echo $res9glucose;?>"><?php echo $res9glucose;?></option>
            <?php
			if($res9glucose=='Sick Test')
			{
			 	
                echo '<option value="Laboratory">Laboratory</option>';
                	
			}
			else
			{
				echo '<option value="Sick Test">Sick Test</option>';
			}
			}
			else
			{
			?>
			 
         		 <option value="Sick Test">Sick Test</option>
                   <option value="Laboratory">Laboratory</option>
             <?php
             }
            ?> 
                   
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Haematology</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="haematology" id="haematology" value="" tabindex="12" autocomplete="off" ="">
                                      
                       <?php
			if($res9haematology!='')
			{
				
				
			?>
				<option value="<?php echo $res9haematology;?>"><?php echo $res9haematology;?></option>
            <?php
			if($res9haematology=='Full Haemogram')
			{
			 	
                echo '<option value="Hb">Hb</option>';
				echo '<option value="HCT">HCT</option>';
                	
			}
			else if($res9haematology=='Hb')
			{
				echo '<option value="Full Haemogram">Full Haemogram</option>';
				echo '<option value="HCT">HCT</option>';
			}
			else
			{
				echo '<option value="Hb">Hb</option>';
				echo '<option value="Full Haemogram">Full Haemogram</option>';
			}
			}
			else
			{
			?>
			 
         		 <option value="Hb">Hb</option>
                   <option value="HCT">HCT</option>
				   <option value="Full Haemogram">Full Haemogram</option>
             <?php
             }
            ?> 
                   
                   
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Chemistry</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="chemistry" id="chemistry" value="" tabindex="12" autocomplete="off" ="">
                   
              <?php
			if($res9chemistry!='')
			{
			?>
				<option value="<?php echo $res9chemistry;?>"><?php echo $res9chemistry;?></option>
            <?php
			if($res9chemistry=='Na + K')
			{
			 	
              echo '<option value="Urea">Urea</option>';
			  echo '<option value="Creat">Creat</option>';
			  echo '<option value="Alb">Alb</option>';
			  echo '<option value="LFT">LFT</option>';
                	
			}
			else if($res9chemistry=='Urea')
			{
			  echo '<option value="Na + K">Na + K</option>';
			  echo '<option value="Creat">Creat</option>';
			  echo '<option value="Alb">Alb</option>';
			  echo '<option value="LFT">LFT</option>';
			}
			else if($res9chemistry=='Creat')
			{
				echo '<option value="Urea">Urea</option>';
			  echo '<option value="Na + K">Na + K</option>';
			  echo '<option value="Alb">Alb</option>';
			  echo '<option value="LFT">LFT</option>';
			}
			else if($res9chemistry=='Alb')
			{
			  echo '<option value="Urea">Urea</option>';
			  echo '<option value="Na + K">Na + K</option>';
			  echo '<option value="Creat">Creat</option>';
			  echo '<option value="LFT">LFT</option>';
			}
			else
			{
			  echo '<option value="Urea">Urea</option>';
			  echo '<option value="Alb">Alb</option>';
			  echo '<option value="Creat">Creat</option>';
			  echo '<option value="Na + K">Na + K</option>';
			}
			}
			else
			{
			?>
             
             
             		<option value="Na + K">Na + K</option>
                   <option value="Urea">Urea</option>
				   <option value="Creat">Creat</option>
				   <option value="Alb">Alb</option>
				   <option value="LFT">LFT</option>
             
             <?php 
			}
			 ?>
                   
                   
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Microbiology</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="microbiology" id="microbiology" value="" tabindex="12" autocomplete="off" ="">
                   
                   
                    <?php
			if($res9microbiology!='')
			{
				
				
			?>
				<option value="<?php echo $res9microbiology;?>"><?php echo $res9microbiology;?></option>
            <?php
			if($res9microbiology=='Blood Cult')
			{
			 	
                echo '<option value="Lumbar Punct">Lumbar Punct</option>';
                	
			}
			else
			{
				echo '<option value="Blood Cult">Blood Cult</option>';
			}
			}
			else
			{
			?>
			 
         		 <option value="Lumbar Punct">Lumbar Punct</option>
                   <option value="Blood Cult">Blood Cult</option>
             <?php
             }
            ?> 
                   
                    
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">HIV</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="hiv" id="hiv" value="" tabindex="12" autocomplete="off" ="">
                  
                     <?php
			if($res9hiv!='')
			{
				
				
			?>
				<option value="<?php echo $res9hiv;?>"><?php echo $res9hiv;?></option>
            <?php
			if($res9hiv=='Rapid Test')
			{
			 	
                echo '<option value="PCR">PCR</option>';
                	
			}
			else
			{
				echo '<option value="Rapid Test">Rapid Test</option>';
			}
			}
			else
			{
			?>
			 
         		<option value="Rapid Test">Rapid Test</option>
                   <option value="PCR">PCR</option>
             <?php
             }
            ?> 
                    
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">X-Ray</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="xray" id="xray" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res9xray!='')
			{
			?>
				 <option value="<?php echo $res9xray;?>"><?php echo $res9xray;?></option>
            <?php
			if($res9xray=='CXR')
			{
			 	
              echo '<option value="Other">Other</option>';
			  echo '<option value="AXR">AXR</option>';
                	
			}
			else if($res9xray=='AXR')
			{
			 echo '<option value="CXR">CXR</option>';
			  echo '<option value="Other">Other</option>';
                	
			}
			else
			{
			  echo '<option value="CXR">CXR</option>';
			  echo '<option value="AXR">AXR</option>';
                	
			}
			}
			else
			{
			?>
                     <option value="CXR">CXR</option>
                   <option value="AXR">AXR</option>
				   <option value="Other">Other</option>
                   
                    <?php 
			}
			?>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Other</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="other" id="other" value="<?php echo $res9other; ?>" size="20" ></td>
			     </tr>
			   <tr>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Admission Diagnosis - Select &quot;1&quot; for primary diagnosis and &quot;2&quot; for any secondary diagnosis </strong></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Malaria</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="malaria1" id="malaria1" value="" tabindex="12" autocomplete="off" ="">
                  
                      <?php
			if($res9malaria1!='')
			{
				
			?>
				<option value="<?php echo $res9malaria1;?>"><?php echo $res9malaria1;?></option>
            <?php
			if($res9malaria1==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                   
                 </select>	
                 <select name="smalaria" id="smalaria" value="" tabindex="12" autocomplete="off" ="">
                     
                         <?php
			if($res9smalaria!='')
			{
				
			?>
				<option value="<?php echo $res9smalaria;?>"><?php echo $res9smalaria;?></option>
            <?php
			if($res9smalaria=='Non-Sev')
			{
			 	
                echo '<option value="Sev">Sev</option>';
                	
			}
			else
			{
				echo '<option value="Non-Sev">Non-Sev</option>';
			}
			}
			else
			{
			?>
			 
           		<option value="Non-Sev">Non-Sev</option>
			         <option value="Sev">Sev</option>
             <?php
             }
            ?>
                     
                                    </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Anaemia</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="anaemia1" id="anaemia1" value="" tabindex="12" autocomplete="off" ="">
                  
                        <?php
			if($res9anaemia!='')
			{
				
			?>
				<option value="<?php echo $res9anaemia;?>"><?php echo $res9anaemia;?></option>
            <?php
			if($res9anaemia==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select>
			       <select name="sanaemia" id="sanaemia" value="" tabindex="12" autocomplete="off" ="">
                    
                      <?php
			if($res9sanaemia!='')
			{
				
			?>
				<option value="<?php echo $res9sanaemia;?>"><?php echo $res9sanaemia;?></option>
            <?php
			if($res9sanaemia=='Non-Sev')
			{
			 	
                echo '<option value="Sev">Sev</option>';
                	
			}
			else
			{
				echo '<option value="Non-Sev">Non-Sev</option>';
			}
			}
			else
			{
			?>
			 
           		<option value="Non-Sev">Non-Sev</option>
			         <option value="Sev">Sev</option>
             <?php
             }
            ?>
                   </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Pneumonia</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="pneumonia" id="pneumonia" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res9pneumonia!='')
			{
				
			?>
				<option value="<?php echo $res9pneumonia;?>"><?php echo $res9pneumonia;?></option>
            <?php
			if($res9pneumonia==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select>			       <select name="spneumonia" id="spneumonia" value="" tabindex="12" autocomplete="off" ="">
                     
                      <?php
			if($res9spneumonia!='')
			{
				
			?>
				<option value="<?php echo $res9spneumonia;?>"><?php echo $res9spneumonia;?></option>
            <?php
			if($res9spneumonia=='Non-Sev')
			{
			 	
                echo '<option value="Sev">Sev</option>';                	
			    echo '<option value="V.Sev">V.Sev</option>';
			}
			else if($res9spneumonia=='V.Sev')
			{
				echo '<option value="Non-Sev">Non-Sev</option>';
				echo '<option value="Sev">Sev</option>';
			}
			else
			{
				echo '<option value="Non-Sev">Non-Sev</option>';
				echo '<option value="V.Sev">V.Sev</option>';
			}
			}
			else
			{
			?>
			 
           		 	<option value="Non-Sev">Non-Sev</option>
			         <option value="Sev">Sev</option>
			         <option value="V.Sev">V.Sev</option>
             <?php
             }
            ?>
                     
                     
                    
                                    </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Meningitis</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="meningitis" id="meningitis" value="" tabindex="12" autocomplete="off" ="">
                  
                   <?php
			if($res9meningitis!='')
			{
				
			?>
				<option value="<?php echo $res9meningitis;?>"><?php echo $res9meningitis;?></option>
            <?php
			if($res9meningitis==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diarrhoea</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="diarrhoea" id="diarrhoea" value="" tabindex="12" autocomplete="off" ="">
                  
                     <?php
			if($res9diarrhoea!='')
			{
				
			?>
				<option value="<?php echo $res9diarrhoea;?>"><?php echo $res9diarrhoea;?></option>
            <?php
			if($res9diarrhoea==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select>			       <select name="sdiarrhoea" id="sdiarrhoea" value="" tabindex="12" autocomplete="off" ="">
                     
                        <?php
			if($res9sdiarrhoea!='')
			{
				
			?>
				<option value="<?php echo $res9sdiarrhoea;?>"><?php echo $res9sdiarrhoea;?></option>
            <?php
			if($res9sdiarrhoea=='Non-bloody')
			{
			 	
                echo '<option value="Bloody">Bloody</option>';
                	
			}
			else
			{
				echo '<option value="Non-bloody">Non-bloody</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="Non-bloody">Non-bloody</option>
                     <option value="Non-bloody">Bloody</option>
             <?php
             }
            ?>
                     
                    
                                    </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Neonatal Sepsis </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="neonatal" id="neonatal" value="" tabindex="12" autocomplete="off" ="">
                   
                     <?php
			if($res9neonatal!='')
			{
				
			?>
				<option value="<?php echo $res9neonatal;?>"><?php echo $res9neonatal;?></option>
            <?php
			if($res9neonatal==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Dehydration</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="dehydration" id="dehydration" value="" tabindex="12" autocomplete="off" ="">
                  
                    <?php
			if($res9dehydration!='')
			{
				
			?>
				<option value="<?php echo $res9dehydration;?>"><?php echo $res9dehydration;?></option>
            <?php
			if($res9dehydration==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select>			       <select name="sdehydration" id="sdehydration" value="" tabindex="12" autocomplete="off">
			         
                        <?php
			if($res9sdehydration!='')
			{
				
			?>
				<option value="<?php echo $res9sdehydration;?>"><?php echo $res9sdehydration;?></option>
            <?php
			if($res9sdehydration=='Some')
			{
			 	
                echo '<option value="Severe">Severe</option>';
                	
			}
			else
			{
				echo '<option value="Some">Some</option>';
			}
			}
			else
			{
			?>
			 		 <option value="Some">Some</option>
			         <option value="Severe">Severe</option>
             <?php
             }
            ?>
                     
                    
		              </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Birth Asphyxia </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="asphyxia" id="asphyxia" value="" tabindex="12" autocomplete="off" ="">
                  
                   <?php
			if($res9asphyxia!='')
			{
				
			?>
				<option value="<?php echo $res9asphyxia;?>"><?php echo $res9asphyxia;?></option>
            <?php
			if($res9asphyxia==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Malnutrition</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="malnutrition" id="malnutrition" value="" tabindex="12" autocomplete="off" ="">
                   
                     <?php
			if($res9malnutrition!='')
			{
				
			?>
				<option value="<?php echo $res9malnutrition;?>"><?php echo $res9malnutrition;?></option>
            <?php
			if($res9malnutrition==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select>			       <select name="smalnutrition" id="smalnutrition" value="" tabindex="12" autocomplete="off" ="">
                    
                      <?php
			if($res9smalnutrition!='')
			{
				
			?>
				<option value="<?php echo $res9smalnutrition;?>"><?php echo $res9smalnutrition;?></option>
            <?php
			if($res9smalnutrition=='Kwash')
			{
			 	
                echo '<option value="Marasm">Marasm</option>';                	
			    echo '<option value="M.Kwash">M.Kwash</option>';
			}
			else if($res9smalnutrition=='Marasm')
			{
				echo '<option value="Kwash">Kwash</option>';                	
			    echo '<option value="M.Kwash">M.Kwash</option>';
			}
			else
			{
				echo '<option value="Marasm">Marasm</option>';                	
			    echo '<option value="Kwash">Kwash</option>';
			}
			}
			else
			{
			?>
			 
           		 	 <option value="Kwash">Kwash</option>
                     <option value="Marasm">Marasm</option>
                     <option value="M.Kwash">M.Kwash</option>
             <?php
             }
            ?>
                     
                     
                                    </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Prematurity/LBW</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="lbw" id="lbw" value="" tabindex="12" autocomplete="off" ="">
                   
                   <?php
			if($res9lbw!='')
			{
				
			?>
				<option value="<?php echo $res9lbw;?>"><?php echo $res9lbw;?></option>
            <?php
			if($res9lbw==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">HIV</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="hiv1" id="hiv1" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res9hiv1!='')
			{
				
			?>
				<option value="<?php echo $res9hiv1;?>"><?php echo $res9hiv1;?></option>
            <?php
			if($res9hiv1==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
            </select>
            <select name="shiv1" id="shiv1" value="" tabindex="12" autocomplete="off">
            
            
               <?php
			if($res9shiv1!='')
			{
				
			?>
				<option value="<?php echo $res9shiv1;?>"><?php echo $res9shiv1;?></option>
            <?php
			if($res9shiv1=='Negative')
			{
			 	
                echo '<option value="Positive">Positive</option>';                	
			    echo '<option value="Declined PITC">Declined PITC</option>';
			}
			else if($res9shiv1=='Positive')
			{
				echo '<option value="Negative">Negative</option>';                	
			    echo '<option value="Declined PITC">Declined PITC</option>';
			}
			else
			{
				echo '<option value="Positive">Positive</option>';                	
			    echo '<option value="Negative">Negative</option>';
			}
			}
			else
			{
			?>
			 
           		 	 <option value="Negative">Negative</option>
                   <option value="Positive">Positive</option>
				   <option value="Declined PITC">Declined PITC</option>
             <?php
             }
            ?>
            
            
                   
                 </select></td>
            
            
                 
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Burns</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="burns" id="burns" value="" tabindex="12" autocomplete="off" ="">
                                      
                    <?php
			if($res9burns!='')
			{
				
			?>
				<option value="<?php echo $res9burns;?>"><?php echo $res9burns;?></option>
            <?php
			if($res9burns==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
			     </tr>
			   
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Other 1</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="other1" id="other1" value="" tabindex="12" autocomplete="off" ="">
                   
                    <?php
			if($res9other1!='')
			{
				
			?>
				<option value="<?php echo $res9other1;?>"><?php echo $res9other1;?></option>
            <?php
			if($res9other1==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Other 2</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="other2" id="other2" value="" tabindex="12" autocomplete="off" ="">
                  
                    <?php
			if($res9other2!='')
			{
				
			?>
				<option value="<?php echo $res9other2;?>"><?php echo $res9other2;?></option>
            <?php
			if($res9other2==2)
			{
			 	
                echo '<option value="1">1</option>';
                	
			}
			else
			{
				echo '<option value="2">2</option>';
			}
			}
			else
			{
			?>
			 
           		 <option value="1">1</option>
                   <option value="2">2</option>
             <?php
             }
            ?>
                 </select></td>
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
			     <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Supportive Care & Observations - indicate what is needed</strong></td>
			   </tr>
			    <tr>
			     <td width="97" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Keep warm </td>
			     <td width="20" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="warm" <?php if($res10warm == '1') echo 'checked'; ?> value="1" ></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Oxygen</td>
			     <td width="446" colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="oxygen" <?php if($res10oxygen == '1') echo 'checked'; ?> value="1"></td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">IV / Oral fluids plan </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="ivfluids" <?php if($res10ivfluids == '1') echo 'checked'; ?> value="1" ></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Blood transfusion </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="bloodtransfusion" <?php if($res10bloodtransfusion == '1') echo 'checked'; ?> value="1"></td>
			   </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Vitamin A </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="vitamina" <?php if($res10vitamina == '1') echo 'checked'; ?> value="1"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Nutrition / Feeds plan </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="checkbox" name="nutritionfeeds" <?php if($res10nutritionfeeds == '1') echo 'checked'; ?> value="1"></td>
			   </tr>
			   </tbody>
			  </table>
		 </td>
		</tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
		  <input type="hidden" name="frmflag1" value="frmflag1" />
          <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
          <input name="Submit222" type="submit"  value="Save Record" class="button"/>
		  </td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

