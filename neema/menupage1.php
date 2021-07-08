<?php

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');


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

.submenubutton
{
height: 40px; width: 180px; color:#000000; font: Tahoma; background:#D0CFCF; border-radius: 20px;
}

.submenubutton:hover
{
border: 1px solid #black;
color:#000000;

}

#menu
{	margin: 0;
	padding: 0;
	
	z-index: 30}

#menu li
{	margin: 0;
	padding: 0;
	list-style: none;
	float:left;
	font: bold 11px arial;
	border:0;}

#menu li a
{	display: inline;
	margin: 0px 0px 0 0;
	padding: 15px 2px;
	width: 150px;
	background: #E0E0E0;
	color: #FFF;
	
	text-align: center;
	text-decoration: none}
#menu li a:hover
{	background: #E0E0E0}


#menu div
{	position: absolute;
	visibility: hidden;
	margin: 0;
	padding: 0;
	background: #E0E0E0;
	}

	#menu div a
	{	position: relative;
		display: inline;
		margin: 0;
		padding: 5px 10px;
		width: auto;
		white-space: nowrap;
		text-align: left;
		text-decoration: none;
		background: #E0E0E0;
		color: #2875DE;
		font: 11px arial}

	#menu div a:hover
	{	background: #E0E0E0;
		color: #FFF}
</style>

</head>

<script>
function funcPopupOnLoader()
{
funcPopupExternal();
funcPopupRefund();
}
function funcPopupExternal()
{
<?php 
if (isset($_REQUEST["savedbillnumber"])) { $savedbillnumbers = $_REQUEST["savedbillnumber"]; } else { $savedbillnumber = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

?>
	var savedbillnumberr;
	var savedbillnumberr = "<?php echo $savedbillnumbers; ?>";
	var locationcode = "<?php echo $locationcode; ?>";
	//alert(patientcodes);
	if(savedbillnumberr != "") 
	{
		window.open("print_external_bill.php?billnumber="+savedbillnumberr+"&&locationcode="+locationcode+" ","OriginalWindowA14",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
	
}	
</script>

<body onLoad="return funcPopupOnLoader()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#003399"><?php include ("includes/alertmessages1.php"); ?></td>
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
    <td width="2%" valign="top">&nbsp;
      </td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>
			  <div class="test">
                  <ul id="menu" >
                    <?php
		
		$randomnumber1 = date ("dmYHis");
		$mainmenid = $_REQUEST["mainmenuid"];
		$sessionusername = $_SESSION["username"];

	
		
		if ($mainmenid=='MM006')
		{
		
		$query2sm = "select * from master_menusub where mainmenuid = '$mainmenid' and status <> 'deleted' order by submenutext";
		$exec2sm = mysql_query($query2sm) or die ("Error in Query2sm".mysql_error());
		while ($res2sm = mysql_fetch_array($exec2sm))
		{
		$submenuorder = $res2sm["submenuorder"];
		$submenutext = $res2sm["submenutext"];
		$submenulink = $res2sm["submenulink"];
		$submenuid1 = $res2sm["submenuid"];
		
		$query10 = "select * from master_employeerights where username = '$sessionusername' and submenuid = '$submenuid1'";
		$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
		$rowcount10 = mysql_num_rows($exec10);
		if ($rowcount10 != 0)
		{		
		
		?>
                            <li ><a href="<?php echo $submenulink; ?>">
                              <input name="button" type="button" class="submenubutton" id="submenubutton" value="<?php echo $submenutext; ?>">
                            </a></li>
       <?php
					
			} 
			}
			}
			else
			{
		$query2sm = "select * from master_menusub where mainmenuid = '$mainmenid' and status <> 'deleted' order by submenuorder";
		$exec2sm = mysql_query($query2sm) or die ("Error in Query2sm".mysql_error());
		while ($res2sm = mysql_fetch_array($exec2sm))
		{
		$submenuorder = $res2sm["submenuorder"];
		$submenutext = $res2sm["submenutext"];
		$submenulink = $res2sm["submenulink"];
		$submenuid = $res2sm["submenuid"];
		
		
		$query10 = "select * from master_employeerights where username = '$sessionusername' and submenuid = '$submenuid'";
		$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
		$rowcount10 = mysql_num_rows($exec10);
		if ($rowcount10 != 0)
		{		
		
		?>
                            <li ><a href="<?php echo $submenulink; ?>">
                              <input name="button" type="button" class="submenubutton" id="submenubutton" value="<?php echo $submenutext; ?>">
                            </a></li>
       <?php
					
			
			}
			}
			}
		?>
                  </ul>
			  </div> </td>
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

