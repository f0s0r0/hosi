<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$sno = '';

ob_start();

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
$itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';
?>

<style>
.bodytext31{ font-size:13px; }
.bodytext27{ font-size:12px; }
</style>

<?php 
if($itemcode==""){
$query341 = "select * from consultation_lab where patientvisitcode= '$visitcode' and resultentry = 'completed' 

and consultationdate between '$fromdate' and '$todate' order by auto_number";

}else{
$query341 = "select * from consultation_lab where billnumber = '$billnumber' and resultentry = 'completed' and 

consultationdate between '$fromdate' and '$todate' and labitemcode='$itemcode'   order by auto_number";
}
$exec341 = mysql_query($query341) or die(mysql_error());
while($res341 = mysql_fetch_array($exec341))
{
 $labitemcode34 = $res341['labitemcode'];


$query612 = "select * from consultation_lab where patientvisitcode= '$visitcode' and labitemcode = 

'$labitemcode34' order by auto_number desc";
$exec612 = mysql_query($query612) or die(mysql_error());
$res612 = mysql_fetch_array($exec612);
$orderedby = $res612['username'];
$patientname=$res612['patientname'];
$patientcode=$res612['patientcode'];
$accountname=$res612['accountname'];
$accountcode=$res612['accountcode'];
$doctor=$res612['doctor'];
$locationname=$res612['locationname'];
$docnumber=$res612['resultdoc'];
$samplecollectedon1=$res612['consultationdate'];
$samplecollectedon2=$res612['consultationtime'];
$samplecollectedon=$samplecollectedon1.' '.$samplecollectedon2;
//$dob = $res612['dateofbirth'];
$billdatetime = $res612['sampledatetime'];
$sampleid = $res612['sampleid'];
$res38publisheddatetime = $res612['publishdatetime'];

$query613 = "select * from resultentry_lab where patientname = '$patientname' and patientvisitcode = 

'$visitcode' order by auto_number desc";
$exec613 = mysql_query($query613) or die(mysql_error());
$res613 = mysql_fetch_array($exec613);
$docno = $res613['docnumber'];


$query123 = "select * from samplecollection_lab where patientcode = '$patientcode' and patientname = 

'$patientname' order by auto_number desc";
$exec123 = mysql_query($query123) or die(mysql_error());
$res123 = mysql_fetch_array($exec123);
$res123recordtime=$res123['recordtime'];
$res123recorddate=$res123['recorddate'];
 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$faxnumber1 = $res2["faxnumber1"];
$cstnumber1 = $res2["cstnumber"];

$location= $locationname;

$query8="select * from master_employee where username = '$username' ";
$exec8=mysql_query($query8);
$num8=mysql_num_rows($exec8);
$res8=mysql_fetch_array($exec8);
$res8jobdescription=$res8['employeename'];

$query77 = "select * from consultation_lab where resultdoc = '$docnumber'";
$exec77=mysql_query($query77) or die(mysql_error());
$res77=mysql_fetch_array($exec77);
$locationcode=$res78['locationcode'];

$query771 = "select * from billing_external where billno = '$billnumber'";
$exec771=mysql_query($query771) or die(mysql_error());
$res771=mysql_fetch_array($exec771);
$patientage=$res771['age'];
$patientgender=$res771['gender'];
$dob = '0000-00-00';

if($patientgender==""){
$query771 = "select age,gender from master_visitentry where visitcode = '$visitcode'";
$exec771=mysql_query($query771) or die(mysql_error());
$res771=mysql_fetch_array($exec771);
$patientage=$res771['age'];
$patientgender=$res771['gender'];
}

$query771 = "select area from master_customer where customercode = '$patientcode'";
$exec771=mysql_query($query771) or die(mysql_error());
$res771=mysql_fetch_array($exec771);
$area12=$res771['area'];

$query771 = "select username from master_consultation where patientcode = '$patientcode' and patientvisitcode = 

'$visitcode'";
$exec771=mysql_query($query771) or die(mysql_error());
$res771=mysql_fetch_array($exec771);
$doctor=$res771['username'];


if($dob != '0000-00-00')
{
	$today = new DateTime();
    $diff = $today->diff(new DateTime($dob));
	$diff1 = $diff->format('%y||%m||%d');
	$dayssplit = explode('||',$diff1);
	$year = $dayssplit[0];
	if($year > 1){ $yearname = 'Years'; } else { $yearname = 'Year'; }
	$month = $dayssplit[1];
	if($month > 1){ $monthname = 'Months'; } else { $monthname = 'Month'; }
	$day = $dayssplit[2];
	if($day > 1){ $dayname = 'Days'; } else { $dayname = 'Day'; }
	if($year == 0 && $month != 0)
	{
		$dob1 = $month.' '.$monthname.' '.$day.' '.$dayname;
	}
	else if($year == 0 && $month == 0)
	{
		$dob1 = $day.' '.$dayname;
	}	
	else if($year != 0 && $month != 0)
	{
		$dob1 = $year.' '.$yearname.' '.$month.' '.$monthname;
	}
	else
	{
		$dob1 = $year.' '.$yearname;
	}
}
else
{
$dob1 = $patientage;
}	
?>

    <page pagegroup="new" backtop="8mm" backbottom="7mm" backleft="5mm" backright="3mm">
	<table cellspacing="0" cellpadding="1" border="0">
	 <tr>
	  <td width="150" valign="top" rowspan="6">
	  <?php
		$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
		$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
		$res3showlogo = mysql_fetch_array($exec3showlogo);
		$showlogo = $res3showlogo['showlogo'];
		if ($showlogo == 'SHOW LOGO')
		{
	  ?>
	  <img src="logofiles/<?php echo $companyanum;?>.jpg" width="65" height="65" />
	  <?php
	    }
	  ?></td> 
	  <td width="430" align="center" class="bodytext21" style="font-size:16px"><?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?><strong><?php echo $companyname; ?></strong></td>
	  <td width="150" valign="top" rowspan="6" align="right">
	  <?php
	  $query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
	  $exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
	  $res3showlogo = mysql_fetch_array($exec3showlogo);
	  $showlogo = $res3showlogo['showlogo'];
	  if ($showlogo == 'SHOW LOGO')
	  {
	  ?>
	<!--<img src="logofiles/2.jpg" width="65" height="65" />-->
	  <?php
	  }
	  ?></td> 
	</tr>
	<tr>
	 <td width="430" align="center" class="printbodytext22" style="font-size:15px"><?php
			$address2 = $area.''.$pincode.' '.$city;
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?><?php
			$address3 = "Tel: ".$phonenumber1.', '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			
			?>
			<?php echo $address2.''.$address3; ?></td>
	</tr>
	<tr>
	 <td width="430" align="center" class="bodytext23" style="font-size:13px"><?php
			//$address5 = "Fax: ".$faxnumber1;
			$strlen3 = strlen($address5);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address5 = ' '.$address5;
			}
			?>
			<?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}

			$labemail="Lab E-mail: ".$emailid1;
			$labemobile="Lab Mobile Number: ".$phonenumber1;
			$website="Website : ";

			?>
            <?php echo $address5.', '.$address4; ?>
              <?php echo '<br>'. $labemobile.'<br>'.$labemail.'<br>'; ?>
          </td>
   </tr>
   <tr>
	 <td width="430" align="center" class="bodytext24" style="font-size:13px">&nbsp;</td>
   </tr>
   <tr>
	<td width="430" align="center">&nbsp;</td>
   </tr>
   <tr>
	<td width="430" align="center" style="font-size:12px;">&nbsp;</td>
   </tr>
   <tr>
	<td colspan="3" align="center" class="bodytext26"><strong>&nbsp;</strong></td>
   </tr>
  </table>
  
  <table cellspacing="4" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
   <tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Patient</strong></td>
	<td width="230" align="left" valign="top" class="bodytext27"><?php echo $patientname; ?>&nbsp;<?php if

