<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$paymentreceiveddateto = date('Y-m-d');


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = ""; }
if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = ""; }


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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script language="javascript">


function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}


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


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
	function activeplan(planid)
	{
		/*var con = confirm('Are you sure want to delete this Copay name');
		if(con == false)
		{
			return false;
			}*/
			//alert(planid);
			form1.method="post"
			form1.action="ambulancerequestlistip.php?planid="+planid+"&&actkey=1";
			form1.submit();
		}
		
		
	function copay(a){
	var amount = document.getElementById("planfixedamount");
	var percentage = document.getElementById("planpercentage");
	if(amount.id==a){
		percentage.readOnly = true;
		percentage.value = '';
		amount.readOnly = false;
	}else if(percentage.id==a){
		percentage.readOnly = false;
		amount.readOnly = true;
		amount.value = '';
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

<?php 

$query34="select * from ip_ambulancerequest where recordstatus='' and recorddate between '$transactiondatefrom' and '$transactiondateto'  order by auto_number asc";
		$exec34=mysql_query($query34) or die(mysql_error());
			$resnw1=mysql_num_rows($exec34);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
              <form name="cbform1" method="post" action="ambulancerequestlistip.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Ambulanc Request List-IP</strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $currentdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                    
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
<!--                  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
-->				 <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
   			    </tr>
                  </tbody>
                </table>
              </form> </td> </tr></table>   
        <?php      
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
                
          ?>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="500" 
            align="left" border="0">
          <tbody>
            <tr>
             
              <td colspan="7" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Ambulanc Request List-IP</strong>
                  <label class="number"><<<?php echo $resnw1;?>>></label></div>
                  
                  </td>
              </tr>
			  
			
            <tr>
              <td class="bodytext31" valign="center"  align="left"  width="10"
                bgcolor="#ffffff"><strong>No.</strong></td>
				 <td   align="left" valign="center" width="20"
                bgcolor="#ffffff" class="bodytext31"><strong>Date </strong></td>
				<td   align="left" valign="center" width="30"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td   align="left" valign="center" width="100"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
				<td   align="left" valign="center" width="100"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
				<td   align="left" valign="center" width="40"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
     			<td   align="left" valign="center" width="10" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              	</tr>
                
			
            
			<?php
			
			
			$colorloopcount = '';
			$sno = '';
			
		  $query11 = "select * from ip_ambulancerequest where recordstatus='' and recorddate between '$transactiondatefrom' and '$transactiondateto'  order by auto_number asc";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows=mysql_num_rows($exec11);
		 
		 while($res11 = mysql_fetch_array($exec11))
		 {
		$patientname=$res11['patientname'];
		$patientcode=$res11['patientcode'];
		$visitcode=$res11['patientvisitcode'];
		$accountname = $res11['accountname'];
		$docno = $res11['docno'];
		$recorddate = $res11['recorddate'];
		
		// $suppliername = $res11['suppliername'];
					
			
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
		/*	$query3 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode = '$visitcode'";
		 $exec3 = mysql_query($query3) or die(mysql_error());
		 $rows=mysql_num_rows($exec3);
		 if($rows==0){*/
			?>
			  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" width="10"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center" width="40"  align="left">
			    <?php echo $recorddate; ?></td>
				<td class="bodytext31" valign="center" width="40"  align="left">
			    <?php echo $docno; ?></td>
			   <td class="bodytext31" valign="left" width="40"  align="left">
			    <?php echo $patientname; ?></td>
				<td class="bodytext31" valign="center" width="40"  align="left">
			    <?php echo $patientcode; ?></td>
			   <td class="bodytext31" valign="center" width="40"  align="left">
			    <?php echo $visitcode; ?></td>
                
	  		      <td class="bodytext31" valign="center"  width="10" align="left">
			  <div class="bodytext31" align="center"><a href="ipambulance.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno; ?>" onClick="activeplan(<?php echo $visitcode; ?>);">Process </a></div></td>
              
              
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
   			    </tr>
                <?php }
				
				?>
          </tbody>
        </table>
        
        </td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	  
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	   </td>
	  </tr>
    </table>
</table>

<?php include ("includes/footer1.php"); ?>

</body>
</html>

