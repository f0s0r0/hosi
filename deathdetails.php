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
$department = '';
if(isset($_REQUEST['department']))
{
$department = $_REQUEST['department'];
}
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
if(isset($_POST['doctor'])){$searchdoctor = $_POST['doctor'];}else{$searchdoctor="";}
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
.number1
{
text-align:right;
padding-left:700px;
}

-->

.ui-menu .ui-menu-item{ 
zoom:.9 !important;
 }
</style>
<link  href="css/autocomplete.css" rel="stylesheet" type="text/css" />

<script  src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>


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

function testcheck()
{

   if($('#dead').is(":not(:checked)")){
                alert("Checkbox is unchecked.");
				return false;
            }
  
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2"/>
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
	 <td width="1145">
              <form name="cbform1" method="post" action="deathdetails.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
					  <td width="16%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Select Type</strong></td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="analysis">
                        <option value="">All</option>
                        <option value="Pediatric">Pediatric</option>
                        <option value="Adult">Adult</option>
                        </select>
                  </td>
				    </tr>
						<tr>
					  
					  </tr>
					  
					
			 			
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" onClick="return testcheck()"/>
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
          </form>		</td>
	 </tr>  
		        
     
	  
	
  </table>
  <?php 
  $colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["Submit"])) { $Submit = $_REQUEST["Submit"]; } else { $Submit = ""; }
  {
	  if ($Submit == 'Search')
{
	
	 $death=$_POST['analysis'];
	
	
	 ?>
     <br><br>
     <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="3%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="22%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Age</strong></div></td>
				 <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Gender</strong></div></td>
					 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
                 
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
                 
              </tr>
              
              <?php
			  if($death == 'Pediatric')
			  {
			  $query0="select * from master_customer where age <=10 and dead like 'Dead' order by customercode";
			  $exe0=mysql_query($query0);
			  }
			  else if($death == 'Adult')
			  {
				  $query0="select * from master_customer where age >10 and dead ='Dead' order by customercode";
			  $exe0=mysql_query($query0);
			  }
			  else
			  {
				  $query0="select * from master_customer where  dead ='Dead' order by customercode";
			  $exe0=mysql_query($query0);
				  
			  }
			 while( $res0=mysql_fetch_array($exe0))
			 {
			  $patientname=$res0['customerfullname'];
			  $patientcode1=$res0['customercode'];
			  $age=$res0['age'];
			  $gender=$res0['gender'];
			  $type=$res0['billtype'];
			  $status2=$res0['dead'];
			 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?>
                <input type="hidden" name="patientname0" id="patientname0" value="<?php echo $patientname; ?>"></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode1; ?>
                <input type="hidden" name="patientcode1" id="patientcode1" value="<?php echo $patientcode1; ?>">
                </div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $age; ?>
                      <input type="hidden" name="age1" id="age1" value="<?php echo $age; ?>">
                      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?>
                <input type="hidden" name="gender1" id="gender1" value="<?php echo $gender; ?>">
                </div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $type; ?>
                <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                </div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $status2; ?>
              
                </div></td>
                 	  
               
                
              
            
              
               <?php 
				} ?>
     
     </tbody>
     </table>
     
     
     
     
     
     <?php
	 }
  }
  ?>
  
<?php include ("includes/footer1.php"); ?>
</body>
</html>

