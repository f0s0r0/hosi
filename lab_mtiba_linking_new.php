
<?php
include ("db/db_connect.php");
?>

<table border="1" width="100%">
	<tr>
		<td>Sno</td>
		<td>Code</td>
		<td>Name</td>
		<td>Mtiba Code</td>
		<td>Mtiba Name</td>
	</tr>

<?php
	$query1 = "select * from master_lab group by itemcode";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
?>
<?php
$sno = 0;
$name= '';
$code= '';
$mtiba_sno = 0;

	while ($res1 = mysql_fetch_array($exec1))
	{
	$name= $res1["itemname"];
	$code= $res1["itemcode"];


	$query1a = "select * from mtiba_codes where neema_code like '$code' and mtiba_code like '%LO%' ";
	$exec1a = mysql_query($query1a) or die ("Error in Query1".mysql_error());

	$mtiba_name= '';
	$mtiba_code= '';

	$j=0;
	while ($res1a = mysql_fetch_array($exec1a))
	{

	$mtiba_name.= $res1a["mtiba_name"]."<br>";
	$mtiba_code.= $res1a["mtiba_code"]."<br>";
	$j++;
	}


	if($mtiba_code!=""){
		$mtiba_sno ++;
	}


	$color = ($mtiba_code!="")?"#c9ffc9;":"#ffc9d3"; 	

	if($j>1){
		$color = "#55a5de";
	}

?>
	<tr style="background-color:<?= $color ?>">
		<td><?= ++$sno ?></td>
		<td><?= $code ?></td>
		<td><?= $name ?></td>
		<td><?= $mtiba_code ?></td>
		<td><?= $mtiba_name ?></td>
	</tr>

<?php } ?>

	<tr>
		<td></td>
		<td>
			Total Matches
		</td>	
		<td>
			<?= $mtiba_sno ?>
		</td>	
		<td>
			Total Mismatches
		</td>	
		<td>
			<?= $sno-$mtiba_sno ?>			
		</td>
	</tr>

</table>