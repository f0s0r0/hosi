<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$query55 = "select tillnumber from master_company where auto_number='1'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);

$url = 'https://med360-mtiba.tislive.com/api/queue_search.php';
$till_number = $res55['tillnumber'];
$mtiba_anum=3638;

$ipaddress = $_SERVER['REMOTE_ADDR'];
$transactiondate = date('Y-m-d');
$transactiontime = date('h:i:s');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatedate = date('Y-m-d');
ini_set('max_execution_time', 12000000); //120 seconds
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$colorloopcount=0;
$transId = "";
$visitcodeId = "";
$billno = "";
$amount = "";

$query55 = "select * from master_location where username='$username'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationname = $res55['locationname'];
$locationcode = $res55['locationcode'];

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

 	if (isset($_POST["save"])) { $save = $_POST["save"]; } else { $save = ""; }
  
	if (isset($_POST["save"])) {
		
		$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
		$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
		$res = mysql_fetch_array($exec);
			
		$locationname = $res["locationname"];
		$locationcode = $res["locationcode"];
		
		
		$paynowbillprefix = 'AR-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		
		$query2 = "select paylaterdocno from master_transactionpaylater where transactiontype='PAYMENT' and paylaterdocno <>'' order by auto_number desc limit 0, 1";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$billnumber = $res2["paylaterdocno"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode ='AR-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2["paylaterdocno"];
			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			//echo $billnumbercode;
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;
		
			$maxanum = $billnumbercode;
			
			
			$billnumbercode = 'AR-' .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}
		$docno = $billnumbercode;  // docnumber
	
	// ********************************************************************************************************************
	
		$query1 = "select * from master_accountname where auto_number = '$mtiba_anum' AND recordstatus <> 'deleted'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$res1 = mysql_fetch_array($exec1);
	
		$accountname = $res1["accountname"];
		$accountcode = $res1['id'];  
		$paymenttypeanum = $res1['paymenttype'];
		$subtypeanum = $res1['subtype'];
		$accanum = $res1['auto_number'];
		
		$query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$paymenttype = $res2['paymenttype'];
		
		$query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$subtype = $res3['subtype'];
		$subtypeano = $res3['auto_number'];
		
	// ********************************************************************************************************************
		
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MTIBA';			
		$transactionmodule = 'PAYMENT';
		$transactionamount = $_REQUEST['totalcheckamount'];
		
		$sqlquery = "insert into master_transactionpaylater (transactiondate, transactiontime,docno, particulars,paymenttype,subtype,accountname,transactionmode,transactiontype,transactionmodule, transactionamount,mpesaamount,transactionstatus, ipaddress, updatedate, companyanum, companyname,receivableamount, paylaterdocno,locationname,locationcode,username,acc_flag,subtypeano,accountnameid,accountnameano) values ('$transactiondate', '$transactiontime','$docno','$particulars','$paymenttype','$subtype','$accountname','$transactionmode','$transactiontype','$transactionmodule','$transactionamount','$transactionamount','onaccount','$ipaddress', '$updatedate','$companyanum', '$companyname','$transactionamount','$docno','$locationname','$locationcode','$username','2','$subtypeano','$accountcode','$accanum')";
		$exec = mysql_query($sqlquery) or die ("Error in Query9".mysql_error());	
		
		
		$checked_arr = $_POST['checktransid'];
		$count = count($checked_arr);
		
		if($count > 0){

			foreach($_REQUEST['checktransid'] as $key=>$value){
				$transId = $_POST['checktransid'][$key]; 
				$patientcode = $_POST['patientcode'.$transId];
				$patientname = $_POST['patientname'.$transId];
				$visitcode = $_POST['visitcode'.$transId];
				$billnumber = $_POST['billno'.$transId];
				$transactionamount1 = $_POST['amount'.$transId];
				$balanceamount = "0.00";
				$balamount = "0.00";
				$billanum = '';
				
				$sqlquery = "insert into master_transactionpaylater (transactiondate, transactiontime,docno, particulars,patientcode,patientname,visitcode,paymenttype,subtype, accountname,transactionmode, transactiontype, transactionamount,mpesaamount,billnumber,ipaddress, updatedate,recordstatus,companyanum, companyname,billstatus,receivableamount,locationname,locationcode,username,billanum,balanceamount,transactionmodule,billbalanceamount,subtypeano,accountnameano,accountnameid) values ('$transactiondate', '$transactiontime','$docno','$particulars','$patientcode','$patientname','$visitcode','$paymenttype','$subtype','$accountname','$transactionmode','$transactiontype','$transactionamount1','$transactionamount1','$billnumber','$ipaddress', '$updatedate','allocated','$companyanum', '$companyname','paid','$transactionamount1','$locationname','$locationcode','$username','$billanum','$balanceamount','$transactionmodule','$balamount','$subtypeano','$accanum','$accountcode')";

				
				$exequery = mysql_query($sqlquery); 
			    if($exequery){
					
					$bgcolorcode = 'success';	
					$errmsg = "Successfully";
	
				// **************************************************************************************************		
					
					$fields1 ="";	
					
					$fields1 = array(
					 'docno' => urlencode($docno),
					 'transactionId' => urlencode($transId)
					);	
					//print_r($fields1);
					
					$jsondata1 =  json_encode($fields1); 
					$curl = curl_init();
			   
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://med360-mtiba.tislive.com/api/queue_docno_update.php",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $jsondata1,
						CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/json",
						),
					));

					$response1 = curl_exec($curl);
					$err1 = curl_error($curl);

					curl_close($curl);
				  
					if ($err1) {
					  echo "cURL Error #:" . $err1;
					} else {
						echo $response1;
					}

				// **************************************************************************************************		
				//exit;   
									
				}

			}
			
		}else{
			$bgcolorcode = 'failed';	
			$errmsg = "failed";
 
		}			
		header ("location:approved_mtiba_data.php?st=1");
		exit;			
	}

}

