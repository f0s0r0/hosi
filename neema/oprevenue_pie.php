<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

$yearfrom = $_SESSION['datefrom'];
$yearto = $_SESSION['dateto'];

$query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$yearfrom' and '$yearto'";
$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$res1consultationamount = $res1['billamount1'];

if($res1consultationamount != 0)
{
$data[] = $res1consultationamount;
$alldepartment1[] = "Consultation" ;
}

$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$yearfrom' and '$yearto'";
$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2labitemrate = $res2['labitemrate1'];

$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$yearfrom' and '$yearto'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$res3labitemrate = $res3['labitemrate1'];

$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$yearfrom' and '$yearto'";
$exec14 = mysql_query($query14) or die ("Error in query14".mysql_error());
$res14 = mysql_fetch_array($exec14);
$res14labitemrate = $res14['labitemrate1'];

$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;

if($totallabitemrate != 0)
{
$data[] = $totallabitemrate;
$alldepartment1[] = "Lab" ;
}

$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$yearfrom' and '$yearto'";
$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$res4radiologyitemrate = $res4['radiologyitemrate1'];

$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$yearfrom' and '$yearto'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
$res5radiologyitemrate = $res5['radiologyitemrate1'];

$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$yearfrom' and '$yearto'";
$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
$res15 = mysql_fetch_array($exec15);
$res15radiologyitemrate = $res15['radiologyitemrate1'];

$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;

if($totalradiologyitemrate != 0)
{
$data[] = $totalradiologyitemrate;
$alldepartment1[] = "Radiology" ;
}

$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$yearfrom' and '$yearto'";
$exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
$res6 = mysql_fetch_array($exec6);
$res6servicesitemrate = $res6['servicesitemrate1'];

$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$yearfrom' and '$yearto'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$res7servicesitemrate = $res7['servicesitemrate1'];

$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$yearfrom' and '$yearto'";
$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
$res16 = mysql_fetch_array($exec16);
$res16servicesitemrate = $res16['servicesitemrate1'];

$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;

if($totalservicesitemrate != 0)
{
$data[] = $totalservicesitemrate;
$alldepartment1[] = "Services" ;
}

$query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billdate between '$yearfrom' and '$yearto'";
$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$res8pharmacyitemrate = $res8['amount1'];

$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where billdate between '$yearfrom' and '$yearto'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$res9pharmacyitemrate = $res9['amount1'];

$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where billdate between '$yearfrom' and '$yearto'";
$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
$res17 = mysql_fetch_array($exec17);
$res17pharmacyitemrate = $res17['amount1'];

$totalpharmacyitemrate = $res8pharmacyitemrate + $res9pharmacyitemrate + $res17pharmacyitemrate;

if($totalpharmacyitemrate != 0)
{
$data[] = $totalpharmacyitemrate;
$alldepartment1[] = "Pharmacy" ;
}

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$yearfrom' and '$yearto'";
$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
$res10 = mysql_fetch_array($exec10);
$res10referalitemrate = $res10['referalrate1'];

$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$yearfrom' and '$yearto'";
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$res11referalitemrate = $res11['referalrate1'];

$totalreferalitemrate = $res10referalitemrate + $res11referalitemrate;

if($totalreferalitemrate != 0)
{
$data[] = $totalreferalitemrate;
$alldepartment1[] = "Referral" ;
}

//$data = array($res1consultationamount,$totallabitemrate,$totalradiologyitemrate,$totalservicesitemrate, $totalpharmacyitemrate, $totalreferalitemrate);

//print_r($data);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->bg_colour = '0xFFFFFF';

// PIE chart, 60% alpha
//
$g->pie(180,'#505050','{font-size: 12px; color: #404040;');
//
// pass in two arrays, one of data, the other data labels

$c = array_combine($data, $alldepartment1);

foreach($c as $key => $value) {
  //echo "$key $value".' ';
  $key = number_format($key,2,'.','');
  $both[] = "$value $key".' ';
}

//print_r($data);
//print_r($both);

$g->pie_values( $data, $both,'' );
//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF','#C79810','#FF0066','#FF3399') );

//$g->set_tool_tip( '#val# of #total#<br>#percent# of 100%' );

$g->title( 'OP Revenue', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
