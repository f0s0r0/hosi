<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$docno = $_SESSION['docno'];
$query = "select * from master_location where  status <> 'deleted' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
	 $employeeid=isset($_REQUEST['eid'])?$_REQUEST['eid']:'';
	 $query1 = "select username from master_employee where  status = 'Active' AND employeecode = '".$employeeid."'";
$exec1 = mysql_query($query1) or die ("Error in Query11".mysql_error());
$res1 = mysql_fetch_array($exec1);
	
	  $employeename  = $res1["username"];
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		 $locationcode=$location;
		}
		//location get end here
		$loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$employeeidget=isset($_REQUEST['employeeidget'])?$_REQUEST['employeeidget']:'';
	$employeenameget=isset($_REQUEST['employeenameget'])?$_REQUEST['employeenameget']:'';
	$employeeid=$employeeidget;
	$employeename=$employeenameget;
	$query4 = "DELETE FROM master_employeelocation WHERE employeecode = '".$employeeid."'";
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	
	for($i=1; $i<=$loccountloop; $i++)
	{
	 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
	 $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';
	 
		 if($loccodeget!='')
		 {
			 
	 
						$query1 = "select locationname,locationcode from master_location where status <> 'deleted' AND auto_number = '".$loccodeget."'";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						$locationcode = $res1["locationcode"];
						$locationname = $res1["locationname"];
						
		$stocountloop=isset($_REQUEST['storecount'.$i])?$_REQUEST['storecount'.$i]:'';
		$stocount=0;
		for($j=1; $j<=$loccountloop; $j++)
			{
			$stocodeget=isset($_REQUEST['scheck'.$i.$j])?$_REQUEST['scheck'.$i.$j]:'';
			
			if($stocodeget!='')
			{$stocount=$stocount+1;
				$query2 = "INSERT INTO master_employeelocation SET employeecode = '".$employeeid."',username = '".$employeename."',locationanum = '".$loccodeget."',locationname = '".$locationname."',locationcode = '".$locationcode."',lastupdate = '".date('Y-m-d h:i:s')."',lastupdateipaddress = '".$_SERVER['REMOTE_ADDR']."',lastupdateusername = '".$username."',storecode = '".$stocodeget."'";
						$exec1 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				}
			
			// $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';
			}
			if($stocount==0)
			{
				$query2 = "INSERT INTO master_employeelocation SET employeecode = '".$employeeid."',username = '".$employeename."',locationanum = '".$loccodeget."',locationname = '".$locationname."',locationcode = '".$locationcode."',lastupdate = '".date('Y-m-d h:i:s')."',lastupdateipaddress = '".$_SERVER['REMOTE_ADDR']."',lastupdateusername = '".$username."'";
						$exec1 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				}
		//$itemcode = $_REQUEST["itemcode"];
		 }
	}
	header("Location:employeeclose.php");
}



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
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.department.value == "")
	{
		alert ("Pleae Enter Department Name.");
		document.form1.department.focus();
		return false;
	}
}

function funcDeleteDepartment1(varDepartmentAutoNumber)
{

     var varDepartmentAutoNumber = varDepartmentAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Department '+varDepartmentAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Department  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Department Entry Delete Not Completed.");
		return false;
	}

}

function showfunction(show)
{
	//alert(show);
	if(document.getElementById('show'+show).style.display=='none')
	{
	document.getElementById('show'+show).style.display='block';
	}
	else
	{
	document.getElementById('show'+show).style.display='none';
	}
	
	}
</script>
<body>
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
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="addemployeelocationandstore.php" onSubmit="return addward1process1()">
                 
                  
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong>Add Location and Stores</strong></td>
                        <td colspan="1" bgcolor="#CCCCCC" class="bodytext3" align="right"><strong>Employee</strong>&nbsp;<?php echo $employeename;?></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
              
              
               </tr>
                  <?php
						
						$query1 = "select locationname,locationcode,auto_number from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$incr=0;
						while ($res1 = mysql_fetch_array($exec1))
						{
						 $res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						 $res1locationautonum = $res1["auto_number"];
						$incr=$incr+1;
						$equallocationanum='';
						?>
                        <?php $query22 = "select * from master_employeelocation where employeecode = '".$employeeid."' AND locationcode = '".$res1locationanum."'";
						$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
						while($res22 = mysql_fetch_array($exec22))
						{
						
						 $equallocationanum = $res22["locationanum"];}?>
						<tr >
                        <th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" colspan="2"><strong><input name="lcheck<?php echo $incr;?>" type="checkbox" value="<?php echo $res1locationautonum;?>" onChange="showfunction(<?php echo $incr?>)" <?php if($equallocationanum){if($res1locationautonum==$equallocationanum){echo "checked";}}?> ><?php echo  $res1location;?></strong></th>
              
              </tr>
            <tr  bgcolor="#FFFFFF" class="bodytext3"><td colspan="2"> <table id="show<?php echo $incr;?>"  bgcolor="#FFFFFF" class="bodytext3"
            
            style="display:none;display:<?php $query22 = "select locationanum from master_employeelocation where employeecode = '".$employeeid."'";
						$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
						while($res22 = mysql_fetch_array($exec22))
						{
						
						 $equallocationanum = $res22["locationanum"]; if($res1locationautonum==$equallocationanum){echo "block";break;}}?>">
              
              <?php
						
						$query11 = "select store,auto_number from master_store where recordstatus <> 'deleted' AND	location = '".$res1locationautonum."'  order by store";
						$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
						$incr1=0;
						while ($res11 = mysql_fetch_array($exec11))
						{
						$res1store = $res11["store"];
						$res1storeanum = $res11["auto_number"];
						$incr1=$incr1+1;
						?>
						<tr >
                        
              <td colspan="1" align="left" ><span class="bodytext3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="checkbox" name="scheck<?php echo $incr.$incr1;?>" value="<?php echo $res1storeanum;?>" <?php $query22 = "select storecode from master_employeelocation where employeecode = '".$employeeid."'";
						$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
						while($res22 = mysql_fetch_array($exec22))
						{
						
						 $equalstorecode = $res22["storecode"]; if($res1storeanum==$equalstorecode){echo "checked";break;}}?>><?php echo $res1store;?></strong> </span></td>
              </td>
						<?php }?>
                        </table></td></tr>
                         <input type="hidden" name="storecount<?php echo $incr;?>" value="<?php echo $incr1;?>">
						<?php
						}
						?>
                  <input type="hidden" name="locationcount" value="<?php echo $incr;?>">
              		<input type="hidden" name="employeeidget" value="<?php echo $employeeid;?>">
                    <input type="hidden" name="employeenameget" value="<?php echo $employeename;?>">
              
                     
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                 
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    
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

