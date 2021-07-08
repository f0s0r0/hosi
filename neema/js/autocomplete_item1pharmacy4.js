
function StateSuggestions4() {
//alert ("Meow..");
this.states =  
[
];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions4.prototype.requestSuggestions = function (AutoSuggestControl4 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl4.textbox.value;
    //alert (sTextboxValue);
	//Dummy value to have one intentional blank space to allow down and up keys to select items is list contains only one item.
	//var varDummyValue = ""; 
	
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

	//aSuggestions.push(varDummyValue);
    //provide suggestions to the control
    AutoSuggestControl4.autosuggest(aSuggestions, bTypeAhead);
};