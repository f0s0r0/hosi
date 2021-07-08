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
ini_set('max_execution_time', 12000000); //120 seconds
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
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["cbfrmflag3"])) { $cbfrmflag3 = $_REQUEST["cbfrmflag3"]; } else { $cbfrmflag3 = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}


if($cbfrmflag2== 'cbfrmflag2')
{
	$startdate=$_REQUEST['startdate'];
	$enddate=$_REQUEST['enddate'];
	$opoveralllimit=$_REQUEST['opoveralllimit'];
	$ipoveralllimit=$_REQUEST['ipoveralllimit'];
	$patientcode=$_REQUEST['patientcode'];
	$visitcode=$_REQUEST['visitcode'];
	$approvedlimit=$_REQUEST['approvedlimit'];
	$check=$_REQUEST['checkpatient'];
	
	if($check !='')
	{
		$query="update master_ipvisitentry set approvedlimit='$approvedlimit' where patientcode='$patientcode' and visitcode='$visitcode' " ; 
	$exec = mysql_query($query) or die ("Error in Query".mysql_error());	
	header('location:updatelimits_ip.php?st=1'); exit;	
	}
	
	header('location:updatelimits_ip.php?st=2'); exit;
}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1')
{
	$errmsg = "Success. Limit Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed.  Entry Not Completed.";
}

function calculate_age($birthday)
			{
				$today = new DateTime();
				$diff = $today->diff(new DateTime($birthday));
			
				if ($diff->y)
				{
					return $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
					return $diff->m . ' Months';
				}
				else
				{
					return $diff->d . ' Days';
				}
			}
?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ 
zoom:.7 !important;
 }
</style>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script>

 function  checksubmit()
 {
	 var check = document.getElementById("checkpatient").checked;
	 
	 if(check==false)
	 {
		 alert('Please tick the checkbox');
		 return false;
	 }
 }
</script>

<script type="text/javascript">
$(document).ready(function() {
		 
		 
$('#scheme').autocomplete({
 	
	source:'ajaxdata.php?process=scheme', 
	
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			
			
			var accountauto = ui.item.accountauto;
			
			$('#accountauto').val(accountauto);
			
			},
    });
	
	$('#patient').autocomplete({
 	
	source:'ajaxcustomerupdate.php', 
	
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var patient = ui.item.customerfullname;
			var patientcode = ui.item.customercode;
			var visitcode=ui.item.visitcode;
			//alert('patientcode');
			document.getElementById('patientcode').value=patientcode;
			document.getElementById('visitcode').value=visitcode;
			
			},
    });
	
	
	$('#checkpatient').click(function() {
        if ($(this).is(':checked')) {
            
			$('#ipoveralllimit').attr("readonly", false);
			$('#opoveralllimit').attr("readonly", false);
			$('#startdate').attr("readonly", false);
			$('#enddate').attr("readonly", false);
			
        }
		if (!$(this).is(':checked')) {
            
			$('#ipoveralllimit').attr("readonly", true);
			$('#opoveralllimit').attr("readonly", true);
			$('#startdate').attr("readonly", true);
			$('#enddate').attr("readonly", true);
        }
    });
	
	//var checksc = $('#checkscheme').val();
	$('.checkscheme').click(function() {
		
		 var checksc = $(this).val();
        if ($(this).is(':checked')) {
            
			$('#ipoveralllimitsc'+checksc).attr("readonly", false);
			$('#opoveralllimitsc'+checksc).attr("readonly", false);
			$('#startdatesc'+checksc).attr("readonly", false);
			$('#enddatesc'+checksc).attr("readonly", false);
			
        }
		if (!$(this).is(':checked')) {
            
			$('#ipoveralllimitsc'+checksc).attr("readonly", true);
			$('#opoveralllimitsc'+checksc).attr("readonly", true);
			$('#startdatesc'+checksc).attr("readonly", true);
			$('#enddatesc'+checksc).attr("readonly", true);
        }
    });

});
function process()
	{
		
		$('#scheme1').hide();
	}
function changefunction()
	{
		var search2=document.getElementById('search').value;
		if( search2=='patient')
		{
		$('#patient1').show();
		$('#scheme1').hide();	
		}
		else
		{
			$('#patient1').hide();
			$('#scheme1').show();
		}
	}
	
	

</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>



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
.pagination{ float:right; }
</style>
</head>


