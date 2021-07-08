// JavaScript Document// JavaScript Document
function insertitem71()
{
	
	if(document.form1.referalcode.value=="")
	{
		alert("Please enter referal name");
		document.form1.referal.focus();
		return false;
	}
	if(document.form1.rate4.value=="")
	{
		alert("Please enter rate");
		document.form1.rate4.focus();
		return false;
	}
	var varSerialNumber2 = document.getElementById("serialnumber2").value;
	var varReferal = document.getElementById("referal").value;
	var varrefRate = document.getElementById("rate4").value;
	
	var varrefsno = document.getElementById("refsno").value;
	
	var varrefCode = document.getElementById("referalcode").value;
	//alert(varlabsno);
	if(varrefsno=='')
	{
	varrefsno=0;	
	}
	var a=1;
	//alert(a);
	var varrefsno1=parseInt(varrefsno)+parseInt(a);
	
	//alert('h');
	//alert(varrefsno1);
	var k = varSerialNumber2;
	
	var tr = document.createElement ('TR');
	tr.id = "refidTR"+varrefsno1+"";
	
	var td1 = document.createElement ('td');
	td1.id = "referal"+varrefsno1+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber2"+varrefsno1+"";
	text1.name = "serialnumber2"+varrefsno1+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber2;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var td101 = document.createElement ('td');
	td101.id = "serialnumber"+varrefsno1+"";
	//td1.align = "left";
	td101.valign = "top";
	td101.style.backgroundColor = "#FFFFFF";
	td101.style.border = "0px solid #001E6A";

	
	
	var text10 = document.createElement ('input');
	text10.id = "refcheck"+varrefsno1+"";
	text10.name = "refcheck["+varrefsno1+"]";
	text10.type = "checkbox";
	text10.align = "left";
	text10.size = "10";
	text10.value = varrefsno1;
	text10.readOnly = "readonly";
	text10.style.backgroundColor = "#FFFFFF";
	text10.style.border = "0px solid #001E6A";
	text10.style.textAlign = "left";
	text10.onclick = function() {  selectselect('ref',varrefsno1),approvalfunction("refcheck"+varrefsno1+"",varrefRate); }

	//td1.appendChild (text1);
	td101.appendChild (text10);
	tr.appendChild (td101);
	
	
	var text11 = document.createElement ('input');
	text11.id = "ref"+varrefsno1+"";
	text11.name = "ref["+varrefsno1+"]";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varReferal;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate4td"+varrefsno1+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate4"+varrefsno1+"";
	text8.name = "rate4["+varrefsno1+"]";
	text8.type = "text";
	text8.size = "8";
	text8.value = varrefRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
//	tr.appendChild (td8);
	
	//this is to create 
	var text88 = document.createElement ('input');
	text88.id = "refcode"+varrefsno1+"";
	text88.name = "refcode["+varrefsno1+"]";
	text88.type = "hidden";
	text88.size = "8";
	text88.value = varrefCode;
	text88.readOnly = "readonly";
	text88.style.backgroundColor = "#FFFFFF";
	text88.style.border = "0px solid #001E6A";
	text88.style.textAlign = "left";
	td8.appendChild (text88);
	tr.appendChild (td8);
	//ends here
	
	
	var td102 = document.createElement ('td');
	td102.id = "serialnumber"+varrefsno1+"";
	//td1.align = "left";
	td102.valign = "top";
	td102.style.backgroundColor = "#FFFFFF";
	td102.style.border = "0px solid #001E6A";

	
	
	var text102 = document.createElement ('input');
	text102.id = "reflatertonow"+varrefsno1+"";
	text102.name = "reflatertonow["+varrefsno1+"]";
	text102.type = "checkbox";
	text102.align = "left";
	text102.size = "10";
	text102.value = varrefsno1;
	text102.readOnly = "readonly";
	text102.style.backgroundColor = "#FFFFFF";
	text102.style.border = "0px solid #001E6A";
	text102.style.textAlign = "left";
	text102.onclick = function() { return selectcash('lab',varrefsno1); }
	td102.appendChild (text102);
	tr.appendChild (td102);
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete51"+varrefsno1+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete51"+varrefsno1+"";
	text11.name = "btndelete51"+varrefsno1+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { btnDeleteClick91(varrefsno1,varrefRate,"refcheck"+varrefsno1+"");  }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow51').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber2").value = parseInt(varSerialNumber2) + 1;
	
	if(document.getElementById('total21').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total21').value;
	}
	
	
	totalamount2=parseInt(totalamount2) + parseInt(varrefRate);
	document.getElementById("total21").value=totalamount2.toFixed(2);
	
	
	
	var varLab = document.getElementById("referal").value = "";
	var varRate = document.getElementById("rate4").value = "";
	document.getElementById("refsno").value="";
	document.getElementById("refsno").value = varrefsno1;
	
	document.getElementById("referal").focus();
	//alert(varrefsno1);
	grandtotl(varrefRate); 
	window.scrollBy(0,5); 
	return true;

}