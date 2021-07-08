<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$paymentreceiveddateto = date('Y-m-d');


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }


		/*	$query11="select * from ambulanceinc where docno='$billnumber1'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$patientname=$res11['patientname'];*/

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script language="javascript">


function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<?php 

$query34="select * from external_request where status='approved' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number asc";
		$exec34=mysql_query($query34) or die(mysql_error());
			$resnw1=mysql_num_rows($exec34);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
              <form name="cbform1" method="post" action="editambulancelist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit Ambulance List</strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $currentdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                    
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
<!--                  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
-->				 <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
   			    </tr>
                  </tbody>
                </table>
              </form> </td> </tr></table>   
        <?php      
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
                
          ?>
          <table width="1600" border="0" 
            align="left" cellpadding="4" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
          <tbody>
            <tr>
             
              <td colspan="23" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Edit Ambulance List</strong>
                <label class="number"></label></div>
                  
                  </td>
              </tr>
			  
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="69" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="69" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inc.Date</strong></div></td>
                
              <td width="57" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Caller</strong></td>
              <td width="86" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
              <td width="28" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sex </strong></div></td>
              <td width="25" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
				<td width="34" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>PT Loc</strong></div></td>
              <td width="90" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Destination </strong></div></td>
              <td width="66" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Diagnosis</strong></div></td>
              <td width="108" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Treatment</strong></div></td>
              <td width="124" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>pt address</strong></div></td>
              <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>pt Tel</strong></div></td>
              <td width="77" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Rescue</strong></div></td>
              <td width="93" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Recieving Nurse</strong></div></td>
              <td width="29" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              <td width="88" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>operator</strong></td>
              <td width="98" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Nurse</strong></td>
              <td width="69" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>RescueTime</strong></td>
              <td width="52" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>EndOfCall</strong></td>
              <td width="43" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>PCR No</strong></td>
              <td width="47" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>KM Covered</strong></td>
              <td width="36" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
              	</tr>
			
                        <tr>
              <td colspan="23" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong> Request List</strong>
                  <label class="number"></label></div>
                  
                  </td>
              </tr>
