<?php 
include ("../db/db_connect.php");
$loc=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$query5 = "select * from master_department where recordstatus = '' AND locationcode = '".$loc."' order by department";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5department = $res5["department"];
?><option value="<?php echo $res5anum;?>"><?php echo $res5department;?></option>
<?php }?>