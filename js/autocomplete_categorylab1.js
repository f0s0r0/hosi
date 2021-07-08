
function StateSuggestions8() {
this.states = 
[
"1 ||BIOCHEMISTRY","2|| HAEMATOLOGY","3|| HISTOPATHOLOGY/CYTOPATHOLOGY","4|| IMMUNOCHEMISTRY","5|| MICROBIOLOGY","6|| MICROBIOLOGY AND PARASITOLOGY","7|| N/A","8|| PARASITOLOGY","9|| RAPID DIAGNOSTIC TESTS","10|| SEROLOGY","11|| SPECIAL BIOCHEMISTRY"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions8.prototype.requestSuggestions = function (AutoSuggestControl8 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl8.textbox.value;
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
    AutoSuggestControl8.autosuggest(aSuggestions, bTypeAhead);
};