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

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$docnumber=$_REQUEST['docnumber'];
$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
		$labname=$_POST['lab'][$key];
		$itemcode=$_POST['code'][$key];
		$sample=$_POST['sample'][$key];
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
	
		if($acknow == $itemcode)
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
	if($refund == $itemcode)
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
	//echo $status1;
		
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($labname != "")
   {
   
 $query26="insert into samplecollection_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$docnumber')";
   $exec26=mysql_query($query26) or die(mysql_error());
   
   $query29=mysql_query("update consultation_lab set labsamplecoll='$status',labrefund='$status1',docnumber='$docnumber' where labitemname='$labname' and patientvisitcode='$visitcode'");
     $query42="select * from master_visitentry where visitcode='$visitcode' and itemrefund='refund'";
   $exec42=mysql_query($query42) or die(mysql_error());
   $num42=mysql_num_rows($exec42);
   if($num42 > 0)
   {
   $query39=mysql_query("update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysql_error());
   }
   else
   {
    $query39=mysql_query("update master_visitentry set itemrefund='$status2' where visitcode='$visitcode'") or die(mysql_error());
   }

  
  	}
	
}
  
  header("location:labsamplecollectionlist.php");
  
  exit();
}

?>

<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'LS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode <> 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='LS-'.'1';
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
	
	
	$billnumbercode = 'LS-' .$maxanum;
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

function funcOnLoadBodyFunctionCall()
{
var varbilltype = document.getElementById("billtype").value
if(varbilltype =='PAY LATER')
{
for(i=1;i<=100;i++)
{
//alert('hi');
document.getElementById("ref"+i+"").disabled = true;
}
}
}

</script>


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
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];
?>
</head>
<script>
function funcPrintBill()
 {
var patientcode;
patientcode = document.getElementById("customercode").value; 
var visitcode;
visitcode = document.getElementById("visitcode").value; 
var docnumber;
docnumber = document.getElementById("docnumber").value; 
var popWin; 
popWin = window.open("print_labtest_label.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&billnumber="+docnumber,"OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
 }
</script>  

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="labsamplecollection.php" onKeyDown="return disableEnterKey(event)" onSubmit="funcPrintBill1();">
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
	  <td class="bodytext3" width="25%" align="left" valign="middle" bgcolor="#CCCCCC">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>
                  </td>
                          <td bgcolor="#CCCCCC" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="27%" bgcolor="#CCCCCC" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               
               <td width="9%" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Doc No</strong></td>
                <td width="23%" align="left" valign="middle" bgcolor="#CCCCCC" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>
                  </td>
              </tr>
			 
		
			  <tr>

			    <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td class="bodytext3" width="25%" align="left" valign="middle" >
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" class="bodytext3" valign="top" >
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type ="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage; ?>
				&
				<input name="patientgender" type="hidden" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				
				  </tr>
			    
				  <tr>
				  <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Type</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$totalamount=0;			
			$query61 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labsamplecoll='pending' and labrefund='norefund' and labitemname <> '' group by labitemname";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
while($res61 = mysql_fetch_array($exec61))
{
$labname =$res61["labitemname"];
$billtype = $res61["billtype"];
$query68="select * from master_lab where itemname='$labname'";
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
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labname;?></div></td>
		<input type="hidden" name="lab[]" value="<?php echo $labname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $samplename; ?>
       </div></td><input type="hidden" name="sample[]" value="<?php echo $samplename; ?>">
        <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $itemcode; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $itemcode; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>
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
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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