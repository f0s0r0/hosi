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
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';
$docno = $_SESSION["docno"];

						$query1 = "select locationcode from login_locationdetails where username='$username' and docno='$docno'";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						 $res1locationanum = $res1["locationcode"];
						


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientname=$_REQUEST['customername'];
$billnumber1=$_REQUEST['billnumber'];

	$paynowbillprefix = 'ES-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode = 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ES-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ES-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
		$sampleid = '';
		$labname=$_POST['lab'][$key];
		$itemcode=$_POST['code'][$key];
		$sample=$_POST['sample'][$key];
		$itemstatus=$_POST['status'][$key];
		$labno =$_POST['labno'][$key];
		$remarks=$_POST['remarks'][$key];

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
	
		if($acknow == $labno)
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

$status1='norefund';
	foreach($_POST['ref'] as $check1)
	{
	$refund=$check1;
	
	if($refund == $labno)
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
	

if($labname == "")
{
$query68="select * from master_lab where itemcode='$itemcode'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);
$labname=$res68['itemname'];

}
	
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($labname != "")
   {
    if(($status == 'completed')&&($itemstatus == 'completed'))
   {
   $paynowbillprefix = 'EPS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode = 'walkin' and sampleid <> '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$sampleidno = $res2["sampleid"];
$billdigit=strlen($sampleidno);
if ($sampleidno == '')
{
	$sampleid ='EPS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$sampleidno = $res2["sampleid"];
	$sampleid = substr($sampleidno,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$sampleid = intval($sampleid);
	$sampleid = $sampleid + 1;

	$maxanum = $sampleid;	
	$sampleid = 'EPS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
   }
   
   
   
 $query26="insert into samplecollection_lab(patientname,patientcode,patientvisitcode,recorddate,itemcode,itemname,sample,acknowledge,refund,billnumber,docnumber,username,sampleid,status,remarks,recordtime,locationcode)values('$patientname','walkin',
   'walkinvis','$dateonly','$itemcode','$labname','$sample','$status','$status1','$billnumber1','$billnumbercode','$username','$sampleid','$itemstatus','$remarks','$timeonly','$res1locationanum')";
   $exec26=mysql_query($query26) or die(mysql_error());
   
   $query29=mysql_query("update consultation_lab set labsamplecoll='$status',labrefund='$status1',docnumber='$billnumbercode',sampleid='$sampleid' where labitemname='$labname' and billnumber='$billnumber1' and auto_number='$labno'") or die(mysql_error());
 
 
  
  	}
	
}
  //
  
  header("location:collectedsampleview.php?patientcode=walkin&&visitcode=walkinvis&&docnumber=$billnumbercode");
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}

$paynowbillprefix = 'ES-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode = 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ES-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ES-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

<script>
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
for(n=1;n<10;n++)
	{
if(document.getElementById("status"+n+"").value == 'notcompleted')
{
if(document.getElementById("remarks"+n+"").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks"+n+"").focus();
return false;
}
}
}
return true;
}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
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

function funcremarksshow(k)
{
var k = k;
//alert(k);
  if (document.getElementById("remarks1"+k+"") != null) 
     {
	 document.getElementById("remarks1"+k+"").style.display = 'none';
	}
	if (document.getElementById("remarks1"+k+"") != null) 
	  {
	  document.getElementById("remarks1"+k+"").style.display = '';
	 }
	 
  if (document.getElementById("remarks2") != null) 
     {
	 document.getElementById("remarks2").style.display = 'none';
	}
	if (document.getElementById("remarks2") != null) 
	  {
	  document.getElementById("remarks2").style.display = '';
	 }
	 
	  if (document.getElementById("remarks3") != null) 
     {
	 document.getElementById("remarks3").style.display = 'none';
	}
	if (document.getElementById("remarks3") != null) 
	  {
	  document.getElementById("remarks3").style.display = '';
	 }
	
}

