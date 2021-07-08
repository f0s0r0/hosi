
function StateSuggestions11() {
this.states = 
[
"BUILDINGS PARTITIONS#06-6001","ACCUMULATED DEPRECIATION#06-6002","MOTOR VEHICLES#06-6003","ACCUMULATED DEPRECIATION#06-6004","FITTINGS  FURNITURE & EQUIPMENTS#06-6011","ACCUMULATED DEPRECIATION#06-6012","COMPUTER COST#06-6013","ACCUMULATED DEPRECIATION#06-6014","LAND & BUILDINGS#06-6015","ACCUMULATED DEPRECIATION#06-6016","COMPUTER SOFTWARE#06-6017","ACCUMULATED DEPRECIATION#06-6018","SILOAM HOSPITAL#06-6019","ACCUMULATED DEPRECIATION - LAND#06-6020","CONSTRUCTION COSTS#06-6021","WORK IN PROGRESS#06-6023","PREPAID OPERATING LEASE RENTAL#06-6101"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl11 The autosuggest control to provide suggestions for.
 */
StateSuggestions11.prototype.requestSuggestions = function (oAutoSuggestControl11 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl11.textbox.value;
    
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
    oAutoSuggestControl11.autosuggest(aSuggestions, bTypeAhead);
};