
function StateSuggestions4() {
this.states = 
[
"AMOEB001 ||FLUPHENAZINE INJ","AMOEB002|| DILOX/METRONID.250/200MG TABS.","AMOEB003|| METRONIDAZOLE 200MG TAB","AMOEB004|| METRONIDAZOLE INFUSION 500MG/100ML","AMOEB005|| METRONIDAZOLE SUSPENSION 200MG/5ML 100ML","AMOEB006|| TINIDAZOLE 500MG  TABS","AMOEB007|| METRONIDAZOLE  400MG  TABLETS","ANAE001|| MERCAINE 0.5% HEAVY 4ML","ANAE002|| DIAZEPAM  INJECTION 5MG/ML","ANAE003|| EPHEDRINE 30MG/ML INJECTION","ANAE004|| HALOTHANE INHALATION","ANAE005|| KETAMINE INJ 50MG/ML","ANAE006|| NEOSTIGMINEINJECTION 1ML 0.5MG/ML","ANAE007|| PANCURONIUM INJECTION(ROTEX MEDICA)","ANAE008|| SUXAMETHONIUM CHLORIDE 50MG/ML(ROTEX MEDICA)","ANAE009|| THIOPENTONE INJ 500MG(ROTEX)","ANAE010|| TRACRIUM INJ 10MG/ML 2.5ML","ANAE011|| ETHYL-CHLORIDE SPRAY","ANAE012|| FENTANYL 100MG INJECT/2ML","ANAE013|| ISOFLURANE 250ML"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl4 The autosuggest control to provide suggestions for.
 */
StateSuggestions4.prototype.requestSuggestions = function (AutoSuggestControl4 /*:AutoSuggestControl4*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl4.textbox.value;
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
				if (loopLength <= 300) //TO REDUCE THE SUGGESTIONS DROP DOWN LIST
				{
					aSuggestions.push(this.states[i]);
				}
            } 
        }
    }

    //provide suggestions to the control
    AutoSuggestControl4.autosuggest(aSuggestions, bTypeAhead);
};