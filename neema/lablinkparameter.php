<?php
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$labcode = $_REQUEST['labcode'];
$sno=0;
$query13 = "select parametername,parametercode from master_test_parameter where labcode='$labcode'";
$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
if(mysql_num_rows($exec13)>0)
{
?>
<tr style="background:#CCC">
 <td>Parameter Name</td>
 <td>Parameter Code</td>
 </tr>
<?php
while ($res13 = mysql_fetch_array($exec13))
{
$referencename = $res13["parametername"];
$refcode = $res13["parametercode"];
$sno=$sno+1;
?>
<tr>
 <td><input name="parameter[]" type="text" id="parameter<?php echo $sno; ?>" size="35" value="<?php echo $referencename; ?>" readonly="readonly"></td>
 <td> <input name="parametercode[]" type="text" id="parametercode<?php echo $sno; ?>" size="20" value="<?php echo $refcode; ?>"></td>
 </tr>
<?php
}
}
else
{
$query13 = "select referencename from master_lab where itemcode='$labcode' and status<>'deleted'";
$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
if(mysql_num_rows($exec13)>0)
{
?>
<tr style="background:#CCC">
 <td>Parameter Name</td>
 <td>Parameter Code</td>
 </tr>
<?php
while ($res13 = mysql_fetch_array($exec13))
{
$referencename = $res13["referencename"];
$refcode = '';
$sno=$sno+1;
?>
<tr>
 <td><input name="parameter[]" type="text" id="parameter<?php echo $sno; ?>" size="35" value="<?php echo $referencename; ?>" readonly="readonly"></td>
 <td> <input name="parametercode[]" type="text" id="parametercode<?php echo $sno; ?>" size="20" value="<?php echo $refcode; ?>"></td>
 </tr>
<?php
}
}
}
?>