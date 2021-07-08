<?php
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
// Example of accessing data for a newly uploaded file
$fileName = $_FILES["uploaded_file"]["name"]; 
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"];
// Path and file name
        $pathAndName= '\\\\'.gethostbyaddr('192.168.1.7').'\C\xampp\htdocs\photofolder\\'.$fileName;
// Run the move_uploaded_file() function here
$moveResult = move_uploaded_file($fileTmpLoc, $pathAndName);
// Evaluate the value returned from the function if needed
if ($moveResult == true) {
    echo "File has been moved from " . $fileTmpLoc . " to" . $pathAndName;
} else {
     echo "ERROR: File not moved correctly";
}
}
?>

<form name="frmsales" id="frmsales" method="post" FORM ENCTYPE="multipart/form-data" action="test34.php" onKeyDown="return disableEnterKey(event)" onSubmit="return toredirect();">
	<table width="101%" border="0" cellspacing="0" cellpadding="2">
			<tr>
			  <td>
					Save image link: <INPUT NAME="uploaded_file" TYPE="file">
              </td>
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