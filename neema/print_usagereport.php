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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";



if (isset($_REQUEST["code"])) { $searchsuppliername = $_REQUEST["code"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
ob_start();
?>

<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px;  text-align:center;}
.bodytext{font-weight:normal; font-size:13px; text-align:center; vertical-align:middle;}
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
    	<td class="bodyhead" align="center">Usage Report</td>
    </tr>
    <tr>
    	<td class="bodytext" align="center"><strong>From: </strong><?php echo date('d/m/Y',strtotime($ADate1));?><strong> To: </strong>
		<?php echo date('d/m/Y',strtotime($ADate2));?></td>
    </tr>
</table>
<table align="center">
<thead>
    <tr>
        <td class="bodytextbold border">Bill No</td>
        <td class="bodytextbold border">Date</td>
        <td class="bodytextbold border">Reg. No</td>
        <td class="bodytextbold border">OP No</td>
        <td class="bodytextbold border">Account</td>
        <td class="bodytextbold border">Patient</td>
        <td class="bodytextbold border">Bill Amount</td>
    </tr>
</thead>
	<?php
   
    $query21 = "select * from billing_paylater where accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
    $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
    while ($res21 = mysql_fetch_array($exec21))
    {
    $res21accountname = $res21['accountname'];
    
    $query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";
    $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
    $res22 = mysql_fetch_array($exec22);
    $res22accountname = $res22['accountname'];
    
    if( $res21accountname != '')
    {
	?>
	<tr>
		<td colspan="7"  class="bodytextbold left"><?php echo $res22accountname;?></td>
	</tr>
<?php
	
	$dotarray = explode("-", $paymentreceiveddateto);
	$dotyear = $dotarray[0];
	$dotmonth = $dotarray[1];
	$dotday = $dotarray[2];
	$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
	
	
	$query2 = "select * from billing_paylater where accountname like '%$res21accountname%' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while ($res2 = mysql_fetch_array($exec2))
	{
	$res2billnumber = $res2['billno'];
	$res2billdate = $res2['billdate'];
	$res2patientcode = $res2['patientcode'];
	$res2visitcode = $res2['visitcode'];
	$res2patientname = $res2['patientname'];
	$res2totalamount = $res2['totalamount'];
	$res2accountname = $res2['accountname'];
	
	$total = $res2totalamount + $total;
	
	$query3 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and transactiontype = 'finalize'";
	$exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$res3doctorname = $res3['doctorname'];
	
	$snocount = $snocount + 1;
	
	//echo $cashamount;


?>
    <tr>
        <td class="bodytext"><?php echo $res2billnumber; ?></td>
        <td class="bodytext"><?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
        <td class="bodytext"><?php echo $res2patientcode; ?></td>
        <td class="bodytext"><?php echo $res2visitcode; ?></td>
        <td class="bodytext left" width="150"><?php echo $res2accountname; ?></td>
        <td class="bodytext left" width="100><?php echo $res2patientname; ?></td>
        <td class="bodytext right"><?php echo number_format($res2totalamount,2,'.',','); ?></td>
    </tr>
<?php
	}
	}
	}
?>
	<tr>
        <td colspan="6" class="bodytextbold right">Grand Total:</td>
        <td class="bodytext right"><?php echo number_format($total,2,'.',','); ?> </td>
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
        $html2pdf->Output('usagereport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
	}
?>