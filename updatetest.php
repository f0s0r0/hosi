<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';

$query43 = "select * from purchase_details";
$exec43 = mysql_query($query43) or die(mysql_error());
while($res43 = mysql_fetch_array($exec43))
{

$itemcode = $res43['itemcode'];
$rate = $res43['rate'];
$receivedqty = $res43['quantity'];
$billnumber = $res43['billnumber'];

$totalamount = $receivedqty * $rate;

$query24 = "update purchase_details set subtotal='$totalamount',totalamount='$totalamount' where itemcode='$itemcode' and billnumber='$billnumber'";
$exec24 = mysql_query($query24) or die(mysql_error());
}


$query43 = "select * from purchase_details where typeofpurchase='Process'";
$exec43 = mysql_query($query43) or die(mysql_error());
while($res43 = mysql_fetch_array($exec43))
{

$itemcode = $res43['itemcode'];
$rate = $res43['rate'];
$billnumber = $res43['billnumber'];
$packagename = $res43['packagename'];
$packagename1 = strlen($packagename);
$packsize = substr($packagename,0,$packagename1-1);
$costprice = $rate / $packsize;

$query24 = "update purchase_details set costprice='$costprice' where itemcode='$itemcode' and billnumber='$billnumber'";
$exec24 = mysql_query($query24) or die(mysql_error());

$query241 = "update master_medicine set purchaseprice='$costprice' where itemcode='$itemcode'";
$exec241 = mysql_query($query241) or die(mysql_error());

$query241 = "update master_itempharmacy set purchaseprice='$costprice' where itemcode='$itemcode'";
$exec241 = mysql_query($query241) or die(mysql_error());


}

$query23 = "select * from purchase_details where typeofpurchase='Process'";
$exec23 = mysql_query($query23) or die(mysql_error());
while($res23 = mysql_fetch_array($exec23))
{

$itemcode = $res23['itemcode'];
$costprice = $res23['costprice'];

$query231 = "select * from master_medicine where itemcode='$itemcode'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$spmarkup = $res231['spmarkup'];

$salespriceamount = ($costprice * $spmarkup)/100;
$salesprice = $costprice + $salespriceamount;

$query24 = "update purchase_details set salesprice='$salesprice' where itemcode='$itemcode' and costprice='$costprice'";
$exec24 = mysql_query($query24) or die(mysql_error());

$query241 = "update master_medicine set rateperunit='$salesprice' where itemcode='$itemcode'";
$exec241 = mysql_query($query241) or die(mysql_error());

$query241 = "update master_itempharmacy set rateperunit='$salesprice' where itemcode='$itemcode'";
$exec241 = mysql_query($query241) or die(mysql_error());


}

?>
