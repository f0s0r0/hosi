<html>
<?php include ("db/db_connect.php"); ?>
<?php
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; 
$ADate1 = date('Y-m-d',strtotime('-1 month'));
$ADate2 = date('Y-m-d');

$visitcode= $_REQUEST['visitcode'];
$visitnum=strlen($visitcode);
      $vvcode6=str_split($visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$visitnum-$value6;
$visitcodenew = substr($visitcode,$visitcodepre6,$visitnum);
$visitcodenew1 = intval($visitcodenew);
} 
else { $patientcode = "";
 $visitcode=""; } 
 
	function arrayHasOnlyInts($array)
{
$count=0;
$count1=0;
    foreach ($array as $key => $value)
    {
        if (is_numeric($value)) // there are several ways to do this
        {
		$count1++;    
		
        }
		else
		{
		$count=$count+1;
		
		}
    }
    return $count1; 
}				
?>
<style>
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<body>
<table>


<tr>
<td align="center" valign="middle" class="bodytext3"><strong>Completed Results</strong></td>
</tr>


<tr>
<td width="400" align="left" valign="middle" bgcolor="#E0E0E0" >
				  <table width="400" height="30">
				  <tr>
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Date </span></td>
				  				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Lab Test</span></td>
				   <td width="4%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Result</span></td>
				  </tr>
				  <?php 
				  $colorloopcount = '';
				  $sno = 0;
		$query1 = "select * from resultentry_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  resultstatus='completed' and publishstatus = 'completed' group by docnumber order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1['itemcode'];
		$itemname = $res1['itemname'];
		$date5 = $res1['recorddate'];
		$docnumber = $res1['docnumber'];

				 	  $colorloopcount = $colorloopcount + 1;
					  $sno = $sno + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date5; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="labresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>">View</a></div></td>
			 
			
			   	</tr>
				  <?php
				 
				  }

		$query1 = "select labitemcode,labitemname,consultationdate from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  paymentstatus='completed' and resultentry = 'completed' and publishstatus <> 'completed' and labsamplecoll = 'completed' and labrefund <> 'refund' order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1['labitemcode'];
		$itemname = $res1['labitemname'];
		$date5 = $res1['consultationdate'];

				 	  $colorloopcount = $colorloopcount + 1;
					  $sno = $sno + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date5; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center">Pending</div></td>
			 
			
			   	</tr>
				  <?php
				 
				  }

				  if($sno > 0)
				  {
				  ?>
				  <tr>
				  <td class="bodytext3" valign="center"  align="left"><a target="_blank" href="print_labresultsfull1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">View All</a></td>
				  </tr>
				  <?php
				  }
				  ?>
				  </table>
				  </td>
</tr>
<tr>
<td width="400" align="left" valign="middle" bgcolor="#E0E0E0" >
				  <table width="400" height="30">
				  <tr >
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Date </span></td>
								  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3"> Radiology Test</span></td>
				   <td width="4%" align="center" valign="middle" class="bodytext3" bgcolor="#cccccc">
				  <span class="bodytext3">Result</span></td>
				  </tr>
				  <?php 
					  $colorloopcount = '';
				$query11 = "select * from resultentry_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc";
		$exec11 = mysql_query($query11) or die ("Error in Query1".mysql_error());
		$num11=mysql_num_rows($exec11);
		
		while($res11 = mysql_fetch_array($exec11))
		{
		$itemname = $res11['itemname'];
		$itemcode = $res11['itemcode'];
		$date6 = $res11['recorddate'];
		$resraddocnumber = $res11['docnumber'];
		
		$query32 = "select * from consultation_radiology where radiologyitemcode='$itemcode' and patientvisitcode='$visitcode'";
			$exec32 = mysql_query($query32) or die(mysql_error());
			$res32 = mysql_fetch_array($exec32);
			$result = $res32['resultentry'];
			
			if($result == 'completed')
			
			{
	
		    $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date6; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="radiologyresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $resraddocnumber; ?>">View<br>
			 </a></div></td>
			   	</tr>
				  <?php
			}	                          
							  }

		$query1 = "select radiologyitemcode,radiologyitemname,consultationdate from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and  paymentstatus='completed' and resultentry = 'pending' and radiologyrefund <> 'refund' order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1['radiologyitemcode'];
		$itemname = $res1['radiologyitemname'];
		$date5 = $res1['consultationdate'];

				 	  $colorloopcount = $colorloopcount + 1;
					  $sno = $sno + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date5; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center">Pending</div></td>
			 
			
			   	</tr>
				  <?php
				 
				  }

				  ?>
				  </table>
    </td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left" style="color:#0000FF;"><input type="checkbox" name="testview" id="testview"> &nbsp; <strong>Check to Complete Review</strong></td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left" style="color:#0000FF;"><div style="padding-left:30px;"><strong><a target="_blank" href="emrcasesheet.php?visitcode=<?php echo $visitcode; ?>">Current Visit Case Sheet</a></strong></div></td>
</tr>
</table>
</body>
</html>