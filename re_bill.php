<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2016-01-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = "2016-08-30"; }
?>
<table border="1" width="100%" style="border-collapse:collapse;">
<tr>
<td colspan="15" align="center" valign="middle"><strong>MARYHELP HOSPITAL</strong></td>
</tr>
<tr>
<td colspan="15" align="center" valign="middle"><strong>Bill Reconcile</strong></td>
</tr>
<form method="post" action="">
<tr>
<td colspan="15" align="center" valign="middle"><strong>From &nbsp; <input type="date" name="ADate1" value="<?= $ADate1; ?>" />&nbsp; To &nbsp; <input type="date" name="ADate2" value="<?= $ADate2; ?>" />&nbsp;</strong>
<input type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
<?php 
$query8 = "SELECT transactiondate, billnumber FROM `master_transactionpharmacy` WHERE `billnumber` LIKE 'EXP%' and `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'PURCHASE'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
while($res8 = mysql_fetch_array($exec8))
{
$billnumber = $res8['billnumber'];
$transactiondate = $res8['transactiondate'];

echo '<br>'.$query3 = "UPDATE `expensepurchase_details` set entrydate = '$transactiondate' WHERE `billnumber` = '$billnumber'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
?>
</table>