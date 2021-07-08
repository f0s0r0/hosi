<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if ($frmflag1 == 'frmflag1')
{
      

		if(isset($_REQUEST['approved'])){
			$mode = $_REQUEST['approved'];
			$paymentstatus = 'completed';
			
		}else if(isset($_REQUEST['ipdeposit'])){
			 $mode = $_REQUEST['ipdeposit']; 
			$paymentstatus = '';
		}
		
				if(isset($_REQUEST['external'])){
			$mode = $_REQUEST['external'];
			$paymentstatus = '';
				}
			
		$query33 = "select * from mortuary_request where docno='$docno'";
		$exec33 = mysql_query($query33) or die(mysql_error());
		$num33 = mysql_num_rows($exec33);
		if($num33 != 0)
		{
		$query88 = "UPDATE mortuary_request SET paymentstatus='$paymentstatus',mode='$mode' WHERE patientcode='".$patientcode."' AND visitcode='".$visitcode."' AND docno = '".$docno."'";
		$exec88 = mysql_query($query88) or die(mysql_query());
	
	
			}
		header("location:mortuaryrequestlist.php");
		exit;

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
<?php



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

<script>


function validcheck()
{
if(document.getElementById("bed").value == '')
{
alert("Please Select Bed");
document.getElementById("bed").focus();
return false;
}
if(document.getElementById("ward").value == '')
{
alert("Please Select Ward");
document.getElementById("ward").focus();
return false;
}

}




function funcvalidation()
{
//alert('h');


if(document.getElementById("requestforapproval").checked == false)
{
alert("Please Click on Request for Approval");
return false;
}

if(confirm("Are you sure of the Request?")==false){
return false;	
}

}
function funcRadio(id){
	
	if(document.getElementById("approved").id==id)
	{
	document.getElementById("ipdeposit").checked=false;
	}else if(document.getElementById("ipdeposit").id==id)
	{
	document.getElementById("approved").checked=false;
	}
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
<form name="form1" id="form1" method="post" action="" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td width="89" align="center" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td width="86" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $docno; ?>" size="10" readonly></td>
			   <td width="79"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="132"  align="left" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
               </td>
             </tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="96"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="248"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				 <td width="71"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
				<td width="89"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
				<td width="138"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>&nbsp;</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from mortuary_request where patientcode='$patientcode' and visitcode='$visitcode' and docno ='$docno'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$billtype =  $res1['billtype'];
		
		$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec32 = mysql_query($query32) or die(mysql_error());
		$num32 = mysql_num_rows($exec32);
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec63 = mysql_query($query63) or die(mysql_error());
		   $res63 = mysql_fetch_array($exec63);
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   
		   $query71 = "select * from ip_creditapproval where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
		   $exec71 = mysql_query($query71) or die(mysql_error());
		   $res71 = mysql_fetch_array($exec71);
		   $num71 = mysql_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
		   }
		
		$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
						  $exec7811 = mysql_query($query7811) or die(mysql_error());
						  $res7811 = mysql_fetch_array($exec7811);
						  $wardname1 = $res7811['ward'];
						  
						  $query50 = "select * from master_bed where auto_number='$bed'";
		                  $exec50 = mysql_query($query50) or die(mysql_error());
						  $res50 = mysql_fetch_array($exec50);
						  $bedname = $res50['bed'];
	

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
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
                
				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">
	  		      <td class="bodytext31" valign="center"  width="138" align="left">
                  <?php
				  if($patientcode !='walkin')
				  {
				  ?>
			  <div class="bodytext31" align="center"><a href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong> Interim</strong> </a></div>
              <?php
				  }
			  ?>
              </td>

			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td width="4%">&nbsp;</td>
      </tr>
<!--       <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="3%">&nbsp;</td>
		<td width="26%" align="right" valign="center" class="bodytext311">Request for Approval</td>
		<td width="29%" align="left" valign="center" class="bodytext311">
        <input type="checkbox" name="requestforapproval" id="requestforapproval" value="1">
        
        </td>
      </tr>
-->	  <tr>
<td>&nbsp;</td>
<td width="4%">&nbsp;</td>
<?php
if($patientcode!='walkin')
{
?>
  	<td width="11%" align="right">Approved<input onClick="funcRadio(this.id)" type="checkbox" name="approved" id="approved"  value="approved" ></td>
	  <td width="26%"  align="center" ><?php if($billtype=='PAY NOW'){?>IP Deposit<input  onClick="funcRadio(this.id)" type="checkbox" name="ipdeposit" id="ipdeposit" value="ipdeposit"  ><?php }?> </td>
	   <td width="55%">   <input type="hidden" name="frmflag1" value="frmflag1" />
      <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>
      <?php }
	  else
	  {
	  ?>
  	<td width="11%" align="right">Cash<input onClick="funcRadio(this.id)" type="checkbox" name="external" id="external"  value="external" ></td>
    <td>&nbsp;</td>
    <td>  <input type="hidden" name="frmflag1" value="frmflag1" />    <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>

<?php
	  }?>
</tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

