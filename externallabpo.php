<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

error_reporting(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$recorddate = date('Y-m-d');
$recordtime= date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$date = date('Ymd');
$colorloopcount = '';


ini_set('display_errors',1);
//error_reporting(E_ALL);
//To populate the autocompetelist_services1.js


$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}




if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

$externallabsupplier = $_REQUEST['externallabsupplier'];
$externallabsupplier1 = explode("#",$externallabsupplier);
$externallabsuppliername = $externallabsupplier1[0];
$externallabsuppliercode = $externallabsupplier1[1];
$externallabsuppliername = trim($externallabsuppliername);
$externallabsuppliercode = trim($externallabsuppliercode);

$paynowbillprefix = 'EL-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from externallab_po order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EL-'.'1';
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
	
	
	$billnumbercode = 'EL-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

foreach($_POST['sampleid'] as $key => $value)
{
$sampleid = $_POST['sampleid'][$key];
$visitcode = $_POST['visitcode'][$key];
$patientcode = $_POST['patientcode'][$key];
$patientname = $_POST['patientname'][$key];

		foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $sampleid)
		{
		$query34 = "update samplecollection_lab set externallab = 'selected',externallabcode='$externallabsuppliercode',externallabname='$externallabsuppliername' where patientvisitcode='$visitcode' and sampleid='$sampleid'";
		$exec34 = mysql_query($query34) or die(mysql_error());
		
		$query35 = "insert into externallab_po(date,docno,sampleid,username,ipaddress)values('$recorddate','$billnumbercode','$sampleid','$username','$ipaddress')";
		$exec35 = mysql_query($query35) or die(mysql_error());
		}
		}
}
header("location:externallabpogenerate.php?docno=$billnumbercode");
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
<?php include ("autocompletebuild_supplier1.php"); ?>
<?php
		function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
<script type="text/javascript">

function externallabvalue()
{
	
	var a=document.getElementById("searchsuppliername").value;
	
	document.getElementById("externallabsupplier").value =a;
}

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}



function validcheck()
{
externallabvalue();	
if(document.getElementById("searchsuppliername").value == '')
{
alert("Please Select External Lab");
document.getElementById("searchsuppliername").focus();
return false;
}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="110%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
			<form name="drugs" action="externallabpo.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="8" bgcolor="#cccccc" class="bodytext31"><strong>External Lab PO</strong></td>
          </tr>
        
        <script language="javascript">

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


</script>
        
         <tr>
					<td width="110" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>External Lab</strong></td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <input name="searchsuppliername" type="text" id="searchsuppliername" size="50" autocomplete="off" />				    </td>
					  <td colspan="3" bgcolor="#FFFFFF" >&nbsp;</td>
				  </tr>
					 <tr>
          <td width="110" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="156" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="94" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><span class="style1"><strong>Date To</strong></span></td>
          <td width="122" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
		  <span class="bodytext31"><img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="24" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">&nbsp;</td>
          <td width="246" align="left" valign="center"  bgcolor="#ffffff"></td>
          </tr>
					
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly /></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><!--Item Code :--> <?php //echo $medicinecode; ?>
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		  <input  type="submit" value="Search" name="Submit" />
		  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
		  <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
		  </strong></td>
        </tr>
      </tbody>
    </table>
    </form>		
	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<form name="form1" id="form1" method="post" action="externallabpo.php" onSubmit="return validcheck()">	
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1033"
            align="left" border="0">
          <tbody>
		  <?php
		  if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

$externallabsupplier = $_REQUEST['searchsuppliername'];
		  ?>
		 
		  <tr>
		      <td width="56" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Select</strong></div></td>
		      <td width="43" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
				<td width="74" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="177" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
              <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg No</strong></td>
              <td width="77" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="58" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
				 <td width="74" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
				 <td width="229" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name</strong></div></td>
				 <td width="90" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>


             </tr>
				<?php
				
$sno=0;

$query7 = "select * from samplecollection_lab where acknowledge = 'completed' and status = 'completed' and resultentry = '' and refund <> 'refund' and externallab = '' and recorddate between '$fromdate' and '$todate' order by recorddate desc";
$exec7 = mysql_query($query7) or die(mysql_error());
$num7 = mysql_num_rows($exec7);
							
while($res7 = mysql_fetch_array($exec7))
{
$patientname6 = $res7['patientname'];
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sampleid = $res7['sampleid'];
$billnumber2 = $res7['billnumber'];

if($regno=='walkin')
{
$query70 = "select * from billing_external where patientcode = '$regno' and billno ='$billnumber2' ";
$exec70 = mysql_query($query70) or die(mysql_error());
$res70 = mysql_fetch_array($exec70);
$age = $res70['age'];
$gender = $res70['gender'];
}
else
{
$query751 = "select * from master_customer where customercode = '$regno' ";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$dob = $res751['dateofbirth'];
$age = calculate_age($dob);
$gender = $res751['gender'];
}


$query68="select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);
$externallab = $res68['externallab'];
$rate = $res68['externalrate'];

if($externallab == 'on')
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
              <td align="left" valign="center"  
                class="bodytext31"><input type="checkbox" name="select[]" id="select" value="<?php echo $sampleid; ?>"></td>
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
             				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $age; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $test; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="right"><?php echo $rate; ?></div></td>
				<input type="hidden" name="sampleid[]" id="sampleid" value="<?php echo $sampleid; ?>"> 
				<input type="hidden" name="patientname[]" id="patientname" value="<?php echo $patientname6; ?>">
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $regno; ?>">
              	

				</tr>
				<?php
				}
				}
				?>
                
                
                
				<?php
				
$sno=0;

$query7 = "select * from ipsamplecollection_lab where acknowledge = 'completed' and refund <> 'refund' and recorddate between '$fromdate' and '$todate' order by recorddate desc";
$exec7 = mysql_query($query7) or die(mysql_error());
$num7 = mysql_num_rows($exec7);
							
while($res7 = mysql_fetch_array($exec7))
{
$patientname6 = $res7['patientname'];
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
 $itemcode = $res7['itemcode'];
$billnumber2 = $res7['billnumber'];

$query751 = "select * from master_customer where customercode = '$regno' ";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$dob = $res751['dateofbirth'];
$age = calculate_age($dob);
$gender = $res751['gender'];


$query68="select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);
$externallab = $res68['externallab'];
$rate = $res68['externalrate'];

if($externallab == 'on')
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
              <td align="left" valign="center"  
                class="bodytext31"><input type="checkbox" name="select[]" id="select" value="<?php echo $sampleid; ?>"></td>
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
             				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $age; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $test; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="right"><?php echo $rate; ?></div></td>
				<input type="hidden" name="sampleid[]" id="sampleid" value="<?php echo $sampleid; ?>"> 
				<input type="hidden" name="patientname[]" id="patientname" value="<?php echo $patientname6; ?>">
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $regno; ?>">

				</tr>
				<?php
				}
				}
				?>
				<tr>
                
        <td colspan="11" align="right">
		<input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input type="text" name="externallabsupplier" id="externallabsupplier" value="<?php echo $externallabsupplier; ?>">
		<input type="submit" name="submit" value="Generate PO" onClick="return externallabvalue()" ></td>
      </tr>
	  <?php
	  }
	  ?>
		  </tbody>
		  </table>
		  </form></td>
      </tr>
	  
      
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>