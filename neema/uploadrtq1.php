<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$date = date('Y-m-d');

if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }
if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
//$upload = $_REQUEST['upload'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. File Uploaded Successfully.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. File Upload Failed.";
		}
}
if ($st == 'failed')
{
		$errmsg = "Failed. Supplier Already Exists.";
}

if ($upload == 'success')
{

if (isset($_REQUEST["docno"])) { $docnum = $_REQUEST["docno"]; } else { $docnum = ""; }


	$importstarted = date("d-M-Y H:i:s");

	$skipcountservice = 0;
	$skipcounttax = 0;
	$skipcountcategory = 0;
	$skipcountunit = 0;
	$successcount = 0;
	$forloopcount = 0;
	$foldername = "tab_file_dump//";
	$filename = $username."_tabdump.txt";
	$filepath = $foldername.$filename;
	$fd = fopen ($filepath, "r");
	$fullcontents = fread ($fd,filesize ($filepath));
	fclose ($fd); 
	
	$linebreak = "\n"; //for line breaks
	$linecounter = 0;
	$splitcontents = explode($linebreak, $fullcontents);
	//print_r($splitcontents);
	
	 $totallinecount = count($splitcontents); 
/*	$query77 = "select * from master_rfq where status=''  order by docno desc";
	$exec77 = mysql_query($query77) or die(mysql_error());
	$fetch=mysql_fetch_array($exec77);
	$docnum=$fetch['docno'];
	
	if($docnum=='')
	{
		
	$docnum='RFQU-1';
	}
	else
	{
	$splitnum=end(explode('-',$docnum));
	$docsplit=$splitnum+1;
	$docnum='RFQU-'.$docsplit;
		
	}
*/	
	//echo "<br>";
	
	foreach ( $splitcontents as $linecontent )
	{
		$forloopcount = $forloopcount + 1;
		//echo "<br>";
		if ($forloopcount > 3 && $forloopcount != 5  && $forloopcount < $totallinecount) // to skip header row. to skip last empty row to avoid empty array error.
		{
			//echo "<br><br>";
			$linecounter = $linecounter + 1;
			$linecontent; //contains the text of each line.
			
			$delimiter = "\t"; // for tab delimit breaks
			$delimitercount = 0;
			$splitdelimiter = explode($delimiter, $linecontent);
			
			if($forloopcount == 4)
			{
			$suppliername = $splitdelimiter[7];
			$suppliername = strtoupper($suppliername);
	
			$suppliercode = $splitdelimiter[10];
			$suppliercode = substr($suppliercode,1,7);
			$suppliercode = strtoupper($suppliercode);
	
			}
			else
			{
			$itemcode = $splitdelimiter[1];
			$itemcode = strtoupper($itemcode);
			$itemname = $splitdelimiter[2];
			$itemname = strtoupper($itemname);
			$strength = $splitdelimiter[3];
			$strength = strtoupper($strength);
			$category = $splitdelimiter[4];
			$category = strtoupper($category);
			$totalquantity = $splitdelimiter[5];
			$totalquantity = strtoupper($totalquantity);
			$packsize = $splitdelimiter[6];
			$packsize = strtoupper($packsize);
			$packagequantity = $splitdelimiter[7];
			$packagequantity = strtoupper($packagequantity);
			$totalrate = $splitdelimiter[8];
			$amount = strtoupper($totalrate);
			$rate = $splitdelimiter[9];
			$rate = strtoupper($rate);
			//$amount = $totalquantity * $rate;
			//$amount = strtoupper($amount);
			$countryoforigin = $splitdelimiter[10];
			$countryoforigin = strtoupper($countryoforigin);
			$expirydate = $splitdelimiter[11];
			$expirydate = strtoupper($expirydate);
	

			}
			
	
			
			preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname);
			
			if ($itemcode != '')
			{
			$query2 = "insert into master_rfq (medicinecode,medicinename,suppliername,suppliercode,packsize,quantity,packagequantity,rate,amount,countryoforigin,expirydate,username,companyanum,ipaddress,date,docno) values ('$itemcode','$itemname','$suppliername','$suppliercode','$packsize','$totalquantity','$packagequantity','$amount','$rate','$countryoforigin','$expirydate','$username','$companyanum','$ipaddress','$date','$docnum')";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		    $successcount = $successcount + 1;
		    }
			else
			{
			$skipcountunit = $skipcountunit + 1;
			}
		}
	}
	
	//echo $suppliercode;
	
	$query1 = "select * from purchase_rfq where docno='$docnum'";
	$exec1 = mysql_query($query1) or die(mysql_error());
	$numrows=mysql_num_rows($exec1);
	while($res1 = mysql_fetch_array($exec1))
	{
		$itemcode1=$res1['medicinecode'];
		$itemname=$res1['medicinename'];

		$totalquantity=$res1['quantity'];
		$packagequantity=$res1['packagequantity'];
		
	$query3 = "select * from master_rfq where docno='$docnum' and medicinecode='$itemcode1' and suppliercode='$suppliercode'";
	$exec3 = mysql_query($query3) or die(mysql_error());
	$numrows3=mysql_num_rows($exec3);
	
	if($numrows3==0)
	{
		$amount=0;
		$rate=0;
		$countryoforigin='';
		$expirydate='';
		
		
		$query11 = "select * from master_medicine where itemcode='$itemcode1' and status <> 'deleted' order by auto_number desc ";
		$exec11 = mysql_query($query11) or die ("Error in Query1".mysql_error());
		$res11 = mysql_fetch_array($exec11);
		$categoryname = $res11["categoryname"];
		$itemname_abbreviation = $res11["packagename"];
		
			$query2 = "insert into master_rfq (medicinecode,medicinename,suppliername,suppliercode,packsize,quantity,packagequantity,rate,amount,countryoforigin,expirydate,username,companyanum,ipaddress,date,docno) values ('$itemcode1','$itemname','$suppliername','$suppliercode','$itemname_abbreviation','$totalquantity','$packagequantity','$amount','$rate','$countryoforigin','$expirydate','$username','$companyanum','$ipaddress','$date','$docnum')";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		
	}
		
		
		
	}
	
	
	
	
header("location:uploadrtq.php?st=success&&upload=success&&billnumber=$docnum");
}
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
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">


</script>
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
                  <table width="83%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Item / Services Data Import From TAB Delimited File </strong></td>
                      </tr>
                      <tr>
                           <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                      </tr>
<!--  					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><?php //echo $importstarted; ?></td>
                      </tr>
                    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $totallinecount = $totallinecount - 1; ?><span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcountcategory; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcountservice; ?> <span class="bodytext3"></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> </td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcountunit; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcounttax; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $totalerrorcount = $skipcountcategory + $skipcountservice + $skipcountunit + $skipcounttax; ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $successcount; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><?php //echo $importfinished; ?></td>
                      </tr>
                      <tr>
                        <td width="28%" align="left" valign="top"  class="bodytext3">&nbsp;</td>
                        <td valign="top" align="left" width="72%" >&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
-->                    </tbody>
                  </table>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
