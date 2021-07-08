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

if ($frmflag1 == 'frmflag1')
{
		$requestno = $_REQUEST['docccno'];
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$shelvename = $_REQUEST['shelvename'];
		
		$packagename = $_REQUEST['packagename'];
		
		$requestforapproval = $_REQUEST['requestforapproval'];
		
		$availableshell = $_REQUEST['availableshell'];
		
		if(isset($_REQUEST['mortuarypackage'])){
		$mortuaryshellpackage = $_REQUEST['mortuaryshellpackage'];
		}
		else
		{
				$mortuaryshellpackage='';
		}
		
		
		
		
		
   $query39=mysql_query("update mortuary_allocation set package='$mortuaryshellpackage',shelve='$availableshell' where docno='$requestno'") or die(mysql_error());
		
   $query40=mysql_query("update master_shelf set allocationstatus='' where shelf like '%$shelvename%'") or die(mysql_error());
   
   $query41=mysql_query("update master_shelf set allocationstatus='occupied' where shelf like '%$availableshell%'") or die(mysql_error());

		header("location:editmortuaryallocationlist.php");
		exit;

}


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
    <td width="1">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td width="13%" align="left" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td width="19%" align="left" valign="center" class="bodytext31"><input type="text" name="docccno" id="docccno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="10%"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
               </td>
             </tr>
            <tr>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
             <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code  </strong></div></td>
			<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>IP Visit  </strong></div></td>
		    <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Shelf</strong></div></td>
			<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Package</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
$query11 = "select * from mortuary_allocation where docno='$billnumbercode' order by auto_number asc";	
	 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows=mysql_num_rows($exec11);
		 while($res11 = mysql_fetch_array($exec11))
		 {
		$patientname=$res11['patientname'];
		$patientcode=$res11['patientcode'];
		$visitcode=$res11['visitcode'];
		$accountname = $res11['accountname'];
		$docno = $res11['docno'];
		$recorddate = $res11['recorddate'];
		$shelve = $res11['shelve'];
		$package = $res11['package'];
		

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
          <tr <?php echo $colorcode;?>>
           <td colspan="2" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></div></td>
		   <td  colspan="2"align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
		   <td  colspan="1" align="left" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
		   <td  align="left" valign="center" class="bodytext31"><?php echo $shelve; ?></td>
		   <td  align="left" valign="center" class="bodytext31"><?php echo $package; ?></td>
				<input type="hidden" name="shelvename" id="shelvename" value="<?php echo $shelve; ?>">
				<input type="hidden" name="packagename" id="packagename" value="<?php echo $package; ?>">
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
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	
          </tbody>
        </table>
		</td>
		</tr>
		
		</table>
	  </td>
	</tr>
	
      <tr>
      <td>&nbsp;</td>
      </tr>
      
     <?php
	 
	if($package=='')
	{
	 ?> 
      
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
      <?php
	}
	else
	{?>
    
       <tr>
        <td>&nbsp;</td>
        <td width="18%">&nbsp;</td>
		<td width="8%" align="left" valign="center" class="bodytext311"><input type="checkbox" name="mortuarypackage" id="mortuarypackage" checked value="1" >MortuaryPackage</td>
		<td width="23%" align="left" valign="center" class="bodytext311">
        <select class="toggleclass"  width="10" name="mortuaryshellpackage" id="mortuaryshell">
          <option value="<?php echo $package?>"><?php echo $package?></option>
          <?php
		$query10 = "select packagename,total from master_mortuarypackage where status ='' and packagename <> '$package'";
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
    
	<?php	
	}
	  ?>
      
      
       <tr>
        <td>&nbsp;</td>
		<td width="363" align="right" valign="center" class="bodytext31"><strong>Available Shelves</strong></td>
		  <td width="51" align="center" valign="center">
          <select name="availableshell" id="availableshell">
          <option value="<?php echo $shelve?>"><?php echo $shelve;?></option>
          <?php
	    $query12 = "select * from master_shelf where recordstatus ='' and allocationstatus='' order by shelf ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		while ($res12 = mysql_fetch_array($exec12))
		{
		$shelf = $res12["shelf"];
		$shelfcharges = $res12['shelfcharges'];
		  
		  ?>
         <option value="<?php echo $shelf?>"><?php echo $shelf;?>(<?php echo intval($shelfcharges); ?>)</option></select></td></tr>
          <?php
		}
		?>
        
          
          <tr>
          <td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
        <tr>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td width="800" align="left" valign="center" class="bodytext311"><input type="hidden" name="frmflag1" value="frmflag1" />
        <input type="submit" name="Submit" value="Update" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>
                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

