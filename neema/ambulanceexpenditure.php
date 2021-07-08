<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');

if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == "frmflag1")
{
	$month = $_REQUEST["month"];
	$insurance = $_REQUEST["insurance"];
	$fuel = $_REQUEST["fuel"];
	$maintenance = $_REQUEST["maintenance"];
	$coordinator = $_REQUEST["coordinator"];
	$humanresource = $_REQUEST["humanresource"];
	$drugs = $_REQUEST["drugs"];
	$consumables = $_REQUEST["consumables"];
	$coordination = $_REQUEST["coordination"];
	$vehicle = $_REQUEST["vehicle"];
	$expdocno = $_REQUEST["expdocno"];
	
	
	$paynowbillprefix = 'AEXP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ambulanceexpenditure order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	 $billnumbercode ='AEXP-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	 $billnumbercode = 'AEXP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	if($expdocno=='')
	{
	$query5 = "insert into ambulanceexpenditure(docno,month,vehicleno,insurance,fuel,maintenance,coordinator,humanresource,drugs,consumables,coordination,recorddate,username) values('$billnumbercode','$month','$vehicle','$insurance','$fuel','$maintenance','$coordinator','$humanresource','$drugs','$consumables','$coordination','$updatedatetime','$username')";  
		$exec5 = mysql_query($query5) or die("Query5".mysql_error());

	}
	else
	{
   mysql_query("update ambulanceexpenditure set month='$month',vehicleno='$vehicle',insurance='$insurance',fuel='$fuel',maintenance='$maintenance',coordinator='$coordinator',humanresource='$humanresource',drugs='$drugs',consumables='$consumables',coordination='$coordination',username='$username' where docno='$expdocno'");
	header("location:editexpenditurelist.php");
   //editexpenditurelist.php
	}
	
	//header("location:otpatients.php");
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

<link href="css/jquery.timepicker.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.1.min.js"></script> 
<script src="js/datetimepicker_css.js"></script> 
<script src="js/jquery.timepicker.js"></script>



<script>

$(function(){
	
	$('#vehicle').change(function (){
		
		$.ajax({
		url:"ajaxvehicle.php",
		data:({vehicle:$('#vehicle').val()}),
		dataType: 'json',
		method:'post',
		success: function(data){
		
			$("#insurance").val(data['insurancecompany']);
		}
		});
		
		
		});
	
	});

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

function from1submit1()
{
	if (document.form1.month.value == "")
	{
		alert ("Please Select Month.");
		document.form1.month.focus();
		return false;
	}
	else if (document.form1.insurance.value == "")
	{
		alert ("Please Enter Insurance.");
		document.form1.insurance.focus();
		return false;
	}
	else if (document.form1.fuel.value == "")
	{
		alert ("Please Enter Fuel.");
		document.form1.fuel.focus();
		return false;
	}
	else if (document.form1.maintenance.value == "")
	{
		alert ("Please Enter Maintenance.");
		document.form1.maintenance.focus();
		return false;
	}
	else if (document.form1.coordinator.value == "")
	{
		alert ("Please Enter Co-Ordinator.");
		document.form1.coordinator.focus();
		return false;
	}
	else if (document.form1.humanresource.value == "")
	{
		alert ("Please Enter Human Resource.");
		document.form1.humanresource.focus();
		return false;
	}
	else if (document.form1.drugs.value == "")
	{
		alert ("Please Enter Drugs.");
		document.form1.drugs.focus();
		return false;
	}
	else if (document.form1.consumables.value == "")
	{
		alert ("Please Enter Consumables.");
		document.form1.consumables.focus();
		return false;
	}
	else if (document.form1.coordination.value == "")
	{
		alert ("Please Enter Co-ordination.");
		document.form1.coordination.focus();
		return false;
	}
}

function isNumberDecimal(evt) 
{
//getting key code of pressed key  
var charCode = (evt.which) ? evt.which : evt.keyCode
//comparing pressed keycodes
 if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
    return false;
  return true;
} 

function validatenumerics(key) 
{
   //getting key code of pressed key
   var keycode = (key.which) ? key.which : key.keyCode;
   //comparing pressed keycodes

   if (keycode > 31 && (keycode < 48 || keycode > 57)) {
	   //alert(" You can enter only characters 0 to 9 ");
	   return false;
   }
   else return true;
}
</script>

<script src="js/datetimepicker_css.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {COLOR: #3B3B3C; FONT-FAMILY: Tahoma; font-size: 11px;}
.style2 {COLOR: #3B3B3C; FONT-FAMILY: Tahoma; font-size: 11px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
  <form name="form1" id="form1" method="post" action="ambulanceexpenditure.php" onSubmit="return from1submit1()">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		 <td colspan="2">
			<table width="449" height="85" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			  <tr>
			   <td height="20" colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Ambulance Expenditure </strong></td>
			  </tr>
			  <tr>
              <?php
			  if (isset($_REQUEST["docno"])) { $expdocno = $_REQUEST["docno"]; } else { $expdocno = ""; }
			  
		  $query11 = "select * from ambulanceexpenditure where docno='$expdocno'";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows=mysql_num_rows($exec11);
		 $res11 = mysql_fetch_array($exec11);
		 
		$docno=$res11['docno'];
		$month=$res11['month'];
		$insurance = $res11['insurance'];
		$fuel = $res11['fuel'];
		$maintenance = $res11['maintenance'];
		$coordinator=$res11['coordinator'];
		$humanresource=$res11['humanresource'];
		$drugs = $res11['drugs'];
		$consumables = $res11['consumables'];
		$coordination = $res11['coordination'];
		$vehicleno1 = $res11['vehicleno'];

			  ?>
			    <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Month</strong></td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">
                <input type="hidden" name="expdocno" value="<?php echo $expdocno; ?>">
				<input name="month" id="month" style="border: 1px solid #001E6A" value="<?php echo $month;?>" size="6" onKeyDown="return disableEnterKey()"/>
			    <img src="images2/cal.gif" onClick="javascript:NewCssCal('month')" style="cursor:pointer"/>
				</td>
			    </tr>
                 <tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Vehicle No:</strong></td>
				<td width="294" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <select  name="vehicle" id="vehicle" value=""  >
                  <?php if($vehicleno1!='')
				  {
				   ?>
                       <option value="<?= $vehicleno1; ?>" ><?= $vehicleno1; ?></option>
                       <?php }
					   else
					   {
					   ?>
                  <option value="" >Select Vehicle</option>
                  <?php 
					   }
				  $qury=mysql_query("select * from master_vehicle where vehiclenumber <> '$vehicleno1' and recordstatus<> 'DELETED' order by autonumber") or die();
				  while($row=mysql_fetch_array($qury))
				  {
					  $vehicleno=$row['vehiclenumber'];
					  $vehicletype=$row['vehicletype'];
					  
					  
					  ?>
                       <option value="<?= $vehicleno; ?>" ><?= $vehicleno; ?></option>
                      <?php
				  }
				  
				  ?>
                 
                  </select>
				</span></td>
				</tr>
			  <tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Insurance</strong></td>
				<td width="294" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="insurance" id="insurance" value="<?php echo $insurance;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			 <tr>
			    <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Fuel</span></td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
			      <input type="text" name="fuel" id="fuel" value="<?php echo $fuel;?>" size="20" onKeyPress="return isNumberDecimal(event);">
			    </span></td>
			    </tr>
             <tr>
                <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Maintenance</strong></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="maintenance" id="maintenance" value="<?php echo $maintenance;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			<tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Co-ordinator</strong></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="coordinator" id="coordinator" value="<?php echo $coordinator;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			<tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Human Resource Cost </strong></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="humanresource" id="humanresource" value="<?php echo $humanresource;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			<tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Drugs</strong></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="drugs" id="drugs" value="<?php echo $drugs;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			<tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Consumables</strong></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="consumables" id="consumables" value="<?php echo $consumables;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			<tr>
				<td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><strong>Co-ordination/Misc</strong></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1"><span class="bodytext3">
				  <input type="text" name="coordination" id="coordination" value="<?php echo $coordination;?>" size="20" onKeyPress="return isNumberDecimal(event);">
				</span></td>
				</tr>
			<tr>
			  <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
			  </tr>
			</tbody>
			</table>		  </td>
		</tr>
        <tr>
          <td width="389">&nbsp;</td>
          <td width="592"><input type="hidden" name="frmflag1" value="frmflag1" />
            <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
            <input name="Submit222" type="submit"  value="Save" class="button"/></td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

