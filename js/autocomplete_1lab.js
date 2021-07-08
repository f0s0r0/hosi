
function StateSuggestions1() {
this.states = 
[
" AFB STAINING"," HBA1C"," ALBUMIN"," ALKALINE PHOSPHATASE(ADULT MALE)"," ANC PROFILE(B.GROUP,HB,VDRL & URINALYSIS)"," ADENO/ROTA VIRUS"," ASOT TEST"," BRUCELLOSIS TEST"," RANDOM BLOOD SUGAR RBS"," BLOOD GROUPING"," BETA HCG"," DIRECT BILIRUBIN"," TOTAL BILIRUBIN (AT BIRTH)"," BS FOR MPS"," CALCIUM"," CHLORIDES"," TOTAL CHOLESTEROL"," CREATININE(MALE)"," ERYTHROCYTE SEDIMENTATION RATE ESR"," FASTING BLOOD SUGAR FBS"," FULL HAEMOGRAM(MALE ADULT)"," T3"," T4"," GAMMA GT"," HAEMOGLOBIN LEVELS HB"," HIGH DENSITY LIPOPROTEIN"," TISSUE BIOPSY FOR HISTOLOGY LARGE"," TISSUE BIOPSY FOR HISTOLOGY SMALL"," HIV TESTING AND COUNSELLING (VCT)"," HELICOBACTER PYLORI ANTIBODIES"," HELICOBACTER PYLORI ANTIGEN"," HVS/URETHRAL C/S"," FULL HAEMOGRAM(FEMALE ADULT)"," CD4 COUNTS"," HVS MICROSCOPY AND GRAM STAIN"," HVS MICROSCOPY AND GRAM STAIN"," FULL HAEMOGRAM(CHILD)"," BILIRUBIN TOTAL (ADULTS)"," HVS MICROSCOPY AND GRAM STAIN"," ICT"," KOH"," HVS MICROSCOPY AND GRAM STAIN"," CSF ANALYSIS"," PREURAL EFFUSION(ZN STAIN)"," PREURAL EFFUSION(CULTURE AND SENSITIVITY)"," PREURAL EFFUSION(WETPREP AND GRAM STAIN)"," HEPATITIS B ANTIGEN"," new item"," SICKLING TEST"," PROGESTERONE"," LUTEINIZING HORMONE (LH)"," PROLACTIN  (PRL)"," BLOOD GROUPING AND CROSSMATCH"," Hepatitis C Virus"," ALKALINE PHOSPHATASE-male adult"," LIPID PROFILE"," CRAG TEST"," VIRAL LOAD"," DIRECT COOMBS TEST"," CSF ANALYSIS"," BLOOD CULTURE"," CMV"," electrolytes"," BRUCELLA ANTIGEN"," CA 125"," HISTOLOGY"," ALKALINE PHOSPHATASE- Female adults"," Alkaline Phosphatase - Children upto 15 years"," Alkaline Phosphatase (Children Upto 17 years)"," TOTAL BILIRUBIN (5 DAYS-1 MONTH)"," TOTAL BILIRUBIN (1 MONTH - 12 YEARS)"," TOTAL BILIRUBIN (ADULTS)"," PCR"," SALMONELLA STOOL ANTIGEN"," TB CULTURE"," FLUID ASPIRATE CULTURE & SENSITIVITY"," VIRAL LOAD"," CSF CULTURE AND SENSITIVITY"," C.R.P-Quantative"," ANTI CCP"," PSA"," POTASSIUM"," CSF FM TEST(TB)"," CREATININE (FEMALE)"," Du Test"," IMMUNOHISTOCHEMISTRY"," TESTOSTERONE"," B-HCG"," CORTISOL TEST"," CEA (Carcinoembryonic antigen cancer blood test)"," FOLLICLE STIMULATING HORMONE"," LOW DENSITY LIPOPROTEIN"," LIVER FUNCTION TESTS"," LIPID PROFILE"," FECAL OCCULT BLOOD"," OGTT(ORAL GLUCOSE TOLERANCE TEST)"," PAP SMEAR REPORTING"," PERIPHERAL BLOOD FILM"," PREGNANCY DIAGNOSTIC TEST"," POTASSIUM"," SERUM PROTEINS"," PROSTATIC SURFACE ANTIGEN SCREENING"," TPSA QUANTITATIVE"," PUS CULTURE AND SENSITIVITY"," RHEUMATOID FACTOR"," SEMEN ANALYSIS"," SALMONELLA ANTIGEN TEST SAT"," SGOT (AST)"," SGPT (ALT)"," SODIUM"," STOOL CULTURE /SENSITIVITY"," STOOL FOR OVA/ CYSTS"," THYROID FUNCTION TEST TFTS"," TPHA"," TRYGLYCERIDES"," THROAT SWAB C/S"," TSH"," URINALYSIS"," URINE M/C:S"," RENAL FUNCTION TEST U/E:C"," UREA"," URIC ACID"," VDRL/KHAN:RPR"," URETHRAL SWAB"," WIDAL TEST"];
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