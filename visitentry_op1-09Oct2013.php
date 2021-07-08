<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$patientfirstname = $_REQUEST['patientfirstname'];
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientlastname = $_REQUEST["patientlastname"];
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$department = $_REQUEST["department"];
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$accountname = $_REQUEST["accountname"];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complaint"];
	$visittype = $_REQUEST["visittype"];
	$visitlimit = $_REQUEST["visitlimit"];
	$overalllimit = $_REQUEST["overalllimit"];
		
	$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_visitentry (patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname, consultingdoctor,
		department,paymenttype,subtype,accountname,accountexpirydate,planname,planexpirydate,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,complaint,visittype,visitlimit,overalllimit) 
		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor',
		'$department','$paymenttype','$subtype','$accountname','$accountexpirydate','$planname','$planexpirydate','$consultationdate','$consultationtime','$consultationfees','$referredby', '$consultationremarks','$complaint','$visittype','$visitlimit','$overalllimit')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			
		//$patientcode = '';
		//$visitcode = '';
		$patientfirstname = '';
		$patientmiddlename = '';
		$patientlastname = '';
		$consultingdoctor = '';
		$department = '';
		$paymenttype = '';
		$subtype = '';
		$accountname = '';
		$accountexpirydate = '';
		$planname = '';
		$planexpirydate = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationfees = '';
		$referredby = '';
		$consultationremarks = '';
		$complaint = '';
		$visittype = '';
		$visitlimit ='';
		$overalllimit = '';
		
		header("location:billing_op1.php?patientcode=$patientcode&&visitcode=$visitcode");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
		exit;
	}
	else
	{
		header ("location:visitentry_op1.php?patientcode=$patientcode&&st=failed");
	}

}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$consultingdoctor = '';
	$department = '';
	$paymenttype = '';
	$subtype = '';
	$accountname = '';
	$accountexpirydate = '';
	$planname = '';
	$planexpirydate = '';
	$consultationdate = '';
	$consultationtime = '';
	$consultationfees = '';
	$referredby = '';
	$consultationremarks = '';
	$complaint = '';
	$visittype = '';
	$visitlimit = '';
	$overalllimit = '';
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Visit Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Visit Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Visit Code Already Exists.";
}


$query2 = "select * from master_visitentry order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2visitcode = $res2["visitcode"];
if ($res2visitcode == '')
{
	$visitcode = 'VST00000001';
	$openingbalance = '0.00';
}
else
{
	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode, 3, 8);
	$visitcode = intval($visitcode);
	$visitcode = $visitcode + 1;

	$maxanum = $visitcode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$visitcode = 'VST'.$maxanum1;
	$openingbalance = '0.00';
	//echo $companycode;
}

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//$patientcode = 'MSS00000009';

if ($patientcode != '')
{
	//echo 'Inside Patient Code Condition.';
	$query3 = "select * from master_customer where customercode = '$patientcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$patientfirstname = $res3['customername'];
	$patientmiddlename = $res3['customermiddlename'];
	$patientlastname = $res3['customerlastname'];
	$paymenttype = $res3['paymenttype'];
	$subtype = $res3['subtype'];
	$billtype = $res3['billtype'];
	$accountname = $res3['accountname'];
	$accountexpirydate = $res3['accountexpirydate'];
	$planname = $res3['planname'];
	$planexpirydate = $res3['planexpirydate'];
	$visittype = $res['visittype'];
	$visitlimit = $res3['visitlimit'];	
	$overalllimit = $res3['overalllimit'];
	
}
$consultationdate = date('Y-m-d');
$consultationtime = date('H:i');
//$consultationfees = '500';
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">


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

function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
}


</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function process1()
{
	if (document.form1.patientcode.value == "")
	{
		alert ("Please Search & Select Patient To Proceed.");
		document.form1.visittype.focus();
		return false;
	}
	if (document.form1.patientfirstname.value == "")
	{
		alert ("Please Enter Patient First Name.");
		document.form1.patientfirstname.focus();
		return false;
	}
	if (document.form1.visittype.value == "")
	{
		alert ("Please Select Visit Type.");
		document.form1.visittype.focus();
		return false;
	}
	if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		return false;
	}
	if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Consulting Doctor.");
		document.form1.consultingdoctor.focus();
		return false;
	}
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department.");
		document.form1.department.focus();
		return false;
	}
}

function funcVisitLim()
{
<?php
	$query11 = "select * from master_customer where status = 'ACTIVE'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11customername = $res11["customername"];
	$res11visitlimit = $res11['visitlimit'];
	$res11patientfirstname=$res11patientfirstname['patientfirstname'];
		?>
		if(document.getElementById("customername").value == "<?php echo $res11customername; ?>")
		{
			document.getElementById("visitlimit").value = <?php echo $res11visitlimit; ?>;
			document.getElementById("patientfirstname").value = <?php echo $res11patientfirstname; ?>;
			document.getElementById("customername").value = <?php echo $res11customername; ?>;
	
			return false;
		}
	<?php
	}
	?>
}

