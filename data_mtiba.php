<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$query55 = "select tillnumber from master_company where auto_number='1'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);


$url = 'https://med360-mtiba.tislive.com/queue_data_json.php';
$till_number = $res55['tillnumber'];

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-3 days'));
$transactiondateto = date('Y-m-d');
//ini_set('max_execution_time', 12000000); //120 seconds
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

$query55 = "select * from master_location where username='$username'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationname = $res55['locationname'];
$locationcode = $res55['locationcode'];
	
function calculate_age($birthday)
			{
				$today = new DateTime();
				$diff = $today->diff(new DateTime($birthday));
			
				if ($diff->y)
				{
					return $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
					return $diff->m . ' Months';
				}
				else
				{
					return $diff->d . ' Days';
				}
			}
?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}

</style>

<script type="text/javascript">


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}



</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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

<script type="text/javascript">
window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl2(document.getElementById("searchaccountname"), new StateSuggestions2());        
}
</script>

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
	    <form action="data_mtiba.php" method="post" >
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
			<!--
			<tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
				<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					<span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50">
					</span>
				</td>
            </tr> -->

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
    <td width="97%" valign="top">
	
	<table width="116%" border="0" cellspacing="0" cellpadding="0">
		<tr>
        <td width="860">
		
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
				<tr bgcolor="#011E6A">
					<td colspan="8" bgcolor="#CCCCCC" class="bodytext3"><strong>MTIBA Patient Details </strong></td>
				</tr>
				<tr bgcolor="#FFF">
					<td width="29" align="left" class="bodytext31"><strong>Sno</strong></td>
					<td width="89" align="left" class="bodytext31"><strong>Tranx ID</strong></td>
					<td width="249" align="left" class="bodytext31"><strong>Patientname</strong></td>
					<td width="68" align="left" class="bodytext31"><strong>Age</strong></td>
					<td width="96" align="center" class="bodytext31"><strong>Gender</strong></td>
					<td width="131" align="left" class="bodytext31"><strong>National ID</strong></td>
					<td width="131" align="left" class="bodytext31"><strong>Registration No</strong></td>
					<td width="200" align="left" class="bodytext31"><strong>Action</strong></td>
				</tr>
		<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }
			$fields = array();				
			if(isset($_POST['patientname'])){$searchpatientname = $_POST['patientname'];}else{$searchpatientname="";}
			if(isset($_POST['transid'])){$searchtransid=$_POST['transid'];}else{$searchtransid="";}
			if(isset($_POST['nationalid'])){$searchnationalid = $_POST['nationalid'];}else{$searchnationalid="";}
			if(isset($_POST['mobileno'])){$searchmobileno=$_POST['mobileno'];}else{$searchmobileno="";}			
			if(isset($_POST['ADate1'])){ $fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
			if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
				 
				if($cbfrmflag1 !=""){
					
					

				$fields_string ="";
				
				
				$fields = array(
					'patientname' => urlencode($searchpatientname),
					'transid' => urlencode($searchtransid),
					'nationalid' => urlencode($searchnationalid),
					'mobileno' => urlencode($searchmobileno),
					'fromdate' => urlencode($fromdate),
					'todate' => urlencode($todate),
					'tillNumber' => urlencode($till_number)
				);
				//print_r($fields);
				
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();
			//print_r($fields);
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			
			//execute post
			$result=curl_exec($ch);
			//  print_r($result);
			
			if(curl_error($ch))
			{
			 $return_data['status']=0;
			 $return_data['response_message']=curl_error($ch);
			 $return_data['type']="MTIBA";
			?>
				<tr>
					<td colspan="7">No Internet Connection</td>
				</tr>	
			<?php
			}else{
			 
				$info = curl_getinfo($ch);
				$json = json_decode($result, true);
				//print_r($json);
				
				if($info['http_code']=='200' && count($json) > 0)
				{	
					//print_r($json);
				foreach($json as $key=>$value)
				{	
				
				$res2age = calculate_age($value['dob']);

				$customercode='';

				$id_with = trim($value['idNumber']);	
				$id_with_plus = str_replace('-254','-+254', trim($value['idNumber']));	
				$id = str_replace('-254','-0', trim($value['idNumber']));	
				$id_no_mobile = substr(trim($value['idNumber']),0,-12);	

				 $sqlquery = "SELECT customercode FROM `master_customer` where concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id_with' OR concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id_with_plus' OR concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id' OR concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id_no_mobile' UNION ALL SELECT customercode FROM `master_customer` where `nationalidnumber` = '".$value['idNumber']."'";
				$exec = mysql_query($sqlquery) or die ("Error in SqlQuery".mysql_error());
				if($res = mysql_fetch_array($exec)){
					$customercode = $res['customercode'];
				}

	
				$sqlquery = "SELECT transactionId FROM `master_visitentry` where `transactionId` = '".$value['transactionId']."'";
				$exec = mysql_query($sqlquery) or die ("Error in SqlQuery".mysql_error());
				$num=mysql_num_rows($exec);
				if($num <= 0){				
				
				$colorloopcount = $colorloopcount + 1;
			    $showcolor = ($colorloopcount & 1); 
				
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
                <td align="left" class="bodytext31"><?= $value['names']; ?></td>
                <td align="left" class="bodytext31"><?= $res2age; ?></td>
               <td  align="left" valign="center" class="bodytext31"><div align="center">
				<?php if(($value['gender'] == 'M'))
				 {
				?>
				<img src="images/male.png" width="16" height="16" border="0" />
				<?php
				 }
				 else
				 {
				?>
				<img src="images/female.png" width="16" height="16" border="0" />
				 <?php
				 }
				 ?>
				</div></td>
                <td align="left" class="bodytext31"><?= $value['idNumber']; ?></td>
                <td align="left" class="bodytext31"><?= $customercode; ?></td>
                <td align="center" class="bodytext31"><a href="newpatientreg2.php?txnid=<?= $value['transactionId']; ?>">
                	<?= ($customercode!="")?'OP Visit':'Register and OP Visit'; ?>
                </a></td>
                </tr>
                <?php	
				}
				}
				}
			}
				} 				
				?>


			</tbody>
			
        </table>
		
		</td>
		
		</tr>
    </table>
		
		
	</td>
</tr>

      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
</table>

<?php include ("includes/footer1.php"); ?>
</body>