//This include updatation takes too long to load for hunge items database.

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success.";
}
if ($st == '2')
{
	$errmsg = "Failed.";
}

?>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript">
	function checkAll1(event){

		if(event.checked === true) {
          // Iterate each checkbox
          $('.checktransid').each(function() {
            this.checked = true;                        
          });
        } 
		else {
          // Iterate each checkbox
          $('.checktransid').each(function() {
            this.checked = false;                        
          });
        }
    
	} 

	
	function chktransidvalidation(){   
		 var sum = 0.00;
		 
	   $('input[class="checktransid"]:checked').each(function() {
			var transidcnt = this.value;
			var amounts =  parseFloat($("#amount"+transidcnt).val()); 
			sum+= amounts;
		 
		});
		$("#totalcheckamount").val(sum.toFixed(2));

		var lenchkbox = $('input.checktransid:checked').length; 
		if(lenchkbox <= 0){
			alert ("Please Select at least one Patient.");
			return false;		
		}
	}		
</script>

 <style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}

</style>
      
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
.pagination{ float:right; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
<tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top">
	    <form action="approved_mtiba_data.php" method="post" >
        <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
            <tr bgcolor="#011E6A">
				<td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong> Search Patient </strong></td>
				<td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation">
					<strong> Location </strong>	<?php echo $locationname; ?>
				</td>
     
            </tr>
        
            <tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
				<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<span class="bodytext3">
						<input name="patientname" type="text" id="patientname" value="" size="50">
					</span>
				</td>
			</tr>
			
			<tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Transaction Id </td>
				<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<span class="bodytext3">
						<input name="transid" type="text" id="transid" value="" size="50">
					</span>
				</td>
			</tr>

			<tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">National No </td>
				<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<span class="bodytext3">
						<input name="nationalid" type="text" id="nationalid" value="" size="50" >
					</span>
				</td>
            </tr>
			<tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
				<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50">
					</span>
				</td>
            </tr>
			<tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Mobile No </td>
				<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<span class="bodytext3">
						<input name="mobileno" type="text" id="mobileno" value="" size="50">
					</span>
				</td>
            </tr>
						
			<tr>
				<td width="100" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
				<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
				</td>
				<td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">
					<span class="bodytext31"><strong> Date To </strong></span>
				</td>
				<td width="263" align="left" valign="center"  bgcolor="#ffffff">
					<span class="bodytext31">
						<input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
						<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
					</span>
				</td>
			</tr>
	
			<tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="submit" value="Search" name="Submit" />
                    <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />
				</td>
            </tr>
            </tbody>
        </table>
		</form>
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="960">
		<form action="approved_mtiba_data.php" method="post" name="form1" id="form1" onSubmit="return chktransidvalidation()" >
			<table width="960" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
            <tr>
                <td colspan="9" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#E0E0E0'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
            </tr>            
			<tr bgcolor="#011E6A">
				<td colspan="9" bgcolor="#CCCCCC" class="bodytext3"><strong>Approved MTIBA Patient Details </strong></td>
            </tr>
			<tr bgcolor="#FFF">
				<td width="29" align="left" class="bodytext31">
					<strong>Sno</strong>
				</td>
				<td width="89" align="left" class="bodytext31">
					<strong>Tranx ID</strong>
				</td>
				<td width="249" align="left" class="bodytext31">
					<strong>Patientname</strong>
				</td>
				<td width="131" align="left" class="bodytext31">
					<strong>National ID</strong>
				</td>
				<td width="68" align="left" class="bodytext31">
					<strong>Visit Code</strong>
				</td>
				<td width="68" align="left" class="bodytext31">
					<strong>Bill Number</strong>
				</td>
				<td width="68" align="center" class="bodytext31">
					<strong>Bill Amount</strong>
				</td>				
				<td width="120" align="center" class="bodytext31">
					<strong>Approved Amount</strong>
				</td>
				<td width="80" align="left" class="bodytext31">
					<strong>Select All</strong>
					<input type="checkbox" id="selectalla" title= "Select All"  onclick="checkAll1(this)" />
				</td>
            </tr>
             <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				$fields = array();				
				if(isset($_POST['patientname'])){$searchpatientname = $_POST['patientname'];}else{$searchpatientname="";}
				if(isset($_POST['transid'])){$searchtransid=$_POST['transid'];}else{$searchtransid="";}
				if(isset($_POST['nationalid'])){$searchnationalid = $_POST['nationalid'];}else{$searchnationalid="";}
				if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
				if(isset($_POST['mobileno'])){$searchmobileno=$_POST['mobileno'];}else{$searchmobileno="";}			
				if(isset($_POST['ADate1'])){ $fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
				if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
				 
			if($cbfrmflag1 !=""){
				
			$fields_string ="";
			$totalamnt = '0';
			 
			//$url = 'https://med360-mtiba.tislive.com/api/queue_approvedata_json.php';
			  $url = 'https://med360-mtiba.tislive.com/api/queue_approvedata_json.php';
			
			$fields = array(
				'patientname' => urlencode($searchpatientname),
				'transid' => urlencode($searchtransid),
				'nationalid' => urlencode($searchnationalid),
				'visitCode' => urlencode($searchvisitcode),
				'mobileno' => urlencode($searchmobileno),
				'fromdate' => urlencode($fromdate),
				'todate' => urlencode($todate),
				'tillNumber' => urlencode($till_number)
			);
				
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();
			
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			
			//execute post
			$result=curl_exec($ch);
			//print_r($result);
			
			if(curl_error($ch))
			{
			 $return_data['status']=0;
			 $return_data['response_message']=curl_error($ch);
			 $return_data['type']="MTIBA";
			   // return $return_data;
			}else{
			    //print_r($result);
				$info = curl_getinfo($ch);
				$json = json_decode($result, true);
				//print_r($json);
				if($info['http_code']=='200' && count($json) > 0)
				{	
					//print_r($json);
				foreach($json as $key=>$value)
				{	
				
				$sqlquery = "SELECT patientcode FROM `master_visitentry` where `transactionId` = '".$value['transactionId']."' AND `visitcode` = '".$value['visitCode']."'";
				$exec = mysql_query($sqlquery) or die ("Error in SqlQuery".mysql_error());
				$resquery = mysql_fetch_array($exec);
				$patientcode = $resquery['patientcode'];
				
				$sqlquery1 = "SELECT transactionamount FROM `master_transactionpaylater` where `master_transactionpaylater`.`visitcode` = '".$value['visitCode']."'  AND `master_transactionpaylater`.`billnumber` = '".$value['billNumber']."' ";
				$exec1 = mysql_query($sqlquery1) or die ("Error in SqlQuery".mysql_error());
				$resquery1 = mysql_fetch_array($exec1);
				
				$billAmount = $resquery1['transactionamount'];
				$approvedAmount	= $value['approvedAmount'];
				
				if($approvedAmount > $billAmount ){
					$atribute="disabled";
				}else{
					$atribute="";
				}
				$colorloopcount = $colorloopcount + 1;
			    $showcolor = ($colorloopcount & 1); 
				$totalamnt = $totalamnt + $value['approvedAmount']; 
				
			    $colorcode = '';
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
			    ?>
			<tr <?php echo $colorcode; ?>>
				<td align="left" class="bodytext31"><?= $colorloopcount; ?></td>
				<td align="left" class="bodytext31"><?= $value['transactionId']; ?></td>
				<td align="left" class="bodytext31"><?= $value['names']; ?>
					<input type="hidden" name="patientname<?= $value['transactionId']; ?>" value="<?= $value['names']; ?>" />
					<input type="hidden" name="patientcode<?= $value['transactionId']; ?>" value="<?= $patientcode; ?>" />
					
				</td>
				<td align="left" class="bodytext31"><?= $value['idNumber']; ?></td>
				<td align="left" class="bodytext31"><?= $value['visitCode']; ?> 
					<input type="hidden" name="visitcode<?= $value['transactionId']; ?>" value="<?= $value['visitCode']; ?>" />
				</td>
				<td align="left" class="bodytext31"><?= $value['billNumber']; ?>
					<input type="hidden" name="billno<?= $value['transactionId']; ?>" value="<?= $value['billNumber']; ?>"/>
				</td>
				<td align="right" class="bodytext31"><?= $billAmount; ?></td>				
				<td align="right" class="bodytext31"><?= $value['approvedAmount']; ?>
					<input type="hidden" name="amount<?= $value['transactionId']; ?>" id="amount<?= $value['transactionId']; ?>" value="<?= $value['approvedAmount']; ?>" />
				</td>
				<td align="center" class="bodytext31"><input type="checkbox" name="checktransid[]" id="checktransid" class= "checktransid<?php echo $atribute; ?>" value="<?= $value['transactionId']; ?>"  <?php echo $atribute; ?>></td>
            </tr>
            <?php	
				} 
			?>
			<tr bgcolor="#FFF">
				<td colspan="7" class="bodytext3" align="right"><strong>Total Approved Amount </strong></td>
				<td align="right" class="bodytext31"><?php echo number_format($totalamnt,2);?></td>
				<td align="left" class="bodytext31">&nbsp;</td>
			</tr>
			<tr >
				<td colspan="9" class="bodytext3" align="center"> 
					<input type="hidden" name="frmflag1" value="frmflag1" /> 
					<input type="hidden" name="totalcheckamount" id="totalcheckamount" /> 
					<input name="save" type="submit"  value="Submit" class="button" />
				</td>
			</tr>				
			<?php	
				}else{
			?>	
			<tr >
				<td colspan="9" align="center" valign="middle" bgcolor="#d4d0d0" class="bodytext3" >
					<font color="#f93635" ><b> ------ No Records Available ------ </b></font>
				</td>			
			</tr>			
            <?php	
				} 
			}
			//close connection
			curl_close($ch);
			}
			?>
			</tbody>
			</table>
		</form>
		</td>
      </tr>
          </tbody>
        </table>
		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

