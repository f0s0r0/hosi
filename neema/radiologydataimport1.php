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

if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }
if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; } 
 if (isset($_REQUEST["dellocation"])) {  $dellocation = $_REQUEST["dellocation"]; } else { $dellocation = ""; } 
//$upload = $_REQUEST['upload'];

	$query1 = "select * from master_location where status!='deleted' and locationcode='$location'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$locationname = $res1["locationname"];
					

if($dellocation!='')
{
	 $query="delete from master_radiology where locationcode='$dellocation'"; 
	$exec=mysql_query($query);
	header ("location:radiologydataimport.php?upload=deleted");
}

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
	//echo "<br>";
	
	foreach ( $splitcontents as $linecontent )
	{
		$forloopcount = $forloopcount + 1;
		//echo "<br>";
		if ($forloopcount > 1 && $forloopcount < $totallinecount) // to skip header row. to skip last empty row to avoid empty array error.
		{
			//echo "<br><br>";
			$linecounter = $linecounter + 1;
			$linecontent; //contains the text of each line.
			
			$delimiter = "\t"; // for tab delimit breaks
			$delimitercount = 0;
			$splitdelimiter = explode($delimiter, $linecontent);
			$itemcode = $splitdelimiter[1];
			$itemcode = strtoupper($itemcode);
			$itemname = $splitdelimiter[2];
			$itemname = strtoupper($itemname);
			$categoryname= $splitdelimiter[0];
			$categoryname = strtoupper($categoryname);
			//$sampletype= $splitdelimiter[4];
			$sampletype = '';
			//$itemname_abbreviation = $splitdelimiter[5];
			$itemname_abbreviation = 'RADIOLOGY';
			//$referencename= $splitdelimiter[6];
			$referencename = '';
			$pkg= $splitdelimiter[5];
			$pkg = strtolower($pkg); 
			//$referencerange= $splitdelimiter[8];
			$referencerange = '';
			$rateperunit = $splitdelimiter[3];
			//$rateperunit = strtoupper($rateperunit);
			$rate2 = $splitdelimiter[4];
			//$rate2 = strtoupper($rate2);
			//$referencevalue = $splitdelimiter[11];
			$referencevalue = '';
			$itemname = str_replace("'","",$itemname);
			preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname);
			
			if ($itemcode != '' && $location!='')
			{	
				$query89 = "select * from master_radiology where itemcode = '$itemcode' and locationcode = '$location'";
				$exec89 = mysql_query($query89) or die ("Error in Query89".mysql_error());
				$row89 = mysql_num_rows($exec89);
				if($row89 == 0)
				{	
					$query2 = "insert into master_radiology (itemcode,itemname,categoryname,itemname_abbreviation,rateperunit,ipmarkup,pkg,locationcode,locationname,ipaddress) values ('$itemcode','$itemname','$categoryname','$itemname_abbreviation','$rateperunit','$rate2','$pkg','$location','$locationname','$ipaddress')";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
					$successcount = $successcount + 1;
				}	
		    }
			else
			{
			$skipcountunit = $skipcountunit + 1;
			}
		}
	}
header("location:radiologydataimport.php?st=success");
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
