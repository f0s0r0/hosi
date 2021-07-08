<title>
<?php 
if (isset($_REQUEST["titlestr"])) { $titlestr = $_REQUEST["titlestr"]; } else { $titlestr = ""; }
if ($titlestr == '')
{
	echo 'MED360';
}
else
{
	echo $titlestr.'MED360';
}
?>
</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">