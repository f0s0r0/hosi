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


if(isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2=$_REQUEST["cbfrmflag2"];} else { $cbfrmflag2="";}
if($cbfrmflag2=='cbfrmflag2')
{
	
foreach($_POST['transfer'] as $key => $value)
{
		 $transfer=$_POST['transfer'][$key];

   $query39=mysql_query("update mortuary_request set transferstatus='completed' where docno='$transfer'") or die(mysql_error());
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script language="javascript">
function validcheck()
{
if(

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>

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
              <form name="cbform1" method="post" action="mortuaryapprovallist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Mortuary Approved List</strong></td>
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
					

$query34="select * from mortuary_request where recordstatus='' and paymentstatus <>'' and transferstatus ='' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number asc";
		$exec34=mysql_query($query34) or die(mysql_error());
			$resnw1=mysql_num_rows($exec34);
                
          ?>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="500" 
            align="left" border="0">		  
            <form name="form1" id="form1" method="post" action="" >	

          <tbody>
            <tr>
             
              <td colspan="7" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Mortuary Approved List</strong>
                  <label class="number"><<<?php echo $resnw1;?>>></label></div>
                  
                  </td>
              </tr>
			  
			
            <tr>
              <td class="bodytext31" valign="center"  align="left"  width="38"
                bgcolor="#ffffff"><strong>No.</strong></td>
				 <td   align="left" valign="center" width="95"
                bgcolor="#ffffff" class="bodytext31"><strong>Date </strong></td>
				<td   align="left" valign="center" width="69"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td   align="left" valign="center" width="121"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
				<td   align="left" valign="center" width="164"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
				<td   align="left" valign="center" width="115"
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
     			<td   align="left" valign="center" width="63" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              	</tr>
                
			
            
			<?php
			
			
			$colorloopcount = '';
			$sno = '';
			
		  $query11 = "select * from mortuary_request where recordstatus='' and paymentstatus <>'' and transferstatus ='' and recorddate between '$transactiondatefrom' and '$transactiondateto'  order by auto_number asc";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows=mysql_num_rows($exec11);
		 while($res11 = mysql_fetch_array($exec11))
		 {
		$patientname=$res11['patientname'];
		$patientcode=$res11['patientcode'];
		$visitcode=$res11['visitcode'];
		$accountname = $res11['accountname'];
		$docno = $res11['docno'];
		$anum = $res11['auto_number'];
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
			
			?>
			  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" width="38"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center" width="95"  align="left">
			    <?php echo $recorddate; ?></td>
				<td class="bodytext31" valign="center" width="69"  align="left">
			    <?php echo $docno; ?></td>
			   <td class="bodytext31" valign="left" width="121"  align="left">
			    <?php echo $patientname; ?></td>
				<td class="bodytext31" valign="center" width="164"  align="left">
			    <?php echo $patientcode; ?></td>
			   <td class="bodytext31" valign="center" width="115"  align="left">
			    <?php echo $visitcode; ?></td>
                
	  		      <td class="bodytext31" valign="center"  width="63" align="left">
                 <div class="bodytext31" align="center"><a href="mortuaryapprovalpage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno; ?>&&anum=<?php echo $anum; ?>">Process </a></div>
			  </td>
              
              
			    </tr>
			  <?php
			}
			?>
            <tr>
            
              <td class="bodytext31" colspan="" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                  <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">
<!--					  <input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
                          <input  type="submit" value="Transfer" name="Submit" />
-->                          
                          </td>
                  <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">
					  </td>
                          
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

