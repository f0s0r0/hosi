<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
	$query1 = "truncate table master_billing";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_billing1";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table prescription_externalpharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_departmentreferal";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table bankentryform";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table cogsentry";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table depositrefund_request";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table deposit_refund";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_drugadmin";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table master_ipvisitentry";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_purchase";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_purchaseorder";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table master_purchaserequest";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table master_purchasereturn";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_internalstockrequest";
	$exec1 = mysql_query($query1);
	

	$query1 = "truncate table master_transactionadvancedeposit";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_transactiondoctor";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_transactionexternal";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table master_transactionip";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_transactionipcreditapproved";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_transactionipdeposit";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table master_transactionpaylater";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table master_transactionpaynow";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_transactionpharmacy";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table master_visitentry";
	$exec1 = mysql_query($query1);

	
	$query1 = "truncate table pharmacysalesreturn_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table pharmacysales_details";
	$exec1 = mysql_query($query1);
	

	$query1 = "truncate table purchasereturn_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchaseorder_details";
	$exec1 = mysql_query($query1);
	

	
	$query1 = "truncate table purchaserequest_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchaserequest_tax";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchase_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table transaction_stock";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table receiptsub_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paylater";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paylaterlab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paylaterpharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paylaterradiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paylaterreferal";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table refund_paylaterservices";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paynow";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paynowlab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paynowpharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paynowradiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paynowreferal";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paynowservices";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_consultation";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table billing_external";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_externallab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_externalpharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_externalradiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_externalreferal";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_services";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ip";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipbedcharges";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipcreditapproved";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_iplab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ippharmacy";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table billing_ipradiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipservices";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_lab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylater";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylaterconsultation";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylaterlab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylaterpharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylaterradiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylaterreferal";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paylaterservices";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paynow";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paynowlab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paynowpharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paynowradiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paynowreferal";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_paynowservices";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_pharmacy";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_radiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_referal";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_services";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_consultation";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_externalservices";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipadmissioncharge";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table billing_ipambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipmiscbilling";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table billing_ipnhif";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipotbilling";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table billing_ipprivatedoctor";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table billing_ipadmissioncharge";
	$exec1 = mysql_query($query1);

	
	$query1 = "truncate table expensesub_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table paymentmodedebit";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table paymentmodecredit";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_lab";
	$exec1 = mysql_query($query1);
	
	
	$query1 = "truncate table consultation_radiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_referal";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table consultation_services";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_triage";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table iptest_procedures";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_ambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipmisc_billing";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_otbilling";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipprivate_doctor";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipconsultation_lab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipconsultation_radiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipconsultation_services";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_bedallocation";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_discharge";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table ip_progressnotes";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_vitalio";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_discount";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_doctornotes";
	$exec1 = mysql_query($query1);
	
	
	$query1 = "truncate table ip_creditapproval";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_creditapprovalformdata";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_creditnote";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_creditnotebrief";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table ip_debitnote";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_debitnotebrief";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_bedtransfer";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipsamplecollection_lab";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table ipprocess_service";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipresultentry_lab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipresultentry_radiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ippharmacy_refund";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipmedicine_issue";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table expensesub_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table expense_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_icd";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_icd1";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_ipadmission";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table consultation_lab";
	$exec1 = mysql_query($query1);
	
	
	$query1 = "truncate table consultation_radiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table consultation_referal";
	$exec1 = mysql_query($query1);


	$query1 = "truncate table consultation_services";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table resultentry_lab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table resultentry_radiology";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table samplecollection_lab";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table stock_taking";
	$exec1 = mysql_query($query1);
	
		
	$query1 = "truncate table process_service";
	$exec1 = mysql_query($query1);
	
	
	$query1 = "truncate table purchaseorder_tax";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchaserequest_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchaserequest_tax";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchase_indent";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchase_ordergeneration";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table openingstock_entry";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table pharmacysalesreturn_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table pharmacysales_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_stock";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_stock_transfer";
	$exec1 = mysql_query($query1);
	
	//$query1 = "truncate table master_itemtosupplier";
	//$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_consultation";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_consultationlist";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_consultationpharm";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table master_consultationpharmissue";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_nhifprocessing";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipcreditapprovedtransaction";
	$exec1 = mysql_query($query1);
	
	$query1 = "update master_bed set recordstatus=''";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchase_rfqrequest";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_rfq";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_rfqpurchaseorder";
	$exec1 = mysql_query($query1);

	
	$query1 = "truncate table purchase_rfq";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchase_rfqrequest";
	$exec1 = mysql_query($query1);

	$query1 = "truncate table materialreceiptnote_details";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table shift_tracking";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table depreciation_information";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_fixedassets";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchasenm_rfq";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_nmrfq";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_nmrfqpurchaseorder";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table purchasenm_rfqrequest";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table materialreceiptnote_nmdetails";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table openingbalanceaccount";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table openingbalancesupplier";
	$exec1 = mysql_query($query1);

	
	$query1 = "truncate table bank_record";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_nmstockissue";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table newborn_motherdetails";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table preop";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table postop";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table pharma_insurance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table paylaterpharmareturns";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table optheatrenursenotes";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table operationrecord";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table member_insurance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_wishes";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_vct";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_vaccine";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table details_login";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table dischargesummary";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table dc_discharge";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table dc_progressnotes";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table dc_vitalio";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table externalemr_upload";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table fluidbalance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipclinicalrecord";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipconsentform";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ip_otrequest";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table login_restriction";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table sickleave_entry";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table sick_referral";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table tbtemplate";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ancphysixam";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ancprespreg";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ancprevpreg";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ancprevser";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table vct";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table vaccination";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table userselected_report";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_ipambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_opambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table ipambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table opambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_opambulancepaylater";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table  refund_paylaterambulance";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_homecare";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_homecarepaylater";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table homecare";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table iphomecare";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table refund_paylaterhomecare";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table billing_iphomecare";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table  ipmedicine_prescription";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table  manual_lpo";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table  samplecollection_laban";
	$exec1 = mysql_query($query1);
	
	$query1 = "truncate table  resultentery_laban";
	$exec1 = mysql_query($query1);

	
		$errmsg1 = "Table First Batch Truncate Completed.";
}





?>
<script language="javascript">
function btnClick1()
{
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete All Data In DB And Reset To Original State?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		alert ("Data In Table First Batch Not Deleted.");
		return false;
	}
}



</script>
<form id="form1" name="form1" method="post" action="" onsubmit="return btnClick1()">
  <p>Batch One : Will Delete All Data And Restore To Original State. </p>
  <p>
    <input type="submit" name="Submit" value="Truncate All Data" />
    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
  </p>
</form>
<?php echo $errmsg1; ?>
