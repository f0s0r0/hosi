<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION['username'];
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$templatecode = $_REQUEST["tid"];
$itemcode = $_REQUEST["itemcode"];
$docnumber = $_REQUEST["docnum"];

$query7="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec7=mysql_query($query7) or die(mysql_error());
$res7=mysql_fetch_array($exec7);
$res7patientname=$res7['patientfullname'];
$res7patientage=$res7['age'];
$res7patientgender=$res7['gender'];
$res7billtype = $res7['billtype'];

$query98="select * from master_radiology where itemcode='$itemcode'";
$exec98=mysql_query($query98);
$res98=mysql_fetch_array($exec98);
$res98itemname = $res98['itemname'];

?>

<script>
function acknowledgevalid() 
 {
 window.close();
 }
 
function toredirect()
{ 
var content = CKEDITOR.instances.editor1.getData();

document.getElementById("getdata").value = content;

//alert(content);
}
</script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

.ckeditor {display:none;}
</style>
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>

  
			  
<?php
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$templatecode = $_REQUEST["templatecode"];
$itemcode = $_REQUEST["itemcode"];
$docnumber = $_REQUEST["docnumber"];
$getdata = $_REQUEST["getdata"];
$getitemname = $_REQUEST["itemname"];

$query77="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec77=mysql_query($query77) or die(mysql_error());
$res77=mysql_fetch_array($exec77);
$patientname=$res77['patientfullname'];
$patientage=$res77['age'];
$patientgender=$res77['gender'];
$billtype = $res77['billtype'];

$query61 = "select * from consultation_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultentry='pending' and paymentstatus='completed' group by radiologyitemname";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
$res61 = mysql_fetch_array($exec61);
$radiologyname =$res61["radiologyitemname"];
$billtype = $res61['billtype'];
$accountname = $res61['accountname'];
$acknowledge = 'completed';

$query68="select * from master_radiology where itemname='$radiologyname'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);

if($radiologyname != "")
   {
   $query26="insert into resultentry_radiology(patientname,patientcode,patientvisitcode,account,billtype,recorddate,recordtime,itemcode,itemname,acknowledge,docnumber,templatedata,username)values
   ('$patientname','$patientcode','$visitcode','$accountname','$billtype','$dateonly','$timeonly','$itemcode','$getitemname','$acknowledge','$docnumber','$getdata','$username')";
   $exec26=mysql_query($query26) or die(mysql_error());
  
		$file_upload="true";
		$file_up_size=$_FILES['file_up'][size];
		/* $_FILES['file_up'][name];
		if ($_FILES['file_up'][size]>250000){$msg=$msg."Your uploaded file size is more than 250KB
		so please reduce the file size and then upload.<BR>";
		$file_upload="false";}*/
		
		if (($_FILES['file_up'][type] =="image/jpg" OR $_FILES['file_up'][type] =="image/gif"))
		{$msg=$msg."Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
		$file_upload="false";}
		
		$file_name=$_FILES['file_up'][name];
		//$file_name = $patientcode._.$visitcode.'_'.$filename;
         $filearray = explode('.',$file_name);
         $filearray[0];
		 $filearray[1];
		//$add="upload/$file_name"; // the path with the file name where the file will be stored
         //$dirname= gethostbyaddr('192.168.1.7');		 //$dirname= quotemeta($dirname);
        $add= '\\\\'.gethostbyaddr('192.168.0.15').'\photofolder\\'.$filearray[0].'.'.$filearray[1];
	   $add = mysql_real_escape_string($add);
		if($file_upload=="true"){
		
		//if(move_uploaded_file(($_FILES['file_up'][tmp_name]), $add)){
	     $query76 = "update resultentry_radiology set filename= '$file_name', fileurl='$add' WHERE patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber'";
        $exec76 = mysql_query($query76) or die(mysql_error());
		// do your coding here to give a thanks message or any other thing.
		//}else{echo "Failed to upload file Contact Site admin to fix the problem";}
		
		}else{echo $msg;}
      }
echo '<script type="text/javascript"> acknowledgevalid();  </script>';
}
?>
</head>

<body>
<form name="frmsales" id="frmsales" method="post" FORM ENCTYPE="multipart/form-data" action="appendto.php" onKeyDown="return disableEnterKey(event)" onSubmit="return toredirect();">
	<table width="101%" border="0" cellspacing="0" cellpadding="2">
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
			<td align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td>
		</tr>
		<tr>
			<td colspan="3" align="left" valign="middle"  class="bodytext3"><strong>Add</strong></td>
		</tr>	
		<table width="1150" border="0" cellspacing="0" cellpadding="0">
				<?php
				$query78="select * from master_radiologytemplate where auto_number='$templatecode' ";
				$exec78=mysql_query($query78) or die(mysql_error());
				$res78=mysql_fetch_array($exec78);
				$templatedata=$res78['templatedata'];
				?>
			<tr>
				<td>
				    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
					 <input type="hidden" name="visitcode" value="<?php echo $visitcode; ?>">
					  <input type="hidden" name="templatecode" value="<?php echo $templatecode; ?>">
					   <input type="hidden" name="itemcode" value="<?php echo $itemcode; ?>">
					    <input type="hidden" name="docnumber" value="<?php echo $docnumber; ?>">
						 <input type="hidden" name="getdata" id="getdata" value="">
						  <input type="hidden" name="itemname" id="itemname" value="<?php echo $res98itemname; ?>">
						 
						
						  
					<textarea id="editor1">
					<strong><?php echo $sno; echo "Patient: ".$res7patientname; ?> <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age: ".$res7patientage; ?>  <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender: ".$res7patientgender; ?></strong><br/>
					<?php echo $templatedata; ?><br/>
					<?php echo "<pre>Sonographer: ".strtoupper($username); ?>
					<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign:............</pre>"; ?>
		            </textarea>		
				
					<script>
						CKEDITOR.replace( 'editor1',
						null,
						''
						);
					</script>
						
				</td>
			</tr>	
			<tr>
			  <td>
              <!--
					Save image link: <INPUT NAME="file_up" TYPE="file">
                    
                 -->   
              </td>
			</tr>
		    <tr>
			   <td>&nbsp;</td>
			 </tr>  
			<tr>
				<td width="54%" align="right" valign="top" >
				<input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1" ons>
				<input name="Submit2223" type="submit" value="Save "  accesskey="b" class="button" style="border: 1px solid #001E6A"/>
				</td>
			</tr>
		</table>
	</table>
</form>



			  
		
