<?php
include ("db/db_connect.php");
$query1 = "select * from neema.master_customer where subtype <> '1' group by subtype";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$maintype = $res1['maintype'];
	$subtype = $res1['subtype'];
	$accountname = $res1['accountname'];
	$planname = $res1['planname'];
	
	echo '<br>'.$maintype.'->'.$subtype.'->'.$accountname.'->'.$planname;

	$query2 = mysql_fetch_array(mysql_query("select paymenttype from neema.master_paymenttype where auto_number='$maintype'"));
	echo '<br>'.$maintype1 = $query2['paymenttype'];

	$query21 = mysql_fetch_array(mysql_query("select paymenttype, auto_number from neema17.master_paymenttype where paymenttype='$maintype1'"));
	echo '<br>'.$maintype2 = $query21['paymenttype'];
	$mainanum1 = $query21['auto_number'];

	$query3 = mysql_fetch_array(mysql_query("select subtype from neema.master_subtype where auto_number='$subtype'"));
	echo '<br>'.$subtype1 = $query3['subtype'];

	$query31 = mysql_fetch_array(mysql_query("select auto_number, subtype from neema17.master_subtype where subtype='$subtype1' and maintype = '$mainanum1'"));
	echo '<br>'.$subtype2 = $query31['subtype'];
	$subanum2 = $query31['auto_number'];
	
	$query4 = mysql_fetch_array(mysql_query("select auto_number, accountname from neema.master_accountname where subtype='$subtype' and paymenttype = '$maintype'"));
	echo '<br>'.$account4 = $query4['accountname'];
	$accountanum4 = $query4['auto_number'];

	echo '<br>'."select auto_number, accountname from neema17.master_accountname where subtype='$subanum2' and paymenttype = '$mainanum1'";

	$query41 = mysql_fetch_array(mysql_query("select auto_number, accountname from neema17.master_accountname where subtype='$subanum2' and paymenttype = '$mainanum1'"));
	echo '<br>'.$account41 = $query41['accountname'];
	$accountanum41 = $query41['auto_number'];
	
}	
?>