<body onLoad="return process()">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
		
		
              <form name="cbform1" method="post" action="updatelimits_ip.php" >
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Update Limits</strong></td>
              </tr>
              <?php
			  	if($st==1){
			  ?>
          	 <tr>
        		<td colspan="4" class="bodytext3" bgcolor="#00FF66"><?php echo $errmsg; ?></td>
     		 </tr>
             <?php
				}
             ?>
             
      
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Type</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <Select name="search" id="search" onChange="return changefunction()">
                <option value="patient">Patient</option>
                </Select>
              </span></td>
              </tr>
			    <tr id="scheme1">
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Scheme Search</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="scheme" type="text" id="scheme" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
              
			    <tr id="patient1">
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
                <input name="patientcode" type="hidden" id="patientcode" value="" size="50" autocomplete="off">
                 <input name="visitcode" type="hidden" id="visitcode" value="" size="50" autocomplete="off">
                <input name="accountauto" type="hidden" id="accountauto" value="" size="50" autocomplete="off">
               
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
     
     
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td >&nbsp;</td>
      </tr>
	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
	$st='';
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page']))
{
	  $_process=$_REQUEST['search'];
	  	
	 if($_process =="patient")
	 {
		 ?>
          
         <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1074" 
            align="left" border="0">
            
          <tbody>
           <form name="cbform2" method="post" action="updatelimits_ip.php">
            <tr>
              <td colspan="10" bgcolor="#cccccc" class="bodytext31">
               
                <div align="left"><strong>Patient Search</strong><label class="number"></label>
                </div></td>
              </tr>
			  
					
            
            <tr>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Full Name </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg.No</strong></div></td>
				
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Scheme </strong></div></td>
				  <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Plan Name </strong></div></td>
               <!-- <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Plan Start Date</strong></div></td>
              <td width="20%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Plan End Date</strong></div></td>
                <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> OP Overall Limit</strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>IP Overall Limit</strong></td>-->
                <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Approved Limt</strong></div></td>
                 <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Check</strong></td>
              </tr>
         
         
       
         <?php
		 $sno='';
		
		 $patient=$_REQUEST['patient'];
		 $patientcode=$_REQUEST['patientcode'];
		 $visitcode = $_REQUEST['visitcode'];
	 	 $query01="select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
		 $exe01=mysql_query($query01);
		 while($res01=mysql_fetch_array($exe01))
		 {
		 	$patientname=$res01['patientfullname'];
			$customercode=$res01['patientcode'];
			$accountcode=$res01['accountname'];
			$plancode=$res01['planname'];
			$approvedlimit=$res01['approvedlimit'];
			$visitcode = $res01['visitcode'];
			
		 	 $query1="select * from master_accountname where auto_number='$accountcode'  ";
		 	 $exe1=mysql_query($query1);
			 $res1=mysql_fetch_array($exe1);
			 $accountname=$res1['accountname'];
			 
			 $query12="select * from master_planname where auto_number='$plancode'  ";
		 	 $exe12=mysql_query($query12);
			 $res12=mysql_fetch_array($exe12);
			 $planname=$res12['planname'];
			 
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
         
         <form name="update" method="post" action="updatelimits_ip.php" >
                   <tr  <?php echo $colorcode; ?>>
              <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="center"><strong><?php echo $sno = $sno + 1;  ?> </strong></div></td>
				 <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><?php echo $patientname; ?></td>
				
				<td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php echo $patientcode; ?><input type="hidden" name="patientcode" id="patientcode" value="<?php  echo $customercode; ?>" >
				 <input type="hidden" name="visitcode" id="visitcode" value="<?php  echo $visitcode; ?>" >
				 </div></td>
              <td width="30%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"> <?php echo $accountname; ?></div></td>
				  <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php echo $planname; ?> </div></td>
               <!--<td width="263" align="left" valign="center"  ><span class="bodytext31">
            <input name="startdate" id="startdate" value="" readonly='readonly'  size="10"  onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('startdate')" style="cursor:pointer"/>
		  </span></td>
                <td width="263" align="left" valign="center"  class="bodytext31"><input name="enddate" id="enddate" value=""  size="10"   onKeyDown="return disableEnterKey()" readonly='readonly'  />
			<img src="images2/cal.gif"  onClick="javascript:NewCssCal('enddate')" style="cursor:pointer"/></td>
                 
                <td width="17%"  align="left" valign="center" 
                 class="bodytext31">
                 
                  <input type="text" name="opoveralllimit" id="opoveralllimit" value=" " size="10"></td>
              <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><input type="text" name="ipoveralllimit" id="ipoveralllimit" value="" size="10"></td>-->
                 <td width="17%"  align="left" valign="right" 
                 class="bodytext31"><input type="text" name="approvedlimit" id="approvedlimit" value="<?php  echo $approvedlimit; ?>" size="10"></td>
                <td width="17%"  align="left" valign="center" 
                 class="bodytext31"><input type="checkbox" name="checkpatient" id="checkpatient"   ></td>
              </tr>
               <tr>
        <td>&nbsp;</td>
      </tr>
              <tr>
                      <td align="left" valign="middle"  class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top" >
					  	<input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
                          <input  type="submit" value="Submit" name="Submit" onClick="return checksubmit();" />
                          <input name="resetbutton" type="reset" id="resetbutton"    value="Reset" /></td>
                    </tr>
                   
                    </form>
              </tbody>
              </table>
         <?php
		 
		 }
	 }
	
	
	
	
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
	  
	 
    </table>
  </table>
  <?php
  

  ?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

