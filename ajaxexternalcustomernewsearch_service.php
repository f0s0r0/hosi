<?php
//session_start();
include ("db/db_connect.php");

function calculate_age($birthday)
{
	if($birthday=="0000-00-00")
		return '0'; 
	
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));
    if ($diff->y)
    {
        return $diff->y.' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m.' Months';
    }
    else
    {
        return $diff->d.' Days';
    }
}

$customer = trim($_REQUEST['term']);
$customersplit = explode('|',$customer);
$customersearch='';
//echo count($customersplit);
for($i=0;$i<count($customersplit);$i++)
{
	if(count($customersplit)=='1')
	{
		if($customersearch=='')
		{
			$customersearch = "(patientfirstname like '%$customersplit[$i]%' or patientmiddlename like '%$customersplit[$i]%' or patientlastname like '%$customersplit[$i]%' or patientcode like '%$customersplit[$i]%')";
		}
		else
		{
			$customersearch = $customersearch." or (patientfullname like '%$customersplit[$i]%')";
		}
	}
	else
	{
		
		if($customersearch=='')
		{
			if($i=='0')
			{
				$customersearch = "(patientfirstname like '%$customersplit[$i]%')";
			}
			else if($i=='1')
			{
				$customersearch = "(patientmiddlename like '%$customersplit[$i]%')";
			}
			else if($i=='2')
			{				
				$customersearch = "(patientlastname like '%$customersplit[$i]%')";
			}
			else if($i=='3')
			{
				$customersearch = "(patientcode like '%$customersplit[$i]%')";			
			}
		}
		else
		{
			if($i=='0')
			{
				$customersearch = $customersearch." and (patientfirstname like '%$customersplit[$i]%')";
			}
			else if($i=='1')
			{
				$customersearch = $customersearch." and (patientmiddlename like '%$customersplit[$i]%')";
			}
			else if($i=='2')
			{
				$customersearch = $customersearch." and (patientlastname like '%$customersplit[$i]%')";
			}
			else if($i=='3')
			{
				$customersearch = $customersearch." and (patientcode like '%$customersplit[$i]%')";
			}			
		}
	}
}
//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;  
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$today=date('Y-m-d');
$query1 = "select patientcode,visitcode,patientfullname,accountname,patientfirstname,patientmiddlename,patientlastname,age,gender,billtype from master_visitentry where (patientcode like '%$customer%' or patientfullname like '%$customer%' or visitcode like '%$customer%') and consultationdate='$today' and department IN (25,3) group by visitcode limit 20";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1customercode = $res1['patientcode'];
	$res1visitcode = $res1['visitcode'];
	$res1billtype = $res1['billtype'];
	$res1customerfirstname=$res1['patientfirstname'];
	$res1customermiddlename=$res1['patientmiddlename'];
	$res1customerlastname=$res1['patientlastname'];
	$res1customerfullname=$res1['patientfullname'];
	$res1accountname = $res1['accountname'];

	$res1dateofbirth='';
	$res1gender = '';
	$planfixedamount='';
	$planpercentageamount='';

	$paymenttype='';
	$subtype='';
	

	$query001="select visitcode,planfixedamount,planpercentage,paymenttype,subtype from master_visitentry where patientcode='$res1customercode' and visitcode='$res1visitcode' order by auto_number desc";
	$exec001= mysql_query($query001) or die ("Error in Query001".mysql_error());
	if ($res001 = mysql_fetch_array($exec001))
	{
	$res1visitcode = $res001['visitcode'];
	$planfixedamount=$res001['planfixedamount'];
	$planpercentageamount=$res001['planpercentage'];
	$paymenttype=$res001['paymenttype'];
	$subtype1=$res001['subtype'];
	$querysubtype=mysql_query("select * from master_subtype where auto_number='$subtype1'");
$execsubtype=mysql_fetch_array($querysubtype);
$subtype=$execsubtype['subtype'];
	}


			$query65 = "select auto_number from billing_paylater where visitcode='$res1visitcode'";
			$exec65 = mysql_query($query65) or die(mysql_error());
			$num65 = mysql_num_rows($exec65);
			if($num65 > 0)
			{
				continue;
			}

	$query01="select dateofbirth,gender from master_customer where customercode='$res1customercode'";
	$exec01= mysql_query($query01) or die ("Error in Query01".mysql_error());
	if ($res01 = mysql_fetch_array($exec01))
	{
	$res1dateofbirth = $res01['dateofbirth'];
	$res1gender = $res01['gender'];
	}

	$res1age = calculate_age($res1dateofbirth);
		
	$query111 = "select accountname from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
	$res111 = mysql_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	
	$res1customercode = addslashes($res1customercode);
	

	$res1customercode = strtoupper($res1customercode);
	
	$res1customercode = trim($res1customercode);
	
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);
	
	/*if ($stringbuild1 == '')
	{
		$stringbuild1 = ' '.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.' ';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.'';
	}*/
	$a_json_row["patientfirstname"] = $res1customerfirstname;
	$a_json_row["patientmiddlename"] = $res1customermiddlename;
	$a_json_row["patientlastname"] = $res1customerlastname;
	$a_json_row["customercode"] = $res1customercode;
	$a_json_row["visitcode"] = $res1visitcode;
	$a_json_row["billtype"] = $res1billtype;
	$a_json_row["age"] = $res1age;
	$a_json_row["gender"] = $res1gender;
	$a_json_row["accountname"] = $res111accountname;
	
	$a_json_row["planfixedamount"] = $planfixedamount;
	$a_json_row["planpercentageamount"] = $planpercentageamount;
	$a_json_row["paymenttype"] = $paymenttype;
	$a_json_row["subtype"] = $subtype;
	
	$a_json_row["value"] = trim($res1customerfullname);
	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1customercode.'#'.$res111accountname;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>
