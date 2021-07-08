<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	include ("backupdatabasecode1.php");
	
	header ("location:backupdatabase1.php?st=success");
	exit;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	
	$query3 = "select * from master_backupdatabase where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$deletefilename = $res3['backupfilename'];
	
	unlink('zbackupdatabasefiles/'.$deletefilename.'');

	$query3 = "delete from master_backupdatabase where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

	header ("location:backupdatabase1.php?st=deleted");
	exit;
}
if ($st == 'success')
{
	$errmsg = "Success. Database Backup Completed. Please Download & Save File From List Given Below For Future Reference.";
	$bgcolorcode = 'success';
}
if ($st == 'deleted')
{
	$errmsg = "Success. Database Delete Completed.";
	$bgcolorcode = 'success';
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
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

function funcTakeBackup1()
{
	var fRet;
	fRet = confirm('Are You Sure Want To Take Database Backup Now?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Proceeding To Take Database Backup. Please Wait A Moment.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Database Backup Not Completed.");
		return false;
	}
	//return false;
}

function funcDeleteBackup1(varDeleteFileName)
{
	var varDeleteFileName = varDeleteFileName;
	var fRet;
	fRet = confirm('Are You Sure Want To Delete Database Backup File '+varDeleteFileName+' ?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Success. Database Backup Delete Completed");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Failed. Database Backup Delete Not Completed.");
		return false;
	}
	//return false;
}

/*
function funcDownloadBackup1(varDownloadFileName)
{
	var varDownloadFileName = varDownloadFileName;
	window.location = "zbackupdatabasefiles/"+varDownloadFileName+"";
}
*/

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
              <td><form name="form1" id="form1" method="post" action="backupdatabase1.php">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Database Backup - Click Button To Take Backup of Database </strong></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
                            <div align="center">
                              <input type="hidden" name="frmflag1" value="frmflag1" />
                              <input type="submit" name="Submit" onClick="return funcTakeBackup1()" value="Click To Take Database Backup Now" style="border: 1px solid #001E6A" />
                            </div></td>
                        </tr>
                      <tr>
                        <td align="middle" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Backup -  Existing List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>File Name </strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>File Date Time </strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Download </strong></div></td>
                      </tr>
                      <?php
					$query1 = "select * from master_backupdatabase order by auto_number desc";
					$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
					while ($res1 = mysql_fetch_array($exec1))
					{
					$auto_number = $res1["auto_number"];
					$backupfilename = $res1["backupfilename"];
					$backupfiledate = $res1["backupfiledate"];
			
					$colorloopcount = $colorloopcount + 1;
					$showcolor = ($colorloopcount & 1); 
					if ($showcolor == 0)
					{
						$colorcode = 'bgcolor="#CBDBFA"';
					}
					else
					{
						$colorcode = 'bgcolor="#D3EEB7"';
					}
					  
					?>
					<tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
						<a href="backupdatabase1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteBackup1('<?php echo $backupfilename; ?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="58%" align="left" valign="top"  class="bodytext3"><?php echo $backupfilename; ?> </td>
                        <td width="36%" align="left" valign="top"  class="bodytext3"><?php echo $backupfiledate; ?></td>
                        <td width="36%" align="left" valign="top"  class="bodytext3">
						<a href="backupdatabasedownload1.php?filename=<?php echo $backupfilename; ?>">
						<div align="center">Download</div></a></td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                </td>
            </tr>
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

