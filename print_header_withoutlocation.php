<style>
.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 40px; COLOR: #000000; font-family: Times;}
.bodytextaddress {FONT-WEIGHT: bold; FONT-SIZE: 19px; COLOR: #000000; font-family: Times;}
.style1 {font-size: 24px}
</style>
<table width="auto" border="0" cellpadding="0" cellspacing="0" align="center">

  <tr>
    <td width="100" rowspan="4"  align="left" valign="top" 
	 bgcolor="#ffffff" class="bodytext31">
      
      <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{ 
			?>
      
      <img src="logofiles/<?php echo $companyanum; ?>.jpg" width="164" height="101" />
      
      <?php
			}
			?>	</td>
            <td width="431" align="center" valign="bottom" 
	 bgcolor="#ffffff" class="bodytexthead style1"><?php echo $companyname; ?></td>
  </tr>
    <tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $address1; ?></td>
    </tr>
    <tr>
	<td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress">
	<?php
	if($phonenumber1 != '')
	 {
	echo '<strong class="bodytextaddress"> Tel : '.$phonenumber1.'</strong>';
	 }
	 ?></td>
  </tr>
  <tr>
	<td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress">
	<?php
	if($emailid1 != '')
	 {
	echo '<strong class="bodytextaddress"> Email : '.$emailid1.'</strong>';
	 }
	 ?></td>
  </tr>
</table>
