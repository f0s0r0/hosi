<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$logintime = $_SESSION["logintime"];
$docno = $_SESSION["docno"];
$errmsg = '';
$locationname='';
$locationcode='';
$query7 = "select * from master_company order by auto_number limit 0, 1";
$exec7 = mysql_query($query7) or die ("Error in Query8".mysql_error());
$res7rowcount = mysql_num_rows($exec7);

$res7 = mysql_fetch_array($exec7);
	$dfcompanyanum = $res7['auto_number'];
	
$query6 = "select * from master_company where auto_number = '$dfcompanyanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6companyname = $res6["companyname"];
		$res6companycode = $res6["companycode"];
		
		$_SESSION["companyanum"] = $dfcompanyanum;
		$_SESSION["companyname"] = $res6companyname;
		$_SESSION["companycode"] = $res6companycode;
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
		settingsname = 'CURRENT_FINANCIAL_YEAR'";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$res7 = mysql_fetch_array($exec7);
		$financialyear = $res7["settingsvalue"];
		
		$_SESSION["financialyear"] = $financialyear;
		
		//header ("location:mainmenu1.php");
	
//$query7 = "select * from master_company";

$query34 = "select * from master_employeelocation where username='$username' group by locationcode";
				 $exec34 = mysql_query($query34) or die("Error in Query34".mysql_error());
				$res34 = mysql_fetch_array($exec34);
			 $rowcount34 = mysql_num_rows($exec34);
if($rowcount34=='1')
{		 	
	$query1112 = "select * from master_employeelocation where username = '$username' ";
	$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
	while ($res1112 = mysql_fetch_array($exec1112))
		{
			 $locationname22 = $res1112["locationname"];    
			$locationcode22 = $res1112["locationcode"];
		}
    	$query2 = "insert into login_locationdetails (docno,username,locationname , locationcode) 
					value ('$docno','$username','$locationname22','$locationcode22')";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		
	 
	header("location:mainmenu1.php?st=1");
}
else
{
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

	$locationanum=$_REQUEST["location"];
	 if($locationanum!='')
	 {	
	/*$query1112 = "select * from master_employeelocation where username = '$username' ";
	$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
	while ($res1112 = mysql_fetch_array($exec1112))
		{
			$locationname = $res1112["locationname"];    
			$locationcode = $res1112["locationcode"];
		
    	$query2 = "insert into login_locationdetails (docno,username,locationname , locationcode) 
					value ('$docno','$username','$locationname','$locationcode')";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		header("location:mainmenu1.php?st=1");
		}}
	 else
	 {*/
	 
		 $query1112 = "select * from master_employeelocation where auto_number = '$locationanum' ";
	$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
	while ($res1112 = mysql_fetch_array($exec1112))
		{
			$locationname12 = $res1112["locationname"];    
			$locationcode12 = $res1112["locationcode"];
		}
    	$query2 = "insert into login_locationdetails (docno,username,locationname , locationcode) 
					value ('$docno','$username','$locationname12','$locationcode12')";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		header("location:mainmenu1.php?st=1");
	 }
	 header("location:mainmenu1.php?st=1");
}
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

</style>
</head>
<script language="javascript">

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


function focusSubmit()
{
	document.getElementById("submit").focus();
}

function funclocationChange1()
{

	
	<?php 
	$query12 = "select * from master_location where status = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12locationanum = $res12["auto_number"];
	$res12location = $res12["locationname"];
	?>
	if(document.getElementById("location").value=="<?php echo $res12locationanum; ?>")
	{
		document.getElementById("store").options.length=null; 
		var combo = document.getElementById('store'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
		<?php
		$query10 = "select * from master_store where location = '$res12locationanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10storeanum = $res10["auto_number"];
		$res10store = $res10["store"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10storeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}

function Process3()
{
	if(document.getElementById('location').value == "")
	{
		alert("Please select Location");
		document.getElementById('location').focus();
		return false;		
	}	
}
</script>
<body onLoad="return focusSubmit()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	
	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">
	<?php 
	//include ("includes/menu4.php"); 
	if (isset($_SESSION["companyanum"])) // if the variable is set.
	{
		//include ("includes/menu4.php"); 
	}
	?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="setactivecompany1.php" onSubmit="return Process3()">
                  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Select Active Location - Selected Location Will Be Loaded  </strong></td>
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation" ><strong>  </strong> </td>
                      </tr>
                      <tr>
                        <td  align="left" valign="middle"   bgcolor="<?php if (isset($errmsg)) { echo '#FFFFFF'; } else { echo '#FFCC99'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                       <tr>
                <td align="left" width="80px"  bgcolor="#FFFFFF" class="bodytext3">Select Location</td>
                <td valign="middle" align="left">
					  <select name="location" id="location" onChange="return funclocationChange1(); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						if ($res7location != '')
						{
						?>
						<option value="<?php echo $res7locationanum; ?>" selected="selected"><?php echo $res7location; ?></option>
						<?php
						}
						else
						{
						?>
						<option value="" selected="selected">Select Location</option>
						<?php
						}
						$query1 = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["auto_number"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select></td>
               
              </tr>
                          <input type="hidden" name="frm1submit1" value="frm1submit1" >
                      <tr>
                         <td> <input type="submit" name="submit" value="Click To Proceed" style="border: 1px solid #001E6A" /></td>
               
                      </tr>
                    </tbody>
                  </table>
                  </form>


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

