<?php
session_start();
include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
error_reporting(0);
$ipaddress = $_SERVER["REMOTE_ADDR"];
$action = $_REQUEST['action'];
$updatedatetime = date('Y-m-d H:i:s');
$todaydate = date('Y-m-d');
if($action=='sessioncheck')
{
	if (isset($_SESSION["username"]))
	{
		$user = $_SESSION['username'];
		$inactive = $_SESSION['timelimit'] * 60; 
		$session_life = time() - $_SESSION['timeout'];
	}
	else
	{
		$user = $_REQUEST['username'];
		$inactive = $_REQUEST['timelimit'] * 60; 
		$session_life = time() - $_REQUEST['timeout'];
	}
	if (isset($_COOKIE["logout"])) { $logout = $_COOKIE["logout"]; } else { $logout = ""; }
	
	if($logout=='login')
	{
		if($session_life > $inactive)
		{  
			echo 1;
			if (isset($_SESSION["logintime"])) { $logintime = $_SESSION["logintime"]; } else { $logintime = ""; }
			if($logintime!='')
			{
				$username = $_REQUEST["username"];
				$query1 = "update details_login set logouttime = '$updatedatetime' where username = '$username' and logintime = '$logintime'";
				$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
				session_destroy();
				session_start();
			}
		}
		else
		{
			echo 0;		
		}
	}
	else if($logout=='logout')
	{
		//echo $_COOKIE["logout"];
		echo 2;
	}
	else if($logout=='shiftout')
	{
		echo 3;
	}
}

if($action=='loginuser')
{
	$username = $_REQUEST['username'];
	$password =base64_encode($_POST["password"]);
	//$sessionid = session_id();
	$totalclosingcash = '';
	$locdocno = $_REQUEST["locdocno"];
	//session_start();
	session_destroy();
	session_start();
	session_regenerate_id();
	$sessionid = session_id();
	
	$query1 = "select validitydate,cashlimit from master_employee where username = '$username' and password = '$password'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$rowcount1 = mysql_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		echo '0||0||0';
	}
	else
	{
		$res1 = mysql_fetch_array($exec1);
		$validitydate = $res1['validitydate'];
		$cashlimit = $res1['cashlimit'];
		$validitydatestr = strtotime($validitydate);
		$todaydatestr = strtotime($todaydate);		
		if($validitydatestr >= $todaydatestr)
		{			
			$query2 = "select auto_number from details_login  order by auto_number desc limit 0, 1";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$billnumber = $res2["auto_number"];
			$billdigit=strlen($billnumber);
			if ($billnumber == '')
			{
			$billnumbercode ='1';
			$openingbalance = '0.00';
			}
			else
			{
			$billnumber = $res2["auto_number"];
			$billnumbercode = intval($billnumber);
			$billnumbercode = $billnumbercode + 1;	
			$maxanum = $billnumbercode;		
			$billnumbercode = $maxanum;
			}
			
			$_SESSION["username"] = $username;
			$_SESSION["timelimit"] = $cashlimit;
			$_SESSION["logintime"] = $updatedatetime;	 
			$_SESSION["timestamp"] = time();
			$_SESSION['timeout'] = time();	
			$_SESSION["docno"] = $billnumbercode;		
			setcookie('logout','login', time() + (86400 * 1));
						
			$query2 = "insert into details_login (docno,username, logintime, openingcash,lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 
			value ('$billnumbercode','$username', '$updatedatetime', '0', '$updatedatetime', '$ipaddress', '$username', '$sessionid')";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
			$query4 = "delete from login_restriction where username = '$username'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			
			$query3 = "insert into login_restriction (username, logintime, 
			lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 
			value ('$username', '$updatedatetime', 
			'$updatedatetime', '$ipaddress', '$username', '$sessionid')";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());	
			
			$query5 = "select locationname,locationcode from login_locationdetails where docno='$locdocno'";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			while($res5 = mysql_fetch_array($exec5))
			{
				$locationname = $res5['locationname'];
				$locationcode = $res5['locationcode'];
				$query7 = "insert into login_locationdetails (docno,username,locationname , locationcode) 
					value ('$billnumbercode','$username','$locationname','$locationcode')";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			}
			
			$query6 = "select companyname,companycode,auto_number from master_company order by auto_number limit 0, 1";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6companyname = $res6["companyname"];
			$res6companycode = $res6["companycode"];
			$dfcompanyanum = $res6['auto_number'];
			$_SESSION["companyanum"] = $dfcompanyanum;
			$_SESSION["companyname"] = $res6companyname;
			$_SESSION["companycode"] = $res6companycode;			
			$_SESSION["companyanum"] = $dfcompanyanum;
			$_SESSION["companyname"] = $res6companyname;
			$_SESSION["companycode"] = $res6companycode;
			//exit;
			$query7 = "select settingsvalue from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
			settingsname = 'CURRENT_FINANCIAL_YEAR'";
			$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			$res7 = mysql_fetch_array($exec7);
			$financialyear = $res7["settingsvalue"];
			
			$_SESSION["financialyear"] = $financialyear;
		}
		echo '1||'.time().'||'.$billnumbercode;
	}
}

if($action=='logoutuser')
{
	setcookie('logout','logout', time() + (86400 * 1));
	echo 'logout';
}
?>