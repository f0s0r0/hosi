<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();
$alldepartment = array();
$alldepartment1 = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

            $query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
	
			$query5 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);
			$res5labitemrate = $res5['labitemrate1'];
			
			$query6 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6labitemrate = $res6['labitemrate1'];
			
			$query7 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			$res7 = mysql_fetch_array($exec7);
			$res7labitemrate = $res7['labitemrate1'];
			
			$totallabitemrate = $res5labitemrate + $res6labitemrate + $res7labitemrate;
			
			$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec9 = mysql_query($query9) or die ("Error in query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$res9radiologyitemrate = $res9['radiologyitemrate1'];
			
			$query10 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
			$res10 = mysql_fetch_array($exec10);
			$res10radiologyitemrate = $res10['radiologyitemrate1'];
			
			$query11 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$res11 = mysql_fetch_array($exec11);
			$res11radiologyitemrate = $res11['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res9radiologyitemrate + $res10radiologyitemrate + $res11radiologyitemrate;
			
			$query13 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec13 = mysql_query($query13) or die ("Error in query13".mysql_error());
			$res13 = mysql_fetch_array($exec13);
			$res13servicesitemrate = $res13['servicesitemrate1'];
			
			$query14 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
			$res14 = mysql_fetch_array($exec14);
			$res14servicesitemrate = $res14['servicesitemrate1'];
			
			$query15 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
			$res15 = mysql_fetch_array($exec15);
			$res15servicesitemrate = $res15['servicesitemrate1'];
			
			$totalservicesitemrate = $res13servicesitemrate + $res14servicesitemrate + $res15servicesitemrate ;
			
			$query17 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysql_query($query17) or die ("Error in query17".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$res17referalitemrate = $res17['referalrate1'];
			
			$query18 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
			$res18 = mysql_fetch_array($exec18);
			$res18referalitemrate = $res18['referalrate1'];
			
			$totalreferalitemrate = $res17referalitemrate + $res18referalitemrate;
			
$data1 =  array($res1consultationamount,$totallabitemrate,$totalradiologyitemrate,$totalservicesitemrate,$totalreferalitemrate);
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'OP Revenue','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#DF013A', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);

$ymaxrange = max($data1);
$yminrange = min(array_filter($data1));
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 500;
echo $xy = round($xy, -3);

$g->set_data( $data1 );

$xlabells = array('Consultation', 'Lab', 'Radiology', 'Service','Referral');
$g->set_x_labels( $xlabells );
//$x_labels->set_colour( '#A2ACBA' );

$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy);
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
