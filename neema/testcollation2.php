<?php
include ("db/db_connect.php");
$i=0;
$table = isset($_REQUEST['table']) ? $_REQUEST['table'] : '';
$column = isset($_REQUEST['column']) ? $_REQUEST['column'] : '';

if(isset($_REQUEST['frmflag'])) { $frmflag = $_REQUEST['frmflag']; } else { $frmflag = ''; }
if($frmflag == 'frmflag')
{
	$column = $_REQUEST['column'];
	
	if($column != '')
	{
	echo '<br>'.$query = "ALTER TABLE $table CHANGE $column $column varchar(255) CHARACTER SET `latin1` COLLATE `latin1_general_ci` NOT NULL";
	mysql_query($query) or die ("Error in Query".mysql_error());
	}
}
?>
<form method="post" action="testcollation2.php?table=<?= $table; ?>">
<?php
	$query1 = "SHOW FULL COLUMNS FROM $table";
	$exec1 = mysql_query($query1) or die ("Error".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
		echo '<br>'.($res1['Field']).' --> '.($res1['Collation']);
	}
?>	
<input type="hidden" name="frmflag" id="frmflag" value="frmflag" />
<input type="hidden" name="table" id="table" value="<?php echo $table; ?>" />
<br />
<br />
<input type="text" name="column" id="column" value="<?php echo ''; ?>" />
<br />
<br />
<input type="submit" name="submit" value="Submit" />
</form>