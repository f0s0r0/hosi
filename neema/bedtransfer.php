<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
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

if ($frmflag1 == 'frmflag1')
{
       
		$paynowbillprefix7 = 'BT-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_bedtransfer order by auto_number desc limit 0, 1";
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
		///$locationname = $_REQUEST['location'];
		$visitcode = $_REQUEST['visitcode'];
        $searchedlocationcode = $_REQUEST['locationcode']; 
		//$patientlocationcode = $_REQUEST['locationcode'];
		$query51 = "select * from ip_bedallocation where visitcode='$visitcode' and locationcode = '$searchedlocationcode' and recordstatus='transfered'";
		$exec51 = mysql_query($query51) or die(mysql_error());
		$num51 = mysql_num_rows($exec51);
		if($num51 > 0)
		{
		$query67 = "select * from ip_bedtransfer where visitcode='$visitcode' and locationcode = '$searchedlocationcode' order by auto_number desc limit 0, 1";
		$exec67 = mysql_query($query67) or die(mysql_error());
		while($res67 = mysql_fetch_array($exec67))
		{
		$ward = $res67['ward'];
		$bed = $res67['bed'];
		}
		$query79 = "update master_bed set recordstatus='' where auto_number='$bed' and ward='$ward' and locationcode = '$searchedlocationcode'";
		$exec79 = mysql_query($query79) or die(mysql_error());
		
		$query791 = "update ip_bedallocation set recordstatus='transfered' where bed='$bed' and ward='$ward' and visitcode='$visitcode' and locationcode = '$searchedlocationcode' and recordstatus=''";
		$exec791 = mysql_query($query791) or die(mysql_error());
		
		$query792 = "update ip_bedtransfer set recordstatus='transfered',leavingdate='$updatedate' where bed='$bed' and ward='$ward' and visitcode='$visitcode' and locationcode = '$searchedlocationcode' and recordstatus='' and leavingdate='0000-00-00'";
		$exec792 = mysql_query($query792) or die(mysql_error());
		}
		else
		{
		
		$query59 = "select * from ip_bedallocation where visitcode='$visitcode' and recordstatus='' and locationcode = '$searchedlocationcode' ";
		$exec59 = mysql_query($query59) or die(mysql_error());
		$res59 = mysql_fetch_array($exec59);
		$ward = $res59['ward'];
		$bed = $res59['bed'];
		
		$query79 = "update master_bed set recordstatus='' where auto_number='$bed' and ward='$ward' and locationcode = '$searchedlocationcode' ";
		$exec79 = mysql_query($query79) or die(mysql_error());
		
	    $query791 = "update ip_bedallocation set recordstatus='transfered',leavingdate='$updatedate' where bed='$bed' and ward='$ward' and visitcode='$visitcode' and recordstatus='' and leavingdate='0000-00-00'"; 
		$exec791 = mysql_query($query791) or die(mysql_error());
	
		}
		$accname = $_REQUEST['accname'];
		$ward = $_REQUEST['ward'];
		$bed = $_REQUEST['bed']; 
		$standbybed = '';
		$query33 = "select * from ip_bedtransfer where docno='$docno' and locationcode = '$searchedlocationcode'";
		$exec33 = mysql_query($query33) or die(mysql_error());
		$num33 = mysql_num_rows($exec33);
		if($num33 == 0)
		{
        $query67 = "insert into ip_bedtransfer(docno,patientname,patientcode,visitcode,accountname,ward,bed,standbybedstatus,recordtime,recorddate,ipaddress,username,locationcode)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward','$bed','$standbybed','$updatetime','$updatedate','$ipaddress','$username','$searchedlocationcode')";
		$exec67 = mysql_query($query67) or die(mysql_error()); 
			
		$query53 = "update master_bed set recordstatus='occupied' where ward='$ward' and auto_number='$bed' and locationcode = '$searchedlocationcode' ";
		$exec53 = mysql_query($query53) or die(mysql_error());
		}
		header("location:bedtransferlist.php");
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
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'BT-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_bedtransfer order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
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
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['locationcode'])) { $searchedlocationcode = $_REQUEST['locationcode']; } else { $searchedlocationcode ="";}

      $query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode = '$searchedlocationcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		$res1 = mysql_fetch_array($exec1);
		
		//$patientlocationcode=$res1['locationcode'];
		$patientlocationname=$res1['locationname'];

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
if(document.getElementById("ward").value == '')
{
alert("Please Select Ward");
document.getElementById("ward").focus();
return false;
}
if(document.getElementById("bed").value == '')
{
alert("Please Select Bed");
document.getElementById("bed").focus();
return false;
}
}



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus='' and locationcode ='$searchedlocationcode'";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Bed", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = '' and locationcode ='$searchedlocationcode'";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}

