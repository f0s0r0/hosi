<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if(isset($_REQUEST['update'])) { echo $update = $_REQUEST["update"]; } else { $update = ""; }

if ($frmflag1 == 'frmflag1')
{

      $disease='hai';
	  
      $date=$_REQUEST['date'];
	  $docno=$_REQUEST['docno']; 
	  $conditionofdisease= mysql_real_escape_string($_REQUEST['conditionofdisease']);
	  $scars= mysql_real_escape_string($_REQUEST['scars']);
	  $comments= mysql_real_escape_string($_REQUEST['comments']);
	  
	  $shirt= mysql_real_escape_string($_REQUEST['shirt']);
	  
	  
	  $belt= mysql_real_escape_string($_REQUEST['belt']);
	  $trousers= mysql_real_escape_string($_REQUEST['trousers']);
	  $jacket= mysql_real_escape_string($_REQUEST['jacket']);
	  $socks= mysql_real_escape_string($_REQUEST['socks']);
	  $tie= mysql_real_escape_string($_REQUEST['tie']);
	  $dress= mysql_real_escape_string($_REQUEST['dress']);
	  $skirt= mysql_real_escape_string($_REQUEST['skirt']);
	  $blouse= mysql_real_escape_string($_REQUEST['blouse']);
	  $anyothers= mysql_real_escape_string($_REQUEST['anyothers']);
	  $rings= mysql_real_escape_string($_REQUEST['rings']);
	  $bracelet= mysql_real_escape_string($_REQUEST['bracelet']);
	  $necklace= mysql_real_escape_string($_REQUEST['necklace']);
	  $earrings= mysql_real_escape_string($_REQUEST['earrings']);
	  $watch= mysql_real_escape_string($_REQUEST['watch']);
	  $make= mysql_real_escape_string($_REQUEST['make']);
	  $pens= mysql_real_escape_string($_REQUEST['pens']);
	  $specify= mysql_real_escape_string($_REQUEST['specify']);
	  $id= mysql_real_escape_string($_REQUEST['id']);
	  $keys= mysql_real_escape_string($_REQUEST['keys']);
	  $passport= mysql_real_escape_string($_REQUEST['passport']);
	  $drivinglicense= mysql_real_escape_string($_REQUEST['drivinglicense']);
	  $creditcard= mysql_real_escape_string($_REQUEST['creditcard']);
	  $cash= mysql_real_escape_string($_REQUEST['cash']);
	  $amount= mysql_real_escape_string($_REQUEST['amount']);
	  $othersspecify= mysql_real_escape_string($_REQUEST['othersspecify']);
	  $witnessedby= mysql_real_escape_string($_REQUEST['witnessedby']);
	  $relationship= mysql_real_escape_string($_REQUEST['relationship']);
	  $witnessid= mysql_real_escape_string($_REQUEST['witnessid']);
	  $witnesstelephone= mysql_real_escape_string($_REQUEST['witnesstelephone']);
	  $nextofkin= mysql_real_escape_string($_REQUEST['nextofkin']);
	  $nextofkinrelationship= mysql_real_escape_string($_REQUEST['nextofkinrelationship']);
	  $nextofkinrelationshitelephone= mysql_real_escape_string($_REQUEST['nextofkinrelationshitelephone']);
	  $placeoftransfer= mysql_real_escape_string($_REQUEST['placeoftransfer']);
	
		$query10 = "select docno from mortuary_transferdetails where docno='$docno'";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
	if($num10==0)
	{		 
 $query38="insert into mortuary_transferdetails(date,docno,disease,conditionofdecease,scarsmarkings,comments,shirt,belt,trousers,jacket,socks,tie,dress,skirt,blouse,clothingothers,rings,bracelet,necklace,earrings,watch,make,pens,jewelleryspecify,walletid,
keyy,passport,drivinglicense,creditcard,cash,amount,walletspecify,witnessedby,relationship,witnessid
,witnesstelephone,nextofkin,kinrelationship,nextofkintelephone,username,placeoftransfer) values('$date','$docno','$disease','$conditionofdisease','$scars','$comments','$shirt','$belt','$trousers','$jacket','$socks','$tie','$dress','$skirt','$blouse','$anyothers','$rings','$bracelet','$necklace','$earrings','$watch','$make','$pens','$specify','$id','$keys','$passport','$drivinglicense','$creditcard','$cash','$amount','$othersspecify','$witnessedby','$relationship','$witnessid','$witnesstelephone','$nextofkin','$nextofkinrelationship','$nextofkinrelationshitelephone','$username','$placeoftransfer')";
	}
	else
	{
	  $query38="update mortuary_transferdetails set conditionofdecease='$conditionofdisease',scarsmarkings='$scars',comments='$comments',shirt='$shirt',belt='$belt',trousers='$trousers',jacket='$jacket',socks='$socks',
	  tie='$tie',dress='$dress',skirt='$skirt',blouse='$blouse',clothingothers='$anyothers',rings='$rings',bracelet='$bracelet',necklace='$necklace',earrings='$earrings',watch='$watch',
	  make='$make',pens='$pens',jewelleryspecify='$specify',walletid='$id',keyy='$keys',passport='$passport',drivinglicense='$drivinglicense',creditcard='$creditcard',cash='$cash',amount='$amount',walletspecify='$othersspecify',witnessedby='$witnessedby',
	  relationship='$relationship',witnessid='$witnessid',witnesstelephone='$witnesstelephone',
	  nextofkin='$nextofkin',kinrelationship='$nextofkinrelationship',nextofkintelephone='$nextofkinrelationshitelephone',placeoftransfer='$placeoftransfer' where docno='$docno'";
	}
	   
	  $exec381=mysql_query($query38) or die(mysql_error());