function funcDepartmentChange()
{
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11department; ?>")
		{
		document.getElementById("consultingdoctor").options.length=null; 
		var combo = document.getElementById('consultingdoctor'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Doctor Name", ""); 
		<?php
		$query10 = "select * from master_doctor where department = '$res11department' order by doctorname";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10doctorcode = $res10["doctorcode"];
		$res10doctorname = $res10["doctorname"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctorcode;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11department; ?>")
		{
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11department' order by consultationtype";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10consultationtype = $res10["consultationtype"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtype;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>


}
function funcConsultationTypeChange()
{
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
		if(document.getElementById("consultationtype").value == "<?php echo $res11consultationtype; ?>")
		{
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
		}
	<?php
	}
	?>
}


function funcOnLoadBodyFunctionCall()
{
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}


</script>
<?php include ("js/dropdownlist1scripting1.php"); ?>
<script type="text/javascript" src="js/autosuggest1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="visitentry_op1.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Search By Name </td>
				  <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="customer" id="customer"  onClick="javascript:customersearch('sales')" style="border: 1px solid #001E6A;" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">				  <label></label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td width="31%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td width="29%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> First Name </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Middle Name </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Last Name </span></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly="readonly"  style="border: 1px solid #001E6A;"  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" /></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Reg ID </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" readonly="readonly" style="border: 1px solid #001E6A"  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Visit ID </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly="readonly" style="border: 1px solid #001E6A;"  size="20" /></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Type</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				    <input type="text" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttype;?>" readonly="readonly"   style="border: 1px solid #001E6A;">
				</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Bill Type </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				  </td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Sub Type </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="subtype" id="subtype"  value="<?php echo $subtype;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Account Name </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="accountname" id="accountname"  value="<?php echo $accountname;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Account Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
                  </label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Plan Name </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="planname" id="planname"  value="<?php echo $planname;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Plan Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
                  </label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Visit Limit </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Overall Limit </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
                  </label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Visit Type </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
				    <select name="hidden" id="visittype" >
                      <?php
				if ($visittype == '')
				{
					echo '<option value="" selected="selected">Select Visit Type</option>';
				}
				else
				{
					$query51 = "select * from master_visittype where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51visittype = $res51["visittype"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51visittype.'" selected="selected">'.$res51visittype.'</option>';
				}
				
				$query5 = "select * from master_visittype where recordstatus = '' order by visittype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5visittype = $res5["visittype"];
				?>
                      <option value="<?php echo $res5visittype; ?>"><?php echo $res5visittype; ?></option>
                      <?php
				}
				?>
                    </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Department</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
                      <strong>
                      <select name="department" id="department" onChange="return funcDepartmentChange()">
                        <?php
				if ($department == '')
				{
					echo '<option value="" selected="selected">Select Department</option>';
				}
				else
				{
					$query51 = "select * from master_department where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51department = $res51["department"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51department.'" selected="selected">'.$res51department.'</option>';
				}
				
				$query5 = "select * from master_department where recordstatus = '' order by department";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5department = $res5["department"];
				?>
                        <option value="<?php echo $res5department; ?>"><?php echo $res5department; ?></option>
                        <?php
				}
				?>
                      </select>
                    </strong></td>
				</tr>
				<tr>
                <td width="23%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<span class="bodytext32">Consulting Doctor </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
                  <select name="consultingdoctor" id="consultingdoctor">
				  <option value="" selected="selected">Select Doctor Name</option>
                 </select>
									
                </strong></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Consultation Type </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
                  <select name="consultationtype" id="consultationtype" onChange="return funcConsultationTypeChange()">
 				  <option value="" selected="selected">Select Consultation Type</option>
                 </select>
                </strong></td>
				</tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Consultation Date </span></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly="readonly" style="border: 1px solid #001E6A;">
                     <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('consultationdate')" style="cursor:pointer"/> </span></strong
				  ></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Consultation Time </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly="readonly" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="country" id="select">
                    <?php
		 	if ($country != '') 
		  	{
			  echo '<option value="'.$country.'" selected="selected">'.$country.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_country where status <> 'deleted' order by country";
			$exec1 = mysql_query($query1) or die ("Error in Query1.country".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$country = $res1["country"];
			if ($country == 'India') { $selectedcountry = 'selected="selected"'; }
			?>
                    <option <?php echo $selectedcountry; ?> value="<?php echo $country; ?>"><?php echo $country; ?></option>
                    <?php
			  $selectedcountry = '';
				  
			  }
			  ?>
                  </select>                
-->
<span class="bodytext32">(Ex: HH:MM)</span></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Consultation Fees </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="consultationfees" id="consultationfees" value="<?php echo $consultationfees; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Referred By </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="referredby" id="referredby" value="<?php echo $referredby; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Consultation Remarks </td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="consultationremarks" id="consultationremarks" value="<?php echo $consultationremarks; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Complaint</td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="complaint" id="complaint" value="<?php echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
				 <tr>
				   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			      </tr>
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#E0E0E0"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
<script language="javascript">
</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>