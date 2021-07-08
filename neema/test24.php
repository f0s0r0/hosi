<?php
include('db/db_connect.php');
?>
<html>
<body>
<table width="100" border="1" style="border-collapse:collapse;">
<tr>
<td colspan="30"><strong>Medicine master</strong></td>
</tr>
<tr>
<td valign="top">
<table border="1" width="200" style="border-collapse:collapse;">
<tr>
<?php
$i=0;
$query1 = "select * from master_medicine limit 27";
$exec1 = mysql_query($query1);
while($res1 = mysql_fetch_array($exec1))
{
$i +=1;
?>
<td valign="top"><?php echo substr($res1['itemname'],0,10); ?></td>
<?php
if($i % 10 == 0)
{
	echo '</td></tr><tr>';
}
}
?>
</table>
</tr>
</table>
</body>
</html>