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
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
$pagebreak = '';

ob_start();

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
$itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';

$chkward="select bed,ward,recordstatus from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> 'transfered'";
$execwa = mysql_query($chkward) or die(mysql_error());
 $numwardrow=mysql_num_rows($execwa);
 
 $chkward1="select bed,ward,recordstatus from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus ='transfered'";
$execwa1 = mysql_query($chkward1) or die(mysql_error());
 $numwardrow1=mysql_num_rows($execwa1);

if($numwardrow !=0)
{
	$reswa = mysql_fetch_array($execwa);
	 $bedno=$reswa['bed'];
	$wardno=$reswa['ward'];
	
	$querybed="select bed from master_bed where auto_number='$bedno'";
	$execbed=mysql_query($querybed) or die(mysql_error());
	$resbed=mysql_fetch_array($execbed);
	 $bednumber=$resbed['bed'];
	
	$queryward="select ward from master_ward where auto_number='$wardno'";
	$execward=mysql_query($queryward) or die(mysql_error());
	$resward=mysql_fetch_array($execward);
	 $wardname=$resward['ward'];
	
}
else if($numwardrow1 !=0)
{
	$querytransfer="select bed,ward from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode'";
	$exectrans = mysql_query($querytransfer) or die(mysql_error());
	$restrans=mysql_fetch_array($exectrans);
	$bedno=$restrans['bed'];
	$wardno=$restrans['ward'];
	
	$querybed="select bed from master_bed where auto_number='$bedno'";
	$execbed=mysql_query($querybed) or die(mysql_error());
	$resbed=mysql_fetch_array($execbed);
	$bednumber=$resbed['bed'];
	
	$queryward="select ward from master_ward where auto_number='$wardno'";
	$execward=mysql_query($queryward) or die(mysql_error());
	$resward=mysql_fetch_array($execward);
	$wardname=$resward['ward'];

}



$query612 = "select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultentry = 'completed' group by docnumber,labitemcode order by auto_number desc";
$exec612 = mysql_query($query612) or die(mysql_error());
$res612 = mysql_fetch_array($exec612);
$orderedby = $res612['username'];
$Patientname=$res612['patientname'];
$accountname=$res612['accountname'];
$accountcode=$res612['accountcode'];
$doctor=$res612['doctor'];
$locationname=$res612['locationname'];
//$docno=$res612['resultdoc'];
$samplecollectedon1=$res612['consultationdate'];
$samplecollectedon2=$res612['consultationtime'];
$patientvisitcode=$res612['patientvisitcode'];
$samplecollectedon=$samplecollectedon1.' '.$samplecollectedon2;
//$dob = $res612['dateofbirth'];
$billdatetime = $res612['sampledatetime'];
 $sampleid = $res612['sampleid'];
$res38publisheddatetime = $res612['publishdatetime'];

$query8="select * from master_employee where username = '$orderedby' and username <> ''";
$exec8=mysql_query($query8);
if($res8=mysql_fetch_array($exec8)){
$orderedby=$res8['employeename'];
}


$query613 = "select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
$exec613 = mysql_query($query613) or die(mysql_error());
$res613 = mysql_fetch_array($exec613);
$docno = $res613['docnumber'];
$res41jobdescription=$res613['username'];

$query8="select * from master_employee where username = '$res41jobdescription' ";
$exec8=mysql_query($query8);
if($res8=mysql_fetch_array($exec8)){
$res41jobdescription=$res8['employeename'];
}


 $query123 = "select * from ipsamplecollection_lab where patientcode = '$patientcode' and patientvisitcode='$patientvisitcode' order by auto_number desc";
$exec123 = mysql_query($query123) or die(mysql_error());
$res123 = mysql_fetch_array($exec123);
$res123recordtime=$res123['recordtime'];
$res123recorddate=$res123['recorddate'];

?>
<?php 
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
$website = $res2["emailid2"];

$location= $locationname;

$query8="select * from master_employee where username = '$username' ";
$exec8=mysql_query($query8);
$num8=mysql_num_rows($exec8);
$res8=mysql_fetch_array($exec8);
$res8jobdescription=$res8['employeename'];

