<?php
//Simacle Billing Software - Version 7.0 - Released Jan 2012
//Simacle Billing Software - Version 8.0 - Released 21Nov2012 Wednesday
$titlestr = '';
include ("includes/pagetitle1.php");
?>
<style type="text/css">
<!--
.style4TM1 {font-size: 18px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000099;}
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="0%" bgcolor="#FFFFFF">&nbsp;</td>
    <td colspan="4" bgcolor="#FFFFFF">
	<span class="style4TM1">
	<img src="images/medit.gif" />	</span></td>
    <td bgcolor="#FFFFFF"></td>
    <td width="27%" bgcolor="#FFFFFF" class="style4TM1" align="left">
	<?php if (isset($_SESSION["username"])) { echo strtoupper($_SESSION["username"]); } ?>
	&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="style4TM1"><?php echo date('D, M j, Y g:ia'); ?></td>
    <td align ="center" width="26%" bgcolor="#FFFFFF" class="style4TM1"><img src="images/neema.jpg" width="100" height="30"/></td>
  </tr>
</table>
