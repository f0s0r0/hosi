
<?php
include ("db/db_connect.php");

$pagename = '';

if (isset($_COOKIE["logout"]) && $_COOKIE["logout"]=='shiftout' && basename($_SERVER['PHP_SELF'])!='shiftwisereport2.php' && basename($_SERVER['PHP_SELF'])!='shiftwisereportdetailed2.php'){ header ("location:shiftwisereport2.php?anum=254");}

if (!isset($_SESSION["username"])) header ("location:index.php");

if (isset($_SESSION['username'])) { $username1 = $_SESSION['username']; } else { $username1 = ""; }

$query1 = "select * from login_restriction where username = '$username1'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$rowcount1 = mysql_num_rows($exec1);
//$logincount = $res1['rowcount1'];
$res1sessionid = $res1['sessionid'];
//echo '<br>'.session_id();

//$query2 = "select * from master_edition where status = 'ACTIVE'";
//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
//$res2 = mysql_fetch_array($exec2);
//$res2usercount = $res2['users'];
//if ($logincount > $res2usercount)
//{
if ($res1sessionid != session_id())
{
	//echo 'inside if';
	//header ("location:login1restricted1.php");
	//exit;
}


//echo $_SESSION[companyanum];
if (!isset($_SESSION["companyanum"])) // if the variable is set.
{
	header ("location:setactivecompany1.php"); 
}
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION["username"];

$pagename = basename($_SERVER['REQUEST_URI'], ".php");

$query881 = "select * from master_menumain where mainmenulink='$pagename'";
$exec881 = mysql_query($query881) or die(mysql_error());
$res881 = mysql_fetch_array($exec881);
$menumainid = $res881['mainmenuid'];

$query882 = "select * from master_employeerights where mainmenuid='$menumainid' and username='$username'";
$exec882 = mysql_query($query882) or die(mysql_error());
$num882 = mysql_num_rows($exec882);

$_SESSION['timeout'] = time();

?>
