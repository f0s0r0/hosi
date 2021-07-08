<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];


		$query1 = "select sum(amount) from billing_ipadmissioncharge where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$totalipadmissionamount =$res1['sum(amount)'];
	    }	

		$query2 = "select sum(amount) from billing_ipbedcharges where description='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		
		while($res2 = mysql_fetch_array($exec2))
		{
		$totalbedcharges=$res2['sum(amount)'];
		 }	
		  
		 ?>

         		 <?php 				
	    		
		$query3 = "select sum(amount) from billing_ipbedcharges where description='RMO charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
		
		while($res3 = mysql_fetch_array($exec3))
		{
		$totalrmocharges=$res3['sum(amount)'];
		 }	
		 ?>
		 <?php
		 $query4 = "select sum(amount) from billing_ipbedcharges where description='Nursing Charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		
		while($res4 = mysql_fetch_array($exec4))
		{
		$totalnursingcharges=$res4['sum(amount)'];
		 }
		 ?>
		 <?php 
		 $query5 = "select sum(amount) from billing_ippharmacy where billdate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		
		while($res5 = mysql_fetch_array($exec5))
		{
		$totalpharmacyamount=$res5['sum(amount)'];
		 }	
		 ?>
		 <?php
		  $query6 = "select sum(labitemrate) from billing_iplab where billdate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		
		while($res6 = mysql_fetch_array($exec6))
		{
		$totallabamount=$res6['sum(labitemrate)'];
		 }	
		 ?>
		 	 
		 <?php
		  $query7 = "select sum(radiologyitemrate) from billing_ipradiology where billdate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		
		while($res7 = mysql_fetch_array($exec7))
		{
		$totalradiologyamount=$res7['sum(radiologyitemrate)'];
		 }	
		 ?>
		 <?php
		   $query8 = "select sum(servicesitemrate) from billing_ipservices where billdate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		
		while($res8 = mysql_fetch_array($exec8))
		{
		$totalservicesamount=$res8['sum(servicesitemrate)'];
		 }	
		 ?>
		 	
		 <?php
		    $query9 = "select sum(amount) from billing_ipotbilling where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$num9=mysql_num_rows($exec9);
		
		while($res9 = mysql_fetch_array($exec9))
		{
		$totalotamount=$res9['sum(amount)'];
		 }	
		 ?>
		 
			<?php
		  $query10 = "select sum(amount) from billing_ipmiscbilling where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		
		while($res10 = mysql_fetch_array($exec10))
		{
		$totalmiscamount=$res10['sum(amount)'];
		 }	
		 ?>
		<?php	 
		 $query11 = "select sum(amount) from billing_ipambulance where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		
		while($res11 = mysql_fetch_array($exec11))
		{
		$totalambulanceamount=$res11['sum(amount)'];
		 }	
		 ?>		
			<?php
			 
		 $query12 = "select sum(amount) from billing_ipprivatedoctor where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while($res12 = mysql_fetch_array($exec12))
		{
		$totalipprivatedoctoramount=$res12['sum(amount)'];
		 }	
		 ?>
		 <?php	 
		 $query13 = "select sum(transactionamount) from master_transactionipdeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		
		while($res13 = mysql_fetch_array($exec13))
		{
		$totalipdepositsamount=$res13['sum(transactionamount)'];
		 }	

$data = array($totalipadmissionamount,$totalbedcharges,$totalrmocharges,$totalnursingcharges,$totalpharmacyamount,$totallabamount,$totalradiologyamount,
$totalservicesamount,$totalotamount,$totalmiscamount,$totalambulanceamount,$totalipprivatedoctoramount,$totalipprivatedoctoramount);

//print_r($data);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_pie.php' );

$g = new graph();
$g->bg_colour = '0xFFFFFF';

// PIE chart, 60% alpha
//.
$g->pie(180,'#505050','{font-size: 12px; color: #404040;');
$pie = new pie();

$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
// pass in two arrays, one of data, the other data labels
//$alldepartment = array('Laboratory', 'Radiology', 'Services');

//$c = array_combine($data, $alldepartment);

//print_r($c);
$alldepartment = array('Admission:', 'Bed Charges:', 'RMO:', 'Nursing:', 'Pharmacy:','Lab','Radiology','Services','OT','Misc Bill','Ambulance','Private Doctor','Deposits');

$c = array_combine($data, $alldepartment);

foreach($c as $key => $value) {
  //echo "$key $value".' ';
  $both[] = "$value $key".' ';
}
print_r($c);

$g->pie_values( $data, $both,'' );

//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF','#0000FF','#0000FF','#0000FF','#0000FF','#0000FF','#0000FF','#0000FF','#0000FF','#0000FF',) );

//$g->set_tool_tip( '#val# of #total# <br>#percent# of 100%' );

$g->title( 'Hospital Revenue', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
