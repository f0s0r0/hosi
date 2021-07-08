
function StateSuggestions() {
this.states = 
[
"BANK TRANSFER CHARGES #08-9121","COTU UNION CONTRIBUTION #08-9117","EDUCATION POLICIES #08-9107","EXCESS  OF LEGAL LIMIT ON PENSION #08-9108","EXCESS  OF LEGAL LIMIT ON PENSION REVERSAL #08-9122","HELB LOAN REPAYMENT #08-9101","KUDHEIHA UNION CONTRIBUTION #08-9116","LOCUM/ TEMPORARY STAFF #08-9103","NHIF #08-9114","NSSF-EMPLOYEE CONTRIBUTION #08-9113","NSSF-EMPLOYER CONTRIBUTION #08-9105","PAY AS YOU EARN #08-9115","PAY IN LEAU OF NOTICE #08-9112","PENSION- EMPLOYEES CONTRIBUTION #08-9118","PENSION- EMPLOYERS CONTRIBUTION #08-9106","RESPONSIBILITY ALLOWANCES #08-9111","SACCO CONTRIBUTION #08-9120","SALARIES NET PAY #08-9123-01","SALARY ADVANCE #08-9119","STAFF GRATUITY #08-9109","STAFF PAYMENT IN LEAU OF LEAVE #08-9110","STAFF SALARIES & WAGES #08-9102","STAFF WELFARE CONTRIBUTION #08-9104","WAUMINI SACCO COLLECTIONS #08-9124-01"];
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
};