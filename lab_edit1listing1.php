<?php
$query23 = "select * from master_labreference where itemcode='$itemcode' and status <> 'deleted'";
$exec23 = mysql_query($query23) or die(mysql_error());
while($res23 = mysql_fetch_array($exec23))
{
$itemcount = $itemcount + 1;
$referencename = $res23['referencename'];
$referenceunit = $res23['referenceunit'];
$referencerange = $res23['referencerange'];
$criticallow = $res23['criticallow'];
$criticalhigh = $res23['criticalhigh'];

?>
<TR id="idTR<?php echo $itemcount; ?>" bgcolor="#E0E0E0">
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
<input name="reference[]" value="<?php echo $referencename; ?>" id="serialnumber<?php echo $itemcount; ?>" style="text-align:left" size="20" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
<input name="units[]" value="<?php echo $referenceunit; ?>" id="itemcode<?php echo $itemcount; ?>" style="text-align:left" size="10" />
</td>
<?php /*?><!--<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
<input name="criticallow[]" value="<?php echo $criticallow; ?>" id="criticallow<?php echo $itemcount; ?>" style="text-align:left" size="10" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
<input name="criticalhigh[]" value="<?php echo $criticalhigh; ?>" id="criticalhigh<?php echo $itemcount; ?>" style="text-align:left" size="10" />
</td>--><?php */?>
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
<input type="text" size="10" name="range[]" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $referencerange; ?>">
</td>
<td id="idTD3<?php echo $itemcount; ?>" align="right" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick10(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" />
</td>
</TR>
<?php }
?>