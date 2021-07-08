 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$actkey=isset($_REQUEST['actkey'])?$_REQUEST['actkey']:'';
$autkey=isset($_REQUEST['autkey'])?$_REQUEST['autkey']:'';
$delkey=isset($_REQUEST['delkey'])?$_REQUEST['delkey']:'';

if($actkey==1)
{
	$query66 ="DELETE FROM tempmedicineqty WHERE medicinekey = '".$delkey."'";
				
				$exec66 = mysql_query($query66) or die(mysql_error());
	}
	else
	{
	$query66 ="DELETE FROM tempmedicineqty WHERE auto_number = '".$autkey."'";
				
				$exec66 = mysql_query($query66) or die(mysql_error());
			//	echo "fasdfadsfadsfasdf";
	}

?>


 