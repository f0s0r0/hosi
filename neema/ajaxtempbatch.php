 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$medcod=isset($_REQUEST['medcod'])?$_REQUEST['medcod']:'';
$mednam=isset($_REQUEST['mednam'])?$_REQUEST['mednam']:'';
$batnam=isset($_REQUEST['batnam'])?$_REQUEST['batnam']:'';
$avlqty=isset($_REQUEST['avlqty'])?$_REQUEST['avlqty']:'';
$medkey=isset($_REQUEST['medkey'])?$_REQUEST['medkey']:'';
$fifo=isset($_REQUEST['fifo'])?$_REQUEST['fifo']:'';
//$autkey=isset($_REQUEST['autkey'])?$_REQUEST['autkey']:'';
//$autkey=35;


$query66 ="insert into tempmedicineqty(medicinename,medicinecode,batchname,availableqty,medicinekey,fifo_code)values('".$mednam."','".$medcod."','".$batnam."','".$avlqty."','".$medkey."','".$fifo."')";
				
				$exec66 = mysql_query($query66) or die(mysql_error());
	//	echo	$curid =	"SELECT SCOPE_IDENTITY($exec66)";
	//	echo insert_id($exec66);
	//	echo $exec66->insert_id;
		echo mysql_insert_id();
		//echo "f";

?>


