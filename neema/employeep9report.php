<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$E3 = '0.00';
$F = '0.00';
$J = '0.00'; 

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

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

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
}

</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{
	if(document.getElementById("searchemployee").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="102%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php  include ("includes/alertmessages1.php");  ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php  include ("includes/title1.php");  ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php 
	 include ("includes/menu1.php"); 
	 //include ("includes/menu2.php"); 
	?></td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<form action="employeep9report.php" method="post" name="form1" onSubmit="return from1submit1()">  
  <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode" value="<?php echo $searchemployeecode; ?>">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php  echo $searchemployee;  ?>" size="50" style="border:solid 1px #001E6A;"></td>
    <td align="left" class="bodytext3"><a href="print_p9.php?searchemployeecode=<?php echo $searchemployeecode; ?>&&searchyear=<?php echo $searchyear; ?>" target="_blank"><img src="images/pdfdownload.jpg" width="30" height="30" /></a></td>
	</tr>
	<tr>
	<td width="74" align="left" class="bodytext3">Search Year</td>
	<td width="56" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
	<?php  if($searchyear != '') {  ?>
	<option value="<?php  echo $searchyear;  ?>"><?php  echo $searchyear;  ?></option>
	<?php  }  ?>
	<?php 
	for($j=2010;$j<=date('Y');$j++)
	{
	 ?>
	<option value="<?php  echo $j;  ?>"><?php  echo $j;  ?></option>
	<?php 
	}
	 ?>
	</select></td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</td>
	</tbody>
	</table>
  </form>
  </td>
  </tr>  
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<?php 
	
	
	if($frmflag1 == 'frmflag1')
	{
	if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
	if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
	
	$querycomp = "SELECT companycode,companyname FROM master_company WHERE auto_number = '$companyanum'";
	$execcomp = mysql_query($querycomp) or die ("Error in querycomp".mysql_error());
	$rescomp = mysql_fetch_array($execcomp);
	$companycode = $rescomp['companycode'];
	$companyname = $rescomp['companyname'];	
	$companypin = '';	
	
	$queryemp = "SELECT employeecode,employeename,pinno FROM master_employeeinfo WHERE employeecode='$searchemployeecode'";
	$execemp = mysql_query($queryemp) or die ("Error in queryemp".mysql_error());
	$resemp = mysql_fetch_array($execemp);
	$employeecode = $resemp['employeecode'];
	$employeename = $resemp['employeename'];
	$employeepin = $resemp['pinno'];	
	
	$payrollno = '';	
	$res11e1= '';
	$E3= '0.00';
	$F= '0.00';
	
	$query9 = "select amount from master_taxrelief where type='Monthly' and status=''";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	$res9 = mysql_fetch_array($exec9);
	$J= $res9['amount'];
	?>
<table width="1087" align="left" style="background-color:#FFFFFF; float: left;">
<tr><td align="left" width="518" class="foot_head">APPENDIX 1A</td><td  width="564" align="right">KRA Approval Number: CDTD/1037/2008/4</td></tr>
</table>
<table width="1086" align="left" class="logo" border="0" style="background-color:#FFFFFF; float: left;">
  <tr><td width="1081" align="center"><strong>KENYA REVENUE AUTHORITY</strong></td></tr>
    <tr><td align="center"><strong>INCOME TAX DEPARTMENT</strong></td></tr>
    <tr><td align="center"><strong>TAX DEDUCTION CARD YEAR<?php echo $searchyear;?></strong></td></tr>
	<tr><td align="center">&nbsp;</td></tr>
</table>
<table width="1087" class="info" align="left" cellpadding="" cellspacing="0" style="background-color:#FFFFFF; float: left;">
    <tr>
    	<td width="203">Employer's Name:</td>
        <td width="430" class="borderbottom"><?php echo $companyname;?></td>
        <td width="19">&nbsp;</td>
        <td width="158">Employer's PIN:</td>
        <td width="281" class="borderbottom"><?php echo $companypin;?></td>
    </tr>
    <tr>
    	<td>Employee's Main Name:</td>
        <td class="borderbottom"><?php echo $employeename; ?></td>
        <td>&nbsp;</td>
        <td>Employee's PIN:</td>
        <td class="borderbottom"><?php echo $employeepin; ?></td>
    </tr>
    <tr>
    	<td>Employee's Other Names:</td>
        <td class="borderbottom"><?php //echo $employeelastname; ?></td>
        <td>&nbsp;</td>
        <td>Employee's Payroll:</td>
        <td class="borderbottom"><?php echo $payrollno; ?></td>
    </tr>
    <tr><td colspan="5">&nbsp;</td>
    </tr>
</table>
<table width="1050" border="1" align="left" cellpadding="" cellspacing="" bordercolor="#666666" class="payroll" style="border-collapse:collapse; background-color:#FFFFFF; float: left;">
    <thead>
        <tr>
            <th width="58">MONTH</th>
            <th width="56">Basic Salary<br> Kshs.</th>
            <th width="61">Benefits Non Cash<br> Kshs.</th>
            <th width="61">Values of Quarters<br> Kshs.</th>
            <th width="56">Total Gross Pay<br> Kshs.</th>
            <th colspan="3">Defined Contribution Retirement Scheme<br> Kshs.</th>
            <th width="103">Owner Occupied Interest<br> Kshs.</th>
            <th width="91">Retirement Contribution & Owner Occupied Interest</th>
            <th width="68">Chargeable Pay<br> Kshs.</th>
            <th width="60">Tax Charged<br> Kshs.</th>
            <th width="61">Personal Relief<br> Kshs.</th>
            <th width="63">Insurance Relief<br> Kshs.</th>
        	<th width="56">PAYE Tax (J-K)<br> Kshs.</th>
        </tr>
        <tr>
            <th rowspan="2">&nbsp;</th>
            <th rowspan="2">A</th>
            <th rowspan="2">B</th>
            <th rowspan="2">C</th>
            <th rowspan="2">D</th>
            <th colspan="3">E</th>
            <th rowspan="2">F<br> Amount of Interest</th>
            <th rowspan="2">G<br> The lowest of E<br/> added to F</th>
            <th rowspan="2">H</th>
            <th rowspan="2">I</th>
            <th>J</th>
            <th>K</th>
        	<th rowspan="2">L</th>
        </tr>
        <tr>
       	  <th width="68">E1 <?php echo $res11e1; ?>% of A</th>
          <th width="71">E2 Actual</th>
          <th width="70">E3 Fixed</th>
          <th colspan="2">Total Kshs. <?php echo number_format($J); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
	$totala = '0.00';
	$totalb = '0.00';
	$totalc = '0.00';
	$totald = '0.00';
	$totale1 = '0.00';
	$totale2 = '0.00';
	$totale3 = '0.00';
	$totalf = '0.00';
	$totalg = '0.00';
	$totalh = '0.00';
	$totali = '0.00';
	$totalj = '0.00';
	$totalk = '0.00';
	$totall = '0.00';
	
	$monthnum='';
	$arraymonth = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	$monthnum=$i+1;
	$searchmonthyear = $arraymonth[$i].'-'.$searchyear;
	//date('F',strtotime($arraymonth[$i]));
	
	$query2 = "select `1` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode' group by employeecode";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$res2basic = $res2['componentamount'];
	
	$B = '0.00';
	$C = '0.00';
	$D = '0.00';
	$E1 = '0.00';
	$E2 = '0.00';
	$G = '0.00';
	$H = '0.00';
	$I = '0.00';
	$K = '0.00'; 
	$L = '0.00'; 
	$otherearn = '0.00';
	
	$query3 = "select auto_number from master_payrollcomponent where notional='YES'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	while($res3 = mysql_fetch_array($exec3))
	{
	 $res3auto_number = $res3['auto_number'];
	
	 $query4 = "select `$res3auto_number` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	 $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	 $res4 = mysql_fetch_array($exec4);
	 $res4componentamount = $res4['componentamount'];
	 $B=$B+$res4componentamount;   //B
	}
	
	$query5 = "select `2` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	$res5 = mysql_fetch_array($exec5);
	//$C = $res5['componentamount'];   //C
	$res5componentamount = $res5['componentamount'];   
	
	$query15 = "select `5` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
	$res15 = mysql_fetch_array($exec15);
	$res15absent = $res15['componentamount'];
	
	$query26 = "select componentname, auto_number from master_payrollcomponent where type = 'Earning' and componentname='OTHER EARN' and recordstatus=''";
	$exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
	while($res26 = mysql_fetch_array($exec26))
	{
	 $res26componentname = $res26['componentname'];
	 $res26componentanum = $res26['auto_number'];
	
	$query16 = "select `$res26componentanum` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
	$res16 = mysql_fetch_array($exec16);
	$res16componentamount = $res16['componentamount'];
    $otherearn=$otherearn+$res16componentamount;
	}
	$basic=($res2basic+$res5componentamount+$otherearn)-$res15absent;  //A
	
	/*$query6 = "select componentamount from details_employeepayroll where componentname = 'GROSSPAY' and paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$D = $res6['componentamount'];      //D*/
	
	$D = $basic+$B+$C;      //D
	
	$E1 = ($res11e1*$basic)/100;
	
	$query7 = "select `7` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	$res7 = mysql_fetch_array($exec7);
	$E2= $res7['componentamount'];
	
	$G=(min($E1,$E2,$E3)+$F);  
	$H=$D-$G;
	
	$query8 = "select `8` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
	$res8 = mysql_fetch_array($exec8);
	$res8componentamount = $res8['componentamount'];
	
	$I=$res8componentamount+$J;
	
	$L=$I-$J;

	$totala=$totala+$basic;
	$totalb=$totalb+$B;
	$totalc=$totalc+$C;
	$totald=$totald+$D;
	$totale1=$totale1+$E1;
	$totale2=$totale2+$E2;
	$totale3=$totale3+$E3;
	$totalf=$totalf+$F;
	$totalg=$totalg+$G;
	$totalh=$totalh+$H;
	$totali=$totali+$I;
	$totalj=$totalj+$J;
	$totalk=$totalk+$K;
	$totall=$totall+$L;
	?>
     <tr>
		<td class="month"><?php echo date('F',mktime(0,0,0,$monthnum,10)); ?></td>
		<td align="right"><?php echo number_format($basic,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($B,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($C,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($D,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($E1,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($E2,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($E3,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($F,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($G,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($H,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($I,2,'.',','); ?></td>  
		<td align="right"><?php echo number_format($J,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($K,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($L,2,'.',','); ?></td>
	</tr>
	<?php
	}
	?>
    <tr>
		<td align="left">TOTALS</td>
		<td align="right"><?php echo number_format($totala,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalb,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalc,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totald,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totale1,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totale2,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totale3,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalf,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalg,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalh,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totali,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalj,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalk,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totall,2,'.',','); ?></td>
	</tr>
   </tbody>
</table>
<table width="1089" align="left" class="footer" style="background-color:#FFFFFF; float: left;">
	<tr><td colspan="5" align="center" class="foot_head">TOTAL TAX (COL.L)Kshs. <?php echo number_format($totall,2,'.',','); ?></td></tr>
    <tr><td colspan="5" align="center" class="foot_head">&nbsp;</td></tr>
    <tr><td colspan="5" align="left">To be completed by Employer at end of year</td></tr>
    <tr>
    	<td colspan="2" class="foot_head">TOTAL CHARGEABLE PAY (COL.H)Kshs. <?php echo number_format($totalh,2,'.',','); ?></td>
        <td width="14" colspan="">(b)</td>
        <td colspan="2"> Attach</td>
    </tr>
    <tr>
    	<td colspan="2"><strong><u>IMPORTANT</u></strong></td>
        <td colspan="">&nbsp;</td>
        <td colspan="2">(i) Photostat copy of interest certificate and statement of account from  then Financial Institution</td>
    </tr>
    <tr>
    	<td width="56" colspan="">1. Use P9A </td>
        <td width="506" colspan="">(a) For all liable employees and where director/employee received Benefits in addition to cash emoluments</td>
        <td colspan="">&nbsp;</td>
        <td colspan="2">(ii) The DECLARATION duly signed by the employee</td>
    </tr>
    <tr>
    	<td colspan="">&nbsp;</td>
        <td colspan="">(b) Where an employee is eligible to deduction on owner occupied interest</td>
        <td colspan="">&nbsp;</td>
        <td colspan="2" class="foot_head">NAMES OF FINANCIAL INSTITUTION ADVANCING MORTGATE LOAN</td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
        <td colspan="">&nbsp;</td>
        <td colspan="2" class="borderbottom"></td>
    </tr>
    <tr>
    	<td colspan="2">2. Deductible interest in respect of any month must not exceed Kshs.8333/-</td>
        <td colspan="">&nbsp;</td>
         <td width="250" colspan="" class="foot_head">L.R NO OF OWNER OCCUPIED PROPERTY:</td>
        <td width="200" colspan="" class="borderbottom"></td>
    </tr>
    <tr>
    	<td colspan="2"><strong>(see back of this card for further information required by the Department) <i>P.9A</i></strong></td>
        <td colspan="">&nbsp;</td>
         <td colspan="" class="foot_head">DATE OF OCCUPATION OF HOUSE:</td>
        <td colspan="" class="borderbottom"></td>
    </tr>
</table>
	<?php 
	}
	 ?>
	</td>
  	</tr>
    </table>
<?php  include ("includes/footer1.php");  ?>
</body>
</html>

