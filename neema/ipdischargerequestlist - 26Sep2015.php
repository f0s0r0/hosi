<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno=$_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$docno = $_SESSION['docno'];

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
//$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	 //get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
$adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysql_query($query40) or die ("Error in Query40".mysql_error());
	$res40 = mysql_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysql_query($query65) or die(mysql_error());
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysql_query($query65) or die(mysql_error());
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

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




function cbsuppliername1()
{
	document.cbform1.submit();
}



</script>
<script type="text/javascript">

function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_location";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	 $res12subtypeanum = $res12["auto_number"];
	$res12locationname = $res12["locationname"];
	$res12locationcode = $res12["locationcode"];
	?>

	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{

		document.getElementById("ward").options.length=null; 
		var combo = document.getElementById('ward'); 	
		<?php 
		$loopcount=0; 
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
		<?php
		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$ward = $res10["ward"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td class="bodytext31">&nbsp;</td>
    <td class="bodytext31">&nbsp;</td>
    <td class="bodytext31"><a href="activeinpatientlist.php">Click to See Active IP List</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="ipdischargerequestlist.php">
		<table width="510" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong>Inpatient Discharge Request</strong></td>
              <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
		   <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Location </strong></span></td>
          <td  colspan="3" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
           <select name="location" id="location" onChange=" funcSubTypeChange1(); ajaxlocationfunction(this.value);">
           <?php
		   			$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];
?>
		   <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
  <?php         }?>
		   </select></span></td>
            <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
          </tr>
            <tr>
              <td width="23%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ward</td>
              <td width="15%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="ward" id="ward">
						<option value="" selected="selected"> All</option>
						  <?php 
		  $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
           $exec = mysql_query($query) or die ("Error in Query1".mysql_error());
          $res = mysql_fetch_array($exec);
			
	 		$locationname  = $res["locationname"]; 
	 		$locationcode2 = $res["locationcode"];
			
						  $query78 = "select * from master_ward where  locationcode='$locationcode2' and recordstatus=''";
						  $exec78 = mysql_query($query78) or die(mysql_error());
						  while($res78 = mysql_fetch_array($exec78))
						  {
						  $wardanum = $res78['auto_number'];
						  $wardname = $res78['ward'];
						    ?>
                          <option value="<?php echo $wardanum; ?>"><?php echo $wardname; ?></option>
						  <?php
						  }
			
                          ?>
                      </select>
              </span></td>
              
              <td width="62%" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                <input  type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/></td>
            </tr>
             </tbody>
        </table>
		  <iframe marginheight="1" marginwidth="50" src="inpatientlabtestscrolling.php" frameborder="0" scrolling="no" width="450" height="70"></iframe>
		</form>		</td>
      </tr>
	  <form name="form1" id="form1" method="post" action="ipdischargelist.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	 $searchward = $_POST['ward'];
	 $locationcode = $_REQUEST['location'];
	
	$query781 = "select * from master_ward where auto_number='$searchward' and recordstatus='' and locationcode='$locationcode'";
						  $exec781 = mysql_query($query781) or die(mysql_error());
						  $res781 = mysql_fetch_array($exec781);
						  $wardname = $res781['ward'];
						
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>DOA</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ward</strong></div></td>
			 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No </strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			
					 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
              </tr>
            <?php
            $query34 = "select * from master_ward where ward like '%$wardname%' and locationcode='$locationcode'";
			$exec34 = mysql_query($query34) or die(mysql_error());
			while($res34 = mysql_fetch_array($exec34))
			{
			 $wardnum = $res34['auto_number'];   
			 $wardname5 = $res34['ward'];
			?>
			<tr>
			  <td colspan="9" align="left" valign="center" 
                bgcolor="#CCCCCC" class="bodytext31"><div align="left"><strong><?php echo $wardname5; ?></strong></div></td>
			 </tr>
			<?php
		
		$query50 = "select * from master_bed where ward='$wardnum' and locationcode='$locationcode'";
		$exec50 = mysql_query($query50) or die(mysql_error());
		while($res50 = mysql_fetch_array($exec50))
		{
		$bedname = $res50['bed'];
		$bedanum = $res50['auto_number'];
		$bed = '';
		$ward = '';
		$patientcode = '';
		$visitcode = '';
		
		
		$query69 = "select * from master_bed where auto_number='$bedanum' and ward='$wardnum' and recordstatus='occupied' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
		$exec69 = mysql_query($query69) or die(mysql_error());
		$num69 = mysql_num_rows($exec69);
	
	
		$query59 = "select * from ip_bedallocation where ward='$wardnum' and bed='$bedanum' and recordstatus = '' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
		$exec59 = mysql_query($query59) or die(mysql_error());
		$res59 = mysql_fetch_array($exec59);
		$num59 = mysql_num_rows($exec59);
		if($num59 > 0)
		{
		$ward = $res59['ward'];
		$bed = $res59['bed'];
		$patientname = $res59['patientname'];
		$patientcode = $res59['patientcode'];
		$visitcode = $res59['visitcode'];
		
		$query49 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$locationcode' order by auto_number desc limit 0, 1" ;
		$exec49 = mysql_query($query49) or die(mysql_error());
		$res49 = mysql_fetch_array($exec49);
		$date = $res49['consultationdate'];
		$accoutname = $res49['accountfullname'];
		//$patientlocationcode = $res49['locationcode'];
	
		$query67 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum' and recordstatus='' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
		$exec67 = mysql_query($query67) or die(mysql_error());
		$res67 = mysql_fetch_array($exec67);
		$num67 = mysql_num_rows($exec67);
		if($num67 > 0)
		{
		$ward = $res67['ward'];
		$bed = $res67['bed'];
	    $patientname = $res67['patientname'];
		$patientcode = $res67['patientcode'];
		$visitcode = $res67['visitcode'];
		
		
		$query49 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$locationcode' order by auto_number desc limit 0, 1" ;
		$exec49 = mysql_query($query49) or die(mysql_error());
		$res49 = mysql_fetch_array($exec49);
		$date = $res49['consultationdate'];
		$accoutname = $res49['accountfullname'];
		$patientlocationcode = $res49['locationcode'];
		}
		}
		else
		{
		$query592 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum' and recordstatus = '' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
		$exec592 = mysql_query($query592) or die(mysql_error());
		$res592 = mysql_fetch_array($exec592);
		$num592 = mysql_num_rows($exec592);
		if($num592 > 0)
		{
		$ward = $res592['ward'];
		$bed = $res592['bed'];
		$patientname = $res592['patientname'];
		$patientcode = $res592['patientcode'];
		$visitcode = $res592['visitcode'];
		
		
		$query492 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$locationcode' order by auto_number desc limit 0, 1" ;
		$exec492 = mysql_query($query492) or die(mysql_error());
		$res492 = mysql_fetch_array($exec492);
		$date = $res492['consultationdate'];
		$accoutname = $res492['accountfullname'];
		$patientlocationcode = $res492['locationcode'];
		}
		}
		   $query51 = "select * from master_bed where auto_number='$bed' and locationcode='$locationcode'";
		   $exec51 = mysql_query($query51) or die(mysql_error());
		   $res51 = mysql_fetch_array($exec51);
		   $bedname = $res51['bed'];
		
			$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus='' and locationcode='$locationcode'";
			$exec7811 = mysql_query($query7811) or die(mysql_error());
			$res7811 = mysql_fetch_array($exec7811);
			$wardname1 = $res7811['ward'];
			if($num69 > 0)
		{
		
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and discharge = '' and locationcode='$locationcode'";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   $num82 = mysql_num_rows($exec82);
		   if($num82 > 0)
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
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><a href="ipquickview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" target="_blank"><strong><?php echo $visitcode; ?></strong></a></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $wardname1; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $bedname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accoutname; ?></div></td>
				<td class="bodytext31" valign="center"  align="center">
	<a href="ipdischargerequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode;?>&&patientlocation=<?php echo $location;?>">Discharge</a>
				</td>
              </tr>
		   <?php 
		   }
		}
		}
		}
		   ?>
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			</tr>
          </tbody>
        </table>
<?php
}


?>		</td>
      </tr>
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

