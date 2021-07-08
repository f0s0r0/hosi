<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$rateperunit = "0";
$purchaseprice = "0";
$checkboxnumber = '';
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
if (isset($_POST["searchflag1"])) { $searchflag1 = $_POST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_POST["search1"])) { $search1 = $_POST["search1"]; } else { $search1 = ""; }
if (isset($_POST["location"])) { $location = $_POST["location"]; } else { $location = ""; }
if (isset($_POST["store"])) { $store = $_POST["store"]; } else { $store = ""; }

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>

<script>

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

</script>

<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearchsupplier.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function funcSelectStore()
{
	<?php 
	$query12 = "select * from master_location where status <> 'deleted'";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12anum = $res12["auto_number"];
	$res12locationcode = $res12["locationcode"];
	?>
	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{
		document.getElementById("store").options.length=null; 
		var combo = document.getElementById('store'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
		<?php
		$query10 = "select * from master_store where location = '$res12anum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10anum = $res10["auto_number"];
		$res10store = $res10["store"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}

function form1valid()
{
	if(document.getElementById("location").value == "")
	{
		alert('Select Location');
		document.getElementById("location").focus();
		return false;
	}
}

function form2Valid()
{
	if(document.getElementById("locationcode").value == "")
	{
		alert('Select Location');
		document.getElementById("locationcode").focus();
		return false;
	}
	if(document.getElementById("paynowcashcoa").value == "")
	{
		alert('Select Supplier');
		document.getElementById("paynowcashcoa").focus();
		return false;
	}
}
</script>
<body onLoad="return process2()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="1050" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
                <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Item Master - Existing List - Latest 100 Items </strong></span></td>
                        <td colspan="5" align="center" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo":Select Location";
						//echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td> 
                      </tr>
						<?php
						if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
						//echo $st;
						if ($st == 'success') 
						{
						//echo "Item Mapping To Supplier Completed.";
						?>
                      <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#CCFF00" class="bodytext3">
						Item Mapping To Supplier Completed.&nbsp;</td>
                      </tr>
						<?php
						}
						?>
						<form name="form1" id="form1" action="additemtosupplier1.php" method="post" onSubmit="return form1valid();">
                      <tr bgcolor="#011E6A">
                        <td bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong> </td>
						<td bgcolor="#FFFFFF" class="bodytext3"><select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
					  <option value="">Select Location</option>
					  <?php
					  $query7 = "select * from master_location where status <> 'deleted'";
					  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
					  while($res7 = mysql_fetch_array($exec7))
					  {
					  $res7locationcode = $res7['locationcode'];
					  $res7locationname = $res7['locationname'];
					  ?>
					  <option value="<?php echo $res7locationcode; ?>" <?php if($location == $res7locationcode) { echo "selected"; } ?>><?php echo $res7locationname; ?></option>
					  <?php
					  }
					  ?>
					  </select></td>
					   <td colspan="8" bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong>&nbsp;&nbsp;<input type="hidden" name="store" id="store">
					  </td>
                      </tr>
					   <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />
						 </td>
                      </tr>
					   </form>	
                      <tr bgcolor="#011E6A">
                        <td width="4%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Select</strong></div></td>
                        <td width="7%" bgcolor="#CCCCCC" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="14%" bgcolor="#CCCCCC" class="bodytext3"><strong>Category</strong></td>
                        <td width="24%" bgcolor="#CCCCCC" class="bodytext3"><strong>Item</strong></td>
                        <td width="24%" bgcolor="#CCCCCC" class="bodytext3"><strong>Supplier</strong></td>
                        <td width="5%" bgcolor="#CCCCCC" class="bodytext3"><strong>Unit</strong></td>
                        <td width="4%" bgcolor="#CCCCCC" class="bodytext3"><strong>Tax%</strong></td>
                        <td width="6%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Purchase</strong></div></td>
                        <td width="7%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Selling</strong></div></td>
                        <td width="4%" bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
                      </tr>
 		 <form name="form2" id="form2" action="additemtosupplier2.php" method="post" onSubmit="return form2Valid();">
                     <?php
	  if ($searchflag1 == 'searchflag1')
	  {
					  
		$search1 = $_REQUEST["search1"];			  
	    $query1 = "select * from master_itempharmacy where itemname like '%$search1%' and status <> 'deleted' order by auto_number limit 0,100";// desc LIMIT 100";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$unitname_abbreviation = $res1["unitname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#D3EEB7"';
		}
		
		$query7 = "select * from master_itemtosupplier where itemcode = '$itemcode' and recordstatus <> 'deleted'";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$res7 = mysql_fetch_array($exec7);
		$res7suppliername = $res7['suppliername'];
		  
		$checkboxnumber = $checkboxnumber + 1;
		?>
        <tr <?php echo $colorcode; ?>>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center">
						<?php echo $checkboxnumber; ?>
                          <input type="checkbox" value="<?php echo $itemcode; ?>" name="checkbox<?php echo $checkboxnumber; ?>" id="checkbox<?php echo $checkboxnumber; ?>">
						</div><input type="hidden" name="locationcode" id="locationcode" value="<?php echo $location; ?>"></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res7suppliername; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $unitname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $purchaseprice; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		}
	}
		?>
        <tr>
          <td colspan="10" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
		  <input type="text" name="suppliercoa" id="paynowcashcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('6')" value="Map" accesskey="m" style="border: 1px solid #001E6A">
						 <input type="hidden" name="paynowlabtype6" id="paynowcashtype" size="10"/>
						 <input type="hidden" name="suppliercode" id="paynowcashcode" size="10"/>
		  <span class="bodytext32">
		  <input name="frmflag1" id="frmflag1" value="frmflag1" type="hidden">
		  <input name="checkboxcount" id="checkboxcount" value="<?php echo $checkboxnumber; ?>" type="hidden">
		  <input type="submit" name="Submit22" value="Submit" style="border: 1px solid #001E6A" />
		  </span>		  </td>
          </tr>
		  </form>		   
                    </tbody>
                  </table>
				  
			    </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

