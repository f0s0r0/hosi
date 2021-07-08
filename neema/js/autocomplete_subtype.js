
function StateSuggestions1() {
this.states = 
[
"AON INSURANCE BROKERS LTD","APA INSURANCE","BRITISH INSURANCE CO. (K) LTD.","CASH","CFC/ HERITAGE INSURANCE LTD.","CHARITY ACCOUNT","CIC INSURANCE","DIRECT CREDIT COMPANIES","EAGLE AFRICA","FIRST ASSURANCE","JUBILEE INSURANCE CO (K) LTD","MADISON INSURANCE CO (K) LTD","NEEMA MEDICAL SCHEME","NEEMA STAFF","PACIS INSURANCE CO.(K) LTD.","PIONEER ASSURANCE","RESOLUTION INSURANCE","UAP INSURANCE CO LTD."];
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
};