($patientcode !='') { echo '('.$patientcode.')' ; } ?></td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Lab No</strong> </td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php echo $docnumber; ?></td>
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Visit Date</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime

($samplecollectedon)); ?></td>
   </tr>
   <tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Age</strong></td>
	<td width="230" align="left" valign="top" class="bodytext27"><?php echo $patientage; ?></td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Doctor</strong></td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php echo $doctor; ?></td>
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Sample Rcvd </strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d',strtotime

($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
	</tr>
	<tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
	<td width="230" align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Account</strong></td>                
	<td width="165" align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo 

$accountname; }else{ echo 'SELF'; } ?></td>	
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Reported On</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime

($res38publisheddatetime)); ?></td>
  </tr>
  <tr>
	<?php if($accountcode != '') { ?>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
	<td width="230" align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	<?php }else { ?>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	<?php } ?>	  
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
	<td width="165" align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>	
	<td width="80" align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo $fileno5; ?></td>	
   </tr>	  
</table>
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
	 <td colspan="6" align="left" valign="middle">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31"><strong>Pending Tests :</strong></td>
	</tr>
	<?php
	$labpending = '';
	$query68 = "select * from consultation_lab where billnumber = '$billnumber' and patientcode = 

'$patientcode' and patientvisitcode = '$visitcode' and resultentry <> 'completed' order by labitemname";
	$exec68 = mysql_query($query68) or die(mysql_error());
	while($res68 = mysql_fetch_array($exec68))
	{
	$labitemnamepending = $res68['labitemname'];
	if($labpending == '')
	{
		$labpending = $labitemnamepending;
	}
	else
	{
		$labpending = $labpending.', '.$labitemnamepending;
	}
	}
	?>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31"><strong><?php echo $labpending; ?></strong></td>
	</tr>
	<tr>
	 <td colspan="5" align="center" valign="top" style="font-size:16px; text-

