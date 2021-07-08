
<?php
include ("../db/db_connect.php");

 $loccode=isset($_REQUEST['loccode'])?$_REQUEST['loccode']:'';?>
<strong>Location: </strong>
<?php  $query10 = "select locationname from master_location where locationcode='".$loccode."' and status <> 'deleted'";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		$res10 = mysql_fetch_array($exec10);
		
		//$loopcount = $loopcount+1;
		//$res10plannameanum = $res10["auto_number"];
		echo $locationname=$res10["locationname"];
        ?>
       