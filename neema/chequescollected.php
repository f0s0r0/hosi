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

$searchsuppliername = "";
//This include updatation takes too long to load for hunge items database.

include ("autocompletebuild_supplier2.php");
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
<script type="text/javascript" src="js/autocomplete_supplier2.js"></script>
<script type="text/javascript" src="js/autosuggest3supplier.js"></script>
<script type="text/javascript">
window.onload = function () 
{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
	
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
.style1 {font-weight: bold}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
		
		
              <form name="cbform1" method="post" action="chequescollected.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Cheques </strong></td>
              </tr>
          
            <!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Supplier Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername"  value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docno" type="text" id="docno"  value="" size="50" autocomplete="off">
              </span></td>
              </tr>-->
			   
			  <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="supplierentrylist.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	//$searchsupplier = $_POST['searchsuppliername'];
	//$searchdocno=$_POST['docno'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="805" 
            align="left" border="0">
          <tbody>
             
           <tr>
                <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>
                <td width="9%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
                <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>
				  <td width="40%" align="left" valign="center"  
                bgcolor="#ffffff" class="style2">Supplier</td>
				  <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque Number</strong></td>
			
			        <td width="7%"class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Amount </strong></div></td>
               <td width="17%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
                  </tr>
			  <?php 
			  $totalamount = 0;
			$query22 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and transactionmode='CHEQUE' and transactiondate between '$fromdate' and '$todate' group by suppliername order by suppliername";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			while ($res22 = mysql_fetch_array($exec22))
			{
			$res22suppliername = $res22['suppliername'];
			 ?>
			 <tr>
                <td colspan="7" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res22suppliername; ?></strong></td>
           </tr>
		   <?php
			
            $query2 = "select * from master_transactionpharmacy where suppliername = '$res22suppliername' and transactionmodule = 'PAYMENT' and transactionmode='CHEQUE' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $num2 = mysql_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysql_fetch_array($exec2))
			  {
			      $totalamount=0;
			 	  $transactiondate = $res2['transactiondate'];
				  $date = explode(" ",$transactiondate);
				  $docno = $res2['docno'];
				  $mode = $res2['transactionmode'];
				  $suppliername = $res2['suppliername'];
				  
					$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$totalamount = $res51['transactionamount'];  
					$chequenumber = $res2['chequenumber'];
			  
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
               
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $date[0]; ?></span></div>
                </div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div>
                </div></td>
           
                          <td  align="left" valign="center" class="bodytext31"><?php echo $suppliername; ?></td>
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $chequenumber; ?> </span> </div>
                </div></td>
				
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>
                </div></td>
           
		   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="style2"><a target="_blank" href="print_suppliercheque.php?suppliername=<?php echo $suppliername; ?>&&docno=<?php echo $docno; ?>">Print</a> </span> </div>
                </div></td>
                    </tr>
			  <?php
			    }
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
          </tbody>
        </table>
	
		
	  
      <?php
	  }
	  ?>
	  </form>	  </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

