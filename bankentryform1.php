<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly = date("Y-m-d");
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$accno = "";
$acctype = "";
if (isset($_REQUEST["docno1"])) { $docno1 = $_REQUEST["docno1"]; } else { $docno1 = ""; }
//echo $docno1;
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$frombankname1 = $_REQUEST['frombankname'];
	$frombanknamesplit = explode('||',$frombankname1);
	$frombankid = $frombanknamesplit[0];
	$frombankname = $frombanknamesplit[1];
	$tobankname1 = $_REQUEST['tobankname'];
	$tobanknamesplit = explode('||',$tobankname1);
	$tobankid = $tobanknamesplit[0];
	$tobankname = $tobanknamesplit[1];
	$docnumber = $_REQUEST['docnumber'];
	$branch = $_REQUEST["branchname"];
	$accno = $_REQUEST["accno"];
	 $acctype = $_REQUEST["acctype"];
	 $transactiontype = $_REQUEST["transactiontype"];
	 $ADate = $_REQUEST["ADate"];
	 $transactionmode = $_REQUEST["transactionmode"];
	 $personname = $_REQUEST["personname"];
	 if($transactionmode =='CHEQUE')
	 {
	 	$chequedate = $_REQUEST["ADate1"];
		$chequenumber = $_REQUEST["chequenumber"];
		$chequebankname = '';
		$chequebankbranch = $_REQUEST["branchname"];
	 }
	    $remarks = $_REQUEST["remarks"];
	    $amount = $_REQUEST["amount"];
		
		$location = $_REQUEST['location'];
		$locsplit = explode('|',$location);
		$locationcode = $locsplit[0];
		$locationname = $locsplit[1];
		
	if($transactionmode =='CASH')
	{
		$query1 = "insert into bankentryform (frombankid, frombankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,creditamount,personname,remarks, ipaddress, updatetime, docnumber,locationcode,locationname) 
		values ('$frombankid','$frombankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
		$query11 = "insert into bankentryform (tobankid, bankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,amount,personname,remarks, ipaddress, updatetime, docnumber,locationcode,locationname) 
		values ('$tobankid','$tobankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		
		$errmsg = "Success. Bank Details Updated.";
		$bgcolorcode = 'success';
	}
	else
	{
	 	$query12 = "insert into bankentryform (frombankid, frombankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,chequedate,chequenumber,chequebankname,chequebankbranch,creditamount,personname,remarks, ipaddress, updatetime, docnumber, locationcode, locationname) 
		values ('$frombankid','$frombankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$chequedate','$chequenumber','$chequebankname','$chequebankbranch','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		
		$query13 = "insert into bankentryform (tobankid,bankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,chequedate,chequenumber,chequebankname,chequebankbranch,amount,personname,remarks, ipaddress, updatetime, docnumber, locationcode, locationname) 
		values ('$tobankid','$tobankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$chequedate','$chequenumber','$chequebankname','$chequebankbranch','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		
		$errmsg = "Success. Bank Details Updated.";
		$bgcolorcode = 'success';
	}
	
	header("location:bankentryform1.php?docno1=$docnumber");
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_color set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_color set status = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_color set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_color set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_color set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}



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
<!--<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
--><style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style></head>
<script>
var docno="<?php echo $docno1;?>";
if(docno!="")
{
window.open("printbank.php?billnumber="+docno+"",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 	
}


</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggestbank1.js"></script>
<script type="text/javascript" src="js/autobanksearch.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>     
<script type="text/javascript">     
$(document).ready(function() { 

 $(".hideshow").hide();
 $("#transactionmode").change(function(){
           var $hideshow = $(".hideshow");
          // var $feeschedule2 = $(".feeschedule2");
           var transactionmode = $(this).find('option:checked').val();
            if (transactionmode == 'CHEQUE')
			{
                $hideshow.show();
            }
			else
			{
                $hideshow.hide();
            }
			});  
			});     
</script>     
<script language="javascript">
function Functionchequedetails()
{
	//alert("hi");	
if(document.getElementById("transactiontype").value =="WITHDRAWAL")
	{
	var Bankname = document.getElementById("bankname").value;
	//alert(Bankname);
	
	ajaxprocessACCS7();		
	}
}
var xmlHttp

function ajaxprocessACCS7()
{
	//alert("Meow..");
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return false;
	} 
	var Bankname = document.getElementById("bankname").value;
	//alert(Bankname);
	//var Transactiontype = document.getElementById("transactiontype").value;
	//alert(Transactiontype);
	var url5 = '';
	var url5 = "bankbalancecheck1.php?RandomKey="+Math.random()+"&&Bankname="+Bankname;//+"&&Transactiontype="+Transactiontype
    //alert(url5);
    xmlHttp.onreadystatechange=stateChangedACCS7
	xmlHttp.open("GET",url5,true)
	xmlHttp.send(null)
}
function stateChangedACCS7() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
	
			var t = "";
			t=t+xmlHttp.responseText;
			//alert(t);
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	if (varNewLineLength == 0)
	{
		//return false;

	}
	for (m=1;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		var VarBankBalance = varNewRecordValue[0];
		//alert(VarBankBalance);
		 var Checkbankbalance = document.getElementById("amount").value;
		// alert(Checkbankbalance);
		 if(parseInt(Checkbankbalance) > parseInt(VarBankBalance))
		 {
		 	alert(" You Have Low Balance You Cannot Proceed");
			document.getElementById("amount").focus();
			return false;
		}
		
	//}
	}
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
	
	
	
	
	
 } 
function additemusedprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.frombankname.value == "")
	{
		alert ("Please Select Bank Name.");
		document.form1.frombankname.focus();
		return false;
	}
	if (document.form1.tobankname.value == "")
	{
		alert ("Please Select Bank Name.");
		document.form1.tobankname.focus();
		return false;
	}
	if (document.form1.frombankname.value == document.form1.tobankname.value)
	{
		alert ("Dr and Cr Bank Should not be Same");
		document.form1.tobankname.focus();
		return false;
	}
	if (document.form1.transactiontype.value == "")
	{
		alert ("Please Select Transaction Type To Proceed.");
		document.form1.transactiontype.focus();
		return false;
	}
	if (document.form1.transactionmode.value == "")
	{
		alert ("Please Select Transaction Mode To Proceed.");
		document.form1.transactionmode.focus();
		return false;
	}
	if (document.form1.amount.value == "")
	{
		alert ("Please Enter Amount  To Proceed.");
		document.form1.amount.focus();
		return false;
	}
	if (isNaN(document.getElementById("amount").value))
	{
		alert ("Please Enter Amount Only In Numbers");
		document.form1.amount.focus();
		return false;
	}
	if (document.form1.personname.value == "")
	{
		alert ("Please Enter Person Name To Proceed.");
		document.form1.personname.focus();
		return false;
	}
	if (document.form1.location.value == "")
	{
		alert ("Please select Location.");
		document.form1.location.focus();
		return false;
	}

}

