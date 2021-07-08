<?php
$query23 = "select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
$exec23 = mysql_query($query23) or die(mysql_error());
while($res23 = mysql_fetch_array($exec23))
{
$itemcount = $itemcount + 1;
$referencename = $res23['referencename'];
$referenceunit = $res23['referenceunit'];
$referencerange = $res23['referencerange'];

?>
<TR id="idTR<?php echo $itemcount; ?>">
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="reference[]" value="<?php echo $referencename; ?>" id="serialnumber<?php echo $itemcount; ?>" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="20" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="units[]" value="<?php echo $referenceunit; ?>" id="itemcode<?php echo $itemcount; ?>" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />
</td>
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="range[]" value="<?php echo $referencerange; ?>" id="itemname<?php echo $itemcount; ?>" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" size="10"/>
</td>
<td id="idTD3<?php echo $itemcount; ?>" align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick10(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" style="border: 1px solid #001E6A"/>
</td>
</TR>
<?php }
?>