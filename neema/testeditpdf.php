<?php
session_start();
require_once('html2pdf/html2pdf.class.php');
include ("db/db_connect.php");

$sql = "INSERT INTO master_radiologytemplate VALUES(";
$result = mysql_query($sql) or die('Bad query!'.mysql_error());  

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){        
    $db_pdf = $row['templatedata']; // No stripslashes() here.
}

?>
