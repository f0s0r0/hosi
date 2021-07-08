<?php

//to redirect if there is no entry in masters category or item.
$query90 = "select count(auto_number) as masterscount from master_categorypharmacy";
$exec90 = mysql_query($query90) or die ("Error in Query90".mysql_error());
$res90 = mysql_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1.php?svccount=firstentry");
}


//to redirect if there is no entry in masters category or item or customer.
$query90 = "select count(auto_number) as masterscount from master_itempharmacy";
$exec90 = mysql_query($query90) or die ("Error in Query90".mysql_error());
$res90 = mysql_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:additem1.php?svccount=firstentry");
	exit;
}

//to redirect if there is no entry in masters category or item or customer.
$query91 = "select count(auto_number) as masterscount from master_supplier";
$exec91 = mysql_query($query91) or die ("Error in Query91".mysql_error());
$res91 = mysql_fetch_array($exec91);
$res91count = $res91["masterscount"];
if ($res91count == 0)
{
	header ("location:addsupplier1.php?svccount=firstentry");
	exit;
}


?>