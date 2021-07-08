<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions() {
this.states = 
[
';

$stringpart2 = '];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions.prototype.requestSuggestions = function (oAutoSuggestControl /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl.textbox.value;
    
 	var loopLength = 0;

    if (sTextboxValue.length > 0){
    
	var sTextboxValue = sTextboxValue.toUpperCase();

        //search for matching states
        for (var i=0; i < this.states.length; i++) 
		{ 
            if (this.states[i].indexOf(sTextboxValue) >= 0) 
			{
                loopLength = loopLength + 1;
				if (loopLength <= 15) //TO REDUCE THE SUGGESTIONS DROP DOWN LIST
				{
					aSuggestions.push(this.states[i]);
				}
            } 
        }
    }

    //provide suggestions to the control
    oAutoSuggestControl.autosuggest(aSuggestions, bTypeAhead);
};';
$stringbuild1 = "";
$query1 = "select * from master_ipvisitentry where paymentstatus='completed' and recordstatus <> 'Deleted' order by patientfullname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1patientcode = $res1['patientcode'];
	
	$res1visitcode = $res1['visitcode'];
	
	
	$query33 = "select * from billing_ip where patientcode='$res1patientcode' and visitcode='$res1visitcode'";
	$exec33 = mysql_query($query33) or die(mysql_error());
	$num33 = mysql_num_rows($exec33);
	if($num33 != 0)
	{
	$res33 = mysql_fetch_array($exec33);
	$billno = $res33['billno'];
	}
	else
	{
	$query34 = "select * from billing_ipcreditapproved where patientcode='$res1patientcode' and visitcode='$res1visitcode'";
	$exec34 = mysql_query($query34) or die(mysql_error());
	$res34 = mysql_fetch_array($exec34);
	$billno = $res34['billno'];
	}
	
	$res1patientfullname=$res1['patientfullname'];
	

	
	$res1patientcode = addslashes($res1patientcode);
	
   $res1patientfullname=addslashes($res1patientfullname);
	
	$res1patientcode = strtoupper($res1patientcode);
	
	$res1patientfullname=strtoupper($res1patientfullname);
	
	$res1patientcode = trim($res1patientcode);
	$res1patientfullname = trim($res1patientfullname);
	
	$res1patientcode = preg_replace('/,/', ' ', $res1patientcode);
	$res1patientfullname = preg_replace('/,/', ' ', $res1patientfullname);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1patientfullname.'#'.$res1patientcode.'#'.$res1visitcode.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1patientfullname.'#'.$res1patientcode.'#'.$res1visitcode.'"';
	}
}

$query1op = "select * from master_ipvisitentry where overallpayment='completed' and billtype<>'PAY NOW' order by patientfullname";
$exec1op = mysql_query($query1op) or die ("Error in Query1op".mysql_error());
while ($res1op = mysql_fetch_array($exec1op))
{
	$res1patientcode = $res1op['patientcode'];
	
	$res1visitcode = $res1op['visitcode'];
	
	
	$query33op = "select * from billing_paylater where patientcode='$res1patientcode' and visitcode='$res1visitcode'";
	$exec33op = mysql_query($query33op) or die(mysql_error());
	$num33op = mysql_num_rows($exec33op);
	if($num33op != 0)
	{
	$res33op = mysql_fetch_array($exec33op);
	$billno = $res33op['billno'];
	}
	else
	{
	$query34op = "select * from billing_paynow where patientcode='$res1patientcode' and visitcode='$res1visitcode'";
	$exec34op = mysql_query($query34op) or die(mysql_error());
	$res34op = mysql_fetch_array($exec34op);
	$billno = $res34op['billno'];
	}
	
	$res1patientfullname=$res1op['patientfullname'];
	

	
	$res1patientcode = addslashes($res1patientcode);
	
   $res1patientfullname=addslashes($res1patientfullname);
	
	$res1patientcode = strtoupper($res1patientcode);
	
	$res1patientfullname=strtoupper($res1patientfullname);
	
	$res1patientcode = trim($res1patientcode);
	$res1patientfullname = trim($res1patientfullname);
	
	$res1patientcode = preg_replace('/,/', ' ', $res1patientcode);
	$res1patientfullname = preg_replace('/,/', ' ', $res1patientfullname);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1patientfullname.'#'.$res1patientcode.'#'.$res1visitcode.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1patientfullname.'#'.$res1patientcode.'#'.$res1visitcode.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_customerip.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);





?>
