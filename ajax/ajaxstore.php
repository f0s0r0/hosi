<option value="">-Select Store-</option>
<?php 
include ("../db/db_connect.php");
$loc=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["storecode"];
				$res5name = $res5["store"];
				//$res5department = $res5["department"];
?><option value="<?php echo $res5anum;?>"><?php echo $res5name;?></option>
<?php }?>