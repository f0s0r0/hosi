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
	<li><a href="<?php echo $mainmenulink.'?rand='.$randomnumber1; ?>" onmouseover="mopen('m<?php echo $mainmenuorder; ?>')" onmouseout="mclosetime()"><?php echo $mainmenutext; ?></a>
		<?php
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
		</div>
		<?php
		?>
	</li>
<?php
}
}
?>
</ul>
