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

 $rec_limit = 20;
 $st=isset($_REQUEST['st'])?$_REQUEST['st']:'';
$anum=isset($_REQUEST['anum'])?$_REQUEST['anum']:'';

$cbfrmflag1=isset($_REQUEST['cbfrmflag1'])?$_REQUEST['cbfrmflag1']:'';
if($cbfrmflag1=="cbfrmflag1")
{
	$disease=$_REQUEST['disease'];
	$chapter=$_REQUEST['chapter'];
	$icdname=$_REQUEST['icdname'];
	$icdcode=$_REQUEST['icdcode'];
	$recordstatus='active';
	$recordtime=date('Y-m-d H:i:s');
	$insert=mysql_query("insert into master_icd(disease,chapter,icdcode,description,recordstatus,username,ipaddress) values('$disease','$chapter','$icdcode','$icdname','$recordstatus','$recordtime','$ipaddress')")or die("Error in Insert".mysql_error());
}

if($st=="del")
{
	$delquery=mysql_query("update master_icd set recordstatus='' where auto_number='$anum'");
}
if($st=="act")
{
	$delquery=mysql_query("update master_icd set recordstatus='active' where auto_number='$anum'");
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
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script>

function funcicdsearch()
{
	//var serialno = $("#serialno").val();
	var icdsearch = $("#icdsearch").val();

	if(icdsearch=='')
	{
		alert('Enter The ICD');
		return false;
	}
	var dataString = '&&icdsearch='+icdsearch;
//	alert(dataString);
	$.ajax({
		type: "POST",
		url: "icdsearch.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		//alert(html);
			$("#icdnames").empty();
			$("#icdnames").append(html);
			//$("#hiddenplansearch").val('Searched');
			
		}
	});
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
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
              <td><form name="form1" id="form1" method="post" action="addicd.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>ICD Name Master - Add New</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					  
                      <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Group Name</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="disease" id="disease" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Group Code</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        <input name="chapter" id="chapter" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" />
						</td>
                      </tr>
					  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> ICD Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="icdname" id="icdname" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ICD Code</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="icdcode" id="icdcode" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					  
                     <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Submit" name="Submit" />
                 </td>
            </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                  </form>
                <table width="802" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse"><tr bgcolor="#011E6A">
                        <td colspan="11" bgcolor="#CCCCCC" class="bodytext3"><strong><input type="text" id="icdsearch" name="icdsearch" value="" size="30" placeholder="ICD Search">
                       
                        <input type="button" id="searchbutton" name="searchbutton" value="Search" size="30" placeholder="ICD Search" onClick="return funcicdsearch();"></strong></td>
                      </tr>
                    <tbody id='icdnames'>
                     
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#cccccc" class="bodytext3"><strong>ICD Name Master - Existing List </strong></td>
                        <td colspan="3" bgcolor="#cccccc" class="bodytext3" align="right">
                        <?php 
						  $sno='';
	     
						if( isset($_GET{'page'} ) ) {
           $page = $_GET['page'] + 1;
            $offset = $rec_limit * $page ;
         }else {
            $page = 0;
            $offset = 0;
         }
		  $query2 = "select * from master_icd where recordstatus ='active' order by auto_number desc LIMIT $offset, $rec_limit";
		
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$rec_count=mysql_num_rows($exec2);
          if( $page > 0 ) {
            $last = $page - 2;
            echo "<a href = \"addicd.php?page=$last\">Prev</a> |&nbsp;";
            echo "<a href = \"addicd.php?page=$page\">Next</a>";
         }else if( $page == 0 ) {
            echo "<a href = \"addicd.php?page=$page\">Next</a>";
         }else if( $left_rec < $rec_limit ) {
            $last = $page - 2;
            echo "<a href = \"addicd.php?page=$last\">Previous</a>";
         }
		 
         $left_rec = $rec_count - ($page * $rec_limit);
						?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong></strong></td>
                        <td width="37%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Group Name </strong></td>
                        <td width="10%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Group Code</strong></td>
						<td width="35%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>ICD Name</strong></td>
						<td width="12%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>ICD Code</strong></td>
                        
                      </tr>
                  
        <?php			
					
           
        
		while ($res2 = mysql_fetch_array($exec2))
		{
		$res2disease = $res2['disease'];
		$res2description = $res2['description'];
		$res2icdcode = $res2['icdcode'];
		$res2chapter = $res2['chapter'];
	    $res2auto_number = $res2["auto_number"];
		$sno = $sno + 1;
		
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
		  
		?>
                      <tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addicd.php?st=del&&anum=<?php echo $res2auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res2disease; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res2chapter; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $res2description; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $res2icdcode; ?> </td>
                        
                      </tr>
                     <?php 
		}
		
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                  
                  <table width="798" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#cccccc" class="bodytext3"><strong>ICD Name Master - Deleted List </strong></td>
                        <td colspan="3" bgcolor="#cccccc" class="bodytext3" align="right">
                   
		  

                        </td>
                      </tr>
                      <td align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong></strong></td>
                        <td width="37%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Group Name </strong></td>
                        <td width="10%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Group Code</strong></td>
						<td width="35%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>ICD Name</strong></td>
						<td width="12%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>ICD Code</strong></td>
                        
                      </tr>
        <?php			
					
        $query21 = "select * from master_icd where recordstatus ='' order by auto_number desc ";
		$exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
		while ($res21 = mysql_fetch_array($exec21))
		{
		$res2disease1 = $res21['disease'];
		$res2description1 = $res21['description'];
		$res2icdcode1 = $res21['icdcode'];
		$res2chapter1 = $res21['chapter'];
	    $res2auto_number1 = $res21["auto_number"];
		$sno = $sno + 1;
		
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
		  
		?>
                      <tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addicd.php?st=act&&anum=<?php echo $res2auto_number1; ?>">Activate</a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res2disease1; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res2chapter1; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $res2description1; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $res2icdcode1; ?> </td>
                        
                      </tr>
                     <?php 
		}
		
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
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

