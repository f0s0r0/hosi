
function StateSuggestions3() {
this.states = 
[
" APO-1"," APO-100"," APO-101"," APO-102"," APO-103"," APO-104"," APO-105"," APO-106"," APO-107"," APO-108"," APO-109"," APO-110"," APO-111"," APO-112"," APO-113"," APO-114"," APO-115"," APO-116"," APO-117"," APO-118"," APO-186"," APO-187"," APO-188"," APO-189"," APO-190"," APO-191"," APO-192"," APO-193"," APO-194"," APO-195"," APO-196"," APO-197"," APO-198"," APO-199"," APO-211"," APO-216"," APO-217"," APO-218"," APO-219"," APO-220"," APO-221"," APO-222"," APO-223"," APO-224"," APO-225"," APO-226"," APO-227"," APO-228"," APO-229"," APO-230"," APO-231"," APO-232"," APO-233"," APO-25"," APO-26"," APO-27"," APO-28"," APO-29"," APO-30"," APO-31"," APO-32"," APO-33"," APO-34"," APO-35"," APO-36"," APO-37"," APO-38"," APO-39"," APO-40"," APO-41"," APO-42"," APO-44"," APO-45"," APO-46"," APO-47"," APO-48"," APO-49"," APO-50"," APO-51"," APO-52"," APO-53"," APO-54"," APO-55"," APO-56"," APO-57"," APO-58"," APO-59"," APO-60"," APO-61"," APO-62"," APO-63"," APO-64"," APO-65"," APO-66"," APO-67"," APO-68"," APO-69"," APO-70"," APO-71"," APO-72"," APO-73"," APO-74"," APO-75"," APO-76"," APO-77"," APO-78"," APO-79"," APO-80"," APO-81"," APO-82"," APO-83"," APO-84"," APO-85"," APO-86"," APO-87"," APO-88"," APO-89"," APO-90"," APO-91"," APO-92"," APO-93"," APO-94"," APO-95"," APO-96"," APO-97"," APO-98"," APO-99"];
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