/*		if(isset($_REQUEST['approved'])){
			$docno = $_REQUEST['docno'];
		 $docno; 	
   $query39=mysql_query("update mortuary_request set transferstatus='completed' where docno='$docno'") or die(mysql_error());
		}

		if($paymentstatus=='ipdeposit'){
			header("location:depositform.php?patientcode=$patientcode&&visitcode=$visitcode&&docno=$docno");
		}
		if($update=='update'){
			header("location:mortuaryshellallocation.php?patientcode=$patientcode&&visitcode=$visitcode&&docno=$docno");
		}
		else{
		header("location:mortuaryapprovallist.php");
		}
*/	
			header("location:mortuaryactivity.php");
	exit;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}



?>
<?php



?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<script>
function printmortuary()
 {
	
var popWin; 
popWin = window.open("print_mortuarytransferlist.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno; ?>","OriginalWindowA4",'width=600,height=700,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>

<script>


function validcheck()
{
if(document.getElementById("bed").value == '')
{
alert("Please Select Bed");
document.getElementById("bed").focus();
return false;
}
if(document.getElementById("ward").value == '')
{
alert("Please Select Ward");
document.getElementById("ward").focus();
return false;
}
if(form1.approved.checked==false)
{
alert('please select ready to transfer');
return false;
}


}




function funcvalidation()
{
printmortuary();




}
function funcRadio(id){
	
	if(document.getElementById("approved").id==id)
	{
	document.getElementById("ipdeposit").checked=false;
	}else if(document.getElementById("ipdeposit").id==id)
	{
	document.getElementById("approved").checked=false;
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
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<form name="form1" id="form1" method="post" action="mortyarytransferform.php" onSubmit="return validcheck()">	
  <input type="hidden" name="frmflag1" value="frmflag1" />
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td colspan="2" align="left" valign="center" class="bodytext31"><strong>DocNo</strong></td>
			   <td colspan="1" width="60" align="left" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $docno; ?>" size="10" readonly></td>
			  <td colspan="1" width="144"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td colspan="1" width="146"  align="left" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
               </td>
             </tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><label><strong> Patient Name</strong></label></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="146"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="160"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				 <td width="160"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Shelf</strong></div></td>
				<td width="144"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Package</strong></div></td>
              </tr>
			  
			  
			  
           <?php
            $colorloopcount ='';

	 
	
		$query1 = "select * from mortuary_allocation where patientcode='$patientcode' and visitcode='$visitcode' and docno ='$docno'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
			 $requestno = $res1['requestno'];
		
	
		$query69 = "SELECT * FROM mortuary_request WHERE docno = '$requestno'";
		$exec69 = mysql_query($query69) or die(mysql_error());
		$num69 = mysql_num_rows($exec69);
		$res69 = mysql_fetch_array($exec69);
		$age = $res69['age'];
		$gender = $res69['gender'];
		$billtype = $res69['billtype'];
		
		$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec32 = mysql_query($query32) or die(mysql_error());
		$num32 = mysql_num_rows($exec32);
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		
						  
            $query34 = "SELECT * FROM mortuary_allocation WHERE docno='$docno'";
			$exec34 = mysql_query($query34) or die("Error in Query34: ".mysql_error());
			$res34 = mysql_fetch_array($exec34);
			 $shelf = $res34['shelve'];
			 $package = $res34['package'];
						  
						  
	 $query782="select * from mortuary_transferdetails where docno='$docno'";
	$exec782=mysql_query($query782) or die(mysql_error());
	$result=mysql_fetch_array($exec782);
	 $disease=$result['disease'];
	 $conditionofdisease=$result['conditionofdecease'];
	 $scars=$result['scarsmarkings'];
	 $comments=$result['comments'];
	  $shirt=$result['shirt'];
	 $belt=$result['belt'];
	 $trousers=$result['trousers'];
	 $jacket=$result['jacket'];
	 $socks=$result['socks'];
	 $tie=$result['tie'];
	 $dress=$result['dress'];
	 $skirt=$result['skirt'];
	 $blouse=$result['blouse'];
	 $clothingothers=$result['clothingothers'];
	 $rings=$result['rings'];
	  $bracelet=$result['bracelet'];
	 $necklace=$result['necklace'];
	 $earrings=$result['earrings'];
	 $watch=$result['watch'];
	 $make=$result['make'];
	 $pens=$result['pens'];
	 $jewelleryspecify=$result['jewelleryspecify'];
	 $walletid=$result['walletid'];
	 $keyy=$result['keyy'];
	 $passport=$result['passport'];
	 $drivinglicense=$result['drivinglicense'];
	  $creditcard=$result['creditcard'];
	 $cash=$result['cash'];
	 $amount=$result['amount'];
	 $walletspecify=$result['walletspecify'];
	 $witnessedby=$result['witnessedby'];
	 $relationship=$result['relationship'];
	 $witnessid=$result['witnessid'];
	 $witnesstelephone=$result['witnesstelephone'];
	 $nextofkin=$result['nextofkin'];
	 $kinrelationship=$result['kinrelationship'];
	 $nextofkintelephone=$result['nextofkintelephone'];
	 $placeoftransfer=$result['placeoftransfer'];

	$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				echo "";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			?>
          <tr <?php echo $colorcode; ?>>
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<td  align="center" valign="center" class="bodytext31"><?php echo $shelf; ?></td>
                
				<td  align="center" valign="center" class="bodytext31"><?php echo $package; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">

			   </tr>
			   <tr>
             	<td colspan="1500" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td width="1" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
            
             	<td width="22" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
 
			   
			  <tr>
			  <td colspan="30"align="center" valign="center" bgcolor="#E0E0E0" class="bodytext3" ><b><u>TRANSFER FORM</u></b></td>
			  
			  </tr>
			 
			  <tr>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Place of Transfer:</strong></td>
			  <td><textarea name="placeoftransfer"><?php echo $placeoftransfer;?></textarea></td>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Condition of the diseased:</strong></td>
			  <td><textarea name="conditionofdisease"><?php echo $conditionofdisease;?></textarea></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="146"><strong>Scars,Tattoos,Marking:</strong></td>
			  <td><textarea name="scars"><?php echo $scars;?></textarea></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="160"><strong>Other Comments:</strong></td>
			  <td><textarea name="comments"><?php echo $comments;?></textarea></td>
			  </tr>
			   <tr>
             <td colspan="1500" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
 
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><b style="font-family:Verdana">PERSONAL EFFECTS:</b></td>
			  </tr>
			  <tr>
			  <td colspan="100" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0" cellspacing="5" cellpadding="5"><strong class="bodytext31" width="100" >During removal the following personal effects were found on the diseased and if none mention</strong></td>
			  </tr>
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><strong>Clothing:</strong></td>
			  </tr>
			  <tr>
			  <td colspan="2">Shirt/tshirt</td>
			  <td colspan=""><textarea id="shirt" name="shirt"><?php echo $shirt?></textarea></td>
              
			  <td colspan="" align="right">Belt</td>
			  <td colspan=""><textarea id="belt" name="belt"><?php echo $belt?></textarea></td>
			  <td colspan="1" align="right">Trousers/short</td>
			  <td colspan=""><textarea id="trousers" name="trousers"><?php echo $trousers?></textarea></td>
			  </tr>
              <tr>
			  <td colspan="2">Jacket</td>
			  <td colspan=""><textarea id="jacket" name="jacket"><?php echo $jacket?></textarea></td>
			  <td colspan="" align="right">Socks</td>
			  <td colspan=""><textarea id="socks" name="socks"><?php echo $socks?></textarea></td>
			  <td colspan="" align="right">Tie</td>
			  <td colspan=""><textarea id="tie" name="tie"><?php echo $tie?></textarea></td>
              </tr>
			  <tr>
			  <td colspan="2">Dress</td>
			  <td colspan=""><textarea id="dress" name="dress"><?php echo $dress?></textarea></td>
              
			  <td align="right">Skirt</td>
			  <td colspan=""><textarea id="skirt" name="skirt"><?php echo $skirt?></textarea></td>
              
			  <td align="right">Blouse</td>
			  <td colspan=""><textarea id="blouse" name="blouse"><?php echo $blouse?></textarea></td>
			  <td  align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="2500"><strong>Any others:</strong></td>
			  <td><textarea id="anyothers" name="anyothers"><?php echo $clothingothers?></textarea></td>
              </tr>
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><strong>Jewellery:</strong></td>
			  </tr>
			  <tr>
			  <td colspan="2">Rings</td>
			  <td colspan=""><textarea id="rings" name="rings"><?php echo $rings?></textarea></td>
			  <td colspan="" align="right">Bracelet</td>
			  <td colspan=""><textarea id="bracelet" name="bracelet"><?php echo $bracelet?></textarea></td>
			  <td colspan="1" align="right">Necklace</td>
			  <td colspan=""><textarea id="necklace" name="necklace"><?php echo $necklace?></textarea></td>
			  </tr>
			  <tr>
			  <td colspan="2">Earrings</td>
			  <td colspan=""><textarea id="earrings" name="earrings"><?php echo $earrings?></textarea></td>
			  <td align="right">Watch</td>
			  <td colspan=""><textarea id="watch" name="watch"><?php echo $watch?></textarea></td>
			  <td align="right">Make</td>
			  <td colspan=""><textarea id="make" name="make"><?php echo $make?></textarea></td>
              </tr>
              <tr>
			  <td colspan="2">Pens</td>
			  <td colspan=""><textarea id="pens" name="pens"><?php echo $pens?></textarea></td>
              <td colspan="4">&nbsp;</td>
			  <td  colspan="" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" ><strong>Specify:</strong></td>
			  <td><textarea id="specify" name="specify" rows="0"><?php echo $jewelleryspecify?></textarea>
              </tr>
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><strong>Wallet:</strong></td>
			  </tr>
              
			  <tr>
			  <td colspan="2">Id</td>
			  <td colspan=""><textarea id="id" name="id"><?php echo $walletid?></textarea></td>
			  <td colspan="" align="right">Keys</td>
			  <td colspan=""><textarea id="keys" name="keys"><?php echo $keyy?></textarea></td>
			  <td colspan="1" align="right">Passport</td>
			  <td colspan=""><textarea id="passport" name="passport"><?php echo $passport?></textarea></td>
			  </tr>
              
              
			  <tr>
			  <td colspan="2">DrivingLicense</td>
			  <td colspan=""><textarea id="drivinglicense" name="drivinglicense"><?php echo $drivinglicense?></textarea></td>
			  <td colspan="" align="right">CreditCard</td>
			  <td colspan=""><textarea id="creditcard" name="creditcard"><?php echo $creditcard?></textarea></td>
			  <td colspan="1" align="right">Cash</td>
			  <td colspan=""><input type="text" name="cash" id="cash" value="<?php echo $cash?>"></td>
			  </tr>
			  <tr>
			  <td colspan="2">Amount</td>
			  <td colspan=""><input type="text" name="amount" id="amount" value="<?php echo $amount?>"></td>
              <td colspan="4">&nbsp;</td>
			  <td colspan="" align="right" class="bodytext3"><strong>Others Specify:</strong></td>
			  <td colspan=""><textarea id="othersspecify" name="othersspecify"><?php echo $walletspecify?></textarea></td>
			  <td colspan="1">&nbsp;</td>
			  <td  align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="2500"><strong>&nbsp;</strong></td>
			  <td>&nbsp;</td>
			 </tr>
			 <tr>
             <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
              bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
              bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
				<tr>
				<td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Received by:</strong></td>
				<td><?php echo $username;?></td>
				<td colspan="1" align="center" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Witnessed by:</strong></td>
				<td><input type="text" name="witnessedby" value="<?php echo $witnessedby?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Relationship:</strong></td>
				<td><input type="text" name="relationship" value="<?php echo $relationship?>"></td>
				<td colspan="1" align="center" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Witness ID:</strong></td>
				<td><input type="text" name="witnessid" value="<?php echo $witnessid?>"></td>
				</tr>
				
				<tr>
				<td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Witness Telephone:</strong></td>
				<td><input type="text" name="witnesstelephone" value="<?php echo $witnesstelephone?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Next of Kin</strong></td>
				<td><input type="text" name="nextofkin" value="<?php echo $nextofkin?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Relationship:</strong></td>
				<td><input type="text" name="nextofkinrelationship" value="<?php echo $kinrelationship?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Next of Kin Telephone:</strong></td>
				<td><input type="text" name="nextofkinrelationshitelephone" value="<?php echo $nextofkintelephone?>"></td>
				</tr>
				
 
			  
 
			  
		   <?php 
		  } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
	</tr>
	
      <tr>
        <td width="70">&nbsp;</td>
      </tr>
<!--       <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="3%">&nbsp;</td>
		<td width="26%" align="right" valign="center" class="bodytext311">Request for Approval</td>
		<td width="29%" align="left" valign="center" class="bodytext311">
        <input type="checkbox" name="requestforapproval" id="requestforapproval" value="1">
        
        </td>
      </tr>
-->	  <tr>
<td height="30">&nbsp;</td>
<td width="70">&nbsp;</td>
  	
<td width="96">&nbsp;</td>


	   
      <td width="174"><input type="submit" name="update" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>
	  <td colspan="1" align="left" valign="middle" width="891"><!--<a href="mortuaryshellallocation.php?docno=<?php echo $docno;?>&&patientcode=<?php echo $patientcode;?>&&visitcode=<?php echo $visitcode;?>"><strong><u>Back</u></strong></a>--></td>
</tr>
  </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>



