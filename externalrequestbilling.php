<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billnumber"])) { $billautonumber = $_REQUEST["billnumber"]; } else { $billautonumber = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_external where billstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$billnumber = $billnumbercode;

	$pharmbillnumber= $_REQUEST['pharmbillno'];
	$requestbillno = $_REQUEST['requestbillno'];
	
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
	$referalname=$_REQUEST['referalname'];
	$paymentmode = $_REQUEST['billtype'];
	$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['chequedate'];
		$bankname = $_REQUEST['chequebank'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$card = $_REQUEST['cardname'];
		$cardnumber = $_REQUEST['cardnumber'];
		$bankname1 = $_REQUEST['bankname1'];
		$paymenttype = $_REQUEST['paymenttype'];
		
		$cashgiventocustomer = $_REQUEST['cashgiventocustomer'];
		$cashgivenbycustomer = $_REQUEST['cashgivenbycustomer'];
		$cashamount = $_REQUEST['cashamount'];
		$onlineamount = $_REQUEST['onlineamount'];
		$chequeamount = $_REQUEST['chequeamount'];
		$cardamount = $_REQUEST['cardamount'];
		$creditamount = $_REQUEST['creditamount'];
		
		$labcoa = $_REQUEST['labcoa'];
		$radiologycoa = $_REQUEST['radiologycoa'];
		$servicecoa = $_REQUEST['servicecoa'];
	
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
			
		
		$patientfullname=$_REQUEST['patientname'];
		$age=$_REQUEST['patientage'];
		$gender=$_REQUEST['patientgender'];

		$rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		$query21 = "select * from consultation_radiology order by auto_number desc limit 0, 1";
	    $exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
		$res21 = mysql_fetch_array($exec21);
		$radrefnonumber = $res21["refno"];
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysql_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysql_query("update consultation_radiology set paymentstatus = 'paid', billnumber = '$billnumber' where patientname = '$patientfullname' and radiologyitemcode = '$radiologycode' and billnumber = '$requestbillno'") or die(mysql_error());
		$radiologyquery12=mysql_query("insert into billing_externalradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billdate,paymentstatus,billnumber,username,radiologycoa)values('walkin','$patientfullname','walkinvis','$radiologycode','$pairvar','$pairvar1','$currentdate','paid','$billnumber','$username','$radiologycoa')") or die(mysql_error());
		}
                                                 }
		
		$query2 = "select * from consultation_lab order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$labrefnonumber = $res2["refno"];

			foreach($_POST['categorylab'] as $key=>$value)
	{
	
	$categorylabname=$_POST['categorylab'][$key];
	$categorylabname;
	
	$categorylabrate=$_POST['categoryrate5'][$key];
	if($categorylabname != "")
	{
	$categorylabquery1=mysql_query("update consultation_lab set paymentstatus = 'paid', billnumber = '$billnumber' where patientname = '$patientfullname' and labitemcode = '$labcode' and billnumber = '$requestbillno'") or die(mysql_error());
	$labquery31=mysql_query("insert into billing_externallab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billdate,paymentstatus,billnumber,username,labcoa)values('walkin','$patientfullname','walkinvis','$labcode','$categorylabname','$categorylabrate','$currentdate','paid','$billnumber','$username','$labcoa')") or die(mysql_error());
	}	
	}
	
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysql_query("update consultation_lab set paymentstatus = 'paid', billnumber = '$billnumber' where patientname = '$patientfullname' and labitemcode = '$labcode' and billnumber = '$requestbillno'") or die(mysql_error());
		$labquery21=mysql_query("insert into billing_externallab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billdate,paymentstatus,billnumber,username,labcoa)values('walkin','$patientfullname','walkinvis','$labcode','$labname','$labrate','$currentdate','paid','$billnumber','$username','$labcoa')") or die(mysql_error());
			}
		}
		$query22 = "select * from consultation_services order by auto_number desc limit 0, 1";
	    $exec22 = mysql_query($query22) or die ("Error in Query2".mysql_error());
		$res22 = mysql_fetch_array($exec22);
		$serrefnonumber = $res22["refno"];
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysql_query("update consultation_services set paymentstatus = 'paid', billnumber = '$billnumber' where patientname = '$patientfullname' and servicesitemcode = '$servicescode' and billnumber = '$requestbillno'") or die(mysql_error());
		$servicesquery41=mysql_query("insert into billing_externalservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billdate,paymentstatus,billnumber,username,servicecoa)values('walkin','$patientfullname','walkinvis','$servicescode','$servicesname','$servicesrate','$currentdate','paid','$billnumber','$username','$servicecoa')") or die(mysql_error());
		}
		}
		
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		$transactionmodule = 'PAYMENT';
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		
		$query9 = "insert into master_transactionexternal (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cashamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,cash,cashcoa,source)values('$patientfullname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cashcoa','externalbilling')";
        $exec37 = mysql_query($query37) or die(mysql_error());


		}
		
		if ($paymentmode == 'SPLIT')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT';
		$particulars = 'BY SPLIT '.$billnumberprefix.$billnumber.'';	
		
		$query9 = "insert into master_transactionexternal (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks,cardamount,onlineamount,chequeamount,chequenumber,
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cashamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', '$cardamount', '$onlineamount', '$chequeamount', 
		'$chequenumber', '$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,source)values('$patientfullname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','externalbilling')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	

		}
		
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA '.$billnumberprefix.$billnumber.'';	
		
		$query9 = "insert into master_transactionexternal (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,creditamount,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cashamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$creditamount','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$mpesacoa','externalbilling')";
        $exec37 = mysql_query($query37) or die(mysql_error());


		}
		
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		$query9 = "insert into master_transactionexternal (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$onlineamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,online,onlinecoa,source)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$onlinecoa','externalbilling')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	    }
		if ($paymentmode == 'CREDIT CARD')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber.'';	
		$query9 = "insert into master_transactionexternal (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, cardamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,creditcardname,creditcardnumber,creditcardbankname) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cardamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$card','$cardnumber','$bankname1')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,card,cardcoa,source)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cardcoa','externalbilling')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	    }
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		
			$query9 = "insert into master_transactionexternal (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$chequeamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,cheque,chequecoa,source)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$chequecoa','externalbilling')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	    }
	    
		if ($paymentmode != '' && $nettamount1 != "0.00") { 	
	 	mysql_query("insert into billing_external(billno,patientname,patientcode,visitcode,totalamount,billdate,age,gender,username)values('$billnumber','$patientfullname','walkin','walkinvis','$totalamount','$billdate','$age','$gender','$username')") or die(mysql_error());
		mysql_query("update external_request set billstatus = 'paid', externalbillno = '$billnumber' where billno = '$requestbillno'") or die(mysql_error());
	                        }
		header("location:menupage1.php?savedbillnumber=$billnumber&&mainmenuid=MM005");
        exit;
    
       }
	   
