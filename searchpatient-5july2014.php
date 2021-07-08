<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}



</script>
<script type="text/javascript">


function disableEnterKey(varPassed)
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


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
		
		
              <form name="cbform1" method="post" action="searchpatient.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit Patient Details </strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			      <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">National ID</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="nationalid" type="text" id="nationalid" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
		
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	<form name="form1" id="form1" method="post" action="stockadjustment.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	$searchnationalid=$_POST['nationalid'];
	
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1147" 
            align="left" border="0">
          <tbody>
             
           <tr>
                <td width="24"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                <td width="44" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>
                <td width="43" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Edit</strong></div></td>
                <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
                <td width="58" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
                <td width="137" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type </strong></div></td>
                <td width="84"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Type </strong></td>
                <td width="147"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
                  <td width="209"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
                <td width="49" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
                <td width="55"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
                      <td width="91"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>
                  <!--OpeningBalance-->
                  NationaID</strong> </div></td>
				   <td width="55"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User</strong></div></td>

				   <td width="42"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Create</strong></div></td>
             
                 </tr>
			  <?php 
            $query2 = "select * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $num2 = mysql_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysql_fetch_array($exec2))
			  {
			  $res2customercode = $res2['customercode'];
			  $res2customeranum = $res2['auto_number'];
			  $res2customername = $res2['customerfullname'];
			  $res2customercode = $res2['customercode'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $paymenttypeanum = $res2['paymenttype'];
			  $user = $res2['username'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $subtypeanum = $res2['subtype'];
			  
			  $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysql_query($query4) or die ("Error in Query5".mysql_error());
			  $res4 = mysql_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];
			  $res2billtype = $res2['billtype'];
			  $accountnameanum = $res2['accountname'];
	          $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
			  $res2accountexpirydate = $res2['accountexpirydate'];
			  $plannameanum = $res2['planname'];
			  $query6 = "select * from master_planname where auto_number = '$plannameanum'";
			  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			  $res6 = mysql_fetch_array($exec6);
			  $res6planname = $res6['planname'];
			  
			  $res2planexpirydate = $res2['planexpirydate'];
			  $res2visitlimit = $res2['visitlimit'];
			  $res2overalllimit = $res2['overalllimit'];
			  $res2customername	= $res2['customerfullname'];
			  $res2age = $res2['age'];
			  $res2gender = $res2['gender'];
			  $res2mothername = $res2['mothername'];
			  $res2bloodgroup = $res2['bloodgroup'];
			  $res2area = $res2['area'];
			  $res2nationalidnumber = $res2['nationalidnumber'];
			  $res2pincode = $res2['pincode'];
			  $res2mobilenumber = $res2['mobilenumber'];
			  $res2phonenumber1 = $res2['phonenumber1'];
			  $res2phonenumber2 = $res2['phonenumber2'];
			  $res2emailid1 = $res2['emailid1'];
			  $res2kinname = $res2['kinname'];
			  $res2kincontact = $res2['kincontactnumber'];
			  $res2emailid2 = $res2['emailid2'];
			  $res2faxnumber1 = $res2['faxnumber'];
			  $res2faxnumber2 = '';
			  $res2anum = $res2['auto_number'];
			  $res2address1 = $res2['address1'];
			  $res2city = $res2['city'];
			  $res2openingbalance1 = $res2['openingbalance'];
			  $res2insuranceid = $res2['insuranceid'];
			  $res2registrationdate = $res2['registrationdate'];
			  if ($res2registrationdate == '0000-00-00') $res2registrationdate = '';
			  $res2registrationtime = $res2['registrationtime'];
			  $res2consultingdoctor = $res2['consultingdoctor'];
			  $query201 = "select * from master_doctor where doctorcode = '$res2consultingdoctor'";
			  $exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
			  $res201 = mysql_fetch_array($exec201);
			  $res2consultingdoctor = $res201['doctorname'];
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  $res3ipnumber = '';
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                <td  align="left" valign="center" class="bodytext31">
				<div align="center"><strong><a target="_blank" href="print_registration_label.php?patientcode=<?php echo $res2customercode; ?>">Print</a></strong></div>
				</td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="center">
				<!--<a href="editpatient1.php?customercode=<?php echo $res2customercode; ?>" class="bodytext3">-->
				<a href="editpatient.php?patientcode=<?php echo $res2customercode; ?>" class="bodytext3">
				<span class="bodytext3">Edit</span>				</a>				</div>				</td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $res2customercode; ?></span></div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left">
				  <span class="bodytext3">
				  <?php echo $res4subtype; //.' ('.$res2customercode.')'; ?>				  </span>				  </div>
                </div>				</td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2billtype; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res5accountname; ?></div></td>
                     <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2customername; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2age; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2gender; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left"><?php echo $res2nationalidnumber; ?></td>
					<td class="bodytext31" valign="center"  align="left"><?php echo $user; ?></td>
					 <td class="bodytext31" valign="center"  align="left"><a href="visitentry_op1.php?patientcode=<?php echo $res2customercode; ?>">OP Visit</a></td>
                  </tr>
			  <?php
			  }
			  //}
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
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
           	</tr>
			
          </tbody>
        </table>
<?php
}


?>	
		

		
		
		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

