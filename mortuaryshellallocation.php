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
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
	//******************************Discharging the patient*******************************
	
	
       
		$paynowbillprefix7 = 'DIS-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_discharge order by auto_number desc limit 0, 1";
$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
$res27 = mysql_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
		}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$ward1 = isset($_REQUEST['wardanum'])?$_REQUEST['wardanum']:'';
		$bed1 = isset($_REQUEST['bedanum'])?$_REQUEST['bedanum']:'';
		//$readytodischarge = $_REQUEST['readytodischarge'];
		//$frompage = $_REQUEST['frompage'];
			
		$query33 = "select * from ip_discharge where patientcode='$patientcode' and visitcode = '$visitcode'";
		$exec33 = mysql_query($query33) or die("Error in Query33".mysql_error());
		$num33 = mysql_num_rows($exec33);
		if($num33 == 0)
		{
		
		
		
		$query67 = "insert into ip_discharge(docno,patientname,patientcode,visitcode,accountname,ward,bed,dischargestatus,recordtime,recorddate,ipaddress,username)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward1','$bed1','$readytodischarge','$updatetime','$updatedate','$ipaddress','$username')";
		$exec67 = mysql_query($query67) or die(mysql_error());
		
		$query79 = "update master_bed set recordstatus='' where auto_number='$bed1' and ward='$ward1'";
		$exec79 = mysql_query($query79) or die(mysql_error());
		
		$query81 = "update master_ipvisitentry set discharge='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec81 = mysql_query($query81) or die(mysql_error());
		
		$query88 = "update ip_bedallocation set recordstatus='discharged' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec88 = mysql_query($query88) or die(mysql_query());
		
		$query881 = "update ip_bedtransfer set recordstatus='discharged' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec881 = mysql_query($query881) or die(mysql_query());
		
		$query8811 = "update newborn_motherdetails set discharge='discharged' where patientcode='$patientcode' and patientvisitcode='$visitcode'";
		$exec8811 = mysql_query($query8811) or die(mysql_query());
		
		
	
	
			}/*
		if($frompage == 'newborn')
		{
		header("location:newbornactivity.php");
		}
		else
		{
		header("location:ipdischargelist.php");
		}
		exit;*/


	//******************************Discharge Ends**********************************
	
		$paynowbillprefix7 = 'MRA-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from mortuary_allocation order by auto_number desc limit 0, 1";
$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
$res27 = mysql_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
		}
	
		$requestno = $_REQUEST['docccno'];
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$ward1 = $_REQUEST['wardanum'];
		$bed1 = $_REQUEST['bedanum'];
		$requestforapproval = $_REQUEST['requestforapproval'];
		$availableshell = $_REQUEST['availableshell'];
		$mortuaryshellpackage = $_REQUEST['mortuaryshellpackage'];
		
		
		
		
		
		$query67 = "insert into mortuary_allocation(docno,patientname,patientcode,visitcode,accountname,ward,bed,recordtime,recorddate,ipaddress,username,shelve,package,requestno)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward1','$bed1','$updatetime','$updatedate','$ipaddress','$username','$availableshell','$mortuaryshellpackage','$requestno')";
		$exec67 = mysql_query($query67) or die(mysql_error());
		
   $query39=mysql_query("update mortuary_request set allocationstatus='completed' where docno='$requestno'") or die(mysql_error());
   
   $query40=mysql_query("update master_shelf set allocationstatus='occupied' where shelf like '%$availableshell%'") or die(mysql_error());

		header("location:mortuarytransferlist.php");
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
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $billnumbercode = $_REQUEST["docno"]; } else { $billnumbercode = ""; }

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
<script src="js/jquery-1.11.1.min.js"></script>
<script>
$(function (){
$( "#mortuarypackage" ).click(function() {	
$( ".toggleclass" ).toggle();});

}
);

function showhide()
{
	if(document.getElementById('mortuarypackage').checked)
	{
		//alert('hai');
		document.getElementById('availableshell').disabled=true;		
	}
	else
	{
		document.getElementById('availableshell').disabled=false;		
	}
	
}
</script>

<script src="js/datetimepicker_css.js"></script>


<?php

$query27 = "select * from mortuary_allocation ";
$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
$res27 = mysql_fetch_array($exec27);
$billnumber7 = $res27["docno"];

?>

<body>
<form name="form1" id="form1" method="post" action="" onSubmit="return validcheck()">	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td width="13%" align="center" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td width="19%" align="center" valign="center" class="bodytext31"><input type="text" name="docccno" id="docccno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="10%"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="15%"  align="left" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="8" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
               </td>
             </tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from mortuary_request where patientcode='$patientcode' and visitcode='$visitcode' and docno ='$billnumbercode' and auto_number = '$anum'";
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
				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">		
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 
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
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td width="18%">&nbsp;</td>
		<td width="8%" align="left" valign="center" class="bodytext311"><input type="checkbox" name="mortuarypackage" id="mortuarypackage" value="1" >MortuaryPackage</td>
		<td width="23%" align="left" valign="center" class="bodytext311">
        <select class="toggleclass" style="display:none;" width="10" name="mortuaryshellpackage" id="mortuaryshell">
          <option value="">Select</option>
          <?php
		$query10 = "select packagename,total from master_mortuarypackage where status =''";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		
		while($res10 = mysql_fetch_array($exec10))
		{
		$packagename=$res10['packagename'];
		$total=$res10['total'];
		  
		  ?>
          <option value="<?php echo $packagename?>"><?php echo $packagename?>(<?php echo intval($total); ?>)</option>
          <?php
		}
		?>
        </select>
        </td>
		  <td width="9%" >&nbsp;</td>
		
		  <td width="40%"  align="left" valign="left" >
          
          </td>

      </tr>
      
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td width="8%" align="left" valign="center" class="bodytext311">&nbsp;&nbsp;&nbsp;Available Shelves</td>
		  <td width="23%" align="left" valign="center">
          <select name="availableshell" id="availableshell" width="10">
          <option value="">Select</option>
          <?php
	    $query120 = "select * from master_shelf where recordstatus ='' and allocationstatus='' order by shelf ";
		$exec120 = mysql_query($query120) or die ("Error in Query120".mysql_error());
		while ($res120 = mysql_fetch_array($exec120))
		{
		$shelf = $res120["shelf"];
		$shelfcharges = $res120['shelfcharges'];
		  
		  ?>
          <option value="<?php echo $shelf?>"><?php echo $shelf; ?>(<?php echo intval($shelfcharges); ?>)</option>
          <?php
		}
		?>
        </select>
          
          </td>
          		  <td>&nbsp;</td>
		<td>&nbsp;</td>


      </tr>
	  <tr>
	  <td colspan="20" align="center" valign="middle" width="150"><a href="mortuaryapproved.php?docno=<?php echo $billnumbercode; ?>&&patientcode=<?php echo $patientcode;?>&&visitcode=<?php echo $visitcode;?>"><strong><u>view</u></strong></a>
	  </td>
	  </tr>
	  <tr>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td width="23%" align="center" valign="center" class="bodytext311"><input type="hidden" name="frmflag1" value="frmflag1" />
        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>
        		<td>&nbsp;</td>
		<td>&nbsp;</td>

                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

