<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ippackagereport.xls"');
header('Cache-Control: max-age=80');

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$currentdate = date('d-m-Y');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$snocount = '';
$colorloopcount = '';
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["package"])) { $packagecode = $_REQUEST["package"];  } else { $packagecode = ""; }
?>
</head>
<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
	bordercolor="#666666" cellspacing="0" cellpadding="4" width="724" 
	align="left" border="0">
	<tbody>	
	<?php
	
	$query40 = "select * from master_ippackage where auto_number like '%$packagecode%'";
	$exec40 = mysql_query($query40) or die(mysql_error());
	while($res40 = mysql_fetch_array($exec40))		
	{
		$packagename = $res40['packagename'];
		$packagecode = $res40['auto_number'];
		$num5 = '';
		$query3 = "select * from master_ipvisitentry where consultationdate between '$fromdate' and '$todate' and  package='$packagecode'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
		while($res3 = mysql_fetch_array($exec3))
		{		
			$visitcode=$res3['visitcode'];	
			$patientcode=$res3['patientcode'];
			$query4 = "select * from ip_bedallocation where recorddate between '$fromdate' and '$todate' and  visitcode='$visitcode'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$num4=mysql_num_rows($exec4);
			$num5=$num5+$num4;
		}
		if($num5 != '')
		{
			$snocount = '';
			$colorloopcount = '';
			?>
			
			<tr>
			<td  align="left" valign="center" class="bodytext31" colspan="3"><strong><?php echo $packagename;?></strong></td>
			<td width="112"  align="right" valign="center" class="bodytext31"><strong>Count</strong></td>
			<td width="86"  align="left" valign="center" class="bodytext31"><?php echo $num5;?></td> 
			
			</tr>
			
			
			<tr bgcolor="#fff">
			<td width="42"  align="left" valign="center" class="bodytext31"><strong>Sno</strong></td>
			<td width="60"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			<td width="228"  align="left" valign="center" class="bodytext31"><strong>Patitent Name</strong></td> 
			<td class="bodytext31" valign="center"  align="left"><strong>Patitent Code</strong></td>
			<td class="bodytext31" valign="center"  align="left"><strong>Visit Code</strong></td> 
			<td width="52"  align="left" valign="center" class="bodytext31"><strong>Age</strong></td> 
			<td width="88"  align="left" valign="center" class="bodytext31"><strong>Gender</strong></td> 
			</tr>
			<?php
			$query1 = "select * from master_ipvisitentry where consultationdate between '$fromdate' and '$todate' and  package='$packagecode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$num1=mysql_num_rows($exec1);
			while($res1 = mysql_fetch_array($exec1))
			{			
				$visitcode=$res1['visitcode'];	
				$patientcode=$res1['patientcode'];		
				$patientfullname=$res1['patientfullname'];
				$age=$res1['age'];
				$gender=$res1['gender'];
				$query2 = "select * from ip_bedallocation where recorddate between '$fromdate' and '$todate' and  visitcode='$visitcode'";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				$num2=mysql_num_rows($exec2);
				if($num2 !='')
				{
					$res2 = mysql_fetch_array($exec2);
					$recorddate = $res2['recorddate'];
					$snocount = $snocount + 1;
					
					$colorloopcount = $colorloopcount + 1;
					$showcolor = ($colorloopcount & 1); 
					if ($showcolor == 0)
					{					
						$colorcode = 'bgcolor="#ffffff"';
					}
					else
					{
						$colorcode = 'bgcolor="#ffffff"';
					}					
					?>
					<tr <?php echo $colorcode; ?> >
					<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left"><?php echo $recorddate; ?></td>
					<td class="bodytext31" valign="center"  align="left"><?php echo $patientfullname; ?></td> 
					<td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
					<td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td> 
					<td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td> 
					<td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td> 
					</tr>
				<?php 
				} 
			}
		}
	}
	?>	
	</tbody>
</table>
</body>
</html>