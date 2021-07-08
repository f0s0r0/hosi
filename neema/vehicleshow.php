<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$subtype = "";
$paymenttype = "";
$recorddate = "";
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
//this is for drop a copay plan
$delkey=isset($_REQUEST['delkey'])?$_REQUEST['delkey']:'';
if($delkey==1)
{
	$planid = isset($_REQUEST['planid'])?$_REQUEST['planid']:'';
	$query1 = "UPDATE master_vehicle SET recordstatus = 'DELETED' WHERE autonumber = '".$planid."'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	//	$errmsg = "Success. New Plan Name Updated.";
	//	$bgcolorcode = 'success';
		
	header("location:vehicle.php");
	exit();
	}
	
//this is for active a copay plan
$actkey=isset($_REQUEST['actkey'])?$_REQUEST['actkey']:'';
if($actkey==1)
{
	$planid = isset($_REQUEST['planid'])?$_REQUEST['planid']:'';
	$query1 = "UPDATE master_vehicle SET recordstatus = 'ACTIVE' WHERE autonumber = '".$planid."'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	//	$errmsg = "Success. New Plan Name Updated.";
	//	$bgcolorcode = 'success';
		
	header("location:vehicle.php");
	exit();
	}
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
 
	$vehicletype = $_REQUEST["vehicletype"];
	$vehiclemodel = $_REQUEST["vehiclemodel"];
	$vehiclenumber = $_REQUEST['vehiclenumber'];
	$insurancecompany = $_REQUEST["insurancecompany"];
	$insuranceammount = $_REQUEST["insuranceammount"];
	$renewabledate =  $_REQUEST['renewabledate'];
	$driverassigned =  $_REQUEST['driverassigned'];
	$rateperkm1 =  $_REQUEST['rateperkm1'];
	$rateperkm2 =  $_REQUEST['rateperkm2'];
	//$length=strlen($consultationtype);
	
	/*if ($length<=100)
	{*/
	
	
	if ($vehicletype!='')
	{
	
	
		 $query1 = "insert into master_vehicle (autonumber,vehicletype,vehiclemodel,vehiclenumber,insurancecompany,insuranceammount,renewabledate,driverassigned,rateperkm1,rateperkm2) 
		values ('','$vehicletype', '$vehiclemodel','$vehiclenumber','$insurancecompany','$insuranceammount', '$renewabledate', '$driverassigned', '$rateperkm1','$rateperkm2')";
		
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Consultation Type Updated.";
		$bgcolorcode = 'success';
	header ("location:vehicle.php");
	exit;
	}
	else
	{
		$errmsg = "Failed";
		$bgcolorcode = 'failed';
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }



?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>


