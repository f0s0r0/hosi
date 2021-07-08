
function StateSuggestions3() {
this.states = 
[
"SER174||COSMETOLOGY","SER166||DAILY REFRIGERATION CHARGES AFTER 8 DAYS","SER164||EMBALMING","SER169||IMPLANT REMOVAL MORTUARY","SER161||MORTUARY SERVICES","SER168||POST EMBALMING","SER214||POST- MORTEM (USE OF FACILITY)","SER172||RECOMPOSITION MAJOR","SER171||RECOMPOSITION MEDIUM","SER170||RECOMPOSITION MINOR","SER163||RECONSTRUCTION","SER165||REFRIGERATION","SER167||SPECIAL EMBALMING","SER175||STORAGE IN TRANSIT","SER173||VIEWING"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions3.prototype.requestSuggestions = function (AutoSuggestControl3 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl3.textbox.value;
    //alert (sTextboxValue);
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
    AutoSuggestControl3.autosuggest(aSuggestions, bTypeAhead);
};