if($patientcode != 'walkin')
{
$query5 = "select * from master_customer where customercode = '$patientcode'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
$area12 = $res5['area'];
$fileno5 = $res5['fileno'];
$patientage=$res5['age'];
$patientgender=$res5['gender'];
$dob = $res5['dateofbirth'];
}
else
{
$query77 = "select * from consultation_lab where resultdoc = '$docnumber'";
  $exec77=mysql_query($query77) or die(mysql_error());
$res77=mysql_fetch_array($exec77);
$billnumber=$res77['billnumber'];
  $locationcode=$res78['locationcode'];
  
  $query771 = "select * from billing_external where billno = '$billnumber'";
  $exec771=mysql_query($query771) or die(mysql_error());
$res771=mysql_fetch_array($exec771);
$patientage=$res771['age'];
 $patientgender=$res771['gender'];
 $dob = '0000-00-00';
}

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
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
.bodytext31{ font-size:13px; }
.bodytext27{ font-size:12px; }
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height: 30px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
	font-size: 10px;
	font-weight: bold;
}
</style>
<?php //include('a4pdfheader.php'); ?>
  <table width="520" cellspacing="0" cellpadding="1" border="0">
	     <tr>
		    <td valign="top" rowspan="6" width="83">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="200" height="80" />
			
			<?php
			}
			?>
            </td> 
			<td align="center" style="font-size:16px" class="bodytext21">
	        <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
			<strong><?php echo $companyname; ?></strong></td>
		    <td valign="top" rowspan="6" width="83" align="right">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			
			
			<?php
			}
			?></td> 
        </tr>
		   <tr>
	  </tr>
	    <tr>
		  <td align="center" class="bodytext23" style="font-size:13px">
            <?php
			$address2 = $area.''.$pincode.' '.$city;
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			<?php
			$address3 = "Tel: ".$phonenumber1.', '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{

			$address3 = ' '.$address3.' ';
			}
			
			$labemail="";
			$labemobile="";
			$website="";
			?>
			<?php echo $address2.''.$address3; ?>
          </td>
  </tr>
            
            <tr>
              <td align="center" class="bodytext24" style="font-size:13px">
			<?php
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
			?>
            <?php echo $address5.', '.$address4; ?>
              <?php echo '<br>'. $labemobile.'<br>'.$labemail.'<br>'.$website; ?>
          
            </td>
	 
        </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			</tr>
			<tr>
     			<td align="center" style="font-size:12px;"><strong><?php echo $location; ?>&nbsp;</strong></td>
			</tr>
	       
	 		 <tr>
     			<td colspan="3" align="center" class="bodytext26" style="border-top:solid 0px #000000;"><strong>&nbsp;</strong></td>
			</tr>
