<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

$docno = $_SESSION['docno'];

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if($locationcode!='')
{
	$locationcode=$_REQUEST['locationcode'];
}
else
{
//header location
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
}
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
include("print_header.php");
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
$billnumber = $_REQUEST["billno"];
}
 $query19 = "select accountname,transactiondate,patientname from master_transactionpaylater where docno like '%$billnumber%' and  patientcode like '%$patientcode%' and visitcode like '%$visitcode%' ";
			$exec19 = mysql_query($query19) or die ("Error in query19".mysql_error());
			$res19 = mysql_fetch_array($exec19);
			$accountname= $res19['accountname'];
			$transactiondate= $res19['transactiondate'];
			$patientname= $res19['patientname'];
			
			?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
</style>
<table align="center">
	<tr>
    	<td class="bodyhead" colspan="5">PHARMACY CREDIT NOTE</td>
    </tr>
    <tr>
    	<td class="bodytextbold">Name:</td>
        <td class="bodytext"><?php echo $patientname; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Ref No:</td>
        <td class="bodytext"><?php echo $billnumber; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Reg. No:</td>
        <td class="bodytext"><?php echo $patientcode; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Ref Date:</td>
        <td class="bodytext"><?php echo $transactiondate; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Visit No:</td>
        <td class="bodytext"><?php echo $visitcode; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext"></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Account:</td>
        <td class="bodytext"><?php echo $accountname; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext"></td>
    </tr>
	<tr>
    	<td width="700" colspan="5">&nbsp;</td>
    </tr>
</table>
<table align="center" border="border-collapse">
	<tr>
    	<td class="bodytextbold" width="100" align="center">S.No</td>
        <td class="bodytextbold" width="450" align="center">Item Name</td>
        <td class="bodytextbold" width="100" align="center">Amount</td>
    </tr>
<?php
	$sno = '';
	$totalpharmacysalesreturn=0;
	$query7 = "SELECT itemname,totalamount FROM pharmacysalesreturn_details WHERE patientcode = '$patientcode' AND visitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
	$num7 = mysql_num_rows($exec7);
	while($res7 = mysql_fetch_array($exec7)){
	$itemname = $res7['itemname'];
	$amount = $res7['totalamount'];
	$totalpharmacysalesreturn=$totalpharmacysalesreturn+$amount;
	//$sno = $sno + 1;
	
	if($num7>=1)
	{
		$sno = $sno + 1;
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $itemname;?></td>
        <td class="bodytext" align="right"><?php echo '-'.number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
	}
	
?>
	<tr>
    	<td class="bodytextbold" colspan="2" align="right">Net Amount:</td>
        <td class="bodytext" align="right"><?php echo '-'.number_format($totalpharmacysalesreturn,2,'.',',');?></td>
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
        $html2pdf->Output('printopcreditnote.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
