<?
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION[username];
$frmflag1 = $_POST[frmflag1];
if ($frmflag1 == 'frmflag1')
{
	$alertmessage = $_REQUEST[alertmessage];
	//$alertmessage = strtoupper($alertmessage);
	$alertmessage = trim($alertmessage);
	$length=strlen($alertmessage);
	//echo $length;
	$query1 = "insert into master_alertmessage (alertmessage, updatedby, ipaddress, status) 
	values ('$alertmessage', '$username', '$ipaddress', '')";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$errmsg = "Success. New Alert Message Updated.";
	$bgcolorcode = 'success';
}

$st = $_REQUEST[st];
if ($st == 'del')
{
	$delanum = $_REQUEST[anum];
	$query3 = "update master_alertmessage set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST[anum];
	$query3 = "update master_alertmessage set status = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_nbGroup(event, grpName) { //v6.0
  var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])? args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) {
      img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr)
      for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}
//-->
</script>
<?
/*session_start();
$auto_number=$_SESSION[session_auto_number_post_job];//post job auto number
*/
?>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function process1()
{
	//alert ("Inside Funtion");
	if (document.form1.alertmessage.value == "")
	{
		alert ("Pleae Enter Alert Message.");
		document.form1.alertmessage.focus();
		return false;
	}
}

</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><? include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><? include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><? include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="addalertmessage1.php" onKeyDown="return disableEnterKey()" onSubmit="return process1()">
                  <table width="57%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Alert Message Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle" bordercolor="#F3F3F3"  
						bgcolor="<? if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><? echo $errmsg; ?></div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><div align="right">Alert Message Name </div></td>
                        <td align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF">
						  <textarea name="alertmessage" cols="40" rows="5" id="alertmessage" style="border: 1px solid #001E6A;"></textarea></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top" bordercolor="#F3F3F3" class="bodytext3">&nbsp;</td>
                        <td valign="top" align="left" width="58%" bordercolor="#F3F3F3"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
					 
					  </tbody>
                  </table>
                <table width="57%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Alert Message  Master - Existing List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="6%" bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Alert Message</strong></td>
                        </tr>
                      <?
	    $query1 = "select * from master_alertmessage where status <> 'deleted' order by auto_number ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$alertmessage = $res1['alertmessage'];
		$auto_number = $res1['auto_number'];
		$defaultstatus = $res1['defaultstatus'];
		$updatedby = $res1['updatedby'];
		$updatetime = $res1['updatetime'];
		?>
                      <tr>
                        <td align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="addalertmessage1.php?st=del&&anum=<? echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="76%" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><? echo $alertmessage; ?> </td>
                        <td width="18%" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><? echo strtoupper($updatedby).'<br>'.$updatetime; ?>&nbsp;</td>
                      </tr>
                      <?
		}
		?>
                      <tr>
                        <td align="middle" colspan="3" bordercolor="#F3F3F3">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				  <table width="57%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Alert Message  Master -Deleted List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="6%" bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Alert Message</strong></td>
                        </tr>
                      <?
	    $query1 = "select * from master_alertmessage where status = 'deleted' order by auto_number ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$alertmessage = $res1['alertmessage'];
		$auto_number = $res1['auto_number'];
		$defaultstatus = $res1['defaultstatus'];
		$updatedby = $res1['updatedby'];
		$updatetime = $res1['updatetime'];
		?>
                      <tr>
                        <td align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="addalertmessage1.php?st=activate&&anum=<? echo $auto_number; ?>"><div class="bodytext3">Activate</div></a></div></td>
                        <td width="76%" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><? echo $alertmessage; ?> </td>
                        <td width="18%" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32"><? echo strtoupper($updatedby).'<br>'.$updatetime; ?></span></td>
                      </tr>
                      <?
		}
		?>
                      <tr>
                        <td align="middle" colspan="3" bordercolor="#F3F3F3">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                �</td>
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
<? include ("includes/footer1.php"); ?>
</body>
</html>