//to redirect if there is no entry in masters category or item or customer or settings




//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysql_query($query77) or die ("Error in Query77".mysql_error());
$res77 = mysql_fetch_array($exec77);
$res77allowed = $res77["allowed"];




/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["billnumber"])) { $pharmbillnumber = $_REQUEST["billnumber"]; } else { $pharmbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}

?>
<?php
$query23 = "select * from external_request where billno = '$billautonumber'";
$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
$res23 = mysql_fetch_array($exec23);
$patientname = $res23['patientname'];
$patientage = $res23['age'];
$patientgender = $res23['gender'];
?>
<?php

$query76 = "select * from master_financialintegration where field='labexternal'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyexternal'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceexternal'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalexternal'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyexternal'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashexternal'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeexternal'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaexternal'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardexternal'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineexternal'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>
<?php

$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_external where billstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>


<script language="javascript">
<?php

if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>

function funcOnLoadBodyFunctionCall()
{

	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcPopupPrintFunctionCall();
	//alert ("Auto Print Function Runs Here.");	
}




function funcPopupPrintFunctionCall()
{

	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysql_query($query1print) or die ("Error in Query1print.".mysql_error());
	$res1print = mysql_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	//alert ("Auto Print Function Runs Here.");
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/


}

//Print() is at bottom of this page.

