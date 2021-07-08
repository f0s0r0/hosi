
<?php
include ("../db/db_connect.php");

 $visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';?>

<?php  $query10 = "select visitcode from depositrefund_request where visitcode='".$visitcode."'";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		$res10 = mysql_fetch_array($exec10);
		$numrows = mysql_num_rows($exec10);
		
		//$loopcount = $loopcount+1;
		//$res10plannameanum = $res10["auto_number"];
		echo $numrows;
        ?>
       