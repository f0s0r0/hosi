<?php
session_start();
require_once('html2pdf/html2pdf.class.php');
include ("db/db_connect.php");
/*	$data = file_get_contents("template.pdf");
	// This is important to avoid a ' to accidentally close a string
	$data = mysql_real_escape_string($data);
	mysql_query("INSERT INTO master_radiologytemplate(templatedata) VALUES ('".addslashes($data)."')");*/
?>
<?php	
$sql = "SELECT templatedata FROM master_radiologytemplate WHERE auto_number =7";
$result = mysql_query($sql) or die('Bad query!'.mysql_error());  

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){        
    $db_pdf = $row['templatedata']; // No stripslashes() here.
}

echo $db_pdf;
/*ader("Content-Type: application/pdf");
header("Content-Length: ".strlen($db_pdf)); 
header('Content-Disposition: attachment; filename='.$db_filename);
echo $db_pdf;*/
?>
