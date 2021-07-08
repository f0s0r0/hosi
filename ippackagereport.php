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
$transactiondatefrom = "2014-01-01";
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
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//This include updatation takes too long to load for hunge items database.


//$getcanum = $_GET['canum'];
if (isset($_REQUEST["package"])) { $packagecode = $_REQUEST["package"]; $package=$packagecode; } else { $packagecode = ""; $package = ''; }


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }


$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

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

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script>

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

</script>
<script type="text/javascript">
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

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
        <form name="cbform1" method="post" action="ippackagereport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>IP Package Report </strong></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Package Name</strong></td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="package" id="package">
				    <option value="">Select Package</option>
				   <?php
				   $query66 = "select * from master_ippackage where status=''";
				   $exec66 = mysql_query($query66) or die(mysql_error());
				   while($res66 = mysql_fetch_array($exec66))
				   {
				   $packageanum = $res66['auto_number'];
				   $packagename = $res66['packagename'];
				   ?>
				   <option value="<?php echo $packageanum; ?>"><?php echo $packagename; ?></option>
				   <?php
				   }
				   
				   ?>
				   </select>
              </span></td>
              </tr>
            <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
          <tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
						
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcvalid();" value="Search" name="submit"/>
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$num6='';
	?>
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
	bordercolor="#666666" cellspacing="0" cellpadding="4" width="610" 
	align="left" border="0">
	<tbody>	
	<?php
	
	$query40 = "select * from master_ippackage where locationcode='$locationcode1' and auto_number like '%$packagecode%'";
	$exec40 = mysql_query($query40) or die(mysql_error());
	while($res40 = mysql_fetch_array($exec40))		
	{
		$packagename = $res40['packagename'];
		$packagecode = $res40['auto_number'];
		$num5 = '';
		$query3 = "select * from master_ipvisitentry where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  package='$packagecode'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
		while($res3 = mysql_fetch_array($exec3))
		{		
			$visitcode=$res3['visitcode'];	
			$patientcode=$res3['patientcode'];
			$query4 = "select * from ip_bedallocation where locationcode='$locationcode1' and recorddate between '$fromdate' and '$todate' and  visitcode='$visitcode'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$num4=mysql_num_rows($exec4);
			$num5=$num5+$num4;
			$num6=$num6+$num4;
		}
		if($num5 != '')
		{
			$snocount = '';
			$colorloopcount = '';
			?>
			
			<tr>
			<td  align="left" valign="center" class="bodytext31" colspan="3"><strong><?php echo $packagename;?></strong></td>
			<td width="94"  align="right" valign="center" class="bodytext31"><strong>Count</strong></td>
			<td width="72"  align="left" valign="center" class="bodytext31"><?php echo $num5;?></td> 
			
			</tr>
			
			
			<tr bgcolor="#fff">
			<td width="25"  align="left" valign="center" class="bodytext31"><strong>Sno</strong></td>
			<td width="59"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			<td width="192"  align="left" valign="center" class="bodytext31"><strong>Patitent Name</strong></td> 
			<td class="bodytext31" valign="center"  align="left"><strong>Patitent Code</strong></td>
			<td class="bodytext31" valign="center"  align="left"><strong>Visit Code</strong></td> 
			<td width="43"  align="left" valign="center" class="bodytext31"><strong>Age</strong></td> 
			<td width="69"  align="left" valign="center" class="bodytext31"><strong>Gender</strong></td> 
			</tr>
			<?php
			$query1 = "select * from master_ipvisitentry where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  package='$packagecode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$num1=mysql_num_rows($exec1);
			while($res1 = mysql_fetch_array($exec1))
			{			
				$visitcode=$res1['visitcode'];	
				$patientcode=$res1['patientcode'];		
				$patientfullname=$res1['patientfullname'];
				$age=$res1['age'];
				$gender=$res1['gender'];
				$query2 = "select * from ip_bedallocation where locationcode='$locationcode1' and recorddate between '$fromdate' and '$todate' and  visitcode='$visitcode'";
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
						$colorcode = 'bgcolor="#CBDBFA"';
					}
					else
					{
						$colorcode = 'bgcolor="#D3EEB7"';
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
	<?php if($num6 != '')
	{?>	
	<tr>
	<td colspan="7" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31"><div align="right"><a target="_blank" href="print_ippackagereport.php?ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>&&package=<?php echo $package; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
<?php
}
?>	
		</td>
      </tr>  
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>