
function StateSuggestions() {
this.states = 
[
"ANN GAICHIUMIA #","ANNE MARGARET NGARI #","BRENDA MUKAMI KUNGA #","CATHERINE MUTINDA #","CHRISTINE MWIKALI ASUMAN #","DANIEL CHACHA MWITA #","DANIEL NGUGI WANJIKU #","DICKENS ONYANGO OTWAL #","ELKANAH T. GITAU #","FRANCIS KARIUKI MIRITI #","GEORGE MARWA SANGAI #","GIANFRANCO MORINO #","HELLEN NYAMBURA MWANGI #","HENRY MWANGA #","IRENE MBINYA NZAMU #","IRENE NZAMU NDERITU #","JACQUELINE MWASHWAA #","JOSEPHINE MIRIE #","KWAME ORWENYO #","LEAH NJOKI NDERITU #","LUCY KARIRA KINYANJUI #","MAINA GEOFFREY JOB MAGETO #","MARGARET WANGECI NDEGWA #","MARY WANJIKU MAINA #","MAURINE ANYANGO OKELLO #","NIMROD GARAMA #","OP DOCTOR #","PAUL KANYUA #","PERIS WANJIKU NJIIRI #","PETER MICHOMA #","PHONEX MAKORI #","PROTUS W. NYONGESA #","ROBERT BWIRE WANYAMA #","ROSE EDDER JALANGO #","TUNGANI MUCHIRI #","WASHINGTON NJOGU NGARI #","ZUHURA NAMWAKA JUMANNE LENJAYO #"];
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