</script>
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
    <td colspan="10" bgcolor="#E0E0E0"><?php  include ("includes/menu1.php"); ?></td>
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
              <td><form name="form1" id="form1" method="post" action="bankentryform1.php" onSubmit="return additemusedprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Bank Entry Form </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cr Bank Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="frombankname" id="frombankname">
						<option value="">Select Account</option>
						<?php 

						$query1 ="select * from master_accountname where accountssub IN  ('18','19','20') and recordstatus <> 'deleted'";
						$exec1 = mysql_query($query1) or die("Error in Query1".mysql_error());
						while($res1 = mysql_fetch_array($exec1))
						{
						$accountname = $res1["accountname"];
						$id = $res1["id"];
						?>
						<option  value="<?php echo $id.'||'.$accountname;?>"><?php echo $accountname;?></option>
						<?php
						}
						?>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Dr Bank Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="tobankname" id="tobankname">
						<option value="">Select Account</option>
						<?php 

						$query1 ="select * from master_accountname where accountssub IN  ('18','19','20') and recordstatus <> 'deleted'";
						$exec1 = mysql_query($query1) or die("Error in Query1".mysql_error());
						while($res1 = mysql_fetch_array($exec1))
						{
						$accountname = $res1["accountname"];
						$id = $res1["id"];
						?>
						<option  value="<?php echo $id.'||'.$accountname;?>"><?php echo $accountname;?></option>
						<?php
						}
						?>
						</select></td>
                      </tr>
					  <tr>
		 			 <?php		
						$paynowbillprefix = 'BE-';
						$paynowbillprefix1=strlen($paynowbillprefix);
						$query2 = "select * from bankentryform order by auto_number desc limit 0, 1";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						$res2 = mysql_fetch_array($exec2);
						$billnumber = $res2["docnumber"];
						$billdigit=strlen($billnumber);
						if ($billnumber == '')
						{
							$billnumbercode ='BE-'.'1';
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
							
							
							$billnumbercode = 'BE-' .$maxanum;
							$openingbalance = '0.00';
							//echo $companycode;
						}?>
						 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Doc No</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                        <input type="text" name="docnumber" id="docnumber" value="<?php echo  $billnumbercode;?>" readonly>
                        </label></td>
					  </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Branch</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                        <input type="text" name="branchname" id="branchname">
                        </label></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Number </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="accno" id="accno"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">AccountType </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                          <input type="text" name="acctype" id="acctype">
                        </label></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Transaction Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><select width="150" name="transactiontype" id="transactiontype">
						<option value="">SELECT TYPE</option>
						<option>DEPOSIT</option>
						<option>WITHDRAWAL</option>
						<option>TRANSFER</option>
						<option>BANK CHARGES</option>
						<option>INTEREST</option>
						<option>OPENING BALANCE</option>
						</select>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Transaction Date </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                         <input name="ADate" id="ADate" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" /><img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate')" style="cursor:pointer"/>
                        </label></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Transaction Mode </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="transactionmode" id = "transactionmode">
						<option value ="">Select Mode</option>
						<option value='CASH'>CASH</option>
						<option value ='CHEQUE'>CHEQUE</option>
						</select>                      </tr>
						
                      <tr class="hideshow">
                        <td align="left" valign="top"   bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Cheque Date </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" ><span class="bodytext312">
                          <input name="ADate1" id="ADate1" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
                        </span>						</td></tr>
                      <tr class="hideshow">
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Cheque Number</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" ><input type="text" name="chequenumber" id="chequenumber"></td>
                      </tr>
                     <!-- <tr class="hideshow">
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Cheque Bank Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" ><!--<input type="text" name="chequebank" id="chequebank">
						<select name="chequebank" id="chequebank">
					<option value="">Select Bank</option>
					<?php 
					$querybankname = "select * from master_bank where bankstatus <> 'deleted'";
					$execbankname = mysql_query($querybankname) or die ("Error in Query3".mysql_error());
					while($resbankname = mysql_fetch_array($execbankname))
					{?>
					
						<option value="<?php echo $resbankname['bankname'];?>"><?php echo $resbankname['bankname']; ?></option>
					<?php
					}
					?>
					</select></td>
                      </tr>
                      <tr class="hideshow">
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Bank Branch </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" ><input type="text" name="chequebankbranch" id="chequebankbranch"></td>
                      </tr>-->
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="amount" id="amount" onBlur="return Functionchequedetails()"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Done By </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="personname" id="personname"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Remarks</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><textarea name="remarks" id="remarks"></textarea></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Location</option>
						<?php
						$query1 = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationcode.'|'.$res1location; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
				        </select>
						</td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit"  value="Submit" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                </td>
            </tr>
            <tr>
              <td>
			  <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			  <tr bgcolor="#011E6A">
				<td colspan="8" bgcolor="#CCCCCC" class="bodytext3"><strong>Bank Entry List </strong></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
			  <td align="left" class="bodytext3"><strong>S.No</strong></td>
			  <td align="left" class="bodytext3"><strong>Dr Bank</strong></td>
			  <td align="left" class="bodytext3"><strong>Cr Bank</strong></td>
			  <td align="left" class="bodytext3"><strong>Amount</strong></td>
			  <td align="left" class="bodytext3"><strong>Entry Date</strong></td>
			  <td align="left" class="bodytext3"><strong>Entry By</strong></td>
			  <td align="left" class="bodytext3"><strong>Edit</strong></td>
               <td align="left" class="bodytext3"><strong>Print</strong></td>
			  </tr>
			  <?php
			  $colorloopcount = 0;
			  $query31 = "select * from bankentryform group by docnumber order by auto_number desc";
				$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
				while($res31 = mysql_fetch_array($exec31))
				{
				$docnumber = $res31['docnumber'];
				$entrydate = $res31['transactiondate'];
				
				$query32 = "select * from bankentryform where docnumber = '$docnumber' order by auto_number desc";
				$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
				$res32 = mysql_fetch_array($exec32);
				
				$bankname = $res32['bankname'];
				$amount = $res32['amount'];
				$personname = $res32['personname'];
				
				
				$query33 = "select * from bankentryform where docnumber = '$docnumber' order by auto_number";
				$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
				$res33 = mysql_fetch_array($exec33);
				
				$frombankname = $res33['frombankname'];
				$creditamount = $res33['creditamount'];
				$personname = $res33['personname'];
				
				
				if($amount == '0.00')
				{
				$amount = $creditamount;
				}
				else
				{
				$amount = $amount;
				}
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
			  <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
			  <td align="left" class="bodytext3"><?php echo $bankname; ?></td>
			  <td align="left" class="bodytext3"><?php echo $frombankname; ?></td>
			  <td align="left" class="bodytext3"><?php echo $amount; ?></td>
			  <td align="left" class="bodytext3"><?php echo $entrydate; ?></td>
			  <td align="left" class="bodytext3"><?php echo $personname; ?></td>
			  <td align="left" class="bodytext3"><a href="bankentryformedit1.php?st=edit&&docno=<?php echo $docnumber; ?>"><?php echo 'Edit'; ?></a></td>
              <td align="left" class="bodytext3"><a target="_blank" href="printbank.php?billnumber=<?php echo $docnumber; ?>"><?php echo 'Print'; ?></a></td>
			   </tr>
			   <?php
			   }
			   ?>	
			  </tbody>
			  </table>
			  </td>
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

