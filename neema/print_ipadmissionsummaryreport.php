<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ipadmissionsummaryreport.xls"');
header('Cache-Control: max-age=80');

 $locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 //echo $locationcode1; 
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:''; 
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["fromdate"])) { $fromdate = $_REQUEST["fromdate"]; } else { $fromdate = ""; }
if (isset($_REQUEST["todate"])) { $todate = $_REQUEST["todate"]; } else { $todate = ""; }

	
	
?>

		<table width="1128">
          <tbody>
             <div align="center"> <b>Addmission Summary Report</b> </div>
            <tr>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
				  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Reg. No. </strong></div></td>
				  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Visit Code </strong></div></td>
             
                  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Date </strong></div></td>
                  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>DOA</strong></div></td>
                 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Location Name</strong></div></td>
             </tr>
           <?php
            
		
		$query1 = "select patientname,patientcode,visitcode,recorddate,docno,locationcode from ip_bedallocation where locationcode='$locationcode1' and recorddate between '$fromdate' and '$todate' order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['recorddate'];
	    $docnumber=$res1['docno'];
		$locationcode = $res1['locationcode'];
        $query2 = "select registrationdate from master_ipvisitentry where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);
		$registrationdate=$res2['registrationdate'];
		
		
			$query4 = "select locationname from master_location where locationcode = '$locationcode'";
			$exec4 = mysql_query($query4);
			$res4 = mysql_fetch_array($exec4);
			$locationname = $res4['locationname'];
			
		
			?>
            
            
          <tr>
    
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="left"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>	
            
                <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $registrationdate; ?></div> </td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $locationname; ?></div></td>
              </tr>
		   <?php 
		   } 
		
		   ?>
           
          
          </tbody>
        </table>
<?php

?>	
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

