// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function funcmedicinesearch4(serial)
{// alert('ok');
	var serial = serial;
	//alert ("Calling Bill Number Validation");
	var itemcode = document.getElementById("medicinecode").value;
	//alert(itemcode);
	var fromstr = document.getElementById("fromstore").value;
	var locationcode = document.getElementById("locationcode").value;

	if(document.getElementById("medicinecode").value != "")
	{
		//alert("Meow...");
		ajaxprocess21(serial);		
		//var url = "";
	} 
	/*
	else if(document.form1.hairtype.value=="Select" || document.form1.hairsize.value=="Select")
	{
		document.getElementById("price").innerHTML='';
		
	}
	*/
}

var xmlHttp

function ajaxprocess21(serial1)
{

xmlHttp=GetXmlHttpObject2()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  	var serial1 = serial1;
  	
	var itemcode = document.getElementById("searchmedicineanum1").value;
	var fromstore = document.getElementById("fromstore").value;
	
	var locationcode = document.getElementById("location").value;
	var storecode = document.getElementById("fromstore").value;

	//alert(varbatch);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	var url = "";
	var url="batchbuild.php?itemcode="+itemcode+"&&fromstore="+fromstore+"&&locationcode="+locationcode;
  	//alert (url);
  

xmlHttp.onreadystatechange=stateChanged21
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged21() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customername").value="";
//	document.getElementById('servicename').options.length=null; 

	
	//var t="$";
	document.getElementById("batch").options.length=null; 
	var t = "";
	t=t+xmlHttp.responseText;
	
	var databuild = t.split(',');
	var databuildcount = databuild.length;
	//alert(databuildcount);
	var databuildcount = databuildcount -1;
	
	for(var i=0;i<=databuildcount;i++)
	{
	var combo = document.getElementById("batch");
	var batchdata = databuild[i];
	//alert(batchdata);
	var arrbatchdata=batchdata.split('||');
	if(arrbatchdata != "undefined")
	{
	var batch = arrbatchdata[0];
	var stock = arrbatchdata[1];
	var color = arrbatchdata[2];
	var fifo_code = arrbatchdata[3];
	var batchvalue = batch+"("+stock+")"+"";
	combo.options[i] = new Option (batchvalue,fifo_code); 
	combo.options[i].style.backgroundColor=color;
	}
	}
	
 } 
}

function GetXmlHttpObject2()
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

