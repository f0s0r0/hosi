// JavaScript Document// JavaScript Document
function insertitem8()
{
	if(document.form1.services.value=="")
	{
		alert("Please enter services name");
		document.form1.services.focus();
		return false;
	}
	if(document.form1.rate3.value=="")
	{
		alert("Please enter rate");
		document.form1.rate3.focus();
		return false;
	}
	if(document.form1.serviceqty.value=="")
	{
		alert("Please Enter Quantity");
		document.form1.serviceqty.focus();
		return false;
	}
	var varSerialNumber3 = document.getElementById("serialnumber3").value;
	var varServices = document.getElementById("services").value;
	var varserRate = document.getElementById("rate3").value;
	var varserviceqty = document.getElementById("serviceqty").value;
	var varserviceamount = document.getElementById("serviceamount").value;
	
	var m = varSerialNumber3;
	
	var tr = document.createElement ('TR');
	tr.id = "seridTR"+m+"";
	
	var td1 = document.createElement ('td');
	td1.id = "services"+m+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber3"+m+"";
	text1.name = "serialnumber3"+m+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber3;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "services"+m+"";
	text11.name = "services[]"+m+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varServices;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var td12 = document.createElement ('td');
	td12.id = "serviceqty"+m+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text12 = document.createElement ('input');
	text12.id = "serviceqty"+m+"";
	text12.name = "serviceqty[]"+m+"";
	text12.type = "text";
	text12.size = "8";
	text12.value = varserviceqty;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate3"+m+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate3"+m+"";
	text8.name = "rate3[]"+m+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varserRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td13 = document.createElement ('td');
	td13.id = "serviceamount"+m+"";
	td13.align = "left";
	td13.valign = "top";
	td13.style.backgroundColor = "#FFFFFF";
	td13.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text13 = document.createElement ('input');
	text13.id = "serviceamount"+m+"";
	text13.name = "serviceamount[]"+m+"";
	text13.type = "text";
	text13.size = "8";
	text13.value = varserviceamount;
	text13.readOnly = "readonly";
	text13.style.backgroundColor = "#FFFFFF";
	text13.style.border = "0px solid #001E6A";
	text13.style.textAlign = "left";
	td13.appendChild (text13);
	tr.appendChild (td13);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete3"+m+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete3"+m+"";
	text11.name = "btndelete3"+m+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick12(m,varserviceamount); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow3').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber3").value = parseInt(varSerialNumber3) + 1;
		if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('total3').value;
	}
	
	
	
	totalamount3=parseInt(totalamount3) + parseInt(varserviceamount);
	
	//alert(totalamount3);
	document.getElementById("total3").value=totalamount3.toFixed(2);
	
	
	
	
	
	var varLab = document.getElementById("services").value = "";
	var varRate = document.getElementById("rate3").value = "";
	var varserviceqty = document.getElementById("serviceqty").value = "";
	var Seramt = document.getElementById("serviceamount").value = "";
	
	document.getElementById("services").focus();
	grandtotl(varserRate);
	window.scrollBy(0,5); 
	return true;

}