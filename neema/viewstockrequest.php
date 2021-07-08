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
$transactiondatefrom = date('Y-m-d', strtotime('-7 day'));
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
		
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						$res1location = $res1["locationname"];
						 $locationcode = $res1["locationcode"];
						$query2 = "select storecode FROM master_employeelocation WHERE locationcode = '".$locationcode."' AND username='".$username."'";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						$res2 = mysql_fetch_array($exec2);
						
						// $res2storename = $res2["store"];
						  $res2storecode = $res2["storecode"];
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
padding-left:650px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
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

</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<?php $querynw1 = "select * from master_internalstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' group by docno order by auto_number desc";
			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
			
		
			?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
	<tr>
        <td width="860">
              <form name="cbform1" method="post" action="viewstockrequest.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
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
             <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Location </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><?php echo $res1location;?></td>
            
            
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 
            align="left" border="0">
          <tbody>
            <tr>
             
              <td colspan="6" cellpadding="1" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
               <strong> Requests</strong></td>
              </tr>
            <tr>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Date</strong></div></td>
              <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From </strong></div></td>
               <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			$colorloopcount = '';
			$sno = '';
			
			/*$query23 = "select * from master_employee where username='$username'";
			$exec23 = mysql_query($query23) or die(mysql_error());
			$res23 = mysql_fetch_array($exec23);
			$res7locationanum = $res23['location'];*/
			$query23 = "select * from master_employeelocation where username='$username'";
			$exec23 = mysql_query($query23) or die(mysql_error());
			$res23 = mysql_fetch_array($exec23);
			$res7locationanum = $res23['locationcode'];
			$location = $res23['locationname'];
			 $res7storeanum = $res23['storecode'];
			
			/*$query55 = "select * from master_location where auto_number='$res7locationanum'";
			$exec55 = mysql_query($query55) or die(mysql_error());
			$res55 = mysql_fetch_array($exec55);
			$location = $res55['locationname'];*/
			
			
			
			$query75 = "select * from master_store where auto_number='$res7storeanum'";
			$exec75 = mysql_query($query75) or die(mysql_error());
			$res75 = mysql_fetch_array($exec75);
			 $store = $res75['store'];
			 $storecode = $res75['storecode'];
			
			
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from master_internalstockrequest where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' group by docno order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$from = $res1['fromstore'];
			$query77="select * from master_store where storecode='$from'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$fromstorename=$res77['store'];
			
			$date = $res1['updatedatetime'];
			$docno = $res1['docno'];
			$to = $res1['tostore'];
			
			/*$query23 = "select * from master_employee where username='$username'";
			$exec23 = mysql_query($query23) or die(mysql_error());
			$res23 = mysql_fetch_array($exec23);
			$res7locationanum = $res23['location'];*/
			
			/*$query55 = "select * from master_location where auto_number='$res7locationanum'";
			$exec55 = mysql_query($query55) or die(mysql_error());
			$res55 = mysql_fetch_array($exec55);
			$location = $res55['locationname'];*/
			$query23 = "select * from master_employeelocation where username='$username'";
			$exec23 = mysql_query($query23) or die(mysql_error());
			while($res23 = mysql_fetch_array($exec23))
			{
			$res7locationanum = $res23['locationcode'];
			$location = $res23['locationname'];
			$res7storeanum = $res23['storecode'];
			
			$query75 = "select * from master_store where auto_number='$res7storeanum'";
			$exec75 = mysql_query($query75) or die(mysql_error());
			$res75 = mysql_fetch_array($exec75);
			$storecode = $res75['storecode'];
			
			$timestamp = strtotime($date);

			$child1 = date('j.n.Y', $timestamp); // d.m.YYYY
			$child2 = date('H:i', $timestamp); // HH:ss
			
			if($to == $storecode)
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $child1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $fromstorename; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="stocktransfer.php?docno=<?php echo $docno; ?>"><strong>View</strong></a></div></td>
              </tr>
			<?php
			}    
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
                 </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

