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
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$docnumber=$_REQUEST['docnumber'];
$samplecollectiondocnumber=$_REQUEST['samplecollectiondocno'];
$accountname = $_REQUEST['account'];

$query231 = "select * from master_employee where username='$username'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);
$location = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$store = $res751['store'];
$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
	 $labname=$_POST['lab'][$key];
		 $itemcode=$_POST['code'][$key];
		$resultvalue=$_POST['result'][$key];
		$unit=$_POST['units'][$key];
		$referencevalue=$_POST['reference'][$key];
		$refname = $_POST['referencename'][$key];
		foreach($_POST['ack'] as $ch)
		{
		 $acknow=$ch;
		
		if($acknow == $itemcode)
		{
		$status1='completed';
		$query26="insert into ipresultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname')";
   $exec26=mysql_query($query26) or die(mysql_error());
   
 
   $query29=mysql_query("update ipconsultation_lab set resultentry='$status1' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$samplecollectiondocnumber'");
		}
		
	}
	
		    $query31 = "select * from master_lablinking where labcode = '$itemcode' and recordstatus = ''";
	$exec31 = mysql_query($query31) or die(mysql_error());
	$num31 = mysql_num_rows($exec31);
	while($res31 = mysql_fetch_array($exec31))
	{
	$pharmacyitemcode = $res31['itemcode'];
	$pharmacyitemname = $res31['itemname'];
	$pharmacyquantity = $res31['quantity'];
	
	$query311 = "select * from master_itempharmacy where itemcode = '$pharmacyitemcode'"; 
	$exec311 = mysql_query($query311) or die ("Error in Query31".mysql_error());
	$res311 = mysql_fetch_array($exec311);
	$pharmacyrate = $res311['rateperunit'];
	$categoryname = $res311['categoryname'];
	
	$pharmacyamount = $pharmacyrate * $pharmacyquantity;
	
	$query57 = "select * from purchase_details where itemcode='$pharmacyitemcode'";
//echo $query57;
	$res57=mysql_query($query57);
	$num57=mysql_num_rows($res57);
	//echo $num57;
	while($exec57 = mysql_fetch_array($res57))
	{
	 $batchname = $exec57['batchnumber']; 
//echo $batchname;
$companyanum = $_SESSION["companyanum"];
			 $itemcode = $pharmacyitemcode;
			 $batchname = $batchname;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	 $currentstock;
	if($currentstock > 0 )
	{
	
	mysql_query("insert into pharmacysales_details(itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,categoryname)values('$pharmacyitemname','$pharmacyitemcode','$pharmacyquantity','$pharmacyrate','$pharmacyamount','$batchname','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly1','$accountname','$docnumber','$timeonly','$location','$store','$categoryname')");

	}
	}
	}
	
		 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");

	
}
header("location:iplabresultentrylist.php");
 exit();

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
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
break;
}
}
if (hasChecked == false)
{
alert("Please acknowledge a lab item  or click back button on the browser to exit lab result entry");
return false;
}
return true;
}
</script>
<script>
function funcLabHideView(para)
{	
var idname=para;
alert(idname);
 if (document.getElementById(idname) != null) 
	{
	document.getElementById(idname).style.display = 'none';
	}			
}
function funcLabShowView(param)
{
var idname1=param;

  if (document.getElementById(idname) != null) 
     {
	 document.getElementById(idname).style.display = 'none';
	}
	if (document.getElementById(idname) != null) 
	  {
	  document.getElementById(idname).style.display = '';
	 }
}
</script>
<script>
function funcOnLoadBodyFunctionCall()
{
funcLabHideView();
	}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
