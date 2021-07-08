// JavaScript Document
//function to call ajax process
function FuncEmployeePayrollEdit()
{
	//alert("Meow...");
			
	for(s=1;s<50;s++)
	{	
		if(document.getElementById("earninganum"+s) != null)
		{
			if(document.getElementById("earninganum"+s).value == 1)
			{	
				var EAnum = document.getElementById("earninganum"+s).value;
				document.getElementById("earninganum"+s).checked = "checked";
				document.getElementById("earningvalue"+EAnum).value = "";
				document.getElementById("earningvalue"+EAnum).readOnly = false;
				document.getElementById("earningvalue"+EAnum).style.backgroundColor= "#FFFFFF";
				//EarningAllow();
			}
			else
			{
				var EAnum = document.getElementById("earninganum"+s).value;
				document.getElementById("earninganum"+s).checked = "";
				document.getElementById("earningvalue"+EAnum).value = "";
				document.getElementById("earningvalue"+EAnum).readOnly = true;
				document.getElementById("earningvalue"+EAnum).style.backgroundColor= "#CCCCCC";
				//EarningAllow();
			}
		}
	}
	
	for(h=1;h<50;h++)
	{	
		if(document.getElementById("deductionanum"+h) != null)
		{
			if((document.getElementById("deductionanum"+h).value == 6)||(document.getElementById("deductionanum"+h).value == 7)||(document.getElementById("deductionanum"+h).value == 8))
			{	
				var DAnum = document.getElementById("deductionanum"+h).value;
				document.getElementById("deductionanum"+h).checked = "checked";
				document.getElementById("deductionvalue"+DAnum).value = "";
				document.getElementById("deductionvalue"+DAnum).readOnly = true;
				document.getElementById("deductionvalue"+DAnum).style.backgroundColor= "#CCCCCC";
				//EarningAllow();
			}
			else
			{
				var DAnum = document.getElementById("deductionanum"+h).value;
				document.getElementById("deductionanum"+h).checked = "";
				document.getElementById("deductionvalue"+DAnum).value = "";
				document.getElementById("deductionvalue"+DAnum).readOnly = true;
				document.getElementById("deductionvalue"+DAnum).style.backgroundColor= "#CCCCCC";
				//EarningAllow();
			}
		}
	}
	
	if(document.getElementById("searchemployeecode").value!="")
	{
		var varEmployeesearch = document.getElementById("searchemployeecode").value;
		//alert (varCustomerSearch);
		var varEmployeesearchLen = varEmployeesearch.length;
		//alert (varCustomerSearchLen);
		if (varEmployeesearchLen > 1)
		{
			ajaxprocessACCS26();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS26()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmployeesearch = document.getElementById("searchemployeecode").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeepayrolledit1.php?RandomKey="+Math.random()+"&&employeesearch="+varEmployeesearch;
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS26
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS26() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customersearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	if(t != '')
	{
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("||^||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	if (varNewLineLength == 0)
	{
		//return false;
	}
	
	for (m=0;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		var varEmployeecode = varNewRecordValue[0];
		//alert (varCustomerName1);
		var varComponentanum = varNewRecordValue[1];
		//alert (varComponentanum);
		var varComponentname = varNewRecordValue[2];
		var varComponentvalue = varNewRecordValue[3];
		var varTypecode = varNewRecordValue[4];
		
		if(varTypecode == '10')
		{	
			document.getElementById("earningvalue"+varComponentanum).value = varComponentvalue;
		
			for(s=1;s<50;s++)
			{	
				if(document.getElementById("earninganum"+s) != null)
				{
					if((document.getElementById("earninganum"+s).value) == (varComponentanum))
					{
						document.getElementById("earninganum"+s).checked = "checked";
						//document.getElementById("earningvalue"+varComponentanum).readOnly = false;
						EarningAllow();
					}
				}
			}
		
		}
		
		if(varTypecode == '20')
		{	
			document.getElementById("deductionvalue"+varComponentanum).value = varComponentvalue;
				
			for(k=1;k<50;k++)
			{	
				if(document.getElementById("deductionanum"+k) != null)
				{
					if((document.getElementById("deductionanum"+k).value) == (varComponentanum))
					{
						document.getElementById("deductionanum"+k).checked = "checked";
						//document.getElementById("earningvalue"+varComponentanum).readOnly = false;
						DeductionAllow();
					}
				}
			}
		
		}
		
				
	}
	//alert (k);
	}
	
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