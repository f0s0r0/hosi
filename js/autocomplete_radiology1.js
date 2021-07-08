
function StateSuggestions2() {
this.states = 
[
"13||ABDOMEN SUPINE-ERECT AP","RD075||ABDOMEN ULTRASOUND","RD057||ABDOMINAL PELVIC SCAN","RD056||ABDOMINAL SCAN","21||ANKLE JOINT","RD026||ANKLE JOINT AP/LATERAL VIEW","34||BARIUM MEAL","23||BARIUM MEAL FOLLOW THRO","RD048||BARIUM SWALLOW","37||BIOPSY","RD033||BOTH ANKLE JOINT AP/LAT VIEW","RD034||BOTH ANKLE JOINT LATERAL VIEW","RD054||BOTH BREAST SCAN(BILATERAL)","RD043||BOTH CLARICLE AP VIEW","RD031||BOTH FEET AP/LAT VIEW","RD032||BOTH FEET LATERAL VIEW","RD036||BOTH FEMUR","RD035||BOTH FIBULA AP/LAT VIEW","RD018||BOTH HIPS AP/LATERAL VIEW","26||BOTH HIPS LATERAL VIEW","22||BOTH KNEES","RD029||BOTH KNEES AP/LAT VIEW","RD030||BOTH KNEES LATERAL  VIEW","RD042||BOTH SHOULDER AP/LAT VIEW","RD078||BOTH WRIST JOINT AP/LAT VIEW","45||BREAST SCAN(ONE UNILATERAL)","RD064||CALCAENIUM SPUR","RD009||CERVICAL SPINE AP/LATERAL VIEW","RD002||CHEST AP/PA VIEW","RD003||CHEST LATERAL VIEW","RD041||CLARICLE AP VIEW","RD058||CRANIAL DOPPLER U/S","RD050||DOPPLER BOTH BILATERAL LOWER LIMBS","46||DOPPLER LEFT LOWER LIMB","RD049||DOPPLER RIGHT LOWER LIMB","RD051||DUPPLER SOFT TISSUE SCAN","RD038||ELBOW JOINT AP/LAT VIEW","27||ELECTROCARDIOGRAM(E.C.G)","RD069||ENDO VAGINAL","36||ENDOCAVITY","24||FEMUR","RD021||FEMUR AP/LATERAL VIEW","RD024||FIBULAR JOINT AP/LATERAL VIEW","RD040||FINGER AP/LAT VIEW","41||FOOT AP/LAT/OBLIQUE VIEW","RD028||FOOT OBLIQUE VIEW","RD059||GUIDED BIOPSY","44||HAND AP/LAT VIEW","RD019||HIP AP/LATERAL VIEW","RD037||HUMERUS AP/LAT VIEW","1||I.V.U","38||INTRAVENOUS UROGRAPHY-IVU","28||KNEE JOINT AP/LATERAL VIEW","RD023||KNEE JOINT LATERAL VIEW","2||LUMBAR 2 VIEWS/AP/LAT","RD001||LUMBAR 2 VIEWS/AP/LAT","RD015||LUMBER SACRIAL SPINE AP/LATERAL VIEW","RD065||LYMPH NODE-AXILLA","RD066||LYMPH NODE-INGUINAL","RD067||LYMPH NODE-NECK","29||MANDIBLE JOINT 1 VIEW","RD060||MANDIBLES 2 VIEWS OR MAXIL","RD006||MANDIPLE AP/LATERAL VIEW","17||MICTURATING CYSTOURETHROGRAPHY(MCU)","39||MICTURATINGCYSTOURETHROGRAM","4||NASAL BONE","RD061||OBSTETRIC U/S","RD072||OBSTETRIC U/S","RD073||OBSTETRIC U/S","RD008||PARANASAL SINUCES","6||PARANASAL SINUSES 3 VIEWS","RD062||PELVIC SCAN","42||PELVIC X-RAY","RD055||PELVIC(T.V.S) SCAN","RD063||PELVIS SCAN U/S","20||PLAIN ABDOMEN 1 VIEW","RD046||PLAIN ABDOMINAL AP/LAT VIEW","RD007||POST NASAL SPACE","RD077||POST NASAL SPACE(PNS)","RD052||PROSTATE U/SOUND","RD039||RADIUS/ULNA AP/LAT VIEW","25||RENAL U/S","43||REPORT-XRAY","RD016||SACRAL SPINE AP VIEW","RD017||SACRAL SPINE AP/LATERAL VIEW","30||SCAPHOID","40||SCAPULA 2 VIEWS","RD044||SCAPULAR AP VIEW","31||SHOULDER JOINT AP/LAT VIEW","12||SKULL AP VIEW","RD004||SKULL LATERAL VIEW","RD053||SOFT TISSUE U/S","35||SPINE-SACRAL","RD047||STANO CLARICULUM JOINT AP VIEW","32||STERNO-CLAVICULAR JNT","RD045||STERNUM AP/LAT VIEW","15||TEMPERO MANDIBULAR JOINTS","19||TESTICULAR SCAN","RD010||THORACIC SPINE AP/LATERAL VIEW","18||THYROID SCAN","14||TIBIA/FIBULA","16||TOES","RD068||ULTRASOUND-MASS","33||WRIST JOINT AP/LAT VIEW","RD071||XRAY KNEE"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions2.prototype.requestSuggestions = function (AutoSuggestControl2 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl2.textbox.value;
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
    AutoSuggestControl2.autosuggest(aSuggestions, bTypeAhead);
};