function funcstandby()
{
//alert('h');
if(document.getElementById("standbybed").checked == true)
{
<?php 
	$query123= "select * from master_bedcharge where bed='Stand By Bed'";
	$exec123 = mysql_query($query123) or die ("Error in Query123".mysql_error());
	$res123 = mysql_fetch_array($exec123);
	$rate = $res123['rate'];
	?>
	document.getElementById("standbybedrate").value = "<?php echo $rate; ?>";
}
else
{
document.getElementById("standbybedrate").value = "0.00";
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
<form name="form1" id="form1" method="post" action="bedtransfer.php" onSubmit="return validcheck()">	
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
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td width="13%" align="center" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td width="19%" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="10%"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
               </td>
			   <td width="10%" align="center" valign="center"  class="bodytext31"><strong>Location</strong></td>
			  <td width="12%" align="left" valign="center"  ><span class="bodytext31"><strong><?php echo $patientlocationname;?></strong>
			  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $searchedlocationcode;?>" >

			  

              </span></td>
			   
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
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode = '$searchedlocationcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$patientlocation = $res1['locationcode'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and locationcode = '$searchedlocationcode'";
		   $exec63 = mysql_query($query63) or die(mysql_error());
		   $res63 = mysql_fetch_array($exec63);
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   
		   $query71 = "select * from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and locationcode = '$searchedlocationcode' order by auto_number desc";
		   $exec71 = mysql_query($query71) or die(mysql_error());
		   $res71 = mysql_fetch_array($exec71);
		   $num71 = mysql_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
		   }
		
		  $query7811 = "select * from master_ward where auto_number='$ward' and recordstatus='' and locationcode ='$searchedlocationcode'";
		  $exec7811 = mysql_query($query7811) or die(mysql_error());
		  $res7811 = mysql_fetch_array($exec7811);
		  $wardname1 = $res7811['ward'];
		  
		  $query50 = "select * from master_bed where auto_number='$bed' and locationcode ='$searchedlocationcode'";
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
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="locationname" id="locationname" value="<?php $locationame; ?>">
				<input type="hidden" namee="locationcode" id="locationcode" value="<?php $locationcode; ?>">
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
      <td width="11%" align="center" valign="center" class="bodytext311">Ward</td>
	  <td width="16%" align="left" valign="center" class="bodytext311">
	 <select name="ward" id="ward" onChange="return funcwardChange1()">
                          <option value=""> Select Ward</option>
						  <?php 
				echo "519",		  $query78 = "select * from master_ward where locationcode ='$searchedlocationcode' and recordstatus=''"; 
						  $exec78 = mysql_query($query78) or die(mysql_error());
						  while($res78 = mysql_fetch_array($exec78))
						  {
						  $wardanum = $res78['auto_number'];
						  $wardname = $res78['ward'];
						  
						    ?>
						  
                          <option value="<?php echo $wardanum; ?>"><?php echo $wardname; ?></option>
						  <?php
						  }
                          ?>
                        </select></td>
      <td width="11%" align="center" valign="center" class="bodytext311">Bed</td>
      <td width="11%" align="left" valign="center" class="bodytext311">
	   <select name="bed" id="bed">
	    <option value="" selected="selected">Select Bed</option>
	   	<?php 
						  $query78 = "select * from master_bed where locationcode='$searchedlocationcode' and recordstatus=''";
						  $exec78 = mysql_query($query78) or die(mysql_error());
						  while($res78 = mysql_fetch_array($exec78))
						  {
						  $bedanum = $res78['auto_number'];
						  $bedname = $res78["bed"];
						  ?>
						  <!--<option value="<?php echo $bedanum; ?>"><?php echo $bedname; ?></option>-->
                           
							<?php
						  } ?>
                          </select>
	    </td>
      <td width="49%" align="left" valign="center" class="bodytext311">&nbsp;</td>
      </tr>
	  
      <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td align="center" valign="center" class="bodytext311"></td>
		<td align="left" valign="center" class="bodytext311"><input type="text" name="standbybedrate" id="standbybedrate" size="10" align="left">
		<input type="checkbox" name="standbybed" id="standbybed" value="1" onClick="return funcstandby();"></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" valign="center" class="bodytext311">         <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

