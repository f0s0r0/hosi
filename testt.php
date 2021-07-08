<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';
?>
<form enctype="multipart/form-data" method="post" role="form">
        <div class="form-content">
            <h1>Traded Securities Data Upload</h1>

            <div><label for="exampleInputFile">File Upload: </label><br><input type="file" name="file" id="file"><p style="font-size: .8em; color: rgb(51,0,255);">Only Excel/CSV File to be uploaded.</p></div>
            <div><button type="submit" id="Import" class="btn btn-default" name="Import" value="Import">Upload</button></div>

          </div><!--end of form content div--><br class="clear-fix">
            </form>
			
    <?php 
    if(isset($_POST["Import"])){
	$filename=$username."_tabdump.txt";
	$photodate = date('y-m-d');
	$foldername = "tab_file_dump//";
	 $filename = $foldername.$filename;
 	
        if($_FILES["file"]["size"] > 0){
            $file = fopen($filename, "r");
            $count = 0;     
			$fullcontents = fread ($file,filesize ($filename));
        }
            else{
            echo 'Invalid File:Please Upload CSV File';} 
    } // close first if
?>