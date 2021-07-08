<?php
//session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="AmbulanceReport.xls"');
header('Cache-Control: max-age=80');

if ($companyanum == '') //For print view.
{
	if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
	//$username = $_SESSION['username'];
	if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_SESSION['companyanum'];
	if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }
	//$companyname = $_SESSION['companyname'];
	if (isset($_SESSION["financialyear"])) { $financialyear = $_SESSION["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_SESSION['financialyear'];
}
if ($companyanum == '')  // For excel export.
{
	if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
	//$username = $_REQUEST['username'];
	if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_REQUEST['companyanum'];
	if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
	//$companyname = $_REQUEST['companyname'];
	if (isset($_REQUEST["financialyear"])) { $financialyear = $_REQUEST["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_REQUEST['financialyear'];
}

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

if (isset($_REQUEST["user"])) { $searchsuppliername = $_REQUEST["user"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}
?>
<table width="137%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td colspan="14" bgcolor="#FFFFFF" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
			  	}
				?> </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inc.Date</strong></div></td>
              <td width="61" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Caller</strong></td>
              <td width="114" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
              <td width="37" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sex </strong></div></td>
              <td width="59" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
				<td width="103" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>PT Loc</strong></div></td>
              <td width="151" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Destination </strong></div></td>
              <td width="130" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Diagnosis</strong></div></td>
              <td width="127" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Treatment</strong></div></td>
              <td width="118" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>pt address</strong></div></td>
              <td width="105" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>pt Tel</strong></div></td>
              <td width="126" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Rescue</strong></div></td>
              <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Recieving Nurse</strong></div></td>
              <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>operator</strong></td>
              <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Nurse</strong></td>
              <td width="101" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>RescueTime</strong></td>
              <td width="91" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>EndOfCall</strong></td>
              <td width="84" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>PCR No</strong></td>
              <td width="93" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>KM Covered</strong></td>
              </tr>
			<?php
			
		$colorloopcount='';
		$showcolor='';
		$sno='';
		$billnumber='';
		 // $query2 = "select * from ambulancep where  recorddate between '$transactiondatefrom' and '$transactiondateto'  order by recorddate desc";
		  $query2 = "select * from ambulancep ap LEFT JOIN ambulanceinc ainc ON ap.visitcode=ainc.visitcode   where   ap.recorddate between '$transactiondatefrom' and '$transactiondateto'";
		 $exec2 = mysql_query($query2) or die(mysql_error());
		 $rows=mysql_num_rows($exec2);
		 while($res2 = mysql_fetch_array($exec2))
		 {
			$res1patientcode = $res2['patientcode'];
			$res1visitcode = $res2['visitcode'];
			
			$operator=$res2['operator'];
			$nurse=$res2['nurse'];
			$ambulancereg=$res2['ambulancereg'];
			$incidentdate=$res2['incidentdate'];
			$pcrno2=$res2['pcrno2'];
			$unitnum=$res2['unitnum'];
			$ambulancereg1=$res2['ambulancereg1'];
			$patientdispose=$res2['patientdispose'];
			$incidentaddress=$res2['incidentaddress'];
			$responsemode=$res2['responsemode'];
			$responsemodefromscene=$res2['responsemodefromscene'];
			$timeunotified=$res2['timeunotified'];
			$begodometer=$res2['begodometer'];
			$timeuarrived=$res2['timeuarrived'];
			$onsceneodometer=$res2['onsceneodometer'];
			$timeuleft=$res2['timeuleft'];
			$ptdestodometer=$res2['ptdestodometer'];
			$timeparrived=$res2['timeparrived'];
			$endingodometer=$res2['endingodometer'];
			$timeunitback=$res2['timeunitback'];
			$totalkm=$res2['totalkm'];
			$servicereq=$res2['servicereq'];
			$payment=$res2['payment'];
			$amount=$res2['amount'];
			$extbillno=$res2['extbillno'];
			
			$ptaddress=$res2['ptaddress'];
			$caller=$res2['caller'];
			$ptphoneno=$res2['ptphoneno'];
			$ccomplaint=$res2['ccomplaint'];
			$analocation=$res2['analocation'];
			$syslocation=$res2['syslocation'];
			$medication=$res2['medication'];
			$allergies=$res2['allergies'];
			$medadmby=$res2['medadmby'];
			$diagnosis=$res2['diagnosis'];
			$origfacility=$res2['origfacility'];
			$destfacility=$res2['destfacility'];
			$typedestination=$res2['typedestination'];
			$treatment=$res2['treatment'];
			$procedures=$res2['procedures'];
			$rescue=$res2['rescue'];
			$receivenurse=$res2['receivenurse'];
			$destfacility1=$res2['destfacility1'];
			$timeout=$res2['timeout'];
			$timein=$res2['timein'];
			$pcrno=$res2['pcrno'];
			$docno = $res2['docno'];
			
			
if($extbillno!='')
{
			$query11="select * from billing_external where billno='$extbillno'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$patientname=$res11['patientname'];
			$age=$res11['age'];
			$gender=$res11['gender'];
			$mobilenumber='';

}
else
{

		  $query10 = "select * from master_customer where customercode='$res1patientcode'";
		 $exec10 = mysql_query($query10) or die(mysql_error());
		 $rows10=mysql_num_rows($exec10);
		 $res10 = mysql_fetch_array($exec10);
		$patientname=$res10['customerfullname'];
		$gender=$res10['gender'];
		$age=$res10['age'];
		$mobilenumber=$res10['mobilenumber'];
}
/*		if($gender=='Male')
		{
		$gendvalue='0';	
		}
		else
		{
		$gendvalue='1';	
		}
*/		
			$patientvis = explode("-", $res1visitcode);
			 $patientv= $patientvis[0];
			
			if($patientv=='VS')
			{
			$qury="select * from consultation_services where  patientcode='$res1patientcode' and patientvisitcode='$res1visitcode' ";
			$exe = mysql_query($qury) or die(mysql_error());
			$re = mysql_fetch_array($exe);
			$patientfullname = $re['patientname'];
			$billtype = $re['billtype'];
			}
			elseif($patientv=='IP')
			{
			 $qury="select * from ipconsultation_services where  patientcode='$res1patientcode' and patientvisitcode='$res1visitcode' ";
			$exe = mysql_query($qury) or die(mysql_error());
			$re = mysql_fetch_array($exe);
			$patientfullname = $re['patientname'];
			$billtype = $re['billtype'];	
			}
			else
			{
			$qury="select * from consultation_services where  patientcode='$res1patientcode' and patientvisitcode='$res1visitcode' ";
			$exe = mysql_query($qury) or die(mysql_error());
			$re = mysql_fetch_array($exe);
			$patientfullname = $re['patientname'];
			$billtype = $re['billtype'];
			$billnumber = $re['billnumber'];
			}
			
		$query13 = "select destination from amb_destination where auto_number='$typedestination' and recordstatus=''";
		 $exec13 = mysql_query($query13) or die(mysql_error());
		 $res13 = mysql_fetch_array($exec13);
		 
			 $destination=$res13['destination'];
			 
		$query14 = "select * from master_operator where auto_number='$operator' and recordstatus=''";
		 $exec14 = mysql_query($query14) or die(mysql_error());
		 $res14 = mysql_fetch_array($exec14);
		
			 $autonumber=$res14['auto_number'];
			 $operator1=$res14['operator'];

			
			$recorddate = $res2['recorddate'];
			
				
			
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
			  <tr >
              <td class="bodytext31" valign="left" width="25"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"   align="left">
			    <?php echo $recorddate; ?></td>
			   <td class="bodytext31" valign="center"   align="left">
			    <?php echo $incidentdate; ?></td>
			   <td class="bodytext31" valign="left" width="61"  align="left">
			    <?php echo $caller; ?></td>
				<td class="bodytext31" valign="center" width="114"  align="left">
			    <?php echo $patientfullname; ?></td>
			   <td class="bodytext31" valign="center" width="37"  align="left">
			    <?php echo $gender; ?></td>
			   <td class="bodytext31" valign="center" width="59"  align="left">
			    <?php echo $age; ?></td>
              <td class="bodytext31" valign="left" width="103"  align="left"><div align="center"><?php echo $caller; ?></div></td>
			   <td class="bodytext31" valign="center" width="151"  align="left">
			    <?php echo $destination; ?></td>
			   <td class="bodytext31" valign="left" width="130"  align="left">
			    <?php echo $diagnosis; ?></td>
				<td class="bodytext31" valign="center" width="127"  align="left">
			    <?php echo $treatment; ?></td>
			   <td class="bodytext31" valign="center" width="118"  align="left">
			    <?php echo $ptaddress; ?></td>
			   <td class="bodytext31" valign="center" width="105"  align="left">
			    <?php echo $ptphoneno; ?></td>
        
              <td class="bodytext31" valign="left" width="126"  align="left"><div align="center"><?php echo $rescue; ?></div></td>
			   <td class="bodytext31" valign="center" width="136"  align="left">
			    <?php echo $receivenurse; ?></td>
			   <td class="bodytext31" valign="left" width="73"  align="left">
			    <?php echo intval($amount); ?></td>
				<td class="bodytext31" valign="center" width="100"  align="left">
			    <?php echo $operator1; ?></td>
			   <td class="bodytext31" valign="center" width="100"  align="left">
			    <?php echo $nurse; ?></td>
			   <td class="bodytext31" valign="center" width="101"  align="left">
			    <?php echo $timeuarrived; ?></td>
              <td class="bodytext31" valign="left" width="91"  align="left"><div align="center"><?php echo $timeparrived; ?></div></td>
			   <td class="bodytext31" valign="center" width="84"  align="left">
			    <?php echo $pcrno; ?></td>
			   <td class="bodytext31" valign="left" width="93"  align="left">
			    <?php echo $totalkm; ?></td>
			    </tr>
			  <?php
			}
			?>
          </tbody>
        </table>