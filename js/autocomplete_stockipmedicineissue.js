// JavaScript Document
//called from sales1.php
var sd = 0;
//function to call ajax process
function funcBatchNumberVerify2(x)
{
	// if x = callfromAutoSuggest2ItemJs it handle mouse click event of item name drop down list.
	
	//if(document.getElementById("categoryname").value!="")
	//{
		var x= x;
		sd=x;
		//alert("Meow...");
		//alert(x);
			//alert ("2");
		var varbatchnumber = document.getElementById("batchnumber").value;
		//alert(varbatchnumber);

		if (varbatchnumber != '')
		{
			ajaxprocess5stockipmedicineissue(x);
		}
			//alert ("3");
		//var url = "";
	//}
	/*
	else if(document.form1.hairtype.value=="Select" || document.form1.hairsize.value=="Select")
	{
		document.getElementById("price").innerHTML='';
		
	}
	*/
}

var xmlHttp

function ajaxprocess5stockipmedicineissue(sd)
{
xmlHttp=GetXmlHttpObject5stockmedicineissue()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  	var y = sd;
	
  	//var catservice=document.getElementById("itemname"+y).value;
  	//var catservice=document.getElementById("itemname").value;
	//var csarr = catservice.split("||");
	//var varItemCode = csarr[0];
	//alert(serviceanum);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	
  		var varItemCode1 = document.getElementById("medicinecode").value;
  	    var varBatchNumber1 = document.getElementById("batchnumber").value;
		
	
	
	var url = "";
	var url="autocompletestock1ipmedicineissue.php?RandomKey="+Math.random()+"&&itemcode="+varItemCode1+"&&batchnumber="+varBatchNumber1+"&&dummy";
	//alert(url);
  

xmlHttp.onreadystatechange=stateChanged5stockipmedicineissue
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged5stockipmedicineissue() 
{ 
//alert("Simple");
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	//alert("Simple");
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customername").value="";
	//document.getElementById('servicename').options.length=null; 

	
	//var t="$";
	var z=sd;
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var longstring=t;
	//alert (longstring);
	var brokenstring=longstring.split("||");
	//alert(brokenstring);
	//alert(brokenstring.length);
	var arraylength = brokenstring.length;

	arraylength = arraylength - 1;
	//alert(arraylength);
	//if (arraylength == 0)
	if (longstring == "")
	{
			//alert ("Batch Number Does Not Exist. Enter Proper Batch.");
			//document.getElementById("itemmrp").focus();
			//document.getElementById("batchnumber").value = "";
			//document.getElementById("expirydate").value = "";
			//document.getElementById("itemserialnumber").value = "";
			/*
			document.getElementById("itemcode").value = "";
			document.getElementById("itemname").value="";			
			document.getElementById("itemname").focus();
			document.getElementById("itemmrp").value = "0.00";
			document.getElementById("itemquantity").value = "1";
			document.getElementById("itemdiscountpercent").value = "0.00";
			document.getElementById("itemdiscountrupees").value = "0.00";
			document.getElementById("itemtaxpercent").value = "0.00";
			document.getElementById("itemtaxname").value="";	
			document.getElementById("itemtaxautonumber").value="";	
			document.getElementById("itemtotalamount").value = "0.00";
			document.getElementById("showcurrentstock1").value = "0.00";
			//document.getElementById("unitname").value = "";
			//document.getElementById("subtotal").value = "0.00";
			*/
			return false;
	}
	else
	{
		for (i=0;i<9;i++)
		{
				//alert(Simple);
				//alert(brokenstring[i]);
				var longstring2 = t;
				var brokenstring2 = longstring2.split("||");
				//alert(brokenstring2[0]);
				document.getElementById("currentstock").value = brokenstring2[0];
				/*
				//alert(brokenstring2[0]);
				//document.getElementById("itemserialnumber").value = "1";
				document.getElementById("itemcode").value = brokenstring2[2];
				document.getElementById("itemname").value="";			
				document.getElementById("itemmrp").value = brokenstring2[0];
				document.getElementById("itemquantity").value = "1";
				document.getElementById("itemdiscountpercent").value = "0.00";
				document.getElementById("itemdiscountrupees").value = "0.00";
				document.getElementById("itemtaxpercent").value = brokenstring2[3];
				document.getElementById("itemtotalamount").value = brokenstring2[0];
				alert (brokenstring2[0]);
				//document.getElementById("unitname").value = brokenstring2[1];
				//document.getElementById("subtotal").value = brokenstring2[4];
				//alert (document.getElementById("itemcode").value);
				//document.getElementById("itemcode").focus();
				var varItemCodeCatch = document.getElementById("itemcode").value
				itemsearch3(varItemCodeCatch)
				//funcSubTotalCalc(z);
				*/
				
		}
	}
 } 
}

function GetXmlHttpObject5stockmedicineissue()
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

