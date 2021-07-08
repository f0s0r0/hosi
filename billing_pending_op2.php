<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
		$cbfrmflag1=isset($_REQUEST['cbfrmflag1'])?$_REQUEST['cbfrmflag1']:'';
		
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["printbill"])) { $printbill = $_REQUEST["printbill"]; } else { $printbill = ""; }

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
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here
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
	window.open("print_paylater_summary.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function loadprintpage2(banum)
{
	var banum = banum;
	window.open("print_paylater_detailed.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function doLoad()
{
   alert("Page is loaded");
}
</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
</head>

<body 
	<?php 
	if($st=='success' && $printbill =='detailed')
	{ 
	?>
	onload = "return loadprintpage2('<?php echo $billautonumber; ?>')"
	<?php
	}
	else if($st=='success' && $printbill=='summary')
	{ 
	?>
onload = "return loadprintpage1('<?php echo $billautonumber; ?>')"
<?php
}
?>>

<script>
function funcPopupOnLoader()
{
<?php 
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
?>
var billautonumbers;
var billautonumbers = "<?php echo $billautonumber; ?>";
//alert(patientcodes1);
if(billautonumbers != "") 
{
	window.open("print_paylater_detailed.php?billautonumber="+billautonumbers+" ","OriginalWindowA5",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
}
}
</script>

<body onLoad="funcPopupOnLoader()">
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
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="billing_pending_op2.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong> Search Billing Paylater</strong></td>
                 <td colspan="3" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td>
              
     
              </tr>
               <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
						while ($res = mysql_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
						<?php
						}
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
             
              </tr>
                <tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
                   <tr>
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
					
				
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>

  <tr>
    <?php if($cbfrmflag1=='cbfrmflag1'){?>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1074" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="9" bgcolor="#cccccc" class="bodytext31"><script language="javascript">
				function printbillreport1()
				{
					window.open("print_collectionpendingreport1hospital.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/CollectionPendingByPatientHospital.xls"
				}
				</script>
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Billing Pay Later</strong><label class="number"></label>
                </div></td>
              </tr>
			  
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
           <!-- <tr>
              
              <td colspan="8"  align="left" valign="center" bgcolor="#CCCCCC" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Summary" class="button" style="border: 1px solid #001E6A"/>
			  <input name="billprint" type="button" onClick="return loadprintpage2('<?php echo $billautonumber; ?>')" value="Click Here To Detailed" class="button" style="border: 1px solid #001E6A"/>			  </td>
            </tr>-->
			<?php
			}
			?>
		
            
            <tr>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>OP Date </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg.No</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No </strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				  <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Subtype </strong></div></td>
                <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Account</strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
              </tr>
			
            
			<?php
			$searchpatient=$_POST['patient'];
			$searchpatientcode=$_POST['patientcode'];
			$searchvisitcode=$_POST['visitcode'];
			$colorloopcount = '';
			$sno = '';
			$query31=mysql_query("select * from master_visitentry where  locationcode = '".$locationcode."' and billtype='PAY LATER' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc") or die(mysql_error());
			while($exec31=mysql_fetch_array($query31))
			{
			
			$patientcode = $exec31['patientcode'];
			$subtypeanum = $exec31['subtype'];
			
			$query321 = "select * from master_subtype where auto_number = '$subtypeanum'";
			$exec321 = mysql_query($query321) or die(mysql_error());
			$res321 = mysql_fetch_array($exec321);
			$subtype = $res321['subtype'];
			
			$query39=mysql_query("select * from master_customer where customercode='$patientcode'") or die(mysql_error());
			$res39=mysql_fetch_array($query39);
		    $accname=$res39['accountname'];
			
			$query40=mysql_query("select * from master_accountname where auto_number='$accname'");
			$res40=mysql_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultingdoctor = $exec31['consultingdoctor'];
			
			$query33=mysql_query("select * from master_doctor where auto_number='$consultingdoctor'") or die(mysql_error());
			$exec33=mysql_fetch_array($query33);
			$consultingdoctorname=$exec33['doctorname'];
			
			$query34=mysql_query("select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysql_error());
			$exec34=mysql_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec31['consultationdate'];
			$consultationfees=number_format(0,2,'.','');
			$query32=mysql_query("select * from master_consultation where patientvisitcode='$patientvisitcode'");
			while($exec32=mysql_fetch_array($query32))
			{
		     $consultationfees=$consultationfees+$exec32['amount'];
			$consultationfees=number_format($consultationfees,2,'.','');
			}
			
			$query65 = "select * from billing_paylater where visitcode='$patientvisitcode'";
			$exec65 = mysql_query($query65) or die(mysql_error());
			$num65 = mysql_num_rows($exec65);
			if($num65 == 0)
			{
			
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientvisitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $subtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $accountname; ?>			      </div></td>
             
             <td class="bodytext31" valign="center"  align="left"><a href="billing_paylater.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>"><strong>Finalize Bill</strong></a>			  </td>
              </tr>
			  <?php
			}
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              </tr>
          </tbody>
        </table></td>
      </tr>
    </table><?php }?>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

