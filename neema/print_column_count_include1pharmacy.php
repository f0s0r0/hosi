<?php

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and 
settingsname = 'SHOW_COLUMN_RATE'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumnrate = $res8["settingsvalue"];
if ($showcolumnrate == 'SHOW COLUMN RATE') $columncount = $columncount + 1;
//if ($showcolumnrate == 'HIDE COLUMN RATE') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_QUANTITY'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumnquantity = $res8["settingsvalue"];
if ($showcolumnquantity == 'SHOW COLUMN QUANTITY') $columncount = $columncount + 1;
//if ($showcolumnquantity == 'HIDE COLUMN QUANTITY') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_UNIT'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumnunit = $res8["settingsvalue"];
if ($showcolumnunit == 'SHOW COLUMN UNIT') $columncount = $columncount + 1;
//if ($showcolumnunit == 'HIDE COLUMN UNIT') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_TAX'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumntax = $res8["settingsvalue"];
if ($showcolumntax == 'SHOW COLUMN TAX') $columncount = $columncount + 1;
//if ($showcolumntax == 'HIDE COLUMN TAX') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_DISCOUNT'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumndiscount = $res8["settingsvalue"];
if ($showcolumndiscount == 'SHOW COLUMN DISCOUNT') $columncount = $columncount + 2;
//if ($showcolumndiscount == 'HIDE COLUMN DISCOUNT') $columncount = $columncount - 2;


$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_FREE_QUANTITY'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumnfreequantity = $res8["settingsvalue"];
if ($showcolumnfreequantity == 'SHOW COLUMN FREE QUANTITY') $columncount = $columncount + 1;
//if ($showcolumndiscount == 'HIDE COLUMN FREE') $columncount = $columncount - 1;



$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_TOTAL_QUANTITY'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumntotalquantity = $res8["settingsvalue"];
if ($showcolumntotalquantity == 'SHOW COLUMN TOTAL QUANTITY') $columncount = $columncount + 1;
//if ($showcolumndiscount == 'HIDE COLUMN TOTAL QUANTITY') $columncount = $columncount - 1;


$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_BATCH_NUMBER'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumnbatchnumber = $res8["settingsvalue"];
if ($showcolumnbatchnumber == 'SHOW COLUMN BATCH NUMBER') $columncount = $columncount + 1;
//if ($showcolumndiscount == 'HIDE COLUMN BATCH NUMBER') $columncount = $columncount - 1;


$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and submodulename = 'PHARMACY' and  
settingsname = 'SHOW_COLUMN_EXPIRY_DATE'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$showcolumnexpirydate = $res8["settingsvalue"];
if ($showcolumnexpirydate == 'SHOW COLUMN EXPIRY DATE') $columncount = $columncount + 1;
//if ($showcolumndiscount == 'HIDE COLUMN EXPIRY DATE') $columncount = $columncount - 1;

//echo $columncount;



?>