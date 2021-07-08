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
header('Content-Disposition: attachment;filename="Expenditure Report.xls"');
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
            <tr>
              <td  width="25" height="25"  align="left" valign="center"
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				 <td   align="left" valign="center" width="76"
                bgcolor="#ffffff" class="bodytext31"><strong>Month </strong></td>
				<td   align="left" valign="center" width="59"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Docno</strong></div></td>
				<td   align="left" valign="center" width="86"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Insurance</strong></div></td>
				<td   align="left" valign="center" width="60"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Fuel</strong></div></td>
     			<td   align="left" valign="center" width="91" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Maintenance</strong></div></td>
     			<td   align="left" valign="center" width="91" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Coordinator</strong></div></td>
				 <td   align="left" valign="center" width="112"
                bgcolor="#ffffff" class="bodytext31"><strong>Human Resource </strong></td>
				<td   align="left" valign="center" width="93"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Drugs</strong></div></td>
				<td   align="left" valign="center" width="146"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>consumables</strong></div></td>
				<td   align="left" valign="center" width="137"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>coordination</strong></div></td>
              	</tr>
			<?php
			
			
			
		  $query11 = "select * from ambulanceexpenditure where recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows=mysql_num_rows($exec11);
		 while($res11 = mysql_fetch_array($exec11))
		 {
		$docno=$res11['docno'];
		$month=$res11['month'];
		$insurance = $res11['insurance'];
		$fuel = $res11['fuel'];
		$maintenance = $res11['maintenance'];
		$coordinator=$res11['coordinator'];
		$humanresource=$res11['humanresource'];
		$drugs = $res11['drugs'];
		$consumables = $res11['consumables'];
		$coordination = $res11['coordination'];
					
			
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
              <td class="bodytext31" valign="left" width="25"  align="left"><div align="center"><?php echo $colorloopcount; ?></div></td>
			   <td class="bodytext31" valign="center" width="76"  align="left">
			    <?php echo $month; ?></td>
			   <td class="bodytext31" valign="left" width="59"  align="left">
			    <?php echo $docno; ?></td>
				<td class="bodytext31" valign="center" width="86"  align="left">
			    <?php echo $insurance; ?></td>
			   <td class="bodytext31" valign="center" width="60"  align="left">
			    <?php echo $fuel; ?></td>
			   <td class="bodytext31" valign="center" width="91"  align="left">
			    <?php echo $maintenance; ?></td>
			   <td class="bodytext31" valign="center" width="91"  align="left">
			    <?php echo $coordinator; ?></td>
			   <td class="bodytext31" valign="left" width="112"  align="left">
			    <?php echo $humanresource; ?></td>
				<td class="bodytext31" valign="center" width="93"  align="left">
			    <?php echo $drugs; ?></td>
			   <td class="bodytext31" valign="center" width="146"  align="left">
			    <?php echo $consumables; ?></td>
			   <td class="bodytext31"  valign="center"  align="left">
			    <?php echo $coordination; ?></td>
                              
              
			    </tr>
			  <?php
			}

			
			?>          </tbody>
        </table>