<?php
session_start();
require_once('html2pdf/html2pdf.class.php');
include ("db/db_connect.php");

$sql = "SELECT templatedata FROM master_radiologytemplate WHERE auto_number =1";
$result = mysql_query($sql) or die('Bad query!'.mysql_error());  

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){        
    $db_pdf = $row['templatedata']; // No stripslashes() here.
}

header("Content-Type: application/pdf");
header("Content-Length: ".strlen($db_pdf)); 
header('Content-Disposition: attachment; filename=fkj.pdf');
echo $db_pdf;

?>