$docnumber = $_REQUEST["docnumber"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'IPLRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipresultentry_lab order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPLRE-'.'1';
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
	
	
	$billnumbercode = 'IPLRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="iplabresultentry.php" onKeyDown="return disableEnterKey(event)">
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
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#E0E0E0'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#E0E0E0">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#E0E0E0"><strong>Patient  * </strong></td>
	  <td width="22%" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                          <td bgcolor="#E0E0E0" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="26%" bgcolor="#E0E0E0" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
				<td width="11%" align="left" valign="middle"  class="bodytext3"><strong>Doc No</strong></td>
                <td width="21%" align="left" class="bodytext3" valign="middle" >
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>
                  </td>
              </tr>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" align="left" valign="middle" class="bodytext3">
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="samplecollectiondocno" value="<?php echo $docnumber; ?>">
				</td>
				  </tr>
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
            </tbody>
        </table></td>
      </tr>
	
     <tr>
	  <td colspan="5" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext365">
				 <strong>LAB TEST RESULTS</strong>
				  </td> </tr>
				  
				   <tr>
		    <td width="5%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
			<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Result value</strong></div></td>
			<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Units</strong></div></td>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Reference Value</strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Acknowledge</strong></div></td>
		  </tr>
				  <?php
	  $query31="select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labsamplecoll='completed' and resultentry='pending' and docnumber='$docnumber' group by labitemname";
	  $exec31=mysql_query($query31);
	  $num=mysql_num_rows($exec31);
	  while($res31=mysql_fetch_array($exec31))
	  { 
	   $labname1=$res31['labitemname'];
	   $labitemcode = $res31['labitemcode'];
	
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
			$sno = $sno + 1;
		?>		  
			  <tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="center"><div align="left"><?php echo $labname1; ?></div></td>
			  	   <input type="hidden" name="lab[]" value="<?php echo $labname1;?>">
              <td class="bodytext31" valign="center"  align="center">
			  <div align="center">
			  <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcShowDetailHide('<?php echo $sno; ?>')" onClick="return funcShowDetailView('<?php echo $sno; ?>')">			  </div>			  </td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"></div></td>
			       	  <td class="bodytext31" valign="center"  align="center">
			  <div class="bodytext31"></div></td>
			  <td class="bodytext31" valign="center"  align="center"><div align="center"><input type="checkbox" name="ack[]" value="<?php echo $labitemcode; ?>"></div></td>
		
         </tr>
		 	<tr id="idTRSub<?php echo $sno; ?>">
			<td colspan="7"  align="left" valign="center" class="bodytext31">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1000"
            align="left" border="0">
              <tbody>
               
			   <?php 
			   $subTRsno = 0;
			  $query52="select * from master_lab where itemname='$labname1' and itemcode='$labitemcode'";
			   $exec52=mysql_query($query52);
			   $num=mysql_num_rows($exec52);
			   while($res52=mysql_fetch_array($exec52))
			   {
			   $labname2=$res52['itemname'];
			 $itemcode2=$res52['itemcode'];
			    /* $query52="select * from master_lab where itemname='$labname2'";
				  $exec52=mysql_query($query52);
				  $res52=mysql_fetch_array($exec52);*/
				  $labunit1=$res52['itemname_abbreviation'];
				   $labreferenceunit = $res52['referenceunit'];
				   
				$labreferencename = $res52['referencename'];
				$labitemanum = $res52['auto_number'];
				 
				
				   $labreferencerange = $res52['referencerange'];
				  $labreferencevalue1=$res52['referencevalue'];
				  
				  $query64 = "select * from master_lab where itemcode='$itemcode2' and referencename = '$labreferencename' and auto_number = '$labitemanum' and status <> 'deleted' group by referencename";
				  $exec64 = mysql_query($query64) or die(mysql_error());
				  $num64 = mysql_num_rows($exec64);
				  if($num64 > 0)
				  {
				  
				  	$subTRcolorloopcount = $subTRcolorloopcount + 1;
				$subTRshowcolor = ($subTRcolorloopcount & 1); 
				if ($subTRshowcolor == 0)
				{
					//echo "if";
					$subTRcolorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$subTRcolorcode = 'bgcolor="#D3EEB7"';
				}
						   ?> 
						     <tr <?php echo $subTRcolorcode; ?>>
							 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="150"><div class="bodytext311"> <?php if($labreferencename == '')
				   {
				   echo $labname2;
				   }
				   else
				   {
				   echo $labreferencename;
				   } ?></div></td>
				   <input type="hidden" name="lab[]" value="<?php echo $labname2;?>"><input type="hidden" name="referencename[]" value="<?php echo $labreferencename; ?>">
				  <input type="hidden" name="code[]" value="<?php echo $itemcode2; ?>">
				  
				
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center"><div align="center"> <input type="text" name="result[]" size="8"/> </div></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="150"><div align="left"> <?php if($labreferenceunit == '')
				  {
				  echo $labunit1;
				  }
				  else
				  {
				  echo $labreferenceunit;
				  } ?><input type="hidden" name="units[]" size="8" value="<?php echo $labreferenceunit; ?>"/> </div></td>
               <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="250"><div align="left"> <?php if($labreferencerange == '')
			   {
			   echo $labreferencevalue1;
			   }
			   else
			   {
			   echo $labreferencerange;
			   } ?><input type="hidden" name="reference[]" size="8" value="<?php echo $labreferencerange; ?>"/></div></td>
              </tr>
			  <?php 
		 }
		 }
		 ?>
			  </tbody>
            </table>			</td>
			<td width="6%"  align="left" valign="center" class="bodytext31"><div align="left">&nbsp;</div></td>
			</tr>
			 
		 
			 
		 <tr>
		 <td class="bodytext31" colspan="7" valign="center"  align="left"><div align="left">&nbsp;</div></td>
			
		 </tr> 
		 <?php
		  
		 }
		 ?>
		 
				  
				  
				  	<script language="javascript">
			//alert ("Inside JS");
			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.
			for (i=1;i<=100;i++)
			{
				if (document.getElementById("idTRSub"+i+"") != null) 
				{
					document.getElementById("idTRSub"+i+"").style.display = 'none';
				}
			}
			
			function funcShowDetailView(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = 'none';
					}
				}

				if (document.getElementById("idTRSub"+varSerialNumber+"") != null) 
				{
					document.getElementById("idTRSub"+varSerialNumber+"").style.display = '';
				}
			}
			
			function funcShowDetailHide(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = 'none';
					}
				}
			}
			</script>	

      <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">User Name: 
               <input name="user" type="hidden" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"><?php echo strtoupper($_SESSION['username']); ?></td>
               </tr>
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()"  accesskey="b" class="button" style="border: 1px solid #001E6A"/>
               </td>
          </tr>
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>