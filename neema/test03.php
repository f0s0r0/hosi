<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
 
/*$query2 = "select * from master_radiologytemplate where auto_number = 1 ";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2templatedata=$res2['templatedata'];*/

require_once('html2pdf/html2pdf.class.php');

    // get the HTML
    $content = file_get_contents('testtab.php');
	//$content = ob_get_clean();

    $content = '<page style="font-family: freeserif"><br />'.nl2br($content).'</page>';

    // convert to PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('utf8.pdf','D');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }