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

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	

$query1111 = "select * from master_employee where username = '$username'";
			$exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
			 while ($res1111 = mysql_fetch_array($exec1111))
			 {
			   $locationnumber = $res1111["location"];
			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
				$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
			 while ($res1112 = mysql_fetch_array($exec1112))
			 {
			   $locationname = $res1112["locationname"];    
				$locationcode = $res1112["locationcode"];
			 }
			 }
if(isset($_REQUEST['department']))
{
$department = $_REQUEST['department'];
}
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}


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

					
//ajax to get location which is selected ends here


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

<?php $query12= "select * from master_triage where  locationcode='$locationcode' and triagestatus = 'completed' and overallpayment='' and consultationdate >= NOW() - INTERVAL 2 DAY order by consultationdate DESC";
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
    <td colspan="9">:&nbsp;&nbsp;</td>
  </tr>
  <tr>
                 <td width="454" align="left" valign="middle" bgcolor="#E0E0E0" >
                  <iframe id="consultationlistiframe" src="consultationlistiframe.php" width="680" height="700" frameborder="1">                  </iframe>                  </td>
			   <td width="454" align="left" valign="middle" bgcolor="#E0E0E0" >
                  <iframe id="publishedlistiframe" src="publishedlistiframe.php" width="680" height="700" frameborder="1">                  </iframe>                  </td>

			  </tr>
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
