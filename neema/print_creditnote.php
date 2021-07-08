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

	$query4 = "SELECT * FROM ip_creditnote WHERE patientcode = '$patientcode' AND visitcode = '$visitcode' AND billno = '$billnumber'";
	$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$patientname = $res4['patientname']; 
	$billnumbercode = $res4['billno']; 
	$patientcode = $res4['patientcode'];
	$dateonly = $res4['billdate']; 
	$visitcode = $res4['visitcode'];
	$patientaccount1 = $res4['accountname'];
	$totalamount = $res4['totalamount'];
	$remarks = $res4['remarks'];
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
    	<td class="bodyhead" colspan="5">IP CREDIT NOTE</td>
    </tr>
    <tr>
    	<td class="bodytextbold">Name:</td>
        <td class="bodytext"><?php echo $patientname; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Bill No:</td>
        <td class="bodytext"><?php echo $billnumbercode; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Reg. No:</td>
        <td class="bodytext"><?php echo $patientcode; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Bill Date:</td>
        <td class="bodytext"><?php echo $dateonly; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">IP Visit No:</td>
        <td class="bodytext"><?php echo $visitcode; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext"></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Account:</td>
        <td class="bodytext"><?php echo $patientaccount1; ?></td>
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
        <td class="bodytextbold" width="200" align="center">Description</td>
	<td class="bodytextbold" width="250" align="center">Remarks</td>
        <td class="bodytextbold" width="100" align="center">Amount</td>
    </tr>
<?php
	$sno = '';
	$query5 = "SELECT * FROM ip_creditnotebrief WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND docno = '$billnumber'";
	$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
	while($res5 = mysql_fetch_array($exec5)){
	$item = $res5['description'];
	$amount = $res5['rate'];
	$sno = $sno + 1;
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
	<td class="bodytext"><?php echo $remarks;?></td>
        <td class="bodytext" align="right"><?php echo $amount;?></td>
    </tr>
<?php
	}
?>
	<tr>
    	<td class="bodytextbold" colspan="3" align="right">Net Amount:</td>
        <td class="bodytext" align="right"><?php echo $totalamount;?></td>
    </tr>
</table>
<table align="left" border="0">
	<tr>
    	<td class="bodytextbold" width="" align="left"><strong>&nbsp;</strong></td>
        <td class="bodytextbold" width="" align="center"></td>
    </tr>
<tr>
    	<td class="bodytextbold" width="" align="left"><strong>&nbsp;</strong></td>
        <td class="bodytextbold" width="" align="center"></td>
    </tr>
<tr>
    	<td class="bodytextbold" width="" align="left"><strong>Proposed By: ------------------------------</strong></td>
        <td class="bodytextbold" width="" align="center"></td>
    </tr>
<tr>
    	<td class="bodytextbold" width="" align="left"><strong>&nbsp;</strong></td>
        <td class="bodytextbold" width="" align="center"></td>
    </tr>
<tr>
    	<td class="bodytextbold" width="" align="left"><strong>&nbsp;</strong></td>
        <td class="bodytextbold" width="" align="center"></td>
    </tr>
<tr>
    	<td class="bodytextbold" width="" align="left"><strong>Authorised By: ------------------------------</strong></td>
        <td class="bodytextbold" width="" align="center"></td>
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
        $html2pdf->Output('printcreditnote.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
