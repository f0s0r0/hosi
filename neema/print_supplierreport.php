<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$totalat = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;
$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="supplierreport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["name"])) { $searchsuppliername = $_REQUEST["name"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["code"])) { $searchsuppliercode = $_REQUEST["code"]; } else { $searchsuppliercode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>

<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="860"><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#FFFFFF" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					/*$arraysupplier = explode("#", $searchsuppliername);
					$arraysuppliername = $arraysupplier[0];
					$arraysuppliername = trim($arraysuppliername);
					$arraysuppliercode = $arraysupplier[1];*/
     			}
				?>            </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
            </tr>
			<?php
		
			 $query1 = "select * from master_supplier where suppliercode = '$searchsuppliercode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$openingbalance = $res1['openingbalance'];	
		  ?>
			<!--<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><strong>&nbsp;</strong></td>
				
              <td width="9%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="35%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><strong> Opening Balance </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="16%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="16%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>
			</tr>-->
			
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
		  	$query21 = "select * from master_supplier where suppliername like '%$searchsuppliername%' and   status <>'DELETED' and dateposted between '$ADate1' and '$ADate2' group by suppliername order by suppliername desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$res21accountname = $res21['suppliername'];
			$supplieranum = $res21['auto_number'];
			 ?>
         
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>
            </tr>
		
		    <?php		
		
		  $query45 = "select * from master_transactionpharmacy where suppliercode = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' order by transactiondate desc";
		 $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['transactiondate'];
	      $res45patientname = $res45['suppliername'];
		  $res45patientcode = $res45['suppliercode'];
		  $res45transactionamount = $res45['transactionamount'];
		  $res45billnumber = $res45['billnumber'];
		  $res45openingbalance = $res45['openingbalance'];
		  
		  $query85 = "select * from master_purchase where billnumber = '$res45billnumber' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec85 = mysql_query($query85) or die ("Error in Query85".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   while ($res85 = mysql_fetch_array($exec85))
		  {
		  $res85supplierbillnumber = $res85['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $totalat = $totalat + $res45transactionamount + $openingbalance;
	
		  $snocount = $snocount + 1;
			
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
			
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res45transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Purchase'; ?> (<?php echo $res85supplierbillnumber; ?>,<?php echo $res45billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res45transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  }
		   ?>
			
			<?php
		  $query5 = "select * from master_transactionpharmacy where suppliercode = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res5 = mysql_fetch_array($exec5))
		  {
     	  $res5transactiondate = $res5['transactiondate'];
	      $res5patientname = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  $res5transactionamount = $res5['transactionamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  
		  $query15 = "select * from master_purchase where billnumber = '$res5billnumber' ";
		  $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   $res15 = mysql_fetch_array($exec15);
		  
		  $res15supplierbillnumber = $res15['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  $total = $res5transactionamount + $res5openingbalance;
		  
		  $totalat = $totalat - $total;
	
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Payment ('.$res5transactionmode.','.$res5chequenumber.','.$res5docnumber.','.$res5remarks; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res5transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  
		   ?>
		   
		   <?php
		      
		  $query65 = "select * from purchasereturn_details where suppliername = '$searchsuppliername' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
		   $exec65 = mysql_query($query65) or die ("Error in Query65".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res65 = mysql_fetch_array($exec65))
		  {
     	  $res65transactiondate = $res65['entrydate'];
	      $res65patientname = $res65['suppliername'];
		  $res65patientcode = $res65['suppliercode'];
		  $res65subtotal= $res65['subtotal'];
		  $res65billnumber = $res65['billnumber'];
		  $res65grnnumber = $res65['grnbillnumber'];
		 
		  $totalatret = $totalat - $res65subtotal ;
		  
		  $totalat = $totalat - $res65subtotal; 
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res65transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Return ('.$res65billnumber.','.$res65grnnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res65subtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  
		   ?>
		  
		  
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
            </tr>
				 </tbody>
        </table></td>
      </tr>
	  
   
			<tr>
        <td>
		
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
	
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total Due</strong></td>
            </tr>
			<?php 
			$grandtotal = $totalat;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($grandtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalat,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right">&nbsp;</td> 
		    </tr>
			
		    <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
           
		   	<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
               </tr>
			  </table>
			</td>
      </tr>
			<?php
			}
			
		
			?>
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
