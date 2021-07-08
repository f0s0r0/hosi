<?php
$openingbalance = "0.00";
$totalamount21 = "0.00";
$totalamount2 = "0.00";

$query89 = "select accountssub, id from master_accountname where auto_number = '$ledgeranum'";
$exec89 = mysql_query($query89) or die ("Error in Query89".mysql_error());
$res89 = mysql_fetch_array($exec89);
$group = $res89['accountssub'];
$ledgerid = $res89['id'];

$query678 = "select accountsmain from master_accountssub where auto_number = '$group'";
$exec678 = mysql_query($query678) or die ("Error in Query678".mysql_error());
$res678 = mysql_fetch_array($exec678);
$accountsmain = $res678['accountsmain'];

$query6781 = "select section from master_accountsmain where auto_number = '$accountsmain'";
$exec6781 = mysql_query($query6781) or die ("Error in Query6781".mysql_error());
$res6781 = mysql_fetch_array($exec6781);
$type1 = $res6781['section'];

$query83 = "select condfield from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
$exec83 = mysql_query($query83) or die ("Error in Query83".mysql_error());
$res83 = mysql_fetch_array($exec83);
$condfield3 = $res83['condfield'];
if($condfield3 == '')
{
$query31 = "select tblname, field, datefield, coa, selectstatus, code from master_financialintegration where code = '$ledgerid' and recordstatus <> 'deleted'";
}
else
{
$query31 = "select tblname, field, datefield, coa, selectstatus, code from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
}
$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
while($res31 = mysql_fetch_array($exec31))
{
$tblname1 = $res31['tblname'];
$tblcolumn1 = $res31['field'];
$tbldate1 = $res31['datefield'];
$acccoa = $res31['coa'];
$status = $res31['selectstatus'];
//$type1 = $res31['type'];
//$condfield = $res31['condfield'];
$code1 = $res31['code'];

$query9 = "select accountname, id from master_accountname where auto_number = '$ledgeranum'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$accountsmain2 = $res9['accountname'];	
$id2 = $res9['id'];


$query81 = "select condfield from master_financialintegration where groupcode = '$group' and tblname = '$tblname1' and recordstatus <> 'deleted'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$condfield1 = $res81['condfield'];
if($condfield1 == '')
{
$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $tbldate1 < '$ADate1' and locationcode = '$location'";
}
else
{
$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $condfield1 = '$id2' and $tbldate1 < '$ADate1' and locationcode = '$location'";
}
$exec132 = mysql_query($query132) or die ("Error in Query132".mysql_error());
$res132 = mysql_fetch_array($exec132);
//echo '<br>'.$query132;
$totalsumamount32 = $res132['totalsumamount32'];

if($status == 'dr' && $type1 == 'A')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'cr' && $type1 == 'A')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
if($status == 'cr' && $type1 == 'I')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'dr' && $type1 == 'I')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
if($status == 'cr' && $type1 == 'L')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'dr' && $type1 == 'L')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
if($status == 'dr' && $type1 == 'E')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'cr' && $type1 == 'E')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
}
//$openingbalance;
/*if($type1 == 'A' || $type1 == 'E')
{
$openingbalancedebit = $openingbalance;
}
else
{
$openingbalancecredit = $openingbalance;
}*/
$openingbalance;
?>	
<?php
$query8 = "select condfield from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$condfield = $res8['condfield'];
if($condfield == '')
{
$query1 = "select tblname, field, datefield, coa, selectstatus, code, displayname, condfield, auto_number from master_financialintegration where code = '$ledgerid' and selectstatus = 'dr' and recordstatus <> 'deleted'";
}
else
{
$query1 = "select tblname, field, datefield, coa, selectstatus, code, displayname, condfield, auto_number from master_financialintegration where groupcode = '$group' and selectstatus = 'dr' and recordstatus <> 'deleted'";
}
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while($res1 = mysql_fetch_array($exec1))
{
$tblname1 = $res1['tblname'];
$tblcolumn1 = $res1['field'];
$tbldate1 = $res1['datefield'];
//$acccoa = $res1['coa'];
$status = $res1['selectstatus'];
//$type1 = $res1['type'];
$displayname = $res1['displayname'];
$condfield = $res1['condfield'];
$code1 = $res1['code'];
$fanum1 = $res1['auto_number'];

$query9 = "select accountname, id from master_accountname where auto_number = '$ledgeranum'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$acccoa = $res9['accountname'];
$id = $res9['id'];

if($condfield == '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
else
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $condfield = '$id' and $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while($res2 = mysql_fetch_array($exec2))
{
$totalsumamount2 = $res2['totalsumamount2'];

$totalamount21 = $totalamount21 + $totalsumamount2;

}
}
?>
<?php
$totalamount2 = '0.00';
$snocount = '';
$condfield1 = '';
$query81 = "select condfield from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$condfield1 = $res81['condfield'];
if($condfield1 == '')
{
$query1 = "select tblname, field, datefield, coa, selectstatus, code, displayname, condfield, auto_number from master_financialintegration where code = '$ledgerid' and selectstatus = 'cr' and recordstatus <> 'deleted'";
}
else
{
$query1 = "select tblname, field, datefield, coa, selectstatus, code, displayname, condfield, auto_number from master_financialintegration where groupcode = '$group' and selectstatus = 'cr' and recordstatus <> 'deleted'";
}
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while($res1 = mysql_fetch_array($exec1))
{
$tblname1 = $res1['tblname'];
$tblcolumn1 = $res1['field'];
$tbldate1 = $res1['datefield'];
//$acccoa = $res1['coa'];
$status = $res1['selectstatus'];
//$type1 = $res1['type'];
$displayname = $res1['displayname'];
$condfield = $res1['condfield'];
$code1 = $res1['code'];
$fanum2 = $res1['auto_number'];

$query9 = "select accountname, id from master_accountname where auto_number = '$ledgeranum'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$acccoa = $res9['accountname'];
$id = $res9['id'];
		
if($condfield == '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
else
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $condfield = '$id' and $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while($res2 = mysql_fetch_array($exec2))
{
$totalsumamount2 = $res2['totalsumamount2'];

$totalamount2 = $totalamount2 + $totalsumamount2;

}
}
if($type1 == 'A' || $type1 == 'E')
{
$balance = $totalamount21 - $totalamount2 + $openingbalance;
}
else
{
$balance = $totalamount2 - $totalamount21 + $openingbalance;
} 
?>