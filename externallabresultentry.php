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
$colorloopcount = '';
$sno = '';


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientname=$_REQUEST['customername'];
$consbillnumber=$_REQUEST['billnumber'];
$sampleid = $_REQUEST['sampleid'];


$query612 = "select locationcode from consultation_lab where billnumber='$consbillnumber'";
$exec612 = mysql_query($query612) or die(mysql_error());
$res612 = mysql_fetch_array($exec612);
$locationcode = $res612['locationcode'];
 $locationname = $res612['locationname'];

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

$paynowbillprefix = 'LRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from resultentry_lab order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='LRE-'.'1';
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
	
	
	 $billnumbercode = 'LRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}



$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
		 $labname=$_POST['lab'][$key];
		$itemcode=$_POST['code'][$key];
		$resultvalue=$_POST['result'][$key];
		$unit=$_POST['units'][$key];
		 $referencevalue=$_POST['reference'][$key];
		$refname = $_POST['referencename'][$key];
		
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow == $labname)
		{
		$status1='completed';
		break;
		}
		else
		{
		$status1='pending';
		}
	}
		if($resultvalue != '')
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	
		$refund=$_POST['ref'][$key];
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
  if($labname != "")
   {
  
   
    $query26="insert into resultentry_lab(docnumber,patientname,patientcode,patientvisitcode,recorddate,itemcode,itemname,resultvalue,referencevalue,unit,billnumber,username,referencename,resultstatus,sampleid,locationcode,locationname)values('$billnumbercode','$patientname','walkin',
   'walkinvis','$dateonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$consbillnumber','$username','$refname','completed','$sampleid','$locationcode','$locationname')";
   $exec26=mysql_query($query26) or die(mysql_error());
  
   
   $query29=mysql_query("update consultation_lab set resultentry='$status',resultdoc='$billnumbercode' where labitemcode='$itemcode' and billnumber='$consbillnumber'");
   
 $query76 = "update samplecollection_lab set resultentry='$status' where itemcode='$itemcode' and sampleid='$sampleid'";
 $exec76 = mysql_query($query76) or die(mysql_error());
 

 // header("location:externallabresultentry.php?billnumber=$billnumber");
  //exit();
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
	
	mysql_query("insert into pharmacysales_details(itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientname,financialyear,username,ipaddress,entrydate,docnumber,entrytime,location,store,categoryname)values('$pharmacyitemname','$pharmacyitemcode','$pharmacyquantity','$pharmacyrate','$pharmacyamount','$batchname','$companyanum','$patientname','$financialyear','$username','$ipaddress','$dateonly1','$billnumber','$timeonly','$location','$store','$categoryname')");

	}
	}
	}
	
	
}
header("location:samplecollection.php");
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
function funcPrint()
{
var BillNumber = document.getElementById('billnumber').value;
window.open("print_externallabresultentry.php?billnumber=" + BillNumber);
}
</script>
<script>
function funcOnLoadBodyFunctionCall()
{
funcLabHideView();
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

<script src="js/datetimepicker_css.js"></script>
<?php
$billnumber = $_REQUEST["billnumber"];
$sampleid = $_REQUEST["sampleid"];
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
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="externallabresultentry.php" onKeyDown="return disableEnterKey(event)">
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
	  <td width="30%" align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                          <td bgcolor="#E0E0E0" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="42%" bgcolor="#E0E0E0" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
              </tr>
			
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $age; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $gender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $gender; ?>
                <input type="hidden" name="sampleid" value="<?php echo $sampleid?>">
				     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="billnumber" id="billnumber" type="hidden" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $billnumber; ?>
				</td>
			
              	  </tr>
				  <tr>
				  <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
			<td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Units</strong></div></td>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Reference Value</strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Acknowledge</strong></div></td>
		  </tr>
				  <?php
	  $query31="select * from samplecollection_lab where sampleid = '$sampleid'  group by itemcode";
	  $exec31=mysql_query($query31);
	  $num=mysql_num_rows($exec31);
	  while($res31=mysql_fetch_array($exec31))
	  { 
	   $labname1=$res31['itemname'];
	   $labitemcode = $res31['itemcode'];
	  

	
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
			  	  
              <td class="bodytext31" valign="center"  align="center">
			  <div align="center">
			  <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcShowDetailHide('<?php echo $sno; ?>')" onClick="return funcShowDetailView('<?php echo $sno; ?>')">			  </div>			  </td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"></div></td>
			       	  <td class="bodytext31" valign="center"  align="center">
			  <div class="bodytext31"></div></td>
			  <td class="bodytext31" valign="center"  align="center"><div align="center"><input type="checkbox" id="ack" name="ack[]" onClick="return validcheck()" value="<?php echo $labitemcode; ?>"></div></td>
		
         </tr>
		 	<tr id="idTRSub<?php echo $sno; ?>">
			<td colspan="7"  align="left" valign="center" class="bodytext31">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1108"
            align="left" border="0">
              <tbody>
               
			   <?php 
			   $subTRsno = 0;
			   $sn = 0;
			  $query52="select * from master_labreference where itemname='$labname1' and itemcode='$labitemcode' and status <> 'deleted'";
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
				  
				  //echo $labreferencerange1[0]; 
				  $labreferencevalue1=$res52['referencevalue'];
				  
				  $query43 = "select * from resultentry_lab where sampleid='$sampleid' and itemcode = '$itemcode2' and referencename = '$labreferencename' order by auto_number desc";
				  $exec43 = mysql_query($query43) or die(mysql_error());
				  $res43 = mysql_fetch_array($exec43);
				  $result = $res43['resultvalue'];
				  
				  
				  $query64 = "select * from master_labreference where itemcode='$itemcode2' and referencename = '$labreferencename' and status <> 'deleted' group by referencename";
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
				    <input type="hidden" name="lab[]" value="<?php echo $labname2;?>">
				   <input type="hidden" name="referencename[]" value="<?php echo $labreferencename; ?>">
				  <input type="hidden" name="code[]" value="<?php echo $itemcode2; ?>">
				  
				  <?php
				  
				  $labreferencerange1 = $labreferencerange;
				  $labreferencerange1 = explode('-',$labreferencerange1);
				  if(!ctype_digit($labreferencerange1[0]))
				{
				$labreferencerange1length = strlen($labreferencerange1[0]);
				$labreferencerange1symbol = substr($labreferencerange1[0],0,1);
				$labreferencerange1withoutsymbol = substr($labreferencerange1[0],1,$labreferencerange1length);
				if($labreferencerange1symbol == '<')
				{
				$labreferencerange1[0] = 0;
				$labreferencerange1[1] = $labreferencerange1withoutsymbol;
				}
				if($labreferencerange1symbol == '>')
				{
				$labreferencerange1[0] = $labreferencerange1withoutsymbol;
				$labreferencerange1[1] = 1000000;
				}
				}
				  
				 $query49 = "select * from resultentry_lab where patientcode='$patientcode' and itemcode='$itemcode2' and referencename='$labreferencename' order by auto_number desc limit 0,1";
				 $exec49 = mysql_query($query49) or die(mysql_error());
				 $res49 = mysql_fetch_array($exec49);
				 $pastresult = $res49['resultvalue'];
				  ?>
                  <td width="434" align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">
				   <input type="hidden" name="serialnumber" id="serialnumber<?php echo $sn; ?>" value="<?php echo $sn = $sn+1; ?>">
				  <input type="text" name="result[]" id="result<?php echo $sn; ?>" onBlur="return funcrange('<?php echo $sn; ?>')" value="<?php echo $result; ?>"/><!--<label onClick="javascript:coasearch('<?php echo $sn; ?>','<?php echo $itemcode2; ?>','<?php echo $labreferencename; ?>')">Click</label>-->
				 <input type="hidden" name="range111[]" id="range111<?php echo $sn; ?>" value="<?php echo $labreferencerange1[0] ; ?>">
				  <input type="hidden" name="range112[]" id="range112<?php echo $sn; ?>" value="<?php echo $labreferencerange1[1] ; ?>">
				  <input type="hidden" name="color[]" id="color<?php echo $sn; ?>" value="">
				   </div></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="75"><div align="left"> <?php if($labreferenceunit == '')
				  {
				  echo $labunit1;
				  }
				  else
				  {
				  echo $labreferenceunit;
				  } ?><input type="hidden" name="units[]" size="8" value="<?php echo $labreferenceunit; ?>"/> </div></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="75" style="color:red;"><?php echo $pastresult; ?></td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="358"><div align="left" id="rangeref" onClick="return funcrefrange();"> <?php if($labreferencerange == '')
			   {
			   echo $labreferencevalue1;
			   }
			   else
			   {
			   echo $labreferencerange;
			   } ?></div><input type="hidden" name="reference[]" size="8" value="<?php echo $labreferencerange; ?>"/></td>
              </tr>
			  <?php 
		 }
		 }
		 ?>
			  </tbody>
            </table>			</td>
			
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
               <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"><?php echo strtoupper($_SESSION['username']); ?></td>
               </tr>
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                     <input name="Submit22232" type="submit" value="Print " onClick="return funcPrint()"  accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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