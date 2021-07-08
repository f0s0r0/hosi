
<?php
include ("../db/db_connect.php");

 $accname=isset($_REQUEST['accname'])?$_REQUEST['accname']:'';?>
<option value="">-Select Plan Name-</option>
<?php $query10 = "select auto_number,planname from master_planname where accountname = '$accname' and planexpirydate > NOW() and planstartdate <= NOW() and recordstatus = 'ACTIVE' order by planname";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		//$loopcount = $loopcount+1;
		$res10plannameanum = $res10["auto_number"];
		$res10planname=$res10["planname"];
        ?>
        <option value="<?php echo $res10plannameanum;?>"><?php echo $res10planname;?></option>
<?php }?>