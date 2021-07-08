<?php
//session_start();
include ("db/db_connect.php");

//$searchclientgroup = $_REQUEST['searchclientgroup'];

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
//$action = trim(strip_tags($_REQUEST['action'])); 
//$voucher = trim(strip_tags($_REQUEST['voucher'])); 
//$term ='Fredrick Kimathi Muriungi';
$a_json = array();
$a_json_row = array();
//subledger('40',$term);

flush();
$ledgertype = "";
$slo = 0;
$ledgerbuild = "";

subgroup($term);

function subgroup($term)
{

global $a_json_row;

global $a_json;
	$query2 = "select * from master_accountname where accountname like '%$term%' and recordstatus <> 'deleted' and id <> '' order by accountname limit 0, 10";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while ($res2 = mysql_fetch_array($exec2))
	{
		
		$res2subtype = $res2['accountname'];
		$accountsmain = $res2['accountsmain'];
		$accountssub = $res2['accountssub'];	
		
		$query11 = "select accountsmain from master_accountsmain where auto_number = '$accountsmain'";
	    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$res11 = mysql_fetch_array($exec11);
		$accountsmain1 = $res11['accountsmain'];
		
		$query12 = "select accountssub from master_accountssub where auto_number = '$accountssub'";
	    $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$res12 = mysql_fetch_array($exec12);
		$accountssub1 = $res12['accountssub'];
		
		$res2subtype = trim($res2subtype);
		
		$res2subtype = preg_replace('/,/', ' ', $res2subtype); // To avoid comma from passing on to ajax url.
		
		$res2docno = $res2['id'];
		$billwise = '';	
		
		$res2docno = trim($res2docno);
		
		$a_json_row["id"] = $res2docno;
		$a_json_row["billwise"] = $billwise;
		$a_json_row["value"] = $res2subtype;
		$a_json_row["label"] = $res2subtype.' | '.$accountsmain1.' | '.$accountssub1;
		array_push($a_json, $a_json_row);
		
	}
//$a_json_row = array();
echo json_encode($a_json);	

}
?>