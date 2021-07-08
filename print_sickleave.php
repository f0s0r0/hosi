<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly2 = date('Y-m-d');
$username = $_SESSION["username"];
$timeonly = date('H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = "";
$res2sickoffnumber ='';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if(isset($_REQUEST['patientcode'])) {$patientcode=$_REQUEST['patientcode']; } else{$patientcode="";}
if(isset($_REQUEST['visitcode'])) {$visitcode = $_REQUEST['visitcode']; } else{$visitcode="";}

ob_start();

$query2 = "select * from sickleave_entry where patientcode = '$patientcode' order by auto_number desc ";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$num=mysql_num_rows($exec2);

$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2patientname = $res2['patientname'];
$res2recorddate = $res2['recorddate'];
$res2fromdate = $res2['fromdate'];
$res2todate = $res2['todate'];
$res2nodays1= $res2['nodays1'];
$res2nodays2= $res2['nodays2'];
$res2work= $res2['work'];
$res2sicktype= $res2['sicktype'];
$res2sickoffnumber= $res2['sickoffnumber'];
$res2fromreview= $res2['fromreview'];
$res2toreview= $res2['toreview'];
$res2fromduty= $res2['fromduty'];
$res2toduty= $res2['toduty'];
$res2remarks= $res2['remarks'];
$res2recorddate= $res2['recorddate'];
$res2recordtime= $res2['recordtime'];
$res2res2patientname = strtoupper($res2patientname);
$username = $res2['preparedby'];

$query11 = "select * from master_customer where customercode = '$patientcode' ";
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$res11accountname = $res11['accountname'];
$res11consultingdoctor = $res11['consultingdoctor'];

$query5 = "select * from master_accountname where auto_number = '$res11accountname'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
$res5accountname = $res5['accountname'];

$query33= "select * from master_visitentry where patientcode='$patientcode'" ;
$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
$res33 = mysql_fetch_array($exec33);
$re33age = $res33['age'];
$res33gender = $res33['gender'];
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3b3b3c; 
}

.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
</style>

<style type="text/css">
.top {
    border-top:thin solid;
    border-color:black;
}

.bottom {
    border-bottom:thin solid;
    border-color:black;
}

.left {
    border-left:thin solid;
    border-color:black;
}

.right {
    border-right:thin solid;
    border-color:black;
}
</style>