decoration:underline;"><strong>Laboratory Report</strong> </td>
	</tr>
	<tr>
	 <td width="278" align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="142"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="51"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="0"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="70" align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="171" align="left" valign="top" class="bodytext27">&nbsp;</td>
	</tr>
	<tr>
	 <td width="178" align="left" valign="top" class="bodytext27"><strong>TESTS</strong></td>
	 <td width="142"  align="left" valign="top" class="bodytext27"><strong>RESULTS</strong></td>
	 <td width="51"  align="left" valign="top" class="bodytext27"><strong>UNIT</strong></td>
 		<td width="0"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="70" align="left" valign="top" class="bodytext27"><strong>REFERANCE RANGE</strong></td>
	 <td width="171" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	</tr>
	<?php
	$pagecount='';
	$itemnumbers=0;
	$referencenumbers=0;
	
	$query616 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode = '$labitemcode34' and consultationdate between '$fromdate' and '$todate'  order by auto_number desc";
	$exec616 = mysql_query($query616) or die(mysql_error());
	$num=mysql_num_rows($exec616);
	while($res616 = mysql_fetch_array($exec616))
	{
	$res616itemcode = $res616['labitemcode'];
	$res616itemname = $res616['labitemname'];
	?>
	<tr>
		<td colspan="6" align="left" valign="top" class="bodytext31"><strong><?php echo $res616itemname; 

?></strong></td>
	</tr>
	<tr>
		<td colspan="6" align="left" valign="top" class="bodytext31"><strong>&nbsp;</strong></td>
	</tr>
	
	<?php

$query38="select parametercode as referencename from pending_test_orders where testcode='$res616itemcode' and patientcode = '$patientcode' and visitcode = '$visitcode' group by parametercode order by auto_number asc";
   $exec38=mysql_query($query38);
   $num38=mysql_num_rows($exec38);
if($num38==0){

	$query38="select * from master_labreference where itemcode = '$res616itemcode' and status <> 'deleted' 

group by referencename ";
	$exec38=mysql_query($query38);
	$num38=mysql_num_rows($exec38);
}


	while($res38=mysql_fetch_array($exec38))
	{
	 $referencename1=$res38['referencename'];
	
 	$query32="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = 

'$visitcode' and referencename = '$referencename1' and itemcode = '$res616itemcode'  order by auto_number ";
	$exec32=mysql_query($query32);
	 $num32=mysql_num_rows($exec32);
	$res32=mysql_fetch_array($exec32);
	$resultvalue=$res32['resultvalue'];
	//$resultvalue = str_replace('<','&lt;',$resultvalue);
	//$resultvalue = str_replace('>','&gt;',$resultvalue);
	
	$sampletype = $res32['sampletype'];
	$referencename=$res32['referencename'];
	$referencerange=$res32['referencerange'];
	$referenceunit=$res32['referenceunit'];
	//$referenceunit='';
	//$referenceunit = str_replace('\n','',$referenceunit);
	//$referenceunit = str_replace('>','&gt;',$referenceunit);
	$res12referencename = $res32['referencename'];
	$color = $res32['color'];
	if($color == 'red') { $crit = 'H'; }
	else if($color == 'orange') { $crit = 'L'; }
	else if($color == 'green') { $crit = 'N'; }
	else { $crit = ''; }
	$refcomments = $res32['referencecomments'];
	$referencenumbers = $referencenumbers + 1;
	?>
	<tr>
	 <td width="173" align="left" valign="top" class="bodytext31"><?php echo $res12referencename; ?></td>
	 <td width="91" align="left" valign="top" class="bodytext31"><?php echo $resultvalue; ?></td>
	 <td width="51" align="left" valign="top" class="bodytext31"><?php echo $referenceunit; ?></td>
	 <td width="55" align="center" valign="top" class="bodytext31"><strong><?php echo $crit; ?></strong></td>
	 <td width="170" align="left" valign="top" class="bodytext31"><?php echo $referencerange; ?></td>
	 <td width="171" align="left" valign="top" class="bodytext31"><?php echo $refcomments; ?></td>
	</tr>
	<?php 
	 
	$res38comment = '';
	?>	<?php
	 }
	}
	?>
	
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
</table>  
<table border="0" cellspacing="0" cellpadding="2">
   <tr>
     <td width="247">REVIEWED :&nbsp;&nbsp;------------------------------</td>
     <td width="242">SIGNATURE:&nbsp;&nbsp;------------------------------</td>
     <td width="240">DATE:&nbsp;&nbsp;------------------------------</td>
   </tr>
   <tr>
     <td width="247"><strong>Quality Manager/Laboratory Director</strong></td>
     <td width="242"><strong>LAB TECHNOLOGIST</strong> </td>
     <td width="240">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
   </tr>
   <tr>
     <td width="247">Reviewed By:&nbsp;<?php echo strtoupper($res4jobdescription); ?></td>
     <td width="242">Acknowledged By:&nbsp;<?php echo strtoupper($res41jobdescription); ?></td>
     <td width="240">Printed On: <?php echo date('Y-M-d g:i:A',strtotime($updatedatetime)); ?></td>
   </tr>
   <tr>
     <td width="247">&nbsp;</td>
     <td width="242">&nbsp; </td>
     <td width="240">&nbsp;</td>
   </tr>
</table>
<table border="0" cellspacing="0" cellpadding="2" id="footer">
  <tr>
    <td width="745" align="center" valign="top" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td width="745" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
  </tr>
</table>
  
</page>
<?php
}
?>
   <?php
    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {	
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Labresults.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  ?>