</script>

<script type="text/javascript">
function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	//alert(varBillNumber);
	var varBillAutoNumber ="<?php //echo $previousbillautonumber; ?>" ;
	//alert(varBillAutoNumber);
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_paynow.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_paynow_a5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}

function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
	}
}

function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="billing_paynow.php";
	}
	//return false;
}



</script>
<script type="text/javascript">

function balancecalc(mode)
{
var mode = mode;
var cashamount = document.getElementById("cashamount").value;
//alert(cashamount);
if(cashamount == '')
{
cashamount = 0;
}
var chequeamount = document.getElementById("chequeamount").value;
if(chequeamount == '')
{
chequeamount = 0;
}
var cardamount = document.getElementById("cardamount").value;
if(cardamount == '')
{
cardamount = 0;
}
var onlineamount = document.getElementById("onlineamount").value;
if(onlineamount == '')
{
onlineamount = 0;
}
var mpesaamount = document.getElementById("creditamount").value;
if(mpesaamount == '')
{
mpesaamount = 0;
}
var balance =  document.getElementById("subtotal").value;
var totalamount = parseFloat(cashamount)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount);

var newbalance=parseFloat(balance) - parseFloat(totalamount);

if(newbalance < 0)
{
alert("Entered Amount is greater than Bill Amount");

if(mode == '1')
{
document.getElementById("cashamount").value = '0.00';
}    
if(mode == '2')
{
document.getElementById("creditamount").value = '0.00';
}  
if(mode == '3')
{
document.getElementById("chequeamount").value = '0.00';
}  
if(mode == '4')
{
document.getElementById("cardamount").value = '0.00';
}  
if(mode == '5')
{
document.getElementById("onlineamount").value = '0.00';
}            
          
return false;

}

document.getElementById("tdShowTotal").innerHTML = newbalance.toFixed(2);
}
</script>
<?php include ("js/sales1scripting1.php"); ?>

<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

<script src="js/datetimepicker_css.js"></script>

