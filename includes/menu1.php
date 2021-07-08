<?php include "testincld.php" ?>

<link rel="stylesheet" type="text/css" href="css/default.css">
<!-- dd menu -->
<script type="text/javascript">
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 
// -->
</script>
<ul id="sddm">

<?php

$curredattim = date("Y-m-d H:i:s");
$curuser = $_SESSION['username'];

if(isset($_REQUEST['mainmenuid'])) { $mainmenuid = $_REQUEST['mainmenuid']; } else { $mainmenuid = ""; }
//echo $mainmenuid;
if(isset($_REQUEST['anum'])) { $anum = $_REQUEST['anum']; } else { $anum = ""; }
//echo $anum;

$pagename = $_SERVER['PHP_SELF'];
$page = substr($pagename,7);

$pagesd = basename($pagename,'.php');
$mmtext='';

if($mainmenuid == '')
{
	$query11 = "select * from master_menusub where submenulink like '%$pagesd%'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while($res11 = mysql_fetch_array($exec11))
	{
	$submenuid = $res11['submenuid'];
	$mainmenuid = $res11['mainmenuid'];
	}
}
if($mainmenuid != '')
{
$query12 = "select * from master_menumain where mainmenuid = '$mainmenuid'";
$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
$res12 = mysql_fetch_array($exec12);

$mmorder = $res12["mainmenuorder"];
$mmtext = $res12["mainmenutext"];
$mmlink = $res12["mainmenulink"];
$mmid = $res12["mainmenuid"];
}
 
$_SESSION['mmbgcolor'] = $mmtext;

$idletime=120000;//after 60 seconds the user gets logged out


$mmtext = $_SESSION['mmbgcolor'];
//on session creation
$_SESSION['timestamp']=time();

$randomnumber1 = date ("dmYHis");
$sessionusername = $_SESSION["username"];


$query1mm = "select * from master_menumain where status <> 'deleted' order by mainmenuorder";
$exec1mm = mysql_query($query1mm) or die ("Error in Query1mm".mysql_error());
while ($res1mm = mysql_fetch_array($exec1mm))
{
$mainmenuorder = $res1mm["mainmenuorder"];
$mainmenutext = $res1mm["mainmenutext"];
$mainmenulink = $res1mm["mainmenulink"];
$mainmenuid = $res1mm["mainmenuid"];

$query9 = "select * from master_employeerights where username = '$sessionusername' and mainmenuid = '$mainmenuid'";
$exec9 = mysql_query($query9) or die ("Error in query9".mysql_error());
$rowcount9 = mysql_num_rows($exec9);
if ($rowcount9 != 0)
{
	
?>
<!--	<li><a href="<?php echo $mainmenulink.'?rand='.$randomnumber1; ?>" ><?php echo $mainmenutext; ?></a><!--onmouseover="mopen('m<?php echo $mainmenuorder; ?>')" onmouseout="mclosetime()"-->
	
	<li><a href="<?php echo $mainmenulink ?>" ><input type="button" value="<?php echo $mainmenutext; ?>" class="menubutton" id="menubutton" <?php if($mainmenutext == $mmtext) { ?> style="background-color:#A4A4A4;color:#FFFFFF;" <?php } ?>  /></a><!--onmouseover="mopen('m<?php echo $mainmenuorder; ?>')" onmouseout="mclosetime()"-->
		<!--<?php
		$query1sm = "select * from master_menusub where mainmenuid = '$mainmenuid' and status <> 'deleted' order by submenuorder";
		$exec1sm = mysql_query($query1sm) or die ("Error in Query1sm".mysql_error());
		$rowcount1sm = mysql_num_rows($exec1sm);
		?>
		<div id="m<?php echo $mainmenuorder; ?>" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		<?php
		$query2sm = "select * from master_menusub where mainmenuid = '$mainmenuid' and status <> 'deleted' order by submenuorder";
		$exec2sm = mysql_query($query2sm) or die ("Error in Query2sm".mysql_error());
		while ($res2sm = mysql_fetch_array($exec2sm))
		{
		$submenuorder = $res2sm["submenuorder"];
		$submenutext = $res2sm["submenutext"];
		$submenulink = $res2sm["submenulink"];
		$submenuid = $res2sm["submenuid"];

		$query10 = "select * from master_employeerights where username = '$sessionusername' and submenuid = '$submenuid'";
		$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
		$rowcount10 = mysql_num_rows($exec10);
		if ($rowcount10 != 0)
		{
		?>
		<a href="<?php echo $submenulink.'?rand='.$randomnumber1;; ?>"><?php echo $submenutext; ?></a>
		<?php
		}
		}
		?>
		</div>-->
		<?php
		?>
	</li>
<?php
}
}
?>
</ul>
