<?php
include("db/db_connect.php");

$fileData1 = '';

date_default_timezone_set('Africa/Nairobi'); 

if(isset($_REQUEST['billautonumber'])) { $billautonumber = $_REQUEST['billautonumber']; } else { $billautonumber = ''; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; } else { $visitcode = ''; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; } else { $patientcode = ''; }
if(isset($_REQUEST['printbill'])) { $printbill = $_REQUEST['printbill']; } else { $printbill = ''; }
if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }
if($frmflag1 == 'frmflag1')
{
$sno = 0;
$claimdate = date('Y-m-d');
$claimtime = date('H:i:s');

$query7 = "select * from master_visitentry where visitcode = '$visitcode'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$smartbenefitno = $res7['smartbenefitno'];
$patientfirstname = $res7['patientfirstname'];
$patientmiddlename = $res7['patientmiddlename'];
$patientlastname = $res7['patientlastname'];
$consultationanum = $res7['consultationtype'];
$department = $res7['departmentname'];
$consultationfees = $res7['consultationfees'];

$query4 = "select * from master_consultationtype where auto_number = '$consultationanum'";
$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$consultationtype = $res4['consultationtype'];

$query6 = "select * from master_customer where customercode = '$patientcode'";
$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
$res6 = mysql_fetch_array($exec6);
$mrdno = $res6['mrdno'];
$dateofbirth = $res6['dateofbirth'];
$gender = $res6['gender'];
if($gender == 'Male') { $gender = 'M'; }
else { $gender = 'F'; }

$query8 = "select * from billing_paylater where visitcode = '$visitcode'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$paylateramount = $res8['totalamount'];

 $fileData1 = $fileData1.addslashes("
			<Claim>
			<Claim_Header>
				<Invoice_Number>".$billautonumber."</Invoice_Number>
				<Claim_Date>".$claimdate."</Claim_Date>
				<Claim_Time>".$claimtime."</Claim_Time>
				<Pool_Number>".$smartbenefitno."</Pool_Number>
				<Total_Services>".$sno."</Total_Services>
				<Gross_Amount>".$paylateramount."</Gross_Amount>
				<Provider>
				<Role>SP</Role>
				<Country_Code>KEN</Country_Code>
				<Group_Practice_Number>SKSP_92</Group_Practice_Number>
				<Group_Practice_Name>Avenue Hospital</Group_Practice_Name>
				</Provider>
				<Authorization>
				<Pre_Authorization_Number>0</Pre_Authorization_Number>
				<Pre_Authorization_Amount>0</Pre_Authorization_Amount>
				</Authorization>
				<Payment_Modifiers>
					<Payment_Modifier>
						<Type>1</Type>
						<Amount>0</Amount>
						<Receipt>0</Receipt>
					</Payment_Modifier>
					<PaymentModifier>
						<Type>5</Type>
						<NHIF_Member_Nr>0</NHIF_Member_Nr>
						<NHIF_Contributor_Nr>0</NHIF_Contributor_Nr>
						<NHIF_Employer_Code>0</NHIF_Employer_Code>
						<NHIF_Site_Nr>0</NHIF_Site_Nr>
						<NHIF_Patient_Relation>0</NHIF_Patient_Relation>
						<Diagnosis_Code>0</Diagnosis_Code>
						<Admit_Date>".$claimdate."</Admit_Date>
						<Discharge_Date>".$claimdate."</Discharge_Date>
						<Days_Used>0</Days_Used>
						<Amount>0</Amount>
					</PaymentModifier>
				</Payment_Modifiers>
			</Claim_Header>
			<Member>
				<Membership_Number>".$mrdno."</Membership_Number>
				<card_serialnumber>00000010000JB529</card_serialnumber>
				<Scheme_Code>unknown</Scheme_Code>
				<Scheme_Plan>unknown</Scheme_Plan>
			</Member>
			<Patient>
				<Dependant>Y</Dependant>
				<First_Name>".$patientfirstname."</First_Name>
				<Middle_Name>".$patientmiddlename."</Middle_Name>
				<Surname>".$patientlastname."</Surname>
				<Date_Of_Birth>".$dateofbirth."</Date_Of_Birth>
				<Gender>".$gender."</Gender>
			</Patient>
			<Claim_Data>
				<Discharge_Notes>Diagn</Discharge_Notes>");
				
$query11 = "select * from billing_paylaterconsultation where billno = '$billautonumber'";	
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$consultationamount = $res11['totalamount'];			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Consultation</Encounter_Type>
	<Code_Type>".$department."</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".$consultationamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
	
$query12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode'";	
$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
while($res12 = mysql_fetch_array($exec12))
{
$medicinecode = $res12['medicinecode'];	
$medicinecode = substr($medicinecode,0,9);
$medicinename = $res12['medicinename'];
$medquantity = $res12['quantity'];	
$medrate = $res12['rate'];	
$medamount = $res12['amount'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Pharmacy</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$medicinecode."</Code>
	<Code_Description>".$medicinename."</Code_Description>
	<Quantity>".$medquantity."</Quantity>
	<Total_Amount>".$medamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$query13 = "select * from billing_paylaterlab where patientvisitcode = '$visitcode'";	
$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
while($res13 = mysql_fetch_array($exec13))
{
$labcode = $res13['labitemcode'];
$labcode = substr($labcode,0,9);	
$labname = $res13['labitemname'];
$labquantity = '1';	
$labrate = $res13['labitemrate'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Laboratory</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$labcode."</Code>
	<Code_Description>".$labname."</Code_Description>
	<Quantity>".$labquantity."</Quantity>
	<Total_Amount>".$labrate."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$query14 = "select * from billing_paylaterradiology where patientvisitcode = '$visitcode'";	
$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
while($res14 = mysql_fetch_array($exec14))
{
$radiologycode = $res14['radiologyitemcode'];	
$radiologycode = substr($radiologycode,0,9);
$radiologyname = $res14['radiologyitemname'];
$radiologyquantity = '1';	
$radiologyrate = $res14['radiologyitemrate'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Radiology</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$radiologycode."</Code>
	<Code_Description>".$radiologyname."</Code_Description>
	<Quantity>".$radiologyquantity."</Quantity>
	<Total_Amount>".$radiologyrate."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$query15 = "select * from billing_paylaterservices where patientvisitcode = '$visitcode'";	
$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
while($res15 = mysql_fetch_array($exec15))
{
$servicescode = $res15['servicesitemcode'];	
$servicescode = substr($servicescode,0,9);
$servicesname = $res15['servicesitemname'];
$servicesquantity = $res15['serviceqty'];	
$servicesamount = $res15['amount'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Services</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$servicescode."</Code>
	<Code_Description>".$servicesname."</Code_Description>
	<Quantity>".$servicesquantity."</Quantity>
	<Total_Amount>".$servicesamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$query16 = "select * from billing_paylaterreferal where patientvisitcode = '$visitcode'";	
$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
while($res16 = mysql_fetch_array($exec16))
{
$referalcode = $res16['referalcode'];	
$referalcode = substr($referalcode,0,9);
$referalname = $res16['referalname'];
$referalquantity = '1';	
$referalamount = $res16['referalrate'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Referal</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$referalcode."</Code>
	<Code_Description>".$referalname."</Code_Description>
	<Quantity>".$referalquantity."</Quantity>
	<Total_Amount>".$referalamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$query17 = "select * from billing_homecarepaylater where visitcode = '$visitcode'";	
$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
while($res17 = mysql_fetch_array($exec17))
{
$homedocno = $res17['docno'];
$homedocno = substr($homedocno,0,9);	
$homename = $res17['description'];
$homequantity = $res17['quantity'];	
$homeamount = $res17['amount'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Homecare</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$homedocno."</Code>
	<Code_Description>".$homename."</Code_Description>
	<Quantity>".$homequantity."</Quantity>
	<Total_Amount>".$homeamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$query18 = "select * from billing_opambulancepaylater where visitcode = '$visitcode'";	
$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
while($res18 = mysql_fetch_array($exec18))
{
$ambdocno = $res18['docno'];
$ambdocno = substr($ambdocno,0,9);	
$ambname = $res18['description'];
$ambquantity = $res18['quantity'];	
$ambamount = $res18['amount'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_92</Practice_Number>
	</Provider>
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>ICD10</Code_Type>
		<Code>UNKN</Code>
	</Diagnosis>
	<Encounter_Type>Ambulance</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$ambdocno."</Code>
	<Code_Description>".$ambname."</Code_Description>
	<Quantity>".$ambquantity."</Quantity>
	<Total_Amount>".$ambamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
}	

$fileData1 = $fileData1.addslashes("
</Claim_Data>
</Claim>");

$importData = $fileData1;

$updatedate = date('Y-m-d H:i:s');

include("writexmlsmart.php");

header("location:billing_pending_op2.php?billautonumber=$billautonumber&&st=success&&printbill=$printbill");
exit;

}
?>
