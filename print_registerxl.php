<?php
session_start();
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
ini_set('max_execution_time', 12000000); //120 seconds
$errmsg = "";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Patientslist.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["searchnationalid"])) { $searchnationalid = $_REQUEST["searchnationalid"]; } else { $searchnationalid = ""; }
if (isset($_REQUEST["account"])) { $searchaccountcode = $_REQUEST["account"]; } else { $searchaccountcode = ""; }
//$getcanum = $_GET['canum'];
$colorloopcount  = 0;
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

<body>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1147" 
            align="left" border="0">
          <tbody>
           <tr>
                <td width="22"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                <td width="59" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
                <td width="62" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
                <td width="161" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type </strong></div></td>
                <td width="62"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Type </strong></td>
                <td width="160"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
                  <td width="160"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
                <td width="63" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
                <td width="55"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
                      <td width="69"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>
                  <!--OpeningBalance-->
                  NationalID</strong> </div></td>
				   <td width="50"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User</strong></div></td>

				   <td width="48"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong></strong></div></td>
             
                 </tr>
			  <?php 
			  if($searchaccountcode == '') {
            $query2 = "select * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%'";
			} else {
			$query2 = "select * from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and accountname = '$searchaccountcode'";
			}
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $num2 = mysql_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysql_fetch_array($exec2))
			  {
			  $res2customercode = $res2['customercode'];
			  $res2customeranum = $res2['auto_number'];
			  $res2customername = $res2['customerfullname'];
			  $res2customercode = $res2['customercode'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $paymenttypeanum = $res2['paymenttype'];
			  $user = $res2['username'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $subtypeanum = $res2['subtype'];
			  
			  $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysql_query($query4) or die ("Error in Query5".mysql_error());
			  $res4 = mysql_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];
			  $res2billtype = $res2['billtype'];
			  $accountnameanum = $res2['accountname'];
	          $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
			  $res2accountexpirydate = $res2['accountexpirydate'];
			  $plannameanum = $res2['planname'];
			  $query6 = "select * from master_planname where auto_number = '$plannameanum'";
			  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			  $res6 = mysql_fetch_array($exec6);
			  $res6planname = $res6['planname'];
			  
			  $res2planexpirydate = $res2['planexpirydate'];
			  $res2visitlimit = $res2['visitlimit'];
			  $res2overalllimit = $res2['overalllimit'];
			  $res2customername	= $res2['customerfullname'];
			  $dob = $res2['dateofbirth']; 
			  
			  $res2age = calculate_age($dob);

			
			  $res2gender = $res2['gender'];
			  $res2mothername = $res2['mothername'];
			  $res2bloodgroup = $res2['bloodgroup'];
			  $res2area = $res2['area'];
			  $res2nationalidnumber = $res2['nationalidnumber'];
			  $res2pincode = $res2['pincode'];
			  $res2mobilenumber = $res2['mobilenumber'];
			  $res2phonenumber1 = $res2['phonenumber1'];
			  $res2phonenumber2 = $res2['phonenumber2'];
			  $res2emailid1 = $res2['emailid1'];
			  $res2kinname = $res2['kinname'];
			  $res2kincontact = $res2['kincontactnumber'];
			  $res2emailid2 = $res2['emailid2'];
			  $res2faxnumber1 = $res2['faxnumber'];
			  $res2faxnumber2 = '';
			  $res2anum = $res2['auto_number'];
			  $res2address1 = $res2['address1'];
			  $res2city = $res2['city'];
			  $res2openingbalance1 = $res2['openingbalance'];
			  $res2insuranceid = $res2['insuranceid'];
			  $res2registrationdate = $res2['registrationdate'];
			  if ($res2registrationdate == '0000-00-00') $res2registrationdate = '';
			  $res2registrationtime = $res2['registrationtime'];
			  $res2consultingdoctor = $res2['consultingdoctor'];
			  $query201 = "select * from master_doctor where doctorcode = '$res2consultingdoctor'";
			  $exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
			  $res201 = mysql_fetch_array($exec201);
			  $res2consultingdoctor = $res201['doctorname'];
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  $res3ipnumber = '';
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#FFF"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#FFF"';
				}
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $res2customercode; ?></span></div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left">
				  <span class="bodytext3">
				  <?php echo $res4subtype; //.' ('.$res2customercode.')'; ?>				  </span>				  </div>
                </div>				</td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2billtype; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res5accountname; ?></div></td>
                     <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2customername; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2age; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="center">
				<?php echo $res2gender; ?>
				</div></td>
                    <td class="bodytext31" valign="center"  align="left"><?php echo $res2nationalidnumber; ?></td>
					<td class="bodytext31" valign="center"  align="left"><?php echo $user; ?></td>
					 <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
                  </tr>
			  <?php
				}
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
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
           	</tr>
          </tbody>
        </table>
		
</body>
</html>

