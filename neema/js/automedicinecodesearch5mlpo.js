// JavaScript Document
//function to call ajax process
function funcmedicinesearch4()
{
	//alert("Meow...");
	if(document.getElementById("itemcode").value!="")
	{
		var varmedicinesearch = document.getElementById("itemcode").value;
		//alert (varmedicinesearch);
		var varmedicinesearchLen = varmedicinesearch.length;
		//alert (varmedicinesearchLen);
		if (varmedicinesearchLen > 1)
		{
			ajaxprocessACCS24();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS24()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var medicinesearch = document.getElementById("itemcode").value;
	//alert(medicinesearch);

	
	//alert(medicinesearch);
	var url = "";
	var url="automedicinecodesearch5kiambu.php?RandomKey="+Math.random()+"&&medicinesearch="+medicinesearch;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS24 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS24() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("medicinesearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	//var varNewLineValue=varCompleteStringReturned.split("||^||");
	var varNewLineValue=varCompleteStringReturned.split("||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	//varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	//if (varNewLineLength == 0)
	//{
		//return false;
	//}
	
	//for (m=0;m<=varNewLineLength;m++)
	//{
		//alert (m);
		//var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		
		//alert (varCustomerCode1);
		var varMedicineCode = varNewLineValue[0];
		//alert (varMedicineCode);
		document.getElementById("itemcode").value = varMedicineCode;

		var varMedicineName = varNewLineValue[1];
		//alert (varMedicineName);
		document.getElementById("itemname").value = varMedicineName;

		var varMedicineRate = varNewLineValue[2];
		//alert (varMedicineName);
		document.getElementById("itemmrp").value = (varMedicineRate);
		document.getElementById("itemtotalamount").value = (varMedicineRate);
	//}
	//alert (k);
	} 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}