<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];

$colorloopcount = '';
$sno = '';
$snocount = 0;
$total='';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="servicesrevenue.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

if (isset($_REQUEST["category"])) { $scategory = $_REQUEST["category"]; } else { $scategory = ""; }


?>
</head>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<body>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="602" 
            align="left" border="0">
          <tbody>
            <tr>
              <td  align="left" colspan="2" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><?= $scategory ?></strong></td>
			</tr>	
            <tr>
              <td width="131"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
              <td width="122" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
                
              
            </tr>
			
			<?php
			
					$query02="select auto_number from  master_categoryservices where categoryname = '$scategory' ";
					$exec02=mysql_query($query02) or die("q1".mysql_error());
					if($res02=mysql_fetch_array($exec02)){
						$categoryanum=$res02['auto_number'];	
					
					$add_query=" and servicecategory = '$categoryanum'";
					}
		 
					$amount=0;
					$amount1=0;
					$ipamount=0;
					
					$query02="select sum(amount) as amount from  billing_paynowservices where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die("q1".mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$amount+=$res02['amount'];	

					$query02="select sum(amount) as amount from  billing_paylaterservices where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1'";
					$exec02=mysql_query($query02) or die("q2".mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$amount1+=$res02['amount'];
							
				  $totallopamount = $amount + $amount1;


					$query02="select sum(servicesitemrate) as amount from  billing_ipservices where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die("q3".mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$ipamount+=$res02['amount'];
		   
			  $query6647 = "select sum(servicesitemrate) as sumrate from billing_externalservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' ";
			  $exec6647 = mysql_query($query6647) or die("q4".mysql_error());
			  $res6647 = mysql_fetch_array($exec6647);
			  $externalrate = $res6647['sumrate'];
		  
		   $totalservicessales = $totallopamount + $ipamount + $externalrate ;
		 
		 
		 $sumtransactionamount=0;
		 $sumtransactionamount1=0;
		 $sumtransactionamount2=0;
		  
			$query02="select sum(servicesitemrate) as sumrate from refund_paynowservices where patientvisitcode <>'walkinvis' and billdate between '$ADate1' and '$ADate2'";
			$exec02=mysql_query($query02) or die(mysql_error());
			$res02=mysql_fetch_array($exec02);
				$sumtransactionamount =$res02['sumrate'];	
			
		  $query021="select sum(servicesitemrate) as sumrate from refund_paynowservices where patientvisitcode ='walkinvis' and billdate between '$ADate1' and '$ADate2'";
			$exec012=mysql_query($query021) or die(mysql_error());
			$res021=mysql_fetch_array($exec012);
				$sumtransactionamount1 =$res021['sumrate'];
//IP Discount for services 

	  $totallsumtransactionamount2=$sumtransactionamount+$sumtransactionamount1;
		  $nettotalamount=$totalservicessales - $totallsumtransactionamount2;
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
           <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>OP Sales</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totallopamount,2,'.',','); ?></strong></div></td>
                
            
             
           </tr>
			<?php
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
			<tr >
              <td class="bodytext31" valign="center"  align="left"><strong>IP Sales</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($ipamount,2,'.',','); ?></strong></div></td>
                
              
             
           </tr>
		   <?php
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
			<tr >
              <td class="bodytext31" valign="center"  align="left"><strong>External Sales</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($externalrate,2,'.',','); ?></strong></div></td>   
                 
           </tr>
		    <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totalservicessales,2,'.',','); ?></strong></div></td> 
                  
           </tr>
		    <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>OP Returns</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($sumtransactionamount,2,'.',','); ?></strong></div></td>  
                
           </tr>
          <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Ext Returns</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($sumtransactionamount1,2,'.',','); ?></strong></div></td>
                  
           </tr>
		     <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($totallsumtransactionamount2,2,'.',','); ?></strong></div></td>
                  
           </tr>
		        <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Net Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($nettotalamount,2,'.',','); ?></strong></div></td>   
				
           </tr>
       
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
               >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
               >&nbsp;</td>
              <td width="161"  align="left" valign="center" 
                bgcolor="" class="bodytext31">&nbsp;</td>
				 <td width="156"  align="left" valign="center" 
                bgcolor="" class="bodytext31">&nbsp;</td>
 			
             
            </tr>
			
			
		</tbody>
        </table>	
</body>
</html>

