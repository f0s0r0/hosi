<?php
$netpandl = 0;
			function subgroup11($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = "0.00";
				$ledgeramountsum = "0.00";
				$ledgeramountsum1 = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub,auto_number,tbinclude,tbledgerview from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				while($res2 = mysql_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					
					$ledgeramount = ledgervaluepl($parentid2,$ADate1,$ADate2,$tbinclude);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
				
				}
				
				groupplleft($ledgeramountsum);
			}
			function groupplleft($a)
			{
			static $ledgeramountsumtotal1='0';
			$ledgeramountsumtotal1 = $ledgeramountsumtotal1 + $a;
			return $ledgeramountsumtotal1;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if (true)
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

			$snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('E') order by section, auto_number, accountsmain";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while($res1 = mysql_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			//$orderid = $res1['orderid'];
			$type = substr($accountsmain,0,1);
		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysql_query($querygroup2) or die ("Error in Querygroup2".mysql_error());
			$numgroup2= mysql_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup11($parentid,$orderid,$parentid.'10000',$section); }
			}
			}
			
			function subgroup112($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = '0.00';
				$ledgeramountsum = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub, auto_number,tbinclude,tbledgerview from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				while($res2 = mysql_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					
					$ledgeramount = ledgervaluepl($parentid2,$ADate1,$ADate2,$tbinclude);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
				}

				groupplright($ledgeramountsum);
			}
			
			function groupplright($b)
			{
				static $ledgeramountsumtotal5 = '0';
				$ledgeramountsumtotal5 = $ledgeramountsumtotal5 + $b;
				return $ledgeramountsumtotal5;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if (true)
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('I') order by accountsmain desc";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while($res1 = mysql_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			$type = substr($accountsmain,'0','1');
				
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysql_query($querygroup2) or die ("Error in Querygroup2".mysql_error());
			$numgroup2= mysql_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup112($parentid,$orderid,$parentid.'10000',$section); }
			}
			}
			
			$groupplright12 = groupplright(0);
			$groupplleft12 = groupplleft(0);
			
			$netpandl = $groupplright12 - $groupplleft12;
		
function ledgervaluepl($parentid,$ADate1,$ADate2,$tbinclude)
{
	$orderid1 = 0;
	$lid = 0;
	$sumbalance = 0;
	
	if($parentid != '' && $tbinclude != '')
	{
		include($tbinclude);
		return $sumbalance;
	}
	else
	{
		return $sumbalance;
	}
}
?>