<table width="717" border="0" cellpadding="0" cellspacing="0">
		<?php
		$query1 = "select * from master_company where auto_number = '$companyanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$res1 = mysql_fetch_array($exec1);
		$res1companyname = $res1['companyname'];
		$res1address1 = $res1['address1'];
		$res1area = $res1['area'];
		$res1city = $res1['city'];
		$res1state = $res1['state'];
		$res1country = $res1['country'];
		$res1pincode = $res1['pincode'];
	    $res1emailid = $res1["emailid1"];
		$res1phonenumber1 = $res1['phonenumber1'];
		?>

  <tr>
    <td colspan="6" align="center"><table width="717" border="0">
      <tr>
    <td width="76" align="left" valign="top" class="bodytext31">
	  <div align="left">
	    <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
	    
	    <img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
	    
	    <?php
			}
			?>	
	    </div></td>
	<td width="144" align="left" valign="center" class="bodytext31">&nbsp;</td>
	<td width="147" align="left" valign="center" class="bodytext31">&nbsp;</td>
	<td width="351"align="left" valign="center">
	    <?php
		echo '<strong>'.$res1companyname.'</strong>';
		echo '<br><strong>PHONE :'.$res1phonenumber1.'</strong>';
		echo '<br><strong>E-MAIL :'.$res1emailid.'</strong>';
		?>	    </td>
  </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><strong>SICK OFF FORM</strong></td>
  </tr>
  <tr>
    <td colspan="6" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="250" colspan="2" class="top bottom left right"><br/>&nbsp;&nbsp;Patient Name <br/><br/><br/>&nbsp;&nbsp;<strong><?php echo $res2patientname; ?></strong> </td>
	<td width="92">&nbsp;</td>	
    <td colspan="3"><table width="109%" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left"><strong>DATE</strong></td>
        <td align="left"><strong>PATIENT NO </strong></td>
        <td align="left"><strong>AGE</strong></td>
        <td align="left"><strong>SEX</strong></td>
        <td align="left"><strong>SICK OFF NO </strong></td>
      </tr>
      <tr>
        <td align="left"><?php echo $res2recorddate; ?></td>
        <td align="left"><?php echo $res2patientcode; ?></td>
        <td align="left"><?php echo $re33age; ?></td>
        <td align="left"><?php echo $res33gender; ?></td>
        <td align="left"><?php if($res2sickoffnumber != '') { echo $res2sickoffnumber; } ?></td>
      </tr>
      <tr>
        <td align="left"><strong>SCHEME</strong></td>
        <td colspan="4" align="left"><?php echo $res5accountname; ?></td>
      </tr>
      <tr>
        <td align="left"><strong>DOCTOR:</strong></td>
        <td colspan="4" align="left"><?php echo strtoupper($username); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">THIS IS TO CERTIFY THAT: <strong><?php echo $res2res2patientname; ?></strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">OF P/NO: <?php echo $res2patientcode; ?></td>
    <td colspan="4">SECTION:</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">IS SICK AND REQUIRES SICK OFF </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="147">&nbsp;</td>
    <td width="147">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">FROM DATE: </td>
    <td >TO DATE: </td>
    <td width="118">&nbsp;</td>
    <td>TYPE OF SICK OFF: </td>
    <td>NO. OF DAYS: </td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $res2fromdate; ?></td>
    <td><?php echo $res2todate; ?></td>
    <td>&nbsp;</td>
    <td width="150"><?php echo $res2sicktype; ?></td>
    <td width="33"><?php echo $res2nodays1; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php if(($res2fromreview != '0000-00-00') && ($res2toreview != '0000-00-00')) { ?>
  <tr>
    <td colspan="2">DATE OF REVIEW : </td>
    <td colspan="2">TO RESUME DUTY ON : </td>
    <td colspan="2">WORK RELATED : </td>
  </tr>
  
  <tr>
    <td colspan="2"><?php echo $res2fromreview; ?></td>
    <td colspan="2"><?php echo $res2toreview; ?></td>
    <td colspan="2"><?php if($res2work==1) { echo 'No'; } else { echo 'Yes'; }  ?></td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if(($res2fromduty != '0000-00-00') && ($res2toduty != '0000-00-00')) { ?>
  <tr>
    <td colspan="2">LIGHT DUTY FROM : </td>
    <td colspan="2">LIGHT DUTY TO : </td>
    <td colspan="2">NO. OF DAYS : </td>
  </tr>
    
  <tr>
    <td colspan="2"><?php echo $res2fromduty; ?></td>
    <td colspan="2"><?php echo $res2toduty; ?></td>
    <td colspan="2"><?php echo $res2nodays2; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
   <?php } ?>
   <?php if(($res2remarks) == '') { ?> 
  <tr>
    <td colspan="2">&nbsp;</td>
    <td class="bottom" colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>

  <?php if(($res2remarks) != '') { ?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="190" colspan="2" class="bottom">REMARKS : <?php echo $res2remarks; ?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>

  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" class="left" rowspan="4">&nbsp;</td>
    <td colspan="2" rowspan="4" class="left">&nbsp;</td>
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
    <td colspan="2" class="top">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  
    <tr>
      <td colspan="6">PATIENT SIGN : ___________________</td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2">PREPARED BY : <?php echo strtoupper($username); ?></td>
    <td colspan="2">DR. SIGN: _________________</td>
    <td colspan="2">DATE:<?php echo $res2recorddate; ?> TIME:<?php echo $res2recordtime; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center"><strong>FOR OFFICIAL USE ONLY</strong></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">(1) Given Full/Half pay/No Pay </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="51">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">(2) Sick days/Pay posted in Checkroll/Pay Sheet </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td> By : </td>
    <td colspan="2">Clerk : </td>
    <td colspan="2">Date : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">(3) Cummulative Sick Days To - date: Days </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Signed : </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center"><strong>MANAGER</strong></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>

<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printsickleave.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
