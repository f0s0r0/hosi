<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$colorloopcount = '';
$sno = '';
$snocount = '';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}
?>
</script>
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

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

<BODY LANG="en-US" TEXT="#000000" DIR="LTR">
<form action="viewtesttemplate.php" method="post" name="cbform1">
<TABLE WIDTH=592 CELLPADDING=7 CELLSPACING=0 STYLE="page-break-before: always">
	<COL WIDTH=281>
	<COL WIDTH=281>
	<TR VALIGN=TOP>
	  <TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
      <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western"><FONT FACE="Tahoma, sans-serif"><B>Respiratory
			System:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Cardiovasular
			System:</B></FONT><BR>
        </span></TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western"><FONT FACE="Tahoma, sans-serif"><B>Per Abdomen:</B></FONT></P>	  </TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Musculo-Skeletal
		System:</B></FONT></span></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Skin
		Integumentary System:</B></FONT></span></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Head
		&amp; Neck:</B></FONT></span></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>ENT:</B></FONT></span></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Eyes:</B></FONT></span></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Central
		Nervous System:</B></FONT></span></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><span class="western"><FONT FACE="Tahoma, sans-serif"><B>Other
		Notes:</B></FONT></span></TD>
	</TR>
	<?php
	$query1 = "select * from radiologyform";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
	while ($res1 = mysql_fetch_array($exec1))
	{
		$resp = $res1['resp'];
		$cardio = $res1['cardio'];
		$abdomen = $res1['abdomen'];
		$muscle = $res1['muscle'];
		$skin = $res1['skin'];
		$head = $res1['head'];
		$ent = $res1['ent'];
		$eyes = $res1['eyes'];
		$nerve = $res1['nerve'];
		$other = $res1['other'];
	?>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western"><?php echo $resp; ?></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $cardio; ?></TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $abdomen; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $muscle; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $skin; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $head; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $ent; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $eyes; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $nerve; ?></TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in"><?php echo $other; ?></TD>
	</TR>
	<?php }
	?>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western">&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western"><BR>
		</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
		</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
		</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
			</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
			</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
			</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
			</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY>&nbsp;</P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY><BR>
			</P>		</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	    <TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
	</TR>
	
               <tr>
	  <td colspan="15" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
	  </tr>
</TABLE>
</form>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
</BODY>
</HTML>