</table>	

	<table width="520" border="0" cellspacing="0" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
	       
        <tr>
			<input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
			<td width="40" class="bodytext27"><strong>Patient</strong></td>
		  <td width="120" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?>
		 &nbsp; <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?>
	      <input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly="readonly"/>	      </td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Lab No</strong> </td>
		  <td width="100" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $docno; ?></td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Visit Date</strong></td>
		  <td width="87" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime($samplecollectedon)); ?></td>
		</tr>
       
		<tr>
			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Age</strong></td>
			<td align="left" valign="top" class="bodytext27"><?php echo $dob1; ?>
		  <input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>	      </td>
			<td align="left" valign="top" class="bodytext27"><strong>Doctor</strong></td>
			<td align="left" valign="top" class="bodytext27"><?php echo $orderedby; ?></td>
			<td class="bodytext27"><strong>Sample Rcvd </strong></td>
		  <td class="bodytext27"><?php echo date('Y-M-d',strtotime($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
	  </tr>
	   <tr>
		  <td align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
		  <td align="left" valign="top" class="bodytext27"><strong>Account</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>	
		  <td class="bodytext27"><strong>Ward Name</strong></td>
		  <td class="bodytext27"><?php echo $wardname; ?></td>
	  </tr>
	  <tr>
	  <?php if($accountcode != '') { ?>
	   	  <td align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	  <?php }else { ?>
	  	  <td align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	  <?php } ?>	  
        <input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>
		  <td align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
		  <td align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>	
		  <td align="left" valign="top" class="bodytext27"><strong>Bed No.</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $bednumber; ?></td>	
	  </tr>	  
</table>
    <table width="519" border="0" cellpadding="1" cellspacing="2">
      <tr>
        <td colspan="6" align="left" valign="middle">&nbsp;</td>
      </tr>
	  
	  <?php
	  $pendingtest = '';
	  $query68 = "select labitemname from ipconsultation_lab where patientcode = '$patientcode' and patientcode <> 'walkin' and patientvisitcode = '$visitcode' and resultentry <> 'completed' and labrefund <> 'refund' and labitemcode not in (select itemcode from ipresultentry_lab where patientcode = '$patientcode' and patientcode <> 'walkin' and patientvisitcode = '$visitcode')  order by labitemname";
		$exec68 = mysql_query($query68) or die(mysql_error());
		while($res68 = mysql_fetch_array($exec68))
		{
		$labitemnamepending = $res68['labitemname'];
		if($pendingtest == '')
		{
			$pendingtest = $labitemnamepending;
		}
		else
		{
			$pendingtest = $pendingtest.', '.$labitemnamepending;
		}
		}
		if($pendingtest != '')
		{	
		?>
		<tr>
        <td colspan="6" align="left" valign="middle"><strong>Pending Tests :</strong></td>
      </tr>
		<tr>
        <td colspan="6" align="left" valign="middle"><strong><?php echo $pendingtest; ?></strong></td>
      </tr>
	 <?php
	 }
	 ?>
      <tr>
        <td colspan="6" align="center" valign="middle" style="font-size:16px; text-decoration:underline;"><strong>Laboratory Report</strong> </td>
      </tr>
      <tr>
        <td  align="left" valign="middle">&nbsp;</td>
	    <td  align="left" valign="middle">&nbsp;</td>
        <td  align="left" valign="middle">&nbsp;</td>
		<td  align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
      </tr>
	   <tr>
		<td width="132" align="left" valign="middle" class="bodytext29"><span class="style1">TESTS</span></td>
        <td width="46"  align="left" valign="middle" class="bodytext29"><span class="style1">RESULTS</span></td>
		<td width="35"  align="left" valign="middle" class="bodytext29"><span class="style1">UNIT</span></td>
		<td width="62"  align="center" valign="middle" class="bodytext29 style1">FLAG</td>
        <td width="54" align="left" valign="middle" class="bodytext29"><span class="style1">R.RANGE</span></td>
        <td width="150" align="left" valign="middle" class="bodytext29"><span class="style1">COMMENTS</span></td>
      </tr>
	  <?php
		$pagecount='';
		$itemnumbers=0;
	
	  $referencenumbers=0;
	  
	     $query616 = "select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' group by docnumber,itemcode order by auto_number desc ";
		$exec616 = mysql_query($query616) or die(mysql_error());
		while($res616 = mysql_fetch_array($exec616)){
		$res616itemcode = $res616['itemcode'];
		$res616itemname = $res616['itemname'];
		$resultentrydocno = $res616['docnumber'];
		
		?>

      <tr>
        <td colspan="6" align="left" valign="middle" class="bodytext29"><strong><?php echo $res616itemname; ?></strong></td>
      </tr>
	
	<?php
	  $query38="select * from master_labreference where itemcode = '$res616itemcode' and status <> 'deleted' and itemcode='$res616itemcode' "; //and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto 
	$exec38=mysql_query($query38);
	$num38=mysql_num_rows($exec38);
	while($res38=mysql_fetch_array($exec38))
	{
	 $referencename1=$res38['referencename'];
	 //$referenceitemcode=$res38['itemcode'];
	
	 $query32="select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and referencename = '$referencename1' and itemcode='$res616itemcode' and docnumber='$resultentrydocno'  order by auto_number ";
	$exec32=mysql_query($query32);
	$num32=mysql_num_rows($exec32);
	$res32=mysql_fetch_array($exec32);
	$resultvalue=$res32['resultvalue'];
	$resultvalue = str_replace('<','&lt;',$resultvalue);
	$resultvalue = str_replace('>','&gt;',$resultvalue);
	
	$sampletype = $res32['sampletype'];
	$referencename=$res32['referencename'];
	$referencerange=$res32['referencerange'];
	$referenceunit=$res32['referenceunit'];
	$referenceunit = str_replace('<','&lt;',$referenceunit);
	$referenceunit = str_replace('>','&gt;',$referenceunit);
	$res12referencename = $res32['referencename'];
	$color = $res32['color'];
	if($color == 'red') { $crit = 'H'; }
	else if($color == 'orange') { $crit = 'L'; }
	else if($color == 'green') { $crit = 'N'; }
	else { $crit = ''; }
	$refcomments = $res32['referencecomments'];
	$referencenumbers = $referencenumbers + 1;
	$refcomments = str_replace('border="1"','border="0"',$refcomments);		
		?>
	  
     <tr>
	 <td align="left" valign="top" class="bodytext31"><?php echo $res12referencename; ?></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $resultvalue; ?></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $referenceunit; ?></td>
	 <td align="center" valign="top" class="bodytext31" style="color:<?= $color ?>"><strong><?php echo $crit; ?></strong></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $referencerange; ?></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $refcomments; ?></td>
	</tr>
      <?php } 
	  $res38comment = '';
	  ?>
	  <?php if($res38comment !='') { ?>

			
	  <?php
		 }
		 ?>
         <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
      <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
      
         <?php
		 }
	  ?>
	  <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	
     
	   <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	   <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	  <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	  <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
  </table>
    
	 <table width="543" height="108" border="0" class="bodytext31">
	 
	 <tr>
        <td width="179">REVIEWED :&nbsp;&nbsp;------------------------------</td>
        <td width="172">SIGNATURE:&nbsp;&nbsp;------------------------------</td>
       
         <td width="178" colspan="2">DATE:&nbsp;&nbsp;------------------------------</td>
      </tr>
      <tr>
       	 <td width="179"><strong>Quality Manager/Laboratory Director</strong></td>
        <td width="172"><strong>LAB TECHNOLOGIST</strong> </td>
		
         <td width="178" colspan="2">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
      </tr>

      <tr>
        <td width="179">Reviewed By:&nbsp;<?php echo strtoupper($orderedby); ?></td>
        <td width="172">&nbsp;<?php echo strtoupper($orderedby); ?></td>
       
        <td width="178" colspan="2">Printed On: <?php echo date('Y-M-d g:i:A',strtotime($updatedatetime)); ?></td>
      </tr>
	  <tr>
        <td width="179">&nbsp;</td>
        <td width="172">&nbsp; </td>
       
        <td width="178" colspan="2">&nbsp;</td>
      </tr>
    </table>
	<table border="0" width="540" height="" id="footer">
		<tr>
			  <td colspan="4" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
	  </tr>
	</table>
<?php	

require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("LabResultsFull.pdf", array("Attachment" => 0)); 

?>
