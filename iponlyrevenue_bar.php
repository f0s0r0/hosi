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

            $query2 = "select sum(amount) from billing_ipadmissioncharge where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$num2=mysql_num_rows($exec2);
			$res2 = mysql_fetch_array($exec2);
			$totalipadmissionamount =$res2['sum(amount)'];
			
			$query3 = "select sum(packagecharge) as packagecharge from master_ipvisitentry where consultationdate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$num3=mysql_num_rows($exec3);
			$res3 = mysql_fetch_array($exec3);
			$totalippackageamount =$res3['packagecharge'];
			
			$query4 = "select sum(amount) from billing_ipbedcharges where description='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$num4 = mysql_num_rows($exec4);
			$res4 = mysql_fetch_array($exec4);
			$totalbedcharges =$res4['sum(amount)'];
			
			$totalhospitalrevenue = $totalbedcharges + $totalippackageamount + $totalipadmissionamount;
			
			$query8 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$res8labitemrate = $res8['labitemrate1'];
		    
			$query12 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec12 = mysql_query($query12) or die ("Error in query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res12radiologyitemrate = $res12['radiologyitemrate1'];
		
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
			$res16 = mysql_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
		
$data1 =  array($totalhospitalrevenue,$res8labitemrate,$res12radiologyitemrate,$res16servicesitemrate);

include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'IP Revenue','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#DF013A', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);

$ymaxrange = max($data1);
$yminrange = min($data1);
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 500;
echo $xy = round($xy, -3);

$g->set_data( $data1 );

$xlabells = array('Hospital', 'Lab', 'Radiology', 'Services');
$g->set_x_labels( $xlabells );
//$x_labels->set_colour( '#A2ACBA' );

$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy);
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
