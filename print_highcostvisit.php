<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

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
$range = "";
$total = '0.00';

if (isset($_REQUEST["accountname"])) { $searchsuppliername = $_REQUEST["accountname"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

//header location
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	$query3 = "select * from master_location where locationcode = '$locationcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	//$companyname = $res2["companyname"];
	$address1 = $res3["address1"];
	$address2 = $res3["address2"];
	//$area = $res2["area"];
	//$city = $res2["city"];
	//$pincode = $res2["pincode"];
	$emailid1 = $res3["email"];
	$phonenumber1 = $res3["phone"];
	$locationcode = $res3["locationcode"];
	//$phonenumber2 = $res2["phonenumber2"];
	//$tinnumber1 = $res2["tinnumber"];
	//$cstnumber1 = $res2["cstnumber"];
	$locationname =  $res3["locationname"];
	$prefix = $res3["prefix"];
	$suffix = $res3["suffix"];
ob_start();
?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center; }
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td, th{padding: 5px; }
td{ vertical-align:;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;
font-family:Arial, Helvetica, sans-serif;
}
.width{ max-width:150px;}
.left{text-align:left;}
.right{text-align:right;}
</style>
<table align="center">
	<tr>
    	<td class="logo">Avenue Healthcare - <?php echo $locationname;?> Tel- <?php echo $phonenumber1;?></td>
    </tr>
    <tr>
    	<td align="center" class="bodytext"><strong>From: </strong><?php echo date('d/m/Y', strtotime($ADate1));?><strong> To: </strong><?php echo date('d/m/Y', strtotime($ADate2));?></td>
    </tr>
</table>

<table align="center" border="">
    <tr>
        <td class="bodytextbold border">Bill No</td>
        <td class="bodytextbold border">Date</td>
        <td class="bodytextbold border">Reg. No</td>
        <td class="bodytextbold border">OP No</td>
        <td class="bodytextbold border">Doctor Name</td>
        <td class="bodytextbold border">Patient Name</td>
        <td class="bodytextbold border">Bill Amount</td>
    </tr>
<?php

	$query21 = "select * from billing_paylater where accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
	$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
	while ($res21 = mysql_fetch_array($exec21))
	{
	$res21locationname = $res21['locationname'];
	$res21accountname = $res21['accountname'];
	
	$query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";
	$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
	$res22 = mysql_fetch_array($exec22);
	$res22accountname = $res22['accountname'];
	
	if( $res21accountname != '')
	{
	?>
	<tr>
        <td class="bodytext left" colspan="3"><strong>Location:</strong><?php echo $res21locationname;?></td>
        <td class="bodytext left" colspan="4"><?php echo $res22accountname;?></td>
	</tr>
	<?php
	
	$dotarray = explode("-", $paymentreceiveddateto);
	$dotyear = $dotarray[0];
	$dotmonth = $dotarray[1];
	$dotday = $dotarray[2];
	$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
	
	
	if ($range == '')
	{         
	$query2 = "select * from billing_paylater where accountname like '%$res21accountname%' and totalamount like '%$amount%' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
	}
	else if ($range == 'equal')
	{ 
	$query2 = "select * from billing_paylater where accountname = '$res21accountname' and totalamount = '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
	}
	else if ($range == 'greater')
	{
	$query2 = "select * from billing_paylater where accountname = '$res21accountname' and totalamount > '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
	}
	else if ($range == 'lesser')
	{
	$query2 = "select * from billing_paylater where accountname = '$res21accountname' and totalamount < '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
	}
	else if ($range == 'greaterequal')
	{
	$query2 = "select * from billing_paylater where accountname = '$res21accountname' and totalamount >= '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
	}
	else if ($range == 'lesserequal')
	{
	$query2 = "select * from billing_paylater where accountname = '$res21accountname' and totalamount <= '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
	}
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while ($res2 = mysql_fetch_array($exec2))
	{
	$res2billnumber = $res2['billno'];
	$res2billdate = $res2['billdate'];
	$res2patientcode = $res2['patientcode'];
	$res2visitcode = $res2['visitcode'];
	$res2patientname = $res2['patientname'];
	$res2totalamount = $res2['totalamount'];
	
	$total = $total + $res2totalamount;
	
	$query3 = "select * from master_consultationlist where patientcode = '$res2patientcode'";
	$exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
echo	$res3consultingdoctor = $res3['consultingdoctor'];
	
	$snocount = $snocount + 1;
	
	//echo $cashamount;

?>
    <tr>
        <td class="bodytext"><?php echo $res2billnumber; ?></td>
        <td class="bodytext"><?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
        <td class="bodytext"><?php echo $res2patientcode; ?></td>
        <td class="bodytext"><?php echo $res2visitcode; ?></td>
        <td class="bodytext" width="150"><?php echo $res3consultingdoctor; ?></td>
        <td class="bodytext" width="150"><?php echo $res2patientname; ?></td>
        <td class="bodytext right"><?php echo number_format($res2totalamount,2,'.',','); ?></td>
    </tr>
<?php
	}
	}
	}
?>
    <tr>
        <td colspan="6" class="bodytextbold right">Total Amount:</td>
        <td class="bodytext right"><?php echo number_format($total,2,'.',','); ?></td>
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
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('doctorutilizationreport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>