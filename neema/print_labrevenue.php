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
header('Content-Disposition: attachment;filename="labrevenue.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }


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
              <td width="108"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
              <td width="154" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
                
              
            </tr>
			
			<?php
			
		


					$amount=0;
					$amount1=0;
					$ipamount=0;
					
					$query02="select sum(labitemrate) as amount from  billing_paynowlab where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die(mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$amount+=$res02['amount'];	

					$query02="select sum(labitemrate) as amount from  billing_paylaterlab where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die(mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$amount1+=$res02['amount'];
							
				  $totallopamount = $amount + $amount1;


					$query02="select sum(labitemrate) as amount from  billing_iplab where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die(mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$ipamount+=$res02['amount'];
		   
		  $query6647 = "select sum(labitemrate) as sumrate from billing_externallab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysql_query($query6647) or die(mysql_error());
		  $res6647 = mysql_fetch_array($exec6647);
		  $externalrate = $res6647['sumrate'];
		  
		   $totallabsales = $totallopamount + $ipamount + $externalrate ;
		 
		 
		 $sumtransactionamount=0;
		 $sumtransactionamount1=0;
		 $sumtransactionamount2=0;
		  
			$query02="select sum(labitemrate) as labamount from refund_paynowlab where patientvisitcode <>'walkinvis' and  billdate between  '$ADate1' and '$ADate2'";
			$exec02=mysql_query($query02) or die(mysql_error());
			while($res02=mysql_fetch_array($exec02)){
				$sumtransactionamount +=$res02['labamount'];	
			}
			$query02="select sum(labitemrate) as labamount from refund_paynowlab where patientvisitcode='walkinvis' and billdate between  '$ADate1' and '$ADate2'";
			$exec02=mysql_query($query02) or die(mysql_error());
			while($res02=mysql_fetch_array($exec02)){
				$sumtransactionamount2 +=$res02['labamount'];	
			}
		  
		  $totallsumtransactionamount2=$sumtransactionamount+$sumtransactionamount2;
		  $nettotalamount=$totallabsales - $totallsumtransactionamount2;
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
              <td class="bodytext31" valign="center"  align="left">><strong>External Sales</strong></td>
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
                <div class="bodytext31"><strong><?php echo number_format($totallabsales,2,'.',','); ?></strong></div></td> 
                  
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
              <td  align="left" valign="center" class="bodytext31"><strong>Ext  Returns</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($sumtransactionamount2,2,'.',','); ?></strong></div></td>
                  
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="">&nbsp;</td>
 			
             
            </tr>
			
	 </tbody>
        </table>		
</body>
</html>

