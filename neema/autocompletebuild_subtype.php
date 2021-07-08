<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions1() {
this.states = 
[
';

$stringpart2 = '];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl1 The autosuggest control to provide suggestions for.
 */
StateSuggestions1.prototype.requestSuggestions = function (oAutoSuggestControl1 /*:AutoSuggestControl1*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl1.textbox.value;
    
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
    oAutoSuggestControl1.autosuggest(aSuggestions, bTypeAhead);
};';


$stringbuild1 = "";
$query1 = "select * from master_subtype where recordstatus <> 'Deleted' order by subtype";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1suppliercode1 = $res1['auto_number'];
	$_SESSION['sessionVar'] = $res1suppliercode1;
	$res1suppliername = $res1['subtype'];
	$res1suppliername = strtoupper($res1suppliername);
	$res1suppliername = trim($res1suppliername);
	$res1suppliername = preg_replace('/,/', ' ', $res1suppliername);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.''.$res1suppliername.''.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.''.$res1suppliername.''.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_subtype.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);

?>
