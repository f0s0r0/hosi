<?php
$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = 'medit';
$databasename = 'avenue';

//Folder Name Change Only Necessary
$appfoldername = 'avenue';

$link = mysql_connect($hostname,$hostlogin,$hostpassword) or die('Could not connect Table : ' . mysql_error());
mysql_select_db($databasename) or die('Could not select database'. mysql_error());

//echo $_SERVER['REQUEST_URI'] ; //To get full url. 
$currentworkingdomain = $_SERVER['SERVER_NAME']; //To get only server name.
$currentworkingdomain = 'http://'.$currentworkingdomain;

$applocation1 = $currentworkingdomain.'/'.$appfoldername; //Used inside excel export options on reports module.
$databasename = $databasename; //Used inside autoitemsearch2.php / autoitemsearch2purchase.php

date_default_timezone_set('Africa/Nairobi'); 


?>