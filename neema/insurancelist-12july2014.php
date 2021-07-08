<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if(isset($_POST['insurance'])){$insurance = $_POST['insurance'];}else{$insurance="";}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
..number1
{
text-align:right;
padding-left:700px;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

function selectall() {
//alert("check");
    checkboxes = document.getElementsByName('check[]');
    for ( var i in checkboxes){
	//$('input[name=checkboxes[i]]').prop('checked', true);
        checkboxes[i].checked = true ;
		//alert(checkboxes[i].value);
		}
}
function selectnone() {
//alert("check");
    checkboxes = document.getElementsByName('check[]');
    for ( var i in checkboxes)
	//$('input[name=checkboxes[i]]').prop('checked', true);
        checkboxes[i].checked = false ;
}


</script>
<?php 
if(isset($_POST['delete']))
{
$delete = $_POST['check'];
foreach ($delete as $id) {
$querydel="DELETE FROM member_insurance WHERE membernumber = '".$id."'";
$resultdel= mysql_query($querydel) or die("Invalid query");
}
}
?>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
..bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="860">
              <form name="cbform1" method="post" action="insurancelist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Policy Scheme</td>
					  <td width="82%" colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="insurance" type="text" id="insurance" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
								
			 			
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
	 </tr>  
	  <tr><td>&nbsp;</td></tr>		        
      <tr>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if($cbfrmflag1 == 'cbfrmflag1'){ ?>

	  <tr><form action="insurancelist.php" name="checklist" method="post">
        <td><table width="60%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="4" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Insurance List </strong></div></td>
				<td  bgcolor="#cccccc" class="bodytext31"><input type="button" value="Select All" onClick="selectall();"></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><input type="button" value="Deselect" onClick="selectnone();"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1"><input name="delete" type="submit" value="Delete"></td>
			    </tr>
	
            <tr>
			  <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member Number</strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>First Name</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Last Name</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Policy Scheme</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Insurance</strong></div></td>
           </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
					
			$query1 = "select * from member_insurance where policyholder like '%$insurance%'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$memberno = $res1['membernumber'];
			$firstname = $res1['firstname'];
			$lastname = $res1['firstname'];
			$policynumber =$res1['policyholder'];
			$insurance = $res1['insurance'];
						
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			
			
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
		
		    
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><input type="checkbox" id="check[]" name="check[]" value="<?php echo $memberno; ?>"></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $memberno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $firstname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $lastname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $policynumber;?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $insurance;?></div></td>
              </tr>
              
			<?php
			}
			
			 
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><input type="button" value="Select All" onClick="selectall();"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><input type="button" value="Deselect" onClick="selectnone();"></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1"><input name="delete" type="submit" value="Delete"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
   	       </tr>
          </tbody>
		  
        </table>
      </td> </form>
  </tr><?php } ?>
	</table>
	  
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

