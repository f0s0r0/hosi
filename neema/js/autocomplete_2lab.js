
function StateSuggestions1() {
this.states = 
[
" AAFB STAINING"," HBA1C"," ALBUMIN"," ALKALINE PHOSPHATASE"," ASOT TEST"," RANDOM BLOOD SUGAR RBS"," BETA HCG"," DIRECT BILIRUBIN"," TOTAL BILIRUBIN"," BS FOR MPS"," CALCIUM"," CHLORIDES"," TOTAL CHOLESTEROL"," CREATININE"," ERYTHROCYTE SEDIMENTATION RATE ESR"," FASTING BLOOD SUGAR FBS"," FT3"," FT4"," GAMMA GT"," HAEMOGLOBIN LEVELS HB"," HIGH DENSITY LIPOPROTEIN"," TISSUE BIOPSY FOR HISTOLOGY LARGE"," TISSUE BIOPSY FOR HISTOLOGY SMALL"," HIV TESTING RAPID"," HELICOBACTER PYLORI ANTIBODIES"," HELICOBACTER PYLORI ANTIGEN"," HVS/URETHRAL C/S"," LOW DENSITY LIPOPROTEIN"," FECAL OCCULT BLOOD"," OGTT(ORAL GLUCOSE TOLERANCE TEST)"," PAP SMEAR REPORTING"," PERIPHERAL BLOOD FILM"," PREGNANCY DIAGNOSTIC TEST"," POTASSIUM"," SERUM PROTEINS"," PROSTATIC SURFACE ANTIGEN SCREENING"," TPSA QUANTITATIVE"," PUS CULTURE"," RHEUMATOID FACTOR"," SALMONELLA ANTIGEN TEST SAT"," SGOT (AST)"," SGPT (ALT)"," SODIUM"," STOOL CULTURE /SENSITIVITY"," TPHA"," TRYGLYCERIDES"," THROAT SWAB C/S"," TSH"," URINE M/C:S"," UREA"," URIC ACID"," VDRL/KHAN:RPR"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions1.prototype.requestSuggestions = function (AutoSuggestControl1 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl1.textbox.value;
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
    AutoSuggestControl1.autosuggest(aSuggestions, bTypeAhead);
};