<script>
function printPaynowBill()
 {
var popWin; 
popWin = window.open("print_otcbilling_dmp4inch1.php?billnumber=<?php echo $billnumbercode; ?>&&ranum=<?php echo (rand(10,100)); ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>

<script>
function funcSaveBill1()
{
var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.frmsales.submit();
		//return true;
	}
	</script>
	
<script>	
function loadprintpage3()
{
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script>	
function quickprintbill2sales()
{
   
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow_dmp4inch1view1.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="externalrequestbilling.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>

  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#CCCCCC" class="bodytext32"><strong>External Billing </strong></td>
			 </tr>
			 <?php
			 if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
			 if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				
     		 if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
             
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage3()" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
            </tr>
			<?php
			}
			?>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
             <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?>
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
						<input type="hidden" name="pharmbillno" id="pharmbillno" value="<?php echo $pharmbillnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientage; ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="requestbillno" value="<?php echo $billautonumber; ?>">
				<input type="hidden" name="patientage" value="<?php echo $patientage; ?>">
				<input type="hidden" name="patientgender" value="<?php echo $patientgender; ?>">
				
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill Date</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $dateonly; ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
              	<input type="hidden" name="account" id="account" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Gender</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientgender; ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong></strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientaccount1; ?>
				<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                  <input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  <input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table>
   
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#CCCCCC" class="bodytext32"><strong>Transaction Details</strong></td>
			 </tr>
          
             <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
                  </tr>


		
			   <?php 
			   $totalpharm=0;
			   $totalrad = 0;
			   $totalser = 0;
			$query23 = "select * from consultation_lab where patientname='$patientname' and billnumber = '$billautonumber' and paymentstatus='pending'";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			while($res23 = mysql_fetch_array($exec23))
			{
			$labdate=$res23['consultationdate'];
			$labitemname=$res23['labitemname'];
			$labitemcode=$res23['labitemcode'];
			$labitemrate=$res23['labitemrate'];
			$labrefno=$res23['refno'];
			$res23billnumber = $res23['billnumber'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalpharm=$totalpharm+$labitemrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labitemname; ?></div></td>
			  <input type="hidden" name="lab[]" value="<?php echo $labitemname; ?>">
			 <input name="rate5[]" type="hidden" id="rate5" readonly size="8" value="<?php echo $labitemrate; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labitemrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
			  
			  <?php }
			  ?>
			  <?php
			    $query24 = "select * from consultation_radiology where patientname='$patientname' and billnumber = '$billautonumber' and paymentstatus='pending'";
			$exec24 = mysql_query($query24) or die ("Error in Query1".mysql_error());
			while($res24 = mysql_fetch_array($exec24))
			{
			$raddate=$res24['consultationdate'];
			$raditemname=$res24['radiologyitemname'];
			$raditemcode=$res24['radiologyitemcode'];
			$raditemrate=$res24['radiologyitemrate'];
			$radrefno=$res24['refno'];
			$res24billnumber = $res24['billnumber'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalrad=$totalrad+$raditemrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $raditemname; ?></div></td>
			  <input type="hidden" name="radiology[]" value="<?php echo $raditemname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $raditemrate; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $raditemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $raditemrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  </tr>
			  <?php }
			  ?>
	  			 <?php
			    $query25 = "select * from consultation_services where patientname='$patientname' and billnumber = '$billautonumber' and paymentstatus='pending'";
			$exec25 = mysql_query($query25) or die ("Error in Query1".mysql_error());
			while($res25 = mysql_fetch_array($exec25))
			{
			$serdate=$res25['consultationdate'];
			$seritemname=$res25['servicesitemname'];
			$seritemcode=$res25['servicesitemcode'];
			$seritemrate=$res25['servicesitemrate'];
			$serrefno=$res25['refno'];
			$res25billnumber = $res25['billnumber'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalser=$totalser+$seritemrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $seritemname; ?></div></td>
			  <input type="hidden" name="services[]" value="<?php echo $seritemname; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $seritemrate; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $seritemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $seritemrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  </tr>
			  <?php }
			  ?>
			  <?php 
			  $overalltotal=$totalpharm + $totalrad + $totalser;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $netpay= $totalpharm + $totalrad + $totalser;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
			  ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo $overalltotal; ?></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#cccccc"><div align="right"><strong>&nbsp;</strong></div></td>
			 </tr>
          </tbody>
        </table>		</td>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td><table width="99%" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="#F3F3F3" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
          <tbody id="foo">
            <tr>
              <td width="1%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
              <td colspan="4" rowspan="10" align="left" valign="top"  
                bgcolor="#F3F3F3" class="bodytext31"><!--<table width="99%" border="0" align="right" cellpadding="2" cellspacing="0"  style="BORDER-COLLAPSE: collapse">
				<tr>
				  <td width="53%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong> Disc %                  </strong></span></div></td>
				  <td><span class="bodytext311"><strong>
				    <input name="allitemdiscountpercent" id="allitemdiscountpercent" onKeyUp="return funcAllItemDiscountApply1()" 
				style="border: 1px solid #001E6A; text-align:right;" value="0.00" size="4" />
				  <input name="allitemdiscountpercent1" id="allitemdiscountpercent1" onKeyUp="return funcAllItemDiscountApply1()" 
				style="border: 1px solid #001E6A; text-align:right;background-color:#CCCCCC" value="0.00" size="4"  />
				  <input name="subtotaldiscountpercent" id="subtotaldiscountpercent" onKeyDown="return funcResetPaymentInfo1()" 
					 type="hidden" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" />
				    <input name="totaldiscountamount" id="totaldiscountamount" value="0.00" type="hidden" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
				    <input type="hidden" name="subtotaldiscountrupees" id="subtotaldiscountrupees" onKeyDown="return funcResetPaymentInfo1()" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" />
				    <input type="hidden" name="afterdiscountamount" id="afterdiscountamount" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
				  </strong></span></td>
				  </tr>
				 
				  <tr bordercolor="#f3f3f3">
                    <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>  Disc Amt </strong></span></div></td>
				    <td><span class="bodytext311"><strong>
                      <input name="totaldiscountamountonlyapply1" id="totaldiscountamountonlyapply1" onKeyUp="return funcDiscountAmountCalc1()" 
				type="text" style="border: 1px solid #001E6A; text-align:right;" value="0.00" size="4" />
                      <input name="totaldiscountamountonlyapply2" id="totaldiscountamountonlyapply2" onKeyUp="return funcDiscountAmountCalc1()" readonly  
				type="text" style="border: 1px solid #001E6A; text-align:right; background-color:#CCCCCC" value="0.00" size="4" />
                    </strong></span></td>
				    </tr>
			
				  
 				
				  <tr>
                    <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><span class="bodytext311">
                     
                    </span>
                      <div align="right"><strong><?php //.' '.$res6taxpercent.'%'; ?></strong></div></td>
                    <td width="39%"><span class="bodytext312">
                     
                    </span></td>
                  </tr>
                </table>-->              </td>
              <?php
				$originalamount = $totalamount;
			  $totalamount = round($totalamount);
			  $totalamount = number_format($totalamount,2,'.','');
			  $roundoffamount = $originalamount - $totalamount;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  ?>
              <td width="3%" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?php echo $totalamount; ?></td>
              <td width="12%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Sub Total </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
              <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext31">
                <input name="subtotal" id="subtotal" value="<?php echo $originalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
              </span></td>
              <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>Bill Amt </strong></div></td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="9%"><span class="bodytext311">
                <input name="totalamount" id="totalamount" value="<?php echo $totalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
              </span></td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="23%">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Round Off </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
              <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext311">
                <input name="roundoff" id="roundoff" value="<?php echo $roundoffamount; ?>" style="text-align:right"  readonly="readonly" size="8"/>
                <input name="totalaftercombinediscount" id="totalaftercombinediscount" value="0.00" style="text-align:right" size="8"  readonly="readonly" type="hidden"/>
              </span></td>
              <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="8%"><div align="right"><strong>Nett Amt</strong></div></td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="6%">&nbsp;</td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="9%"><span class="bodytext31">
                <input name="nettamount" id="nettamount" value="0.00" style="text-align:right" size="8" readonly />
              </span></td>
              <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="23%">&nbsp;</td>
            </tr>
          <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly"/>
          <tr>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
            <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Mode </strong></div></td>
            <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
            <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="15%"><select name="billtype" id="billtype" onChange="return paymentinfo()">
                <option value="">SELECT BILL TYPE</option>
                <?php
					$query1billtype = "select * from master_billtype where status = '' order by listorder";
					$exec1billtype = mysql_query($query1billtype) or die ("Error in Query1billtype".mysql_error());
					while ($res1billtype = mysql_fetch_array($exec1billtype))
					{
					$billtype = $res1billtype["billtype"];
					?>
                <option value="<?php echo $billtype; ?>"><?php echo $billtype; ?></option>
                <?php
					}
					?>
                <!--					
                    <option value="CASH">CASH</option>
                    <option value="CREDIT">CREDIT</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="CREDIT CARD">CREDIT CARD</option>
                    <option value="ONLINE">ONLINE</option>
                    <option value="SPLIT">SPLIT</option>
-->
            </select></td>
            <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="10%">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="8%"><!--<select name="billtype" id="billtype" onChange="return paymentinfo()" onFocus="return funcbillamountcalc1()">--></td>
            <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#F3F3F3" width="9%">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#F3F3F3" width="23%">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
          </tr>
          <tr id="cashamounttr">
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
            <td colspan="2" align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash </strong></div></td>
            <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
            <td width="15%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Recd </strong></div></td>
            <td width="10%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()" tabindex="2" style="text-align:right" size="8" autocomplete="off"  /></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>Change </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%">&nbsp;</td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
          </tr>
          <tr id="creditamounttr">
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
            <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('2')"/></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%"></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="23%"></td>
            <td width="1%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
          </tr>
          <tr id="chequeamounttr">
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
            <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cheque </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="chequenumber" id="chequenumber" value="" style=" text-align:left; text-transform:uppercase" size="8"  /></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong> Date </strong></div></td>
            <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequedate" id="chequedate" value="" style="text-transform:uppercase" size="8"  /></td>
            <td width="9%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank </strong></div></td>
            <td width="23%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequebank" id="chequebank" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
          </tr>
          <tr id="cardamounttr">
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
            <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('4')"/></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Card No </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="cardnumber" id="cardnumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
            <td width="8%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name </strong></div></td>
            <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="text" name="cardname" id="cardname" size="8" style="text-align:left;">
                <!--<select name="cardname" id="cardname">
                  <option value="">SELECT CARD</option>
                  <?php
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysql_query($querycom) or die("Error in querycom".mysql_error());
				while($rescom=mysql_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				?>
                  <option value="<?php echo $creditcardname;?>"><?php echo $creditcardname;?></option>
                  <?php
				}
				?>
                </select>--></td>
            <td align="left" valign="center" class="bodytext31" width="9%"><div align="right"><strong> Bank </strong></div></td>
            <td align="left" valign="center" class="bodytext31" width="23%"><input name="bankname1" id="bankname" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase"  size="8"  /></td>
          </tr>
          <tr id="onlineamounttr">
            <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
            <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Online </strong></div></td>
            <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
            <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Online No </strong></div></td>
            <td align="left" valign="center"  
                 class="bodytext31" width="10%"><input name="onlinenumber" id="onlinenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
            <td align="left" valign="center"  
                 class="bodytext31" width="8%">&nbsp;</td>
            <td align="left" valign="center"  
                 class="bodytext31" width="6%">&nbsp;</td>
            <td align="left" valign="center"  
                 class="bodytext31" width="9%">&nbsp;</td>
            <td align="left" valign="center"  
                 class="bodytext31" width="23%">&nbsp;</td>
            <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="14" align="left" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
                <input name="Submit2223" type="submit" onClick="return funcSaveBill1()" value="Save Bill(Alt+S)" accesskey="s" class="button"/>
            </font></font></font></font></font></div></td>
          </tr>
          <!-- <tr>
                <td colspan="8" class="bodytext32">
				<div align="right"><span class="bodytext31">
                <strong>Print Bill No: </strong>
                <input name="quickprintbill" id="quickprintbill" value="<?php echo $billnumber; ?>" style=" text-align:right; text-transform:uppercase"  size="7"  />
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="print4inch2" type="hidden" class="button" id="print4inch2" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill1sales()" value="Print 40" accesskey="p"/>
                </font></font></font></font></font></font></font></font></font>                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="print4inch" type="button" class="button" id="print4inch" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill2sales()" value="View 40" accesskey="p"/>
                  <input onClick="return loadprintpage1('A4<?php //echo $previousbillnumber; ?>')" value="View A4" 
				  name="printA4" type="button" class="button" id="printA4" style="border: 1px solid #001E6A"/>
                  <input onClick="return loadprintpage1('A5<?php //echo $previousbillnumber; ?>')" value="View A5" 
				  name="printA5" type="button" class="button" id="printA5" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></font></font></font></font></span></div>
				</td>
			 </tr>-->
        </table></td>
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>