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

if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }

if (isset($_REQUEST["frommonth"])) { $frommonth = $_REQUEST["frommonth"]; $monthName = date("F", mktime(null, null, null, $frommonth)); } else { $frommonth = ""; }
if (isset($_REQUEST["tomonth"])) { $tomonth = $_REQUEST["tomonth"]; $tomonthName = date("F", mktime(null, null, null, $tomonth)); } else { $frommonth = ""; }
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
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="860">
              <form name="cbform1" method="post" action="vaccinationlistuser.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
              <td colspan="8" bgcolor="#cccccc" class="bodytext31">
             <strong>Vaccination List </strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
			    </tr>
			 		
          <td width="300" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="frommonth" id="frommonth">
            <?php
				if ($frommonth != '')
				{
				?>
            <option value="<?php echo $frommonth; ?>" selected="selected"><?php echo $frommonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo (date('m')-5); ?>"><?php echo (date('m')-5); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="fromyear" id="fromyear">
              <?php
				if ($fromyear != '')
				{
				?>
              <option value="<?php echo $fromyear; ?>" selected="selected"><?php echo $fromyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
		  <td width="300" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>To Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="tomonth" id="tomonth">
            <?php
				if ($tomonth != '')
				{
				?>
            <option value="<?php echo $tomonth; ?>" selected="selected"><?php echo $tomonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo date('m'); ?>"><?php echo date('m'); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="toyear" id="toyear">
              <?php
				if ($toyear != '')
				{
				?>
              <option value="<?php echo $toyear; ?>" selected="selected"><?php echo $toyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
         
        </tr>
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" colspan="3">&nbsp;</td>
                      <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
	 </tr>  
	  <tr><td>&nbsp;</td></tr>		        
      <tr>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if($cbfrmflag1 == 'cbfrmflag1'){ ?>

	  <tr><form action="vaccinationlist.php" name="checklist" method="post">
        <td><table width="60%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="4" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Vaccination List </strong></div></td>
			    </tr>
	
            <tr>
			  <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Vaccination</strong></div></td>
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong><?php echo $monthName." ".$fromyear; echo " to ".$tomonthName." ".$toyear;?></strong></div></td>
				
           </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
			?>
			<tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">1</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">BCG</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query1 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'BCG' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				$res1 =  mysql_fetch_array($exec1);
				echo $res1['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ABOVE 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query2 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'BCG' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','MONTHS')";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				$res2 =  mysql_fetch_array($exec2);
				echo $res2['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 0</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">Birth Dose</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query3 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 0' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS','MONTHS') and age between '1' and '30'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$res3 =  mysql_fetch_array($exec3);
				echo $res3['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">3</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 1</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query4 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 1' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
				$res4 =  mysql_fetch_array($exec4);
				echo $res4['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">4</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 2</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query5 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 2' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				$res5 =  mysql_fetch_array($exec5);
				echo $res5['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">5</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 3</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query6 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 3' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
				$res6 =  mysql_fetch_array($exec6);
				echo $res6['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">6</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">DPT/HEP+HIB1</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query7 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'DPT/HEP+HIB1' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				$res7 =  mysql_fetch_array($exec7);
				echo $res7['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">7</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">DPT/HEP+HIB2</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query8 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'DPT/HEP+HIB2' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				$res8 =  mysql_fetch_array($exec8);
				echo $res8['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">8</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">DPT/HEP+HIB3</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query9 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'DPT/HEP+HIB3' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
				$res9 =  mysql_fetch_array($exec9);
				echo $res9['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">9</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">PNEUMOCCAL 1</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query10 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'PNEUMOCCAL 1' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
				$res10 =  mysql_fetch_array($exec10);
				echo $res10['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">10</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">PNEUMOCCAL 2</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query11 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'PNEUMOCCAL 2' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
				$res11 =  mysql_fetch_array($exec11);
				echo $res11['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">11</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">PNEUMOCCAL 3</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query12 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'PNEUMOCCAL 3' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
				$res12 =  mysql_fetch_array($exec12);
				echo $res12['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">12</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">MEASLES</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query13 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'MEASLES' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
				$res13 =  mysql_fetch_array($exec13);
				echo $res13['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">13</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">YELLOW FEVER</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query14 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'YELLOW FEVER' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
				$res14 =  mysql_fetch_array($exec14);
				echo $res14['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">14</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">FULLY IMMMUNIZED CHILDREN</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query15 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'FULLY IMMMUNIZED CHILDREN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
				$res15 =  mysql_fetch_array($exec15);
				echo $res15['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">15</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ADVERSE EVENTS FOLLOWING IMMUNIZATION</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query16 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'ADVERSE EVENTS FOLLOWING IMMUNIZATION' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
				$res16 =  mysql_fetch_array($exec16);
				echo $res16['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">16</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">TETANUS TOXIOD FOR PREGNANT WOMEN</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">1st DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query17 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '1st dose'";
				$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
				$res17 =  mysql_fetch_array($exec17);
				echo $res17['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2nd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query18 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '2nd dose'";
				$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
				$res18 =  mysql_fetch_array($exec18);
				echo $res18['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">3rd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query19 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '3rd dose'";
				$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
				$res19 =  mysql_fetch_array($exec19);
				echo $res19['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">4th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query20 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '4th dose'";
				$exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());
				$res20 =  mysql_fetch_array($exec20);
				echo $res20['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">5th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query21 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '5th dose'";
				$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
				$res21 =  mysql_fetch_array($exec21);
				echo $res21['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">17</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">TETANUS TOXOID FOR TRAUMA</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">1st DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query22 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '1st dose'";
				$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
				$res22 =  mysql_fetch_array($exec22);
				echo $res22['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2nd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query23 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '2nd dose'";
				$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
				$res23 =  mysql_fetch_array($exec23);
				echo $res23['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">3rd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query24 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '3rd dose'";
				$exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
				$res24 =  mysql_fetch_array($exec24);
				echo $res24['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">4th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query25 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '4th dose'";
				$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
				$res25 =  mysql_fetch_array($exec25);
				echo $res25['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">5th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query26 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '5th dose'";
				$exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
				$res26 =  mysql_fetch_array($exec26);
				echo $res26['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">18</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">VIT A(SUPPLEMENTAL)</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query27 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A(SUPPLEMENTAL)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
				$res27 =  mysql_fetch_array($exec27);
				echo $res27['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ABOVE 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query28 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A(SUPPLEMENTAL)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','MONTHS')";
				$exec28 = mysql_query($query28) or die ("Error in Query28".mysql_error());
				$res28 =  mysql_fetch_array($exec28);
				echo $res28['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">LACTATING MOTHERS</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center">Counts</div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">19</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">VIT A (THERAPUTIC)</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2-5 Months</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query30 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','YEARS') and age between '2' and '5'";
				$exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
				$res30 =  mysql_fetch_array($exec30);
				echo $res30['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">6-11 Months</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query31 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','YEARS') and age between '6' and '11'";
				$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
				$res31 =  mysql_fetch_array($exec31);
				echo $res31['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">12-59 Months</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query32 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('MONTHS','DAYS') and age between '1' and '4'";
				$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
				$res32 =  mysql_fetch_array($exec32);
				echo $res32['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#D3EEB7">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ADULTS</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query33 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('MONTHS','DAYS') and age NOT IN('1','2','3','4')";
				$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
				$res33 =  mysql_fetch_array($exec33);
				echo $res33['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">20</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">SQUINT/WHITE EYE REFLECTION</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query34 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'SQUINT/WHITE EYE REFLECTION' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear";
				$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
				$res34 =  mysql_fetch_array($exec34);
				echo $res34['count'];
				?></div></td>
				
           </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              
   	       </tr>
          </tbody>
		  
        </table>
      </td> </form>
  </tr><?php } ?>
	</table>
	  
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

