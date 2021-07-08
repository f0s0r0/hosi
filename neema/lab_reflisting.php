
<?php
$sno = 1;
$query55="select * from labanalyzervalues where itemcode='$itemcode' and refanum = '$refanum' and status <> 'deleted'"; 
$exec55=mysql_query($query55);
$num1=mysql_num_rows($exec55);
while($res55=mysql_fetch_array($exec55))
{
$resultvalue = $res55['resultvalue'];
$sno = $sno + 1;
?>
<tr id="idTR<?php echo $colorloopcount.$sno; ?>" bgcolor="#FFFFFF">
<td class="bodytext3" valign="center"  align="left">
<input type="text" name="refvalue<?php echo $refanum; ?>[]" id="refvalue<?php echo $refanum; ?>[]" value="<?php echo $resultvalue; ?>" size="20" />
<input type="button" name="refname<?php echo $colorloopcount; ?>" id="refname<?php echo $colorloopcount; ?>" value="Del" onClick="return btnDeleteClick10('<?php echo $colorloopcount.'|'.$sno; ?>')" /></td>
</tr>
<?php	
}
?>
		 