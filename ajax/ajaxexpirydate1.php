<?php
include ("../db/db_connect.php");

 $accname=isset($_REQUEST['accname'])?$_REQUEST['accname']:'';?>

<?php $query10 = "select expirydate from master_accountname where accountname = '$accname' and expirydate > NOW() and recordstatus <> 'deleted' ";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		$res10 = mysql_fetch_array($exec10);
		
		//$res10plannameanum = $res10["auto_number"];
	echo	$expdate=$res10["expirydate"];
		//$exodate=
        ?>
      