<?php
$query2showlogo = "select * from settings_billpharmacy where companyanum = '$companyanum'";
$exec2showlogo = mysql_query($query2showlogo) or die ("Error in Query2showlogo".mysql_error());
$res2showlogo = mysql_fetch_array($exec2showlogo);
$showlogo = $res2showlogo['showlogo'];
if ($showlogo == 'SHOW LOGO')
{
?>	
<td width="14%"><img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" /></td>
<?php
}
?>