function funcremarkshide()
{		

 if (document.getElementById("remarks2") != null) 
	{
	document.getElementById("remarks2").style.display = 'none';
	}	
	for(i=1;i<10;i++)
	{
	if (document.getElementById("remarks1"+i+"") != null) 
	{
	document.getElementById("remarks1"+i+"").style.display = 'none';
	}
	}	
	if (document.getElementById("remarks3") != null) 
	{
	document.getElementById("remarks3").style.display = 'none';
	}	
}

function funcstatus(j)
{
var j = j;
if(document.getElementById("status"+j+"").value == 'notcompleted')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'completed')
{
funcremarkshide();
}
}

function funcOnLoadBodyFunctionCall()
{
funcremarkshide();

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
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
<?php
$billnumber = $_REQUEST["billnumber"];
$query55="select * from consultation_lab where billnumber='$billnumber'";
$exec55=mysql_query($query55) or die(mysql_error());
$res55=mysql_fetch_array($exec55);
$patientname=$res55['patientname'];
$query66="select * from billing_external where billno='$billnumber'";
$exec66=mysql_query($query66) or die(mysql_error());
$res66=mysql_fetch_array($exec66);
$age=$res66['age'];
$gender=$res66['gender'];
?>
<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="externallabsamplecollection.php" onKeyDown="return disableEnterKey(event)">
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
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#CCCCCC" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="21%" align="left" valign="middle" bgcolor="#CCCCCC" class="bodytext3">
				<input name="customername" type="hidden" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>                  </td>
                          <td bgcolor="#CCCCCC" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="28%" bgcolor="#CCCCCC" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
               
               
                <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><strong>Doc No</strong></td>
                <td width="25%" bgcolor="#CCCCCC" class="bodytext3" align="left"><?php echo $billnumbercode; ?> </td>
              </tr>
			   <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $age; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $gender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $gender; ?>			        </td>
                <td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong> Bill No</strong></td>
                <td colspan="5" align="left" valign="middle" class="bodytext3">
				<input name="billnumber" id="billnumber" type="hidden" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $billnumber; ?>				</td>
				  </tr>
			   
			   
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
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
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
              <td width="28%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Type</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				 <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311" id="remarks2"><strong>Remarks</strong></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$totalamount=0;			
			$query61 = "select * from consultation_lab where billnumber='$billnumber' and patientname='$patientname' and labsamplecoll='pending' and labrefund='norefund'";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
while($res61 = mysql_fetch_array($exec61))
{
$labname =$res61["labitemname"];
$labautono = $res61['auto_number'];
$query68="select * from master_lab where itemname='$labname' and status <> 'deleted'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);
$samplename=$res68['sampletype'];
$itemcode=$res68['itemcode'];
$query41="select * from master_categorylab where categoryname='$labname'";
$exec41=mysql_query($query41);
$num41=mysql_num_rows($exec41);
if($num41 > 0)
{
$itemcode=$ssno;
$ssno=$ssno + 1;
}

$sno = $sno + 1;
?>
  <tr>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $labautono; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labname;?></div></td>
		<input type="hidden" name="lab[]" value="<?php echo $labname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="labno[]" value="<?php echo $labautono; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $samplename; ?>
       </div></td><input type="hidden" name="sample[]" value="<?php echo $samplename; ?>">
        <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $labautono; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
						 <td class="bodytext31" valign="center"  align="left"><div align="center">
		 <select name="status[]" id="status<?php echo $sno; ?>" onChange="return funcstatus('<?php echo $sno; ?>');">
		 <option value="completed">Completed</option>
		 <option value="notcompleted">Not Completed</option>
		 </select>
		 </div></td>
		  <td align="center" valign="center" class="bodytext311" id="remarks1<?php echo $sno; ?>"><textarea name="remarks[]" id="remarks<?php echo $sno; ?>"></textarea></td>			

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
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc" id="remarks3">&nbsp;</td>

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
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button"/>
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