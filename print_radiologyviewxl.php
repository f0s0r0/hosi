<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="radiologyitemviewxl.xls"');
header('Cache-Control: max-age=80');



//$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
//$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 $search=isset($_REQUEST['search'])?$_REQUEST['search']:'';
 $type=isset($_REQUEST['type'])?$_REQUEST['type']:'';
	$sno='';

?>
<style>
.xlText {
    mso-number-format: "\@";
}
</style>
<table border="0" width="1278">

<tr>
<td width="6" >&nbsp;</td>
<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Radiology Item View </strong></td>
 <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php //echo $locationcode ?></strong></td>
 </tr>
<tr>
<td colspan="6">&nbsp;</td>
  </tr>
 <tr>
 <td>&nbsp;</td>
 <td>
  <table width="1278" border="1" cellspacing="0" cellpadding="2">
            
            
             <tr bgcolor="#011E6A">
                       	 <td width="9%" bgcolor="#ffffff" class="bodytext3"><strong>S.NO </strong></td>
                        <td width="9%" bgcolor="#ffffff" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="12%" bgcolor="#ffffff" class="bodytext3"><strong>Category</strong></td>
                        <td width="28%" bgcolor="#ffffff" class="bodytext3"><strong>Radiology Item</strong></td>
                      
						<td width="5%" bgcolor="#ffffff" class="bodytext3"><div><strong>IP Markup</strong></div></td>
						<!--<td width="13%" bgcolor="#CCCCCC" class="bodytext3"><div><strong>Location</strong></div></td>-->
						 
                       </tr>
				<?php
		
		if($type=='active')	
		{
		
		
			$query1 = "select * from master_radiology where locationcode='$locationcode' and status <> 'deleted'  group by itemcode  order by auto_number desc ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		while ($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["location"];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$sno=$sno+1;
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		 /*?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */
		
		
		  
		?>
        <tr >
                        <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="radiologyitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>-->
                          <td align="left" valign="top"  class="bodytext3"><?php echo $sno; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                       <?php /*?><!-- <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>
						  <td align="center" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>
						 
        </tr>
                    
						 
                      <?php
		}
		}
		
		
           ?>
			
            
            
			  
			 	  
</table> </td>
</table>
