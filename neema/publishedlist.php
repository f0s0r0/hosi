<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$department = '';
if(isset($_REQUEST['department']))
{
$department = $_REQUEST['department'];
}
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
if(isset($_POST['doctor'])){$searchdoctor = $_POST['doctor'];}else{$searchdoctor="";}
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
.number1
{
text-align:right;
padding-left:700px;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

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




</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<?php $query12= "select * from master_triage where  triagestatus = 'completed' and overallpayment='' and consultationdate >= NOW() - INTERVAL 2 DAY order by consultationdate DESC";
			$exec12 = mysql_query($query12) or die ("Error in Query1".mysql_error());
			$res12=mysql_num_rows($exec12);
			?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="1145">
              <form name="cbform1" method="post" action="publishedlist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
					  <td width="16%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
				    </tr>
						<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Reg No</td>
					  <td width="32%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patientcode" type="text" id="patient" value="" size="20" autocomplete="off">
					  </span></td>
					  <td width="22%" align="center" valign="middle"  bgcolor="#FFFFFF"><span class="bodytext3">Visit No</span></td>
					  <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					    <input name="visitcode" type="text" id="visitcode" value="" size="20" autocomplete="off">
					  </span></td>
					  </tr>
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor</td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input name="doctor" type="text" id="doctor" value="" size="20" autocomplete="off"></td>
             		 </tr>
					
			 			
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
          </form>		</td>
	 </tr>  
		        
     
	  <tr>
        <td><table width="100%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="4" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Published List </strong></div></td>
				<td colspan="4" bgcolor="#cccccc" class="bodytext31" align="right"><label><strong> <a href="consultationlist1.php">Click to See Consultation List</a></strong></label></td>
			    </tr>
	
            <tr>
   				  <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP Date  </strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.No</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No </strong></div></td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient</strong></div></td>
				  <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor </strong></div></td>
             <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Dept</strong></div></td>
                 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Action</strong></div></td>
			  </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
					
		$query1 = "select * from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit='' group by patientvisitcode order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['patientvisitcode'];
		$accountname = $res1['accountname'];
		$requestedbyname = $res1['username'];
		
		
		$query43 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec43 = mysql_query($query43) or die(mysql_error());
		$res43 = mysql_fetch_array($exec43);
		$opdate = $res43['consultationdate'];
		$dept = $res43['departmentname'];
		
				
			$query21 = "select * from master_consultationlist where visitcode='$visitcode' order by auto_number";
			$exec21 = mysql_query($query21) or die(mysql_error());
			$num21 = mysql_num_rows($exec21);
			
			$res21 = mysql_fetch_array($exec21);
			$consultationdatetime = $res21['consultationdate'];
			$consultationdatetime2 = strtotime($consultationdatetime);
		    $consultationdatetime1 = strtotime($consultationdatetime . ' + 1 day');
			$updatedatetime1 = strtotime($updatedatetime);
			
			$consultationdate1 = date('Y-m-d', $consultationdatetime2);
			
						
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
             
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $opdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accountname; ?></div></td>
   
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $requestedbyname;?>			      </div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $dept;?>			      </div></td>
                       
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><strong><a href="consultationformresultscheck.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Consult</a></strong></div></td>
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
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			    </tr>
          </tbody>
		  
        </table>
      </td> 
	  <td width="205"><iframe marginwidth="19" src="labtestscrolling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" frameborder="0" scrolling="no"></iframe></td>   
      </tr>
	  <tr>
	  <td>
	   <td width="205"><iframe marginwidth="19" src="radiologytestscrolling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" frameborder="0" scrolling="no"></iframe></td>   
	   </tr>
	</table>
	  </td>
	  </tr>
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