<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function funcexpiry()
{
	<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("renewabledate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	
}
function addward1process1()
{
	//alert ("Inside Funtion");
	
	if (document.form1.vehicletype.value == "")
	{
		alert ("Enter vehicletype.");
		document.form1.vehicletype.focus();
		return false;
	}


	if (document.form1.vehiclemodel.value == "")
	{
		alert ("Pleae Enter vehiclemodel.");
		document.form1.vehiclemodel.focus();
		return false;
	}
	
	if (document.form1.vehiclenumber.value == "")
	{
		alert ("Pleae Enter vehicle number.");
		document.form1.vehiclenumber.focus();
		return false;
	}	
	if (document.form1.rateperkm1.value == "")
	{
	  
		alert ("Pleae Enter rateperkm1.");
		document.form1.rateperkm1.focus();
		return false;
	}	
	else
	{
			     var numbers = /^[0-9]+$/;  
      if(!document.form1.rateperkm1.value.match(numbers))  
      {  
      alert('Please input numeric characters only');
	  document.form1.rateperkm1.value="";  
      document.form1.rateperkm1.focus();  
      return false;  
      }  
     
	}
	if (document.form1.rateperkm2.value == "")
	{
		alert ("Pleae Enter rateperkm2.");
		document.form1.rateperkm2.focus();
		return false;
	}
	else
	{
			     var numbers = /^[0-9]+$/;  
      if(!document.form1.rateperkm2.value.match(numbers))  
      {  
      alert('Please input numeric characters only');
	  document.form1.rateperkm2.value="";  
      document.form1.rateperkm2.focus();  
      return false;  
      }  
     
	}
	
  
	

}
function IsNumeric(evt)
 {
          /*  var keyCode = e.which ? e.which : e.keyCode
            if ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1){
				return false;
			}*/
			var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        }

function funcDeleteconsultationtype1(varConsultationTypeAutoNumber)
{
     var varAccountNameAutoNumber = varConsultationTypeAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Consultation Type '+varAccountNameAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Consultation Type  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Consultation Type Entry Delete Not Completed.");
		return false;
	}

}
	function dropplan(planid)
	{
		var con = confirm('Are you sure want to delete this Copay name');
		if(con == false)
		{
			return false;
			}
			//alert(planid);
			form1.method="post"
			form1.action="vehicle.php?planid="+planid+"&&delkey=1";
			form1.submit();
		}
		
	function activeplan(planid)
	{
		/*var con = confirm('Are you sure want to delete this Copay name');
		if(con == false)
		{
			return false;
			}*/
			//alert(planid);
			form1.method="post"
			form1.action="vehicle.php?planid="+planid+"&&actkey=1";
			form1.submit();
		}
		
		
	function copay(a){
	var amount = document.getElementById("planfixedamount");
	var percentage = document.getElementById("planpercentage");
	if(amount.id==a){
		percentage.readOnly = true;
		percentage.value = '';
		amount.readOnly = false;
	}else if(percentage.id==a){
		percentage.readOnly = false;
		amount.readOnly = true;
		amount.value = '';
	}
}
</script>
<script src="js/datetimepicker_css.js"></script>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="vehicle.php" onSubmit="return addward1process1()">
                  
                <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                     <tr>
                     <td colspan="10" align="center" class="bodytext3" bgcolor="#FFFFFF"><strong>Vehicle Details</strong></td>
                     </tr> 
                      <tr bgcolor="#011E6A">
                        <td  bgcolor="#CCCCCC" class="bodytext3"><strong>Vehicle Type</strong>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Vehicle Model </strong> 
						<td bgcolor="#CCCCCC" class="bodytext3"><strong>Vehicle Number </strong> 
						<td bgcolor="#CCCCCC" class="bodytext3"><strong>Insurance Company</strong>  
						  <td bgcolor="#CCCCCC" class="bodytext3"><strong>Insurance Amount</strong>   
                           <td bgcolor="#CCCCCC" class="bodytext3"><strong>Renewable Date </strong>
                           <td bgcolor="#CCCCCC" class="bodytext3"><strong>Driver Assigned</strong>     
                            <td bgcolor="#CCCCCC" class="bodytext3"><strong>Rate1 </strong>      
                            <td bgcolor="#CCCCCC" class="bodytext3"><strong>Rate2 </strong>                   
					<!--	 <td bgcolor="#CCCCCC" class="bodytext3"><strong>Edit </strong> --> 
                           <td bgcolor="#CCCCCC" class="bodytext3"><strong>Add </strong>      
                         <!--<td bgcolor="#CCCCCC" class="bodytext3"><strong>Delete </strong> -->              </tr>
                      <?php
	     $query1 = "select * from master_vehicle where recordstatus <> 'deleted'";
		//$query1 = "select * from master_vehicle where recordstatus <> 'deleted' order by paymenttype ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
			$auto_number = $res1["autonumber"];
		$vehicletype =  $res1["vehicletype"];
	$vehiclemodel =  $res1["vehiclemodel"];
	$vehiclenumber =  $res1['vehiclenumber'];
	$insurancecompany =  $res1["insurancecompany"];
	$insuranceammount =  $res1["insuranceammount"];
	$renewabledate =   $res1['renewabledate'];
	$driverassigned =   $res1['driverassigned'];
	$rateperkm1 =   $res1['rateperkm1'];
	$rateperkm2 =   $res1['rateperkm2'];
	
		
		/*$query2 = "select * from master_department where auto_number = '$departmentanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$department = $res2['department'];
		
		$query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$res3paymenttype = $res3['paymenttype'];
		
		$query4 = "select * from master_subtype where auto_number = '$res1subtype'";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$res4 = mysql_fetch_array($exec4);
		$res4subtype = $res4['subtype'];
	*/
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
                      
                      <tr <?php echo $colorcode; ?>>
                     
          <td width="17%" align="left" valign="top"  class="bodytext3"><?php echo $vehicletype; ?></td>
          <td width="17%" align="left" valign="top"  class="bodytext3"><?php echo $vehiclemodel; ?></td>
          <td width="16%" align="left" valign="top"  class="bodytext3"><?php echo $vehiclenumber; ?></td>
		  <td width="15%" align="left" valign="top"  class="bodytext3"><?php echo $insurancecompany ?></td>
          <td width="15%" align="left" valign="top"  class="bodytext3"><?php echo $insuranceammount ?></td>
		  <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $renewabledate ?></td>
           <td width="25%" align="left" valign="top"  class="bodytext3"><?php echo $driverassigned ?></td>
           <td  align="left" valign="top"  class="bodytext3"><?php echo $rateperkm1 ?></td>
           <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $rateperkm2 ?></td>
        <!--  <td width="20%" align="left" valign="top"  class="bodytext3">
		  <a href="vehicleedit.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>		  </td> -->
           <td width="20%" align="left" valign="top"  class="bodytext3">
		  <a href="equipmentdetail.php?st=edit&&anum=<?php echo $auto_number; ?>&&anum1=<?php echo $vehiclenumber; ?>" style="text-decoration:none">Add</a>		  </td> 
<!--      <td align="left" valign="top"  class="bodytext3"> <a href="#" style="text-decoration:none"
                          onClick="dropplan(<?php echo $auto_number; ?>);"><img src="images/b_drop.png" width="16" height="16"></a></td>-->
                        </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
           
              </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

