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
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$tot1 = "00";
$tot2 = "00";
$tot3='00';
$awt_2='00';
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $searchpatientcode=isset($_REQUEST['searchpatientcode'])?$_REQUEST['searchpatientcode']:'';
  $searchvisitcode=isset($_REQUEST['searchvisitcode'])?$_REQUEST['searchvisitcode']:'';

?>
 <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="timereport.xls"');
header('Cache-Control: max-age=80');
?>
<style>
.bodyhead{font-weight:bold; font-size:16px; text-align:center;}
.bodytextbold{font-weight:bold; font-size:12px; text-align:center;}
.bodytext31{font-weight:normal; font-size:13px; text-align:center; vertical-align:middle;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
display:table;}
</style>



<table width="748"  align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
          <tbody>
       
      
    </tr><tr>
              <td width="3%"  class="bodytext31">&nbsp;</td>
              <td colspan="14"  class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?locationcode=<?php echo $locationcode1; ?>&&<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				<td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Visit Date </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit No </strong></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP Visit </strong></div></td>
				<td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cons. Bill </strong></div></td>
				<td width="5%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Triage</td>
                <td width="9%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Consultation</td>
				<td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Med Issue </td>
				<td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Service</td>
				<td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Radiology</td>
				<td width="8%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Lab</td>
				<td width="8%" align="right" valign="right"  
                bgcolor="#ffffff" class="style1">Total Time </td>
            </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            //$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
				if($locationcode1=='All'){
					
					$locationcodenew= "locationcode like '%%'";
				}else{
					$locationcodenew= "locationcode = '$locationcode1'";
				}
				$searchsuppliername=trim($searchsuppliername);
				$searchsuppliername=rtrim($searchsuppliername);
			 $query21 = "select * from master_visitentry where  $locationcodenew and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'   group by accountfullname order by accountfullname desc  ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			 $num2 = mysql_num_rows($exec21);
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountfullname = $res21['accountfullname'];
			
			$query22 = "select * from master_accountname where $locationcodenew and accountname = '$res21accountfullname' and recordstatus <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res21accountfullname != '')
			{
				if($res22accountname <> ''){
								?>
            
			<tr >
            <td colspan="15"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			<?php }?>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query2 = "select * from master_visitentry where $locationcodenew and accountfullname like '%$res21accountfullname%' and consultationdate between '$ADate1' and '$ADate2' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' order by accountfullname desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $numrow=mysql_num_rows($exec2);
		  
		  
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2patientfullname = $res2['patientfullname'];
		  $res2consultationdate = $res2['consultationdate'];
		  $datearray = explode("-",$res2consultationdate);
		  $res2visitcode = $res2['visitcode'];
		  $res2consultationtime = $res2['consultationtime'];
		  $res2accountfullname = $res2['accountfullname'];
		  $res2patientcode = $res2['patientcode'];
		  if($res2consultationtime == '')
		  {
		  $res2consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res2consultationtime = $res2['consultationtime'];
		  }
		  $res2consultationtime1 = strtotime($res2consultationtime);
		  
		  $query3 = "select * from master_billing where $locationcodenew and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billingdatetime between '$ADate1' and '$ADate2' ";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $res3billnumber = $res3['billnumber'];
		  $res3consultationtime = $res3['consultationtime'];
		  if($res3consultationtime == '')
		  {
		  $res3consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res3consultationtime = $res3['consultationtime'];
		  }
		  $res3consultationtime1 = strtotime($res3consultationtime);
		  
		  $query4 = "select * from master_triage where $locationcodenew and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and registrationdate between '$ADate1' and '$ADate2'";
		  $exec4 = mysql_query($query4) or die ("Error in quey4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $res4consultationtime = $res4['consultationtime'];
		  if($res4consultationtime == '')
		  {
		  $res4consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res4consultationtime = $res4['consultationtime'];
		  }
		  $res4consultationtime1 = strtotime($res4consultationtime);
		  
		  $query5 = "select * from pharmacysales_details where $locationcodenew and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5". mysql_error());
		  $res5 = mysql_fetch_array($exec5);
		  $res5entrytime = $res5['entrytime'];
		  if($res5entrytime == '')
		  {
		  $res5entrytime = "00:00:00";
		  }
		  else
		  {
		  $res5entrytime = $res5['entrytime'];
		  }
		  $res5entrytime1 = strtotime($res5entrytime);
		  
		  $query6 = "select * from process_service where $locationcodenew and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'";
		  $exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  $res6recordtime = $res6['recordtime'];
		  if($res6recordtime == '')
		  {
		  $res6recordtime = "00:00:00";
		  }
		  else
		  {
		  $res6recordtime = $res6['recordtime'];
		  }
		  $res6recordtime1 = strtotime($res6recordtime);
		  
		  $query7 = "select * from resultentry_radiology where  patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'"; 
		  $exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  $res7recordtime = $res7['recordtime'];
		  if($res7recordtime=='')
		  {
		  $res7recordtime = "00:00:00";
		  }
		  else
		  {
		  $res7recordtime = $res7['recordtime'];
		  }
		  $res7recordtime1 = strtotime($res7recordtime);
		  
		  $query8 = "select * from samplecollection_lab where $locationcodenew and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'";
		  $exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $res8recordtime = $res8['recordtime'];
		  //echo $splittedstring=explode(":",$res8recordtime,2);
          if ($res8recordtime == '')
		  {
		  $res8recordtime = "00:00:00";
		  }
		  else
		  {
		  $res8recordtime = $res8['recordtime'];
		  }
		  $res8recordtime1 = strtotime($res8recordtime);
		  
		  $query9 = "select * from master_consultation where $locationcodenew and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'";
		  $exec9 = mysql_query($query9) or die ("Error in query9".mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  $res9consultationtime = $res9['consultationtime'];
		  //echo $splittedstring=explode(":",$res8recordtime,2);
          if ($res9consultationtime == '')
		  {
		  $res9consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res9consultationtime = $res9['consultationtime'];
		  }
		  $res9consultationtime1 = strtotime($res9consultationtime);
		  
		   $highest_time = max($res9consultationtime, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);
		   //$lowest_time = min($res2consultationtime1,$res3consultationtime1, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);
		  
		  $highest_time1 = date("H:i:s", $highest_time); 
		  $lowest_time1 = date("H:i:s", $res2consultationtime1);
		 //echo $t = date("H:i",120);
		$tot =  strtotime($highest_time1) - strtotime($lowest_time1);
//		$totalt=date("H:i",$tot);
		 $exe = explode(":",$highest_time1);
		 $exe1 = explode(":",$lowest_time1);
		 $exe2 = abs($exe[0] - $exe1[0]);
		 $exe3 = abs($exe[1] - $exe1[1]);
		 $exe4 = $exe[2] - $exe1[2];
		 $length = strlen($exe2);
		 $length1 = strlen($exe3);
		 

		 
		 if($length == '1')
		 {
		  $exe2 = '0'. $exe2;
		 }
		 
		 if($length1 == '1')
		 {
		 $exe3 = '0'.$exe3;
		 }
		 
		 if($exe2 < 0)
		 {
		 $exe2 = '00';
		 }
		 
		 if($exe3 < 0)
		 {
		 $exe3 = '00';
		 }
		 
		  $tot1 = $tot1 + $exe2; 
	 	 $tot2 = $tot2 + $exe3;
		
		 
		 $length2 = strlen($tot1);
		 $length3 = strlen($tot2);
		 
		 if($length2 == '1')
		 {
		 $tot1 = '0'. $tot1;
		 }
		 
		 if($length3 == '1')
		 {
		 $tot2 = '0'. $tot2;
		 }
		 
		 $exe5 = $exe2 * 3600;
		 $exe6 = $exe3 * 60;
		 $exe7 = $exe5 + $exe6;
		 
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
			
	       $exe8 = $exe7 / $snocount;
		 
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2accountfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $datearray[2]; ?>-<?php echo $datearray[1]; ?>-<?php echo $datearray[0]; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2visitcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo date("H:i",(strtotime($res2consultationtime))); ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo date("H:i",(strtotime($res3consultationtime))); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res4consultationtime))); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo date("H:i",(strtotime($res9consultationtime))); ?></div></td>
              
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res5entrytime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res6recordtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res7recordtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res8recordtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="center"><?php echo $exe2.':'.$exe3; ?></div></td>

           </tr>
			<?php
		   
			}
			}
			}
			
			 if($tot2 >60)
			 {
		 	 $hours=($tot2 / 60);
			   $hours1=($tot2 % 60);
			 $hr=explode('.',$hours);
			 $hr1=substr($hr[1], 0, 1);
			 $tot1=$tot1+$hr[0];
			 
			  $tot2=$hours1;
			  
			 }
			 $tot3=$tot1.':'.$tot2;
			
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Total Time:</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong><?php echo $tot3; ?></strong></div></td>
            </tr>
			<?php
			 $snocount;
			if($snocount!=0){
				$awt1=$tot1/$snocount;
			 $awt = $tot2/$snocount;
			 }
			 else
			 {
				 $awt1=$tot1;
			 $awt=$tot2;
			 }
			 $awt_1=explode('.',$awt1);
			 $awt1=$awt_1[0];
			 $count=count($awt_1);
			 if($count>1)
			 {
				 $awt_2=$awt_1[1];
				 $awt_2=substr($awt_2, 0, 1);
			 }

			 $awt=round($awt)+$awt_2;;
			 
			?>
			 <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
               ><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
               ><div align="right"><strong>A W T:</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
               ><div align="center"><strong><?php echo $awt1.':'.$awt; /*echo number_format($awt,1,'.',''); */ ?></strong></div></td>
            </tr>
			 
		<?php
		}
		?>
          </tbody>
        </table></td>
      </tr>
          </tbody>
        </table>
