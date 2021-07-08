<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientname=$_REQUEST['customername'];
$billnumber=$_REQUEST['billnumber'];
$dateonly = date("Y-m-d");
$billnumbercode = $_REQUEST['docnumber'];

$billtype = $_REQUEST['billtype'];
$accountname = $_REQUEST['accountname'];


foreach($_POST['radiology'] as $key => $value)
		{
		$radiologyname=$_POST['radiology'][$key];
		$itemcode=$_POST['code'][$key];
		$radno =$_POST['radno'][$key];
		if(isset($_POST['ack']))
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow == $radno)
		{
		$status='completed';
		$status2='norefund';
		break;
		}
		else
		{
		$status='pending';
		}
	}
	
	foreach($_POST['ref'] as $check1)
	{
	$refund=$check1;
	if($refund == $radno)
	{
	$status1='refund';
	$status2='refund';
	$status='completed';
	break;
	}
	else
	{
	$status1='norefund';
	}
	}
	
	$uploaddir = 'uploads/';
	$uploadfile = $uploaddir.basename($_FILES['upload']['name'][$key]);
	$uploadfilename=$_FILES['upload']['tmp_name'][$key];
    move_uploaded_file($_FILES['upload']['tmp_name'][$key],$uploadfile);
	$filename=$_FILES['upload']['name'][$key];
		
		
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($radiologyname != "")
   {
   
   mysql_query("update consultation_radiology set resultentry='$status',radiologyrefund='$status1',docnumber = '$billnumbercode' where billnumber='$billnumber' and radiologyitemname='$radiologyname' and auto_number='$radno'");
  }

}
  header("location:externalradiologyentrylist.php");
  exit;
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<script>
function disableafterclick (varserialnumber3)
 {
var varserialnumber3 = varserialnumber3;
document.getElementById("Class"+varserialnumber3+"").disabled = true;
}
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}

var chks1 = document.getElementsByName('ref[]');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;
}
}

if (hasChecked == false && hasChecked1 == false)
{
alert("Please either acknowledge/refund a sample  or click back button on the browser to exit sample collection");
return false;
}
return true;
}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{
document.getElementById("Class"+varserialnumber+"").style.visibility = 'visible';
document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
document.getElementById("Class"+varserialnumber+"").style.visibility = 'hidden';
document.getElementById("ref"+varserialnumber+"").disabled = false;
}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{

document.getElementById("ack"+varserialnumber1+"").disabled = true;
}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
}
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
select { visibility:hidden; }
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
</style>

<script src="js/datetimepicker_css.js"></script>
<?php
$billnumber = $_REQUEST["billnumber"];
$query55="select * from consultation_radiology where billnumber='$billnumber'";
$exec55=mysql_query($query55) or die(mysql_error());
$res55=mysql_fetch_array($exec55);
$patientname=$res55['patientname'];

$locationname=$res55['locationname'];
 $locationcode=$res55['locationcode'];
 $billtype=$res55['billtype'];
 $accountname=$res55['accountname'];
 

$query66="select * from billing_external where billno='$billnumber'";
$exec66=mysql_query($query66) or die(mysql_error());
$res66=mysql_fetch_array($exec66);
$age=$res66['age'];
$gender=$res66['gender'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'ERRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from resultentry_radiology where patientcode = 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumbers = $res2["docnumber"];
$billdigit=strlen($billnumbers);
if ($billnumbers == '')
{
	$billnumbercode ='ERRE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumbers = $res2["docnumber"];
	$billnumbercode = substr($billnumbers,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ERRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="externalradiologyentry.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
             <tr bgcolor="#E0E0E0">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#E0E0E0"><strong>Patient  * </strong></td>
	  <td width="30%" align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3">
				<input name="customername" type="hidden" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                          <td bgcolor="#E0E0E0" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="42%" bgcolor="#E0E0E0" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
                <td bgcolor="#E0E0E0" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Location </strong></td>
				
                 
                
                <td width="42%" bgcolor="#E0E0E0" class="bodytext3"><?php echo $locationname;?>
                <input type="hidden">
                </td>
              </tr>
			 
		
			 
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $age; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $gender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $gender; ?>
				     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="billnumber" id="billnumber" type="hidden" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $billnumber; ?>
				
				</td>
			
              	  </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Doc Number</strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?>
				<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;	</td>
			
              	  </tr>
			   
			   
				  <tr>
				  <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Upload</strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;			
			$query61 = "select * from consultation_radiology where billnumber='$billnumber' and resultentry='pending'";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
while($res61 = mysql_fetch_array($exec61))
{
$radiologyname =$res61["radiologyitemname"];
$radautono = $res61['auto_number'];
$query68="select * from master_radiology where itemname='$radiologyname'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);
$itemcode=$res68['itemcode'];
$sno = $sno + 1;
?>
  <tr>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radiologyname;?></div></td>
		<input type="hidden" name="radiology[]" value="<?php echo $radiologyname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="radno[]" value="<?php echo $radautono; ?>">
		   <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $radautono; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
		<!--<td class="bodytext31" valign="center"  align="center"><div align="center">
		<input type="file" name="upload[]" size="15"></div></td>-->
		<td class="bodytext31" valign="center"  align="left"><div align="center">
			<select name="Class[]" id="Class<?php echo $sno; ?>" onChange="if (this.value) window.open(this.value, '_blank'); disableafterclick(<?php echo $sno; ?>);" >
				<option value = '0'>-Select Template-</option>  
				  <?php
				$query5 = "select * from master_radiologytemplate";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5templatename = $res5["templatename"];
				?>
                   <option value="extappendto.php?docnum=<?php echo $billnumbercode; ?>&&visitcode=<?php echo $visitcode; ?>&&tid=<?php echo $res5anum; ?>&&itemcode=<?php echo $itemcode; ?>&&billnum=<?php echo $billnumber; ?>"><?php echo $res5templatename; ?></option>
                    <?php
				}
				?>
			
				
<!--			    <option value = '0'>-Select Template-</option> 
				<option value = '1'>Template1</option> 
				<option value = '2'>Template2</option> 
				<option value = '3'>Template3</option> 
				<option value = '4'>Template4</option>
				<option value = '4'>Template5</option> 
-->			</select>
		</div>		
		  <div id="tdata">
			  
			   </div>
			   	      </td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>"value="<?php echo $radautono; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>
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
           
               </tr>
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" />
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>