<?php
	
		$colorloopcount='';
		$showcolor='';
		$sno='';
		$billnumber='';
		 // $query2 = "select * from ambulancep where  recorddate between '$transactiondatefrom' and '$transactiondateto'  order by recorddate desc";
		  $query2 = "select * from ambulancep ap LEFT JOIN ambulanceinc ainc ON ap.docno=ainc.docno   where   ap.recorddate between '$transactiondatefrom' and '$transactiondateto'";
		 $exec2 = mysql_query($query2) or die(mysql_error());
		 $rows=mysql_num_rows($exec2);
		 while($res2 = mysql_fetch_array($exec2))
		 {
			$res1patientcode = $res2['patientcode'];
			$res1visitcode = $res2['visitcode'];
			
			$operator=$res2['operator'];
			$nurse=$res2['nurse'];
			$ambulancereg=$res2['ambulancereg'];
			$incidentdate=$res2['incidentdate'];
			$pcrno2=$res2['pcrno2'];
			$unitnum=$res2['unitnum'];
			$ambulancereg1=$res2['ambulancereg1'];
			$patientdispose=$res2['patientdispose'];
			$incidentaddress=$res2['incidentaddress'];
			$responsemode=$res2['responsemode'];
			$responsemodefromscene=$res2['responsemodefromscene'];
			$timeunotified=$res2['timeunotified'];
			$begodometer=$res2['begodometer'];
			$timeuarrived=$res2['timeuarrived'];
			$onsceneodometer=$res2['onsceneodometer'];
			$timeuleft=$res2['timeuleft'];
			$ptdestodometer=$res2['ptdestodometer'];
			$timeparrived=$res2['timeparrived'];
			$endingodometer=$res2['endingodometer'];
			$timeunitback=$res2['timeunitback'];
			$totalkm=$res2['totalkm'];
			$servicereq=$res2['servicereq'];
			$payment=$res2['payment'];
			$amount=$res2['amount'];
			$extbillno=$res2['extbillno'];
			
			$ptaddress=$res2['ptaddress'];
			$caller=$res2['caller'];
			$ptphoneno=$res2['ptphoneno'];
			$ccomplaint=$res2['ccomplaint'];
			$analocation=$res2['analocation'];
			$syslocation=$res2['syslocation'];
			$medication=$res2['medication'];
			$allergies=$res2['allergies'];
			$medadmby=$res2['medadmby'];
			$diagnosis=$res2['diagnosis'];
			$origfacility=$res2['origfacility'];
			$destfacility=$res2['destfacility'];
			$typedestination=$res2['typedestination'];
			$treatment=$res2['treatment'];
			$procedures=$res2['procedures'];
			$rescue=$res2['rescue'];
			$receivenurse=$res2['receivenurse'];
			$destfacility1=$res2['destfacility1'];
			$timeout=$res2['timeout'];
			$timein=$res2['timein'];
			$pcrno=$res2['pcrno'];
			$docno = $res2['docno'];
			
			
if($extbillno!='')
{
			$query11="select * from billing_external where billno='$extbillno'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$patientname=$res11['patientname'];
			$age=$res11['age'];
			$gender=$res11['gender'];
			$mobilenumber='';

}
else
{

		  $query10 = "select * from master_customer where customercode='$res1patientcode'";
		 $exec10 = mysql_query($query10) or die(mysql_error());
		 $rows10=mysql_num_rows($exec10);
		 $res10 = mysql_fetch_array($exec10);
		$patientname=$res10['customerfullname'];
		$gender=$res10['gender'];
		$age=$res10['age'];
		$mobilenumber=$res10['mobilenumber'];
}
/*		if($gender=='Male')
		{
		$gendvalue='0';	
		}
		else
		{
		$gendvalue='1';	
		}
*/		
			$patientvis = explode("-", $res1visitcode);
			 $patientv= $patientvis[0];
			
			if($patientv=='VS')
			{
			$qury="select * from consultation_services where  patientcode='$res1patientcode' and patientvisitcode='$res1visitcode' ";
			$exe = mysql_query($qury) or die(mysql_error());
			$re = mysql_fetch_array($exe);
			$patientfullname = $re['patientname'];
			$billtype = $re['billtype'];
			}
			elseif($patientv=='IP')
			{
			 $qury="select * from ipconsultation_services where  patientcode='$res1patientcode' and patientvisitcode='$res1visitcode' ";
			$exe = mysql_query($qury) or die(mysql_error());
			$re = mysql_fetch_array($exe);
			$patientfullname = $re['patientname'];
			$billtype = $re['billtype'];	
			}
			else
			{
			$qury="select * from consultation_services where  patientcode='$res1patientcode' and patientvisitcode='$res1visitcode' and billnumber='$extbillno'";
			$exe = mysql_query($qury) or die(mysql_error());
			$re = mysql_fetch_array($exe);
			$patientfullname = $re['patientname'];
			$billtype = $re['billtype'];
			$billnumber = $re['billnumber'];
			}
			
		$query13 = "select destination from amb_destination where auto_number='$typedestination' and recordstatus=''";
		 $exec13 = mysql_query($query13) or die(mysql_error());
		 $res13 = mysql_fetch_array($exec13);
		 
			 $destination=$res13['destination'];
			 
		$query14 = "select * from master_operator where auto_number='$operator' and recordstatus=''";
		 $exec14 = mysql_query($query14) or die(mysql_error());
		 $res14 = mysql_fetch_array($exec14);
		
			 $autonumber=$res14['auto_number'];
			 $operator1=$res14['operator'];

			
			$recorddate = $res2['recorddate'];
			
				
			
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
			  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="left" width="25"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"   align="left">
			    <?php echo $recorddate; ?></td>
			   <td class="bodytext31" valign="center"   align="left">
			    <?php echo $incidentdate; ?></td>
			   <td class="bodytext31" valign="left" width="57"  align="left">
			    <?php echo $caller; ?></td>
				<td class="bodytext31" valign="center" width="86"  align="left">
			    <?php echo $patientfullname; ?></td>
			   <td class="bodytext31" valign="center" width="28"  align="left">
			    <?php echo $gender; ?></td>
			   <td class="bodytext31" valign="center" width="25"  align="left">
			    <?php echo $age; ?></td>
              <td class="bodytext31" valign="left" width="34"  align="left"><div align="center"><?php echo $caller; ?></div></td>
			   <td class="bodytext31" valign="center" width="90"  align="left">
			    <?php echo $destination; ?></td>
			   <td class="bodytext31" valign="left" width="66"  align="left">
			    <?php echo $diagnosis; ?></td>
				<td class="bodytext31" valign="center" width="108"  align="left">
			    <?php echo $treatment; ?></td>
			   <td class="bodytext31" valign="center" width="124"  align="left">
			    <?php echo $ptaddress; ?></td>
			   <td class="bodytext31" valign="center" width="80"  align="left">
			    <?php echo $ptphoneno; ?></td>
        
              <td class="bodytext31" valign="left" width="77"  align="left"><div align="center"><?php echo $rescue; ?></div></td>
			   <td class="bodytext31" valign="center" width="93"  align="left">
			    <?php echo $receivenurse; ?></td>
			   <td class="bodytext31" valign="left" width="29"  align="left">
			    <?php echo intval($amount); ?></td>
				<td class="bodytext31" valign="center" width="88"  align="left">
			    <?php echo $operator1; ?></td>
			   <td class="bodytext31" valign="center" width="98"  align="left">
			    <?php echo $nurse; ?></td>
			   <td class="bodytext31" valign="center" width="69"  align="left">
			    <?php echo $timeuarrived; ?></td>
              <td class="bodytext31" valign="left" width="52"  align="left"><div align="center"><?php echo $timeparrived; ?></div></td>
			   <td class="bodytext31" valign="center" width="43"  align="left">
			    <?php echo $pcrno; ?></td>
			   <td class="bodytext31" valign="left" width="47"  align="left">
			    <?php echo $totalkm; ?></td>
        
        
                
                
                
                
	  		      <td class="bodytext31" valign="center"  width="36" align="left">
			  <div class="bodytext31" align="left"><a href="editambulanceentry.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode?>&&docno=<?php echo $docno?>&&billnumber=<?php echo $billnumber?>">Edit</a></div></td>
              
              
			    </tr>
			  <?php
			}
			?>
            
            
		 
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" colspan="17" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31"><a target="_blank" href="print_ambulancereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
            </tr>
                <?php }

			
			?>
          </tbody>
        </table>
        
        </td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	  
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	   </td>
	  </tr>
    </table>
</table>

<?php include ("includes/footer1.php"); ?>

</body>
</html>

