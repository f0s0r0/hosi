<?php
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
$totalsum = 0.00;
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
$totalpayment = 0.00;
$totout = 0.00;
$res112subtotal = 0.00;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="supplieroutstanding.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>

       <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["name"])) { $arraysuppliername = $_REQUEST["name"]; } else { $arraysuppliername = ""; }
					//echo $searchsuppliername;
					if (isset($_REQUEST["code"])) { $arraysuppliercode = $_REQUEST["code"]; } else { $arraysuppliercode = ""; }

					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
					//echo $ADate1;
					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				}	
			
				?>
         <table width="116%" border="0" cellspacing="0" cellpadding="0">
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
			 $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
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
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$query21 = "select * from master_supplier where suppliername like '%$arraysuppliername%' and status <>'DELETED' and dateposted between '$ADate1' and '$ADate2' group by suppliername order by suppliername desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			
			$res21accountname = $res21['suppliername'];
			$supplieranum = $res21['auto_number'];
			 ?>
			 <?php 
			
			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>
            </tr>
			
			<?php } ?>
			<?php
			$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
			$totalamountgreater = 0;

			  $query45 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' ";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['transactiondate'];
	      $res45patientname = $res45['suppliername'];
		  $res45patientcode = $res45['suppliercode'];
		  $res45transactionamount = $res45['transactionamount'];
		  $res45billnumber = $res45['billnumber'];
		  $res45openingbalance = $res45['openingbalance'];
		  
		   $query98 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res45billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule= 'PAYMENT' ";
		  $exec98 = mysql_query($query98) or die(mysql_error());
		  $num98 = mysql_num_rows($exec98);
		  while($res98 = mysql_fetch_array($exec98))
		  {
         $totalpayment =$res98['sum(transactionamount)'];
		  }
		  
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
		  $totalout = $res45transactionamount - $totalpayment;
		  $totcur = $totalout - $totalat;
		   }
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
			<?php 
			  if($totalpayment != $res45transactionamount) 
			   {
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
			    <div align="right"><?php echo number_format($totalout,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
				<?php $totalsum = $totalsum + $totalout; ?>
			    <div align="center"><?php echo $days_between;?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalsum,2,'.',','); ?></div></td>
                </tr>
		      <?php 
			    }      }
			  ?>
		   
		   <?php
		   
		    $query145 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' order by transactiondate desc";
		  $exec145 = mysql_query($query145) or die ("Error in Query145".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res145 = mysql_fetch_array($exec145))
		  {
     	  $res145transactiondate = $res145['transactiondate'];
	      $res145patientname = $res145['suppliername'];
		  $res145patientcode = $res145['suppliercode'];
		  $res145transactionamount = $res145['transactionamount'];
		  $res145billnumber = $res145['billnumber'];
		  $res145openingbalance = $res145['openingbalance'];
		  $res145docno = $res145['docno'];
		  
		   $query198 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res145billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule= 'PAYMENT' order by transactiondate desc";
		  $exec198 = mysql_query($query198) or die(mysql_error());
		  $num198 = mysql_num_rows($exec198);
		  while($res198 = mysql_fetch_array($exec198))
		  {
         $totalpayment =$res198['sum(transactionamount)'];
		  }
		    
     	  $query113 = "select * from purchasereturn_details where grnbillnumber= '$res145billnumber' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
		  $exec113 = mysql_query($query113) or die ("Error in Query113".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   while ($res113 = mysql_fetch_array($exec113)) {
		   
		     
		  $res113billnumber= $res113['grnbillnumber'];
		  $res113rbillnumber= $res113['billnumber'];
		   
		  $query112 = "select *  from purchasereturn_details where grnbillnumber = '$res113billnumber' and entrydate between '$ADate1' and '$ADate2' ";
		  $exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   while($res112 = mysql_fetch_array($exec112)) {
		     
		   $res112subtotal= $res112['subtotal'];
		          }
		   		  
		  
				  		  
		   $totalsum = $totalsum - $res112subtotal;
		 
		   
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
			<?php if($res112subtotal != 0)
			 { 
			  ?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res145transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Return ('.$res113rbillnumber.','.$res145billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res112subtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
				
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalsum,2,'.',','); ?></div></td>
                </tr>
		   <?php
		     } }
           }   
		   ?>
		  
		  
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
			    </tr>
				 </tbody>
        </table></td>
      </tr>
	  
   
			<tr>
        <td>&nbsp;</td>
      </tr>
		
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
            	 </tr>
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong>30 days</strong></td>
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
                bgcolor="#ffffff"><strong>Total Outstanding</strong></td>
            </tr>
			<?php 
			//$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalsum,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalsum,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		    <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
           
		   	<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
               </tr>
			  </table>
			<?php
			}
			
			//}
			?